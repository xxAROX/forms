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
use JetBrains\PhpStorm\Pure;
use pocketmine\form\FormValidationException;


/**
 * Class Label
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:44
 * @ide PhpStorm
 * @project forms
 */
class Label extends Element{
	/**
	 * Label constructor.
	 * @param string $text
	 */
	#[Pure]
	public function __construct(string $text){
		parent::__construct($text);
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "label";
	}

	/**
	 * Function serializeElementData
	 * @return array
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
		if ($value !== null) throw new FormValidationException("Expected null, got " . gettype($value));
	}
}