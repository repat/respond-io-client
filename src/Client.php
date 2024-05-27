<?php

namespace Repat\RespondIoClient;

use GuzzleHttp\Client as Guzzle;
use Repat\RespondIoClient\Traits\Contacts;
use Repat\RespondIoClient\Traits\Messages;

class Client {

	use Contacts;
	use Messages;

	/**
	 * Private instance of Guzzle to be used with all calls
	 */
	private Guzzle $guzzle;

	/**
	 * One API token per channel, e.g. one for Twilio,
	 * one for FB Messenger, one for WhatsApp.
	 */
	private string $channelApiToken;

	const API_URL = 'https://api.respond.io/v2/';

	const FIELDS = [
		'firstName',
		'lastName',
		'profilePic',
		'language',
		'phone',
		'email',
		'custom_fields',
	];

	const ATTACHMENT_TYPES = [
		'image',
		'video',
		'audio',
		'file',
	];

	const TYPE_IMAGE = 'image';
	const TYPE_VIDEO = 'video';
	const TYPE_AUDIO = 'audio';
	const TYPE_FILE = 'file';

	/**
	 * Create a Respond.io Client
	 *
	 * @param string $channelApiToken
	 * @param array $options
	 */
	public function __construct(string $channelApiToken, array $options = [])
	{
		$this->channelApiToken = $channelApiToken;
		$this->guzzle = new Guzzle(array_merge([
			'base_uri' => self::API_URL,
			'headers' => [
				'Authorization' => 'Bearer ' . $channelApiToken,
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
			]
		], $options));
	}

	/**
	 * JSON decodes the guzzle response
	 * @param $response Guzzle Response
	 */
	private function unpackResponse($response) : array {
		return json_decode($response->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
	}
}
