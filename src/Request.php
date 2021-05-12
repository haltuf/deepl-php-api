<?php declare(strict_types=1);

namespace Haltuf\DeepL;

use Haltuf\DeepL\Exception\UnknownFormality;
use Haltuf\DeepL\Exception\UnknownLanguage;
use Haltuf\DeepL\Exception\UnknownSplitSentences;

class Request
{

	protected $text;

	protected $sourceLang;

	protected $targetLang;

	protected $splitSentences;

	protected $preserveFormatting;

	protected $formality;

	protected $tagHandling;
	protected $nonSplittingTags;
	protected $outlineDetection;
	protected $splittingTags;
	protected $ignoreTags;


	/**
	 * @throws UnknownLanguage
	 */
	public function __construct(string $text, string $targetLang, string $sourceLang = null)
	{
		$this->text = $text;

		if (!Validator::validateLanguage($targetLang))
			throw new UnknownLanguage('Target language ' . $targetLang . ' not recognized');

		if ($sourceLang !== null && !Validator::validateLanguage($sourceLang))
			throw new UnknownLanguage('Source language ' . $sourceLang . ' not recognized');

		$this->targetLang = $targetLang;
		$this->sourceLang = $sourceLang;
	}

	/**
	 * @throws UnknownSplitSentences
	 */
	public function splitSentences(string $splitSentences = SplitSentences::DEFAULT_SPLIT): void
	{
		if (!Validator::validateSplitSentences($splitSentences))
			throw new UnknownSplitSentences('Value ' . $splitSentences . ' not recognized for split_sentences parameter');

		$this->splitSentences = $splitSentences;
	}

	public function preserveFormatting(bool $preserveFormatting = false): void
	{
		$this->preserveFormatting = $preserveFormatting;
	}

	/**
	 * @throws UnknownFormality
	 */
	public function formality(string $formality = Formality::DEFAULT_FORMALITY): void
	{
		if (!Validator::validateFormality($formality))
			throw new UnknownFormality('Value ' . $formality . ' not recognized for formality parameter');

		$this->formality = $formality;
	}

	public function toArray(): array
	{
		$array = ['text' => $this->text];

		if ($this->sourceLang !== null)
			$array['source_lang'] = $this->sourceLang;

		$array['target_lang'] = $this->targetLang;

		if ($this->splitSentences !== null)
			$array['split_sentences'] = $this->splitSentences;
		if ($this->preserveFormatting !== null)
			$array['preserve_formatting'] = (string) (int) $this->preserveFormatting;
		if ($this->formality !== null)
			$array['formality'] = $this->formality;

		return $array;
	}
}