<?php declare(strict_types=1);

namespace Haltuf\DeepL\Tests;

use Haltuf\DeepL\Api;
use Haltuf\DeepL\CurlWrapper;
use Haltuf\DeepL\Formality;
use Haltuf\DeepL\Language;
use Haltuf\DeepL\Request;
use Haltuf\DeepL\Response;
use Haltuf\DeepL\SplitSentences;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// --- PREPARE WRAPPER

$wrapper = \Mockery::mock(CurlWrapper::class);
$wrapper->shouldReceive('send')
	->withArgs([
		'https://api-free.deepl.com/v2/translate',
		[
			'text' => 'Text to be translated',
			'target_lang' => 'CS',
			'auth_key' => DEEPL_API_KEY,
		],
	])->andReturn('{"translations":[{"detected_source_language":"EN","text":"Text, který má být přeložen"}]}')
	->once();
$wrapper->shouldReceive('send')
	->withArgs([
		'https://api-free.deepl.com/v2/translate',
		[
			'text' => 'Text to be translated',
			'source_lang' => 'EN',
			'target_lang' => 'CS',
			'split_sentences' => 'nonewlines',
			'preserve_formatting' => '1',
			'formality' => 'less',
			'auth_key' => DEEPL_API_KEY,
		],
	])->andReturn('{"translations":[{"detected_source_language":"EN","text":"Text, který má být přeložen"}]}')
	->once();

// --- TEST ENDPOINT
$api = new Api(DEEPL_API_KEY, true, $wrapper);
Assert::same('https://api-free.deepl.com/v2/translate', $api->getEndpoint());

// --- TEST Api::translate()
$response = $api->translate('Text to be translated', Language::CZECH);
Assert::type(Response::class, $response);
Assert::same('Text, který má být přeložen', $response->getTranslations()[0]->getText());
Assert::same(Language::ENGLISH, $response->getTranslations()[0]->getDetectedSourceLanguage());

$request = new Request('Text to be translated', Language::CZECH, Language::ENGLISH);
$request->formality(Formality::LESS_FORMAL);
$request->preserveFormatting(true);
$request->splitSentences(SplitSentences::NO_NEW_LINES);


// --- TEST Api::send()
$response = $api->send($request);
Assert::type(Response::class, $response);
Assert::same('Text, který má být přeložen', $response->getTranslations()[0]->getText());


// --- clean up
\Mockery::close();
