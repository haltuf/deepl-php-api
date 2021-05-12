<?php declare(strict_types=1);

namespace Haltuf\DeepL;

class Translation
{

	/** @var string */
	protected $detectedSourceLanguage;

	/** @var string */
	protected $text;

	public function __construct(string $text, string $detectedSourceLanguage)
	{
		$this->text = $text;
		$this->detectedSourceLanguage = $detectedSourceLanguage;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function getDetectedSourceLanguage(): string
	{
		return $this->detectedSourceLanguage;
	}
}