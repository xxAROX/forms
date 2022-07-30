<?php
declare(strict_types=1);
namespace xxAROX\forms\elements;
use Closure;
use DaveRandom\CallbackValidator\CallbackType;
use DaveRandom\CallbackValidator\ParameterType;
use DaveRandom\CallbackValidator\ReturnType;
use pocketmine\player\Player;
use pocketmine\form\FormValidationException;
use pocketmine\utils\Utils;


/**
 * Class Toggle
 * @package xxAROX\forms\elements
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:51
 * @ide PhpStorm
 * @project forms
 */
class Toggle extends Element{
	protected ?Closure $on_submit;

	/**
	 * Toggle constructor.
	 * @param string $text
	 * @param bool $default
	 * @param null|Closure $on_submit
	 * @param bool $locked
	 */
	public function __construct(string $text, bool $default = false, ?Closure $on_submit = null, bool $locked = false){
		parent::__construct($text, $locked, $default);
		$this->default = $default;
		Utils::validateCallableSignature(new CallbackType(new ReturnType(), new ParameterType("player", Player::class), new ParameterType("element", Element::class)), $on_submit);
		$this->on_submit = $on_submit;
	}

	/**
	 * Function onSubmit
	 * @param Player $player
	 * @param Toggle $element
	 * @return void
	 */
	public function onSubmit(Player $player, self $element): void{
		if ($this->on_submit !== null) ($this->on_submit)($player, $element);
	}

	/**
	 * Function getValue
	 * @return bool
	 */
	public function getValue(): bool{
		return parent::getValue();
	}

	/**
	 * Function hasChanged
	 * @return bool
	 */
	public function hasChanged(): bool{
		return $this->default !== $this->value;
	}

	/**
	 * Function getDefault
	 * @return bool
	 */
	public function getDefault(): bool{
		return $this->default;
	}

	/**
	 * Function getType
	 * @return string
	 */
	public function getType(): string{
		return "toggle";
	}

	/**
	 * Function serializeElementData
	 * @return bool[]
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
		if (!is_bool($value)) throw new FormValidationException("Expected bool, got " . gettype($value));
	}
}