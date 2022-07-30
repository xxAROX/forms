<?php
/*
 * Copyright (c) 2021 Jan Sohn.
 * All rights reserved.
 * I don't want anyone to use my source code without permission.
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
		if ($value !== null) {
			throw new FormValidationException("Expected null, got " . gettype($value));
		}
	}
}