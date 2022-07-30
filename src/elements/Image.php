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
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;


/**
 * Class Image
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:44
 * @ide PhpStorm
 * @project forms
 */
#[Immutable]
class Image implements JsonSerializable{
	public const TYPE_URL  = "url";
	public const TYPE_PATH = "path";
	private string $type;
	private string $data;

	/**
	 * Function url
	 * @param string $data
	 * @return static
	 */
	#[Pure]
	public static function url(string $data): self{
		return new self($data, self::TYPE_URL);
	}

	/**
	 * Function path
	 * @param string $data
	 * @return static
	 */
	#[Pure]
	public static function path(string $data): self{
		return new self($data, self::TYPE_PATH);
	}

	/**
	 * Image constructor.
	 * @param string $data
	 * @param string $type
	 */
	public function __construct(string $data, string $type = self::TYPE_URL){
		$this->type = $type;
		$this->data = $data;
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return $this->type;
	}

	/**
	 * Function getData
	 * @return string
	 */
	public function getData(): string{
		return $this->data;
	}

	/**
	 * Function jsonSerialize
	 * @return array
	 */
	#[ArrayShape([ "type" => "string", "data" => "string" ])]
	public function jsonSerialize(): array{
		return [
			"type" => $this->type,
			"data" => $this->data,
		];
	}
}