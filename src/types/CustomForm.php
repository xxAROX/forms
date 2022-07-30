<?php
declare(strict_types=1);
namespace xxAROX\forms\types;
use Closure;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use xxAROX\forms\elements\Element;


/**
 * Class CustomForm
 * @package xxAROX\forms\types
 * @author Jan Sohn / xxAROX
 * @date 04. July, 2022 - 23:52
 * @ide PhpStorm
 * @project forms
 */
class CustomForm extends Form{
	/** @var Element[] */
	protected array $elements;
	private Closure $onSubmit;
	private ?Closure $onClose;

	/**
	 * CustomForm constructor.
	 * @param string $title
	 * @param array $elements
	 * @param null|Closure $onClose
	 * @param null|Closure $onSubmit after all elements are called
	 */
	#[Pure]
	public function __construct(string $title, array $elements, ?Closure $onClose = null, ?Closure $onSubmit = null){
		parent::__construct($title);
		$this->elements = $elements;
		$this->onSubmit = $onSubmit;
		$this->onClose = $onClose;
		$this->onSubmit = $onSubmit;
	}

	/**
	 * Function append
	 * @param Element ...$elements
	 * @return $this
	 */
	public function append(Element ...$elements): self{
		$this->elements = array_merge($this->elements, $elements);
		return $this;
	}

	/**
	 * Function getType
	 * @return string
	 */
	final public function getType(): string{
		return self::TYPE_CUSTOM_FORM;
	}

	/**
	 * Function handleResponse
	 * @param Player $player
	 * @param mixed $data
	 * @return void
	 */
	final public function handleResponse(Player $player, $data): void{
		if ($data === null) {
			if ($this->onClose !== null)
				($this->onClose)($player);
		} else if (is_array($data)) {
			foreach ($data as $index => $value) {
				if (!isset($this->elements[$index]))
					throw new FormValidationException("Element at index $index does not exist");
				$element = $this->elements[$index];
				$element->validate($value);
				$element->setValue($value);
				/** @var Player $player */
				if (method_exists($element, "onSubmit")) $element->onSubmit($player, $element);
			}
			($this->onSubmit)($player, new CustomFormResponse($this->elements));
		} else throw new FormValidationException("Expected array or null, got " . gettype($data));
	}

	/**
	 * Function serializeFormData
	 * @return array
	 */
	#[ArrayShape(["content" => "array|\\xxAROX\\forms\\elements\\Element[]"])] protected function serializeFormData(): array{
		return ["content" => $this->elements];
	}
}