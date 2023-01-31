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
use JetBrains\PhpStorm\ArrayShape;


/**
 * Class StepSlider
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:50
 * @ide PhpStorm
 * @project forms
 */
class StepSlider extends Dropdown{
	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "step_slider";
	}

	/**
	 * Function serializeElementData
	 * @return array
	 */
	#[ArrayShape(["steps" => "string[]"])]
	public function serializeElementData(): array{
		return ["steps"   => $this->options ];
	}
}