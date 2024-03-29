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
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use pocketmine\form\FormValidationException;
use pocketmine\utils\Utils;


/**
 * Class Slider
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:50
 * @ide PhpStorm
 * @project forms
 */
class Slider extends Element{
	protected float $min;
	protected float $max;
	protected float $step = 1.0;
	protected ?Closure $on_submit;

	/**
	 * Slider constructor.
	 * @param string $text
	 * @param float $min
	 * @param float $max
	 * @param float $step
	 * @param null|float $default
	 * @param null|Closure $on_submit
	 * @param bool $locked
	 */
	public function __construct(string $text = "", float $min = 0, float $max = 5, float $step = 1.0, ?float $default = null, ?Closure $on_submit = null, bool $locked = false){
		parent::__construct($text, $locked, $default, $on_submit);
		$this->min = min($max, $min);
		$this->max = max($max, $min);
		$this->step = $step;
		if (is_null($this->default)) $this->default = $this->min;
		if ($step <= 0) throw new InvalidArgumentException("Step must be greater than zero");
	}

	/**
	 * Function getValue
	 * @return float|int
	 */
	public function getValue(): float|int{
		return parent::getValue();
	}

	/**
	 * Function getMin
	 * @return float
	 */
	public function getMin(): float{
		return $this->min;
	}

	/**
	 * Function getMax
	 * @return float
	 */
	public function getMax(): float{
		return $this->max;
	}

	/**
	 * Function getStep
	 * @return float
	 */
	public function getStep(): float{
		return $this->step;
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "slider";
	}

	/**
	 * Function serializeElementData
	 * @return array
	 */
	#[ArrayShape([
		"min"  => "float",
		"max"  => "float",
		"step" => "float",
	])]
	public function serializeElementData(): array{
		return [
			"min"  => $this->min,
			"max"  => $this->max,
			"step" => $this->step,
		];
	}

	public function validate(mixed $value): void{
		if (!is_int($value) && !is_float($value)) throw new FormValidationException("Expected int or float, got " . gettype($value));
	}
}