<?php declare(strict_types=1);

namespace Haltuf\DeepL;

class Validator
{

	public static function validateLanguage(string $language): bool
	{
		$languages = self::getAllowedValues(Language::class);
		return in_array($language, $languages);
	}

	public static function validateSplitSentences(string $splitSentences): bool
	{
		$allowed = self::getAllowedValues(SplitSentences::class);
		return in_array($splitSentences, $allowed);
	}

	public static function validateFormality(string $formality): bool
	{
		$allowed = self::getAllowedValues(Formality::class);
		return in_array($formality, $allowed);
	}

	protected static function getAllowedValues(string $className): array
	{
		$class = new \ReflectionClass($className);
		return $class->getConstants();
	}
}