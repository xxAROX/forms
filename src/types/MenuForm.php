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
namespace xxAROX\forms\types;
use Closure;
use xxAROX\forms\elements\Button;
use JetBrains\PhpStorm\ArrayShape;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;


/**
 * Class MenuForm
 * @package xxAROX\forms\types
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:59
 * @ide PhpStorm
 * @project forms
 */
class MenuForm extends Form{
	/** @var Button[] */
	protected array $buttons = [];
	protected string $text;
	private ?Closure $onClose = null;

	/**
	 * MenuForm constructor.
	 * @param string $title
	 * @param string $text
	 * @param Button[]|string[] $buttons
	 * @param Closure|null $onClose
	 */
	public function __construct(string $title, string $text = "", array $buttons = [], ?Closure $onClose = null){
		parent::__construct($title);
		$this->text = $text;
		foreach ($buttons as $k => $button) {
			if (is_null($button) || is_string($button)) unset($this->buttons[$k]);
			else if ($button instanceof Button) $this->buttons[] = $button;
		}
		$this->setOnClose($onClose);
	}

	/**
	 * Function setOnClose
	 * @param null|Closure $onClose
	 * @return $this
	 */
	public function setOnClose(?Closure $onClose): self{
		if ($onClose !== null) $this->onClose = $onClose;
		return $this;
	}

	/**
	 * Function setText
	 * @param string $text
	 * @return $this
	 */
	public function setText(string $text): self{
		$this->text = $text;
		return $this;
	}

	/**
	 * Function getType
	 * @return string
	 */
	final public function getType(): string{
		return self::TYPE_MENU;
	}

	/**
	 * Function handleResponse
	 * @param Player $player
	 * @param mixed $data
	 * @return void
	 */
	final public function handleResponse(Player $player, $data): void{
		if ($data === null) {
			if ($this->onClose !== null) ($this->onClose)($player, $data);
		}
		else if (is_int($data)) {
			if (!isset($this->buttons[$data])) throw new FormValidationException("Button with index $data does not exist");
			$button = $this->buttons[$data];
			$button->setValue($data);
			$button->onSubmit($player);
		}
		else {
			throw new FormValidationException("Expected int or null, got " . gettype($data));
		}
	}

	/**
	 * Function serializeFormData
	 * @return array
	 */
	#[ArrayShape([
		"buttons" => "array|\\xxAROX\\forms\\elements\\Button[]",
		"content" => "string",
	])] protected function serializeFormData(): array{
		return [
			"buttons" => array_values($this->buttons),
			"content" => $this->text,
		];
	}
}