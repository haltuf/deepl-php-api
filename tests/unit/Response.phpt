<?php declare(strict_types=1);

namespace Haltuf\DeepL\Tests;

use Haltuf\DeepL\Response;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


$jsonResponse = '{
	"translations": [{
		"detected_source_language":"EN",
		"text":"Hallo, Welt!"
	}]
}';

$response = Response::fromJson($jsonResponse);
Assert::type(Response::class, $response);
Assert::count(1, $response->getTranslations());
Assert::same('Hallo, Welt!', $response->getTranslations()[0]->getText());


$jsonResponse = '{
	"translations":[
		{
			"detected_source_language": "EN",
			"text": "Das ist der erste Satz."
		},
		{
			"detected_source_language": "EN",
			"text": "Das ist der zweite Satz."
		},
		{
			"detected_source_language": "EN",
			"text": "Dies ist der dritte Satz."
		}
	]
}';

$response = Response::fromJson($jsonResponse);
Assert::type(Response::class, $response);
Assert::count(3, $response->getTranslations());
Assert::same('Dies ist der dritte Satz.', $response->getTranslations()[2]->getText());