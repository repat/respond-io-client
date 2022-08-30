<?php

namespace Repat\RespondIoClient\Traits;

use Repat\RespondIoClient\Exceptions\RespondIoException;

/**
 * @see https://docs.respond.io/developer-api/messages-api
 */
trait Messages {

	/**
	 * @param string $id Contact ID
	 * @param string $text Text of message
	 * @see https://docs.respond.io/developer-api/messages-api#send-text-request
	 */
	public function sendText(string $id, string $text) {
		$response = $this->guzzle->post('message/sendContent/' . urlencode($id), [
			'body' => [
				'type' => 'text',
				'text' => $text,
			]
		]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param string $type 'image', 'audio', 'video', 'file'
	 * @param string $url URL of media
	 * @see https://docs.respond.io/developer-api/messages-api#send-attachment-request
	 */
	public function sendAttachment(string $id, string $type, string $url) {
		if(! in_array($type, self::ATTACHMENT_TYPES)) {
			throw new RespondIoException('Invalid Type for attachment: ' . $type);
		}

		$response = $this->guzzle->post('message/sendContent/' . urlencode($id), [
			'body' => [
				'type' => $type,
				'text' => $url,
			]
		]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param string $title Question
	 * @param array $replies Answers
	 * @see https://docs.respond.io/developer-api/messages-api#send-text-with-quick-replies-request
	 */
	public function sendQuickReply(string $id, string $title, array $replies) {
		if(array_keys($replies) !== array_keys(array_keys($replies))) {
			throw new RespondIoException('Replies array cannot be an associative array');
		}
		$response = $this->guzzle->post('message/sendContent/' . urlencode($id), [
			'body' => [
				'type' => 'quick_reply',
				'title' => $title,
				'replies' => $replies,
			]
		]);
		return $this->unpackResponse($response);
	}
}

