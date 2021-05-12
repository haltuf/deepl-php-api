# DeepL API wrapper for PHP

![example workflow](https://github.com/haltuf/deepl-php-api/actions/workflows/ci.yml/badge.svg)

Unofficial, no-dependency library for calling DeepL API.
Requires curl extension. Supports PHP >= 7.1, works for PHP 8.0, too.

Currently Work-In_progress. Works for basic use cases, no support for xml parameters yet.

## Installation

```
composer require haltuf/deepl-php-api
```

## Usage

Create `Api` object and call `translate` method.

```php
use Haltuf\DeepL\Api;
use Haltuf\DeepL\Language;

$api = new Api('my_key');
$translation = $api->translate('Text to be translated', Language::CZECH, Language::ENGLISH);

echo $translation->getText();
```

Outputs: `Text, který má být přeložen`

