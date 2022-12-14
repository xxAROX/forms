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
namespace xxAROX\forms\types;
use Closure;


/**
 * Class Form
 * @package xxAROX\forms\types
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:57
 * @ide PhpStorm
 * @project forms
 */
abstract class Form implements \pocketmine\form\Form{
	protected const TYPE_MODAL       = "modal";
	protected const TYPE_MENU        = "form";
	protected const TYPE_CUSTOM_FORM = "custom_form";
	private string $title;
	private ?Closure $onCreate = null;
	private ?Closure $onDestroy = null;

	/**
	 * Form constructor.
	 * @param string $title
	 */
	public function __construct(string $title){
		$this->title = $title;
	}

	public function __destruct(){
		if ($this->onDestroy !== null) {
			($this->onDestroy)();
		}
	}

	/**
	 * Function jsonSerialize
	 * @return array
	 */
	final public function jsonSerialize(): array{
		if ($this->onCreate !== null) ($this->onCreate)();
		return array_merge([
			"title" => $this->getTitle(),
			"type"  => $this->getType(),
		], $this->serializeFormData());
	}

	/**
	 * @return string
	 */
	public function getTitle(): string{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle(string $title): self{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	abstract public function getType(): string;

	/**
	 * @return array
	 */
	abstract protected function serializeFormData(): array;

	/**
	 * @param Closure $onCreate
	 * @return $this
	 */
	public function setOnCreate(Closure $onCreate): self{
		$this->onCreate = $onCreate;
		return $this;
	}

	/**
	 * @param Closure $onDestroy
	 * @return $this
	 */
	public function setOnDestroy(Closure $onDestroy): self{
		$this->onDestroy = $onDestroy;
		return $this;
	}
}