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
use JetBrains\PhpStorm\ArrayShape;
use pocketmine\form\FormValidationException;
use pocketmine\utils\Utils;


/**
 * Class Input
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:44
 * @ide PhpStorm
 * @project forms
 */
class Input extends Element{
	protected string $placeholder;
	protected ?Closure $on_submit;

	/**
	 * Input constructor.
	 * @param string $text
	 * @param string $placeholder
	 * @param string $default
	 * @param null|Closure $on_submit
	 * @param bool $locked
	 */
	public function __construct(string $text, string $placeholder = "", string $default = "", ?Closure $on_submit = null, bool $locked = false){
		parent::__construct($text, $locked, $default);
		$this->placeholder = $placeholder;
		Utils::validateCallableSignature(new CallbackType(
			new ReturnType(),
			new ParameterType("player", Player::class),
			new ParameterType("element", self::class)
		), $on_submit);
		$this->on_submit = $on_submit;
	}

	public function onSubmit(Player $player, self $element): void{
		if ($this->on_submit !== null) ($this->on_submit)($player, $element);
	}

	/**
	 * Function getValue
	 * @return string
	 */
	public function getValue(): string{
		return parent::getValue();
	}

	/**
	 * Function getPlaceholder
	 * @return string
	 */
	public function getPlaceholder(): string{
		return $this->placeholder;
	}

	/**
	 * Function getDefault
	 * @return string
	 */
	public function getDefault(): string{
		return $this->default;
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "input";
	}

	/**
	 * Function serializeElementData
	 * @return array
	 */
	#[ArrayShape(["placeholder" => "string"])]
	public function serializeElementData(): array{
		return ["placeholder" => $this->placeholder ];
	}

	/**
	 * Function validate
	 * @param mixed $value
	 * @return void
	 */
	public function validate(mixed $value): void{
		if (!is_string($value)) {
			throw new FormValidationException("Expected string, got " . gettype($value));
		}
	}
}