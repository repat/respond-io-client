<?php

namespace Repat\RespondIoClient\Traits;

use Repat\RespondIoClient\Exceptions\RespondIoException;

/**
 * @see https://developers.respond.io/docs/api/42fc125b57906-messaging
 */
trait Messages {

	/**
	 * @param string $id Contact ID
	 * @param string $text Text of message
	 * @see https://developers.respond.io/docs/api/a748f5bfb1bb5-send-a-message
	 */
	public function sendMessage(string $id, string $text) {
		$response = $this->guzzle->post("contact/{$id}/message", [
			'form_params' => [
				'message' => [
					'type' => 'text',
					'text' => $text,
				]
			]
		]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param string $type 'image', 'audio', 'video', 'file'
	 * @param string $url URL of media
	 * @see https://developers.respond.io/docs/api/a748f5bfb1bb5-send-a-message
	 */
	public function sendAttachment(string $id, string $type, string $url) {
		if(! in_array($type, self::ATTACHMENT_TYPES)) {
			throw new RespondIoException('Invalid Type for attachment: ' . $type);
		}

		$response = $this->guzzle->post("contact/{$id}/message", [
			'form_params' => [
				'message' => [
					'type' => 'attachment',
					'attachment' => [
						'type' => $type,
						'url' => $url,
					]
				]
			]
		]);
		return $this->unpackResponse($response);
	}
}

