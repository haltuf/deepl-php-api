<?php declare(strict_types=1);

namespace Haltuf\DeepL;

class Response
{

	/** @var Translation[] */
	protected $translations = [];

	public function addTranslation(string $text, string $detectedSourceLanguage): void
	{
		$this->translations[] = new Translation($text, $detectedSourceLanguage);
	}

	public static function fromJson(string $json): self
	{
		$data = json_decode($json, true);
		$object = new self();
		foreach ($data['translations'] as $translation) {
			$object->addTranslation($translation['text'], $translation['detected_source_language']);
		}

		return $object;
	}

	/**
	 * @return Translation[]
	 */
	public function getTranslations(): array
	{
		return $this->translations;
	}

	public function getText(): string
	{
		$output = [];
		foreach ($this->getTranslations() as $translation)
		{
			$output[] = $translation->getText();
		}

		return implode("\n", $output);
	}
}