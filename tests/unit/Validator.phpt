<?php declare(strict_types=1);

namespace Haltuf\DeepL\Tests;

require __DIR__ . '/../bootstrap.php';

use Haltuf\DeepL\Formality;
use Haltuf\DeepL\Language;
use Haltuf\DeepL\SplitSentences;
use Haltuf\DeepL\Validator;
use Tester\Assert;

$lang = Language::CZECH;
Assert::true(Validator::validateLanguage($lang));
Assert::false(Validator::validateLanguage('elvish'));


$split = SplitSentences::NO_NEW_LINES;
Assert::true(Validator::validateSplitSentences($split));
Assert::false(Validator::validateSplitSentences('nonsense'));


$formality = Formality::LESS_FORMAL;
Assert::true(Validator::validateFormality($formality));
Assert::false(Validator::validateFormality('vulgar'));