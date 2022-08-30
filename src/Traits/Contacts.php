<?php

namespace Repat\RespondIoClient\Traits;

use Repat\RespondIoClient\Exceptions\RespondIoException;

/**
 * @see https://docs.respond.io/developer-api/contacts-api
 */
trait Contacts {

	/**
	 * @param string $id Contact ID
	 * @see https://docs.respond.io/developer-api/contacts-api#get-contact-by-id
	 */
	public function getContactById(string $id) {
		$response = $this->guzzle->get('contact/' . urlencode($id));
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $name Custom Field Name
	 * @param string $value Custom Field Value
	 * @see https://docs.respond.io/developer-api/contacts-api#get-contact-by-custom-field
	 */
	public function getContactByCustomField(string $name, string $value) {
		$response = $this->guzzle->get('contact/by_custom_field?name=' . urlencode($name) . '&value=' . urlencode($value));
		return $this->unpackResponse($response);
	}

	/**
	 * @param
	 * @see https://docs.respond.io/developer-api/contacts-api#update-contact-by-id
	 */
	public function updateContact(string $id, array $fields) {
		if(! array_keys($fields, self::UPDATEABLE_FIELDS)) {
			throw new RespondIoException('Not all fields can be updated');
		}
		$response = $this->guzzle->put('contact/' . urlencode($id), [
			'custom_fields' => array_map(fn($k, $v) => ['name' => $k, 'value' => $v], array_keys($fields), array_values($fields))
		]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param array $tags List of tags to be added
	 * @see https://docs.respond.io/developer-api/contacts-api#add-tag-by-id
	 */
	public function addTag(string $id, array $tags) {
		$response = $this->guzzle->post('contact/' . urlencode($id) . '/tags', ['tags' => $tags]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param string $id Contact ID
	 * @param array $tags List of tags to be removed
	 * @see https://docs.respond.io/developer-api/contacts-api#remove-tag-by-id
	 */
	public function removeTag(string $id, array $tags) {
		$response = $this->guzzle->delete('contact/' . urlencode($id) . '/tags', ['tags' => $tags]);
		return $this->unpackResponse($response);
	}

	/**
	 * @param array $fields Fields to be used to create
	 * @see https://docs.respond.io/developer-api/contacts-api#create-contact
	 */
	public function createContact(array $fields) {
		if(! array_keys($fields, self::FIELDS)) {
			throw new RespondIoException('Not all fields are valid');
		}
		$response = $this->guzzle->post('contact', $fields);
		return $this->unpackResponse($response);
	}
}

