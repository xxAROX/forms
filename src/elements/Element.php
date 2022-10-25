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
use JsonSerializable;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;


/**
 * Class Element
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:43
 * @ide PhpStorm
 * @project forms
 */
abstract class Element implements JsonSerializable{
	const TYPE_INPUT       = "input";
	const TYPE_LABEL       = "label";
	const TYPE_TOGGLE      = "toggle";
	const TYPE_SLIDER      = "slider";
	const TYPE_STEP_SLIDER = "stepslider";
	const TYPE_DROPDOWN    = "dropdown";
	const TYPE_BUTTON      = "button";
	const TYPE_IMAGE       = "image";
	protected string $text;
	protected mixed $value;
	protected null|string|int|float|bool $default;
	protected bool $locked = false;
	protected ?Closure $on_submit = null;

	/**
	 * Element constructor.
	 * @param string $text
	 * @param null|bool $locked
	 * @param null|string|int|float|bool $default
	 */
	public function __construct(string $text, ?bool $locked = false, null|string|int|float|bool $default = null, null|Closure $on_submit = null){
		$this->text = $text;
		$this->locked = $locked ?? false;
		$this->default = $default ?? null;
		$this->on_submit = $on_submit;
	}

	public function onSubmit(Player $player): void{
		if (!is_null($this->on_submit)) ($this->on_submit)($player, $this);
	}

	/**
	 * Function setOnSubmit
	 * @param null|Closure $on_submit
	 * @return void
	 */
	public function setOnSubmit(?Closure $on_submit): void{
		$this->on_submit = $on_submit;
	}

	/**
	 * Function getValue
	 * @return mixed
	 */
	public function getValue(): mixed{
		return $this->value;
	}

	/**
	 * Function setValue
	 * @param mixed $value
	 * @return void
	 */
	public function setValue(mixed $value): self{
		$this->value = $value;
		return $this;
	}

	/**
	 * Function getDefault
	 * @return null|string|int|float|bool
	 */
	public function getDefault(): null|string|int|float|bool{
		return $this->default;
	}

	/**
	 * Function setDefault
	 * @param null|string|int|float|bool $default
	 * @return void
	 */
	public function setDefault(null|string|int|float|bool $default): self{
		$this->default = $default;
		return $this;
	}

	/**
	 * Function isLocked
	 * @return bool
	 */
	public function isLocked(): bool{
		return $this->locked;
	}

	/**
	 * Function setLocked
	 * @param bool $locked
	 * @return void
	 */
	public function setLocked(bool $locked): self{
		$this->locked = $locked;
		return $this;
	}

	/**
	 * Function jsonSerialize
	 * @return array
	 */
	public function jsonSerialize(): array{
		$array = [];
		$array["locked"] = $this->locked;
		$array["text"] = $this->locked ? "%raw.locked" : $this->text;
		if (!is_null($this->getType())) $array["type"] = $this->getType();
		if (!is_null($this->default)) $array["default"] = $this->default;
		return $array + $this->serializeElementData();
	}

	/**
	 * Function getText
	 * @return string
	 */
	public function getText(): string{
		return $this->text;
	}

	/**
	 * Function setText
	 * @param string $text
	 * @return void
	 */
	public function setText(string $text): self{
		$this->text = $text;
		return $this;
	}

	/**
	 * Function getType
	 * @return null|string
	 */
	abstract public function getType(): ?string;

	/**
	 * Function serializeElementData
	 * @return array
	 */
	abstract public function serializeElementData(): array;

	/**
	 * Function validate
	 * @param mixed $value
	 * @return void
	 */
	public function validate(mixed $value): void{
		if (!is_int($value)) {
			throw new FormValidationException("Expected int, got " . gettype($value));
		}
	}
}