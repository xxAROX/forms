# forms

`composer require xxarox/forms`

> ![GitHub all releases](https://img.shields.io/github/downloads/xxAROX/forms/total?color=violet&label=Downloads&style=flat-square)


### build.php

```php
$packages = [
	"xxarox/forms" => ["path" => ["src" => "src/xxAROX/forms", "encode" => false]],
]
```

### Example
<details>
<summary>Fix images</summary>

```php
\xxAROX\forms\FormImagesFix::register($pluginBase)
```
</details>

<details>
<summary>MenuForm</summary>

```php
/** @var \pocketmine\player\Player $player */
$player->sendForm(new \xxAROX\forms\types\MenuForm(
	"title",
	"text",
	[
		new \xxAROX\forms\elements\Button("button1", fn (\pocketmine\player\Player $player) => $player->sendMessage("button1")),
		new \xxAROX\forms\elements\Button("button2", fn (\pocketmine\player\Player $player) => $player->sendMessage("button2")),
		new \xxAROX\forms\elements\Button("button3", fn (\pocketmine\player\Player $player) => $player->sendMessage("button3")),
	]
));
```
</details>

<details>
<summary>CustomForm</summary>

```php
/** @var \pocketmine\player\Player $player */
$player->sendForm(new \xxAROX\forms\types\CustomForm(
	"title",
	[
		new \xxAROX\forms\elements\Slider("slider", 0, 100, 50, 0, fn (\pocketmine\player\Player $player, \xxAROX\forms\elements\Slider $slider) => $player->sendMessage("slider: {$slider->getValue()}")),
		new \xxAROX\forms\elements\Toggle("toggle", true, fn (\pocketmine\player\Player $player, \xxAROX\forms\elements\Toggle $toggle) => $player->sendMessage("toggle: {$toggle->getValue()}")),
		new \xxAROX\forms\elements\Dropdown("dropdown", ["option1", "option2", "option3"], 0, fn (\pocketmine\player\Player $player, \xxAROX\forms\elements\Dropdown $dropdown) => $player->sendMessage("dropdown: {$dropdown->getSelectedOption()}")),
		new \xxAROX\forms\elements\Input("input", "placeholder", fn (\pocketmine\player\Player $player, \xxAROX\forms\elements\Input $input) => $player->sendMessage("input: {$input->getValue()}")),
		new \xxAROX\forms\elements\Label("label")
	],
	fn (\pocketmine\player\Player $player) => $player->sendMessage("closed"),
	fn (\pocketmine\player\Player $player, \xxAROX\forms\types\CustomFormResponse $response) => $player->sendMessage("response will called after all elements are called")
));
```
</details>

<details>
<summary>ModalForm</summary>

```php
/** @var \pocketmine\player\Player $player */
$player->sendForm(new \xxAROX\forms\types\ModalForm(
	"title",
	"text",
	fn (\pocketmine\player\Player $player, bool $isYes) => $player->sendMessage("modal: " . ($isYes ? "yes" : "no"))
	"Yes",
	"No"
));
```
</details>
