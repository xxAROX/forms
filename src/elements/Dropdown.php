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
use JetBrains\PhpStorm\ArrayShape;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use pocketmine\utils\Utils;


/**
 * Class Dropdown
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:44
 * @ide PhpStorm
 * @project forms
 */
class Dropdown extends Element{
	/** @var string[] */
	protected array $options;
	protected ?Closure $on_submit;

	/**
	 * Dropdown constructor.
	 * @param string $text
	 * @param string[] $options
	 * @param int $default
	 * @param null|Closure $on_submit
	 * @param bool $locked
	 */
	public function __construct(string $text, array $options, int $default = 0, ?Closure $on_submit = null, bool $locked = false){
		parent::__construct($text, $locked, $default);
		$this->options = $options;
		Utils::validateCallableSignature(new CallbackType(new ReturnType(), new ParameterType("player", Player::class), new ParameterType("element", static::class)), $on_submit);
		$this->on_submit = $on_submit;
	}

	/**
	 * Function onSubmit
	 * @param Player $player
	 * @param Dropdown $element
	 * @return void
	 */
	public function onSubmit(Player $player, self $element): void{
		if ($this->on_submit !== null) ($this->on_submit)($player, $element);
	}

	/**
	 * Function getOptions
	 * @return string[]
	 */
	public function getOptions(): array{
		return $this->options;
	}

	/**
	 * Function getSelectedOption
	 * @return string
	 */
	public function getSelectedOption(): string{
		return $this->options[$this->value];
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "dropdown";
	}

	/**
	 * Function serializeElementData
	 * @return \string[][]
	 */
	#[ArrayShape([ "options" => "string[]" ])]
	public function serializeElementData(): array{
		return [ "options" => $this->options ];
	}

	/**
	 * Function validate
	 * @param mixed $value
	 * @return void
	 */
	public function validate(mixed $value): void{
		parent::validate($value);
		if (!isset($this->options[$value])) {
			throw new FormValidationException("Option with index $value does not exist in dropdown");
		}
	}
}