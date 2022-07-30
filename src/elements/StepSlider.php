<?php
/*
 * Copyright (c) 2021 Jan Sohn.
 * All rights reserved.
 * I don't want anyone to use my source code without permission.
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