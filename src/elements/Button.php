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
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use pocketmine\player\Player;


/**
 * Class Button
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:43
 * @ide PhpStorm
 * @project forms
 */
class Button extends Element{
	protected ?Image $image;
	protected string $type;
	protected ?Closure $onClick = null;

	/**
	 * FunctionalButton constructor.
	 * @param string $text
	 * @param null|Closure $onClick
	 * @param null|Image $image
	 * @param bool $locked
	 */
	#[Pure]
	public function __construct(string $text, ?Closure $onClick = null, ?Image $image = null, bool $locked = false){
		parent::__construct($text, $locked);
		$this->onClick = $onClick;
		$this->image = $image;
	}

	/**
	 * Function onClick
	 * @param Player $player
	 * @return void
	 */
	public function onClick(Player $player): void{
		if (!is_null($this->onClick)) ($this->onClick)($player);
	}

	/**
	 * Function serializeElementData
	 * @return array
	 */
	#[ArrayShape([ "text" => "string", "image" => "\\xxAROX\\forms\\elements\\Image|null" ])]
	#[Pure]
	public function serializeElementData(): array{
		$data = ["text" => $this->text];
		if ($this->hasImage()) $data["image"] = $this->image;
		return $data;
	}

	/**
	 * Function getType
	 * @return null|string
	 */
	public function getType(): ?string{
		return null;
	}

	/**
	 * Function hasImage
	 * @return bool
	 */
	public function hasImage(): bool{
		return $this->image !== null;
	}
}