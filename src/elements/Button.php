<?php
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