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
namespace xxAROX\forms\types\defaults;
use JetBrains\PhpStorm\Pure;
use pocketmine\player\Player;
use xxAROX\forms\elements\Button;
use xxAROX\forms\types\ModalForm;


/**
 * Class ConfirmForm
 * @package xxAROX\forms\types\defaults
 * @author Jan Sohn / xxAROX
 * @date 11. August, 2022 - 20:35
 * @ide PhpStorm
 * @project forms
 */
class ConfirmForm extends ModalForm{
	/**
	 * ConfirmForm constructor.
	 * @param string $title
	 * @param string $text
	 * @param Button $yes
	 * @param Button $no
	 */
	#[Pure]
	public function __construct(string $title, string $text, Button $yes, Button $no) {
		parent::__construct($title, $text, fn (Player $player, bool $bool) => ($bool ? $yes : $no)->onClick($player), $yes->getText(), $no->getText());
	}
}
