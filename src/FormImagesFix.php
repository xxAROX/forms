<?php
/*
 *    Copyright 2022 Jan Sohn / xxAROX
 *
 *    Licensed under the Apache License, Version 2.0 (the "License");
 *    you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *    Unless required by applicable law or agreed to in writing, software
 *    distributed under the License is distributed on an "AS IS" BASIS,
 *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *    See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 */
declare(strict_types=1);
namespace xxAROX\forms;
use Closure;
use pocketmine\entity\Attribute;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\NetworkStackLatencyPacket;
use pocketmine\network\mcpe\protocol\types\entity\Attribute as NetworkAttribute;
use pocketmine\network\mcpe\protocol\UpdateAttributesPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\ClosureTask;


/**
 * Class FormImagesFix
 * @package xxAROX\forms
 * @author Musqit
 * @date 11. August, 2022 - 20:24
 * @ide PhpStorm
 * @project forms
 */
final class FormImagesFix implements Listener{
	protected static ?PluginBase $plugin = null;
	protected static bool $registered = false;
	protected static array $callbacks = [];

	public static function register(PluginBase $plugin){
		if (!self::$registered) {
			self::$plugin = $plugin;
			$plugin->getServer()->getPluginManager()->registerEvents(new self(), $plugin);
			self::$registered = true;
		}
	}

	private function onPacketSend(Player $player, Closure $callback): void{
		$ts = mt_rand() * 1000;
		$pk = new NetworkStackLatencyPacket();
		$pk->timestamp = $ts;
		$pk->needResponse = true;
		$player->getNetworkSession()->sendDataPacket($pk);
		self::$callbacks[$player->getId()][$ts] = $callback;
	}

	/**
	 * @param DataPacketReceiveEvent $event
	 * @priority MONITOR
	 */
	public function onDataPacketReceive(DataPacketReceiveEvent $event): void{
		$packet = $event->getPacket();
		if ($packet instanceof NetworkStackLatencyPacket) {
			$player = $event->getOrigin()->getPlayer();
			if ($player !== null && isset(self::$callbacks[$id = $player->getId()][$ts = $packet->timestamp])) {
				$cb = self::$callbacks[$id][$ts];
				unset(self::$callbacks[$id][$ts]);
				if (count(self::$callbacks[$id]) === 0) unset(self::$callbacks[$id]);
				$cb();
			}
		}
	}

	/**
	 * @param DataPacketSendEvent $event
	 * @priority MONITOR
	 */
	public function onDataPacketSend(DataPacketSendEvent $event): void{
		foreach ($event->getPackets() as $packet) {
			if ($packet instanceof ModalFormRequestPacket) {
				foreach ($event->getTargets() as $target) {
					self::$plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($target): void{
						$player = $target->getPlayer();
						if ($player !== null && $player->isOnline()) {
							$this->onPacketSend($player, function () use ($player, $target): void{
								if ($player->isOnline()) {
									$times = 5; // send for up to 5 x 10 ticks (or 2500ms)
									self::$plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(static function () use ($player, $target, &$times): void{
										if (--$times >= 0 && $target->isConnected()) {
											$entries = [];
											$attr = $player->getAttributeMap()->get(Attribute::EXPERIENCE_LEVEL);
											/** @noinspection NullPointerExceptionInspection */
											$entries[] = new NetworkAttribute($attr->getId(), $attr->getMinValue(), $attr->getMaxValue(), $attr->getValue(), $attr->getDefaultValue());
											$target->sendDataPacket(UpdateAttributesPacket::create($player->getId(), $entries, 0));
											return;
										}
										throw new CancelTaskException("Maximum retries exceeded");
									}), 10);
								}
							});
						}
					}), 1);
				}
			}
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 * @priority MONITOR
	 */
	public function PlayerQuitEvent(PlayerQuitEvent $event): void{
		unset(self::$callbacks[$event->getPlayer()->getId()]);
	}
}
