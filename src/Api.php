<?php declare(strict_types=1);

namespace Haltuf\DeepL;

class Api
{

	const ENDPOINT_PRO = 'https://api.deepl.com/v2/translate';
	const ENDPOINT_FREE = 'https://api-free.deepl.com/v2/translate';

	/** @var string */
	protected $authKey;

	/** @var bool */
	protected $isFree = true;

	/** @var CurlWrapper */
	protected $wrapper;


	public function __construct(string $authKey, bool $isFree = true, CurlWrapper $wrapper = null)
	{
		$this->authKey = $authKey;
		$this->isFree = $isFree;

		if ($wrapper === null)
			$wrapper = new CurlWrapper();

		$this->wrapper = $wrapper;
	}

	public function translate(string $text, string $targetLang, string $sourceLang = null): Response
	{
		$request = new Request($text, $targetLang, $sourceLang);
		$response = $this->send($request);
		return $response;
	}

	public function getEndpoint(): string
	{
		return $this->isFree ? self::ENDPOINT_FREE : self::ENDPOINT_PRO;
	}

	public function send(Request $request): Response
	{
		$params = $request->toArray();
		$params['auth_key'] = $this->authKey;
		$output = $this->wrapper->send($this->getEndpoint(), $params);

		return Response::fromJson($output);
	}
}