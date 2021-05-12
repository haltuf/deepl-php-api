<?php declare(strict_types=1);

namespace Haltuf\DeepL\Tests;

use Haltuf\DeepL\Exception\UnknownFormality;
use Haltuf\DeepL\Exception\UnknownLanguage;
use Haltuf\DeepL\Exception\UnknownSplitSentences;
use Haltuf\DeepL\Formality;
use Haltuf\DeepL\Language;
use Haltuf\DeepL\Request;
use Haltuf\DeepL\SplitSentences;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


Assert::exception(function () {
	$request = new Request('Text to be translated', 'some_lang');
}, UnknownLanguage::class, 'Target language some_lang not recognized');

Assert::exception(function () {
	$request = new Request('Text to be translated', Language::ENGLISH, 'some_lang');
}, UnknownLanguage::class, 'Source language some_lang not recognized');

$request = new Request('Text to be translated', Language::CZECH, Language::ENGLISH);

Assert::exception(function () use ($request) {
	$request->formality('nonsense');
}, UnknownFormality::class, 'Value nonsense not recognized for formality parameter');

Assert::exception(function () use ($request) {
	$request->splitSentences('nonsense');
}, UnknownSplitSentences::class, 'Value nonsense not recognized for split_sentences parameter');


$request->formality(Formality::LESS_FORMAL);
$request->preserveFormatting(true);
$request->splitSentences(SplitSentences::NO_NEW_LINES);

Assert::same([
	'text' => 'Text to be translated',
	'source_lang' => 'EN',
	'target_lang' => 'CS',
	'split_sentences' => 'nonewlines',
	'preserve_formatting' => '1',
	'formality' => 'less',
], $request->toArray());