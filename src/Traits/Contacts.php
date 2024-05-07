<?php

namespace Repat\RespondIoClient\Traits;

use Repat\RespondIoClient\ContactFilter;
use Repat\RespondIoClient\Exceptions\RespondIoException;

/**
 * @see https://developers.respond.io/docs/api/c6e1aa937640e-contact
 */
trait Contacts {

	/**
	 * @param string $id Contact ID
	 * @see https://developers.respond.io/docs/api/cbcfb23486778-get-a-contact
	 */
	public function getContactById(string $key, string $value) {
		$response = $this->guzzle->get("contact/{$key}:{$value}");
		return $this->unpackResponse($response);
	/**
	 * @param ContactFilter $filter Object containing filter params
	 * @param int $cursorId Search offset
	 * @param int $limit Number of records to return
	 * @see https://developers.respond.io/docs/api/0759d02787ab3-list-the-contacts
	 *
	 */
	public function getContacts(ContactFilter $filter, int $cursorId = null, int $limit = 10) : Response
	{
		$query = ['limit' => $limit];

		if($cursorId != null) {
			$query['cursorId'] = $cursorId;
		}
		return new Response(
			$this->guzzle->post("contact/list", [
				'query' => $query,
				'body' => $filter->toJson()
			])
		);
	}

	/**
	 * @param array $fields list of fields to update
	 * @param string $id Contact ID
	 * @see https://developers.respond.io/docs/api/12c3d41f3286a-update-a-contact
	 */
	public function updateContact(array $fields, string $id = 'phone') {
		if(!empty(array_diff(array_keys($fields), self::FIELDS))) {
			throw new RespondIoException('Not all fields can be updated');
		}
		if(!in_array($id, array_keys($fields))) {
			throw new RespondIoException(ucwords($id) . ' field value missing');
		}
		$response = $this->guzzle->put(
			"contact/{$id}:{$fields[$id]}",
			["body" => json_encode($fields)]
		);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param array $tags List of tags to be added
	 * @see https://developers.respond.io/docs/api/d28b7f44788ed-add-tags
	 */
	public function addTag(string $id, array $tags) {
		$response = $this->guzzle->post(
			"contact/{$id}/tag",
			['body' => json_encode($tags)]
		);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param array $tags List of tags to be removed
	 * @see https://developers.respond.io/docs/api/f1e1cf145c8ca-delete-tags
	 */
	public function removeTag(string $id, array $tags) {
		$response = $this->guzzle->delete(
			"contact/{$id}/tag",
			['body' => json_encode($tags)]
		);
		return $this->unpackResponse($response);
	}

	/**
	 * @param array $fields Fields to be used to create
	 * @see https://developers.respond.io/docs/api/985a19073853e-create-a-contact
	 */
	public function createContact(array $fields, string $id = 'phone')
	{
		if(!empty(array_diff(array_keys($fields), self::FIELDS))) {
			throw new RespondIoException('Not all fields are valid');
		}
		if(!in_array($id, array_keys($fields))) {
			throw new RespondIoException(ucwords($id) . ' field value missing');
		}
		$response = $this->guzzle->post(
			"contact/{$id}:{$fields[$id]}",
			["body" => json_encode($fields)]
		);

		return $this->unpackResponse($response);
	}
}

