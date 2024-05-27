<?php

namespace Repat\RespondIoClient;

use Psr\Http\Message\ResponseInterface;

class Response
{
	private $contents;

	public function __construct(ResponseInterface $clientResponse)
	{
		$this->contents = json_decode($clientResponse->getBody()->getContents(), true);
	}

	public function getContents()
	{
		return $this->contents;
	}

	public function getItems()
	{
		return $this->contents['items'];
	}

	public function getCursorId(): int | null
	{
		$url = $this->contents['pagination']['next'];

		if($url == null) return null;

		$queryString = parse_url($url, PHP_URL_QUERY);
		parse_str($queryString, $queryParams);
		return (int) $queryParams['cursorId'];
	}
}
