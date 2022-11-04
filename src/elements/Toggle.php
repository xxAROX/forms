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
use DaveRandom\CallbackValidator\CallbackType;
use DaveRandom\CallbackValidator\ParameterType;
use DaveRandom\CallbackValidator\ReturnType;
use pocketmine\player\Player;
use pocketmine\form\FormValidationException;
use pocketmine\utils\Utils;


/**
 * Class Toggle
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:51
 * @ide PhpStorm
 * @project forms
 */
class Toggle extends Element{
	protected ?Closure $on_submit;

	/**
	 * Toggle constructor.
	 * @param string $text
	 * @param bool $default
	 * @param null|Closure $on_submit
	 * @param bool $locked
	 */
	public function __construct(string $text = "", bool $default = false, ?Closure $on_submit = null, bool $locked = false){
		parent::__construct($text, $locked, $default, $on_submit);
	}

	/**
	 * Function getValue
	 * @return bool
	 */
	public function getValue(): bool{
		return parent::getValue();
	}

	/**
	 * Function hasChanged
	 * @return bool
	 */
	public function hasChanged(): bool{
		return $this->default !== $this->value;
	}

	/**
	 * Function getDefault
	 * @return bool
	 */
	public function getDefault(): bool{
		return $this->default;
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "toggle";
	}

	/**
	 * Function serializeElementData
	 * @return bool[]
	 */
	public function serializeElementData(): array{
		return [];
	}

	/**
	 * Function validate
	 * @param mixed $value
	 * @return void
	 */
	public function validate(mixed $value): void{
		if (!is_bool($value)) throw new FormValidationException("Expected bool, got " . gettype($value));
	}
}