<?php declare(strict_types=1);

namespace Haltuf\DeepL;

class CurlWrapper
{

	public function send(string $url, array $params): string
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}
}