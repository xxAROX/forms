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
namespace xxAROX\forms\elements;
use Closure;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\CloningRegistryTrait;
use pocketmine\utils\RegistryTrait;


/**
 * Class Button
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:43
 * @ide PhpStorm
 * @project forms
 */
class Button extends Element{
	static function type_close(string $text = "§cClose"): self{
		return new self($text, null, Image::path("textures/ui/cancel"), false);
	}
	static function type_back(Form $backForm, string $text = "§cBack"): self{
		return new self($text, fn (Player $player) => $player->sendForm($backForm), Image::path("textures/ui/cancel"), false);
	}


	protected ?Image $image;
	protected string $type;

	/**
	 * FunctionalButton constructor.
	 * @param string $text
	 * @param null|Closure $on_submit
	 * @param null|Image $image
	 * @param bool $locked
	 */
	public function __construct(string $text = "", ?Closure $on_submit = null, ?Image $image = null, bool $locked = false){
		parent::__construct($text, $locked, null, $on_submit);
		$this->image = $image;
	}

	/**
	 * Function serializeElementData
	 * @return array
	 */
	#[ArrayShape([ "text" => "string", "image" => "\\xxAROX\\forms\\elements\\Image|null" ])]
	#[Pure]
	public function serializeElementData(): array{
		$data = ["text" => $this->text];
		if ($this->hasImage()) $data["image"] = $this->image;
		return $data;
	}

	/**
	 * Function getType
	 * @return null|string
	 */
	public function getType(): ?string{
		return null;
	}

	/**
	 * Function hasImage
	 * @return bool
	 */
	public function hasImage(): bool{
		return $this->image !== null;
	}
}