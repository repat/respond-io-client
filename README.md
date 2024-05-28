Respond.io Client
======
> ⚠️ WORK IN PROGRESS ⚠️

**respond-io-client** is the unofficial package for the [respond.io messaging platform API](https://respond.io).
Version 0.1 supports API V1 and version 1.0 now supports V2 as well.

Pull requests welcome.

## Installation
`composer require repat/respond-io-client`

## Usage
The library will generally throw Guzzle's Exceptions, see [API Error Codes](https://developers.respond.io/#error-code) in the respond.io [documentation](https://developers.respond.io/docs/api).

### Setup

```php
$apiToken = '...'; // Get an API token from the website, one per channel
$options = []; // Guzzle Options - should probably be left empty, but just in case.
// ...
$client = new \Repat\RespondIoClient\Client($apiToken, $options);
```

### Contacts

> Please note that in case of Viber Channel - due to a certain limitation - the Contact ID needs to be provided in a Base64 encoded format.

```php
// Get ID
$id = '...';

// Set identifying field to use for searches, creation and updates
$identifyingField = 'phone';
```


##### Get Contact
['Get a contact' respond.io documentation](https://developers.respond.io/docs/api/cbcfb23486778-get-a-contact)

```php
// If you know the ID
$client->getContactById($id);
```

##### Search for contacts
['List the contacts' respond.io documentation](https://developers.respond.io/docs/api/0759d02787ab3-list-the-contacts)

- `$cursorId`:  Start position for the search and is `null` by default.  Responses from respond.io will contain a new `cursorId` which can be used for subsequent calls. (Integer)
- `$limit`: Number of records to return.  Max of 100. (Integer)

```php
$filter = new ContactFilter();
$filter->addFilter(
	field: 'phone',
	operator: 'isEqualTo',
	value: '+15551234567'
)
$client->getContacts($filter, $cursorId, $limit);
```

##### Update Contacts
- `$identifyingField`: must exist as key in fields array

```php
$fields = [
	'phone' => '+15557654321',
];

$client->updateContact($fields, $identifyingField);
```

##### Tags

```php
$tags = ['foo', 'bar'];

$client->addTag($id, $tags);
$client->removeTag($id, $tags);
```

##### Create Contact
- `$identifyingField`: must exist as key in fields array

```php
$fields = [
	'firstName' => 'John',
	'lastName' => 'Doe',
	'phone' => '+15551234567',
	'email' => 'test@example.com'
	//
];

$client->createContact($fields, $identifyingField);
```

### Messages

##### Send Message

```php
$client->sendMessage($id, $text);
```

##### Send Attachment

```php
$type = Client::TYPE_IMAGE; // 'image'

// OR:
// $type = Client::TYPE_AUDIO; // 'audio'
// $type = Client::TYPE_VIDEO; // 'video'
// $type = Client::TYPE_FILE; // 'file

$url = 'https://repat.de/Bilder/repat40x40.png';

$client->sendAttachment($id, $type, $url);
```

## ToDo

* Tests
* [Message Template API](https://docs.respond.io/developer-api/messages-api/message-template-api)

## License
* MIT

## Version
* API v1: Version 0.1 (initial version, work in progress)
* API v2: Version 1.0 (community maintained)

## Contact
#### repat (v1 author)
* Homepage: [repat.de](https://repat.de)
* e-mail: repat@repat.de
* Twitter: [@repat123](https://twitter.com/repat123 "repat123 on twitter")
* other communication/social media

#### repat (v2 author)
* [touson on GitHub](https://github.com/touson)

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=repat&url=https://github.com/repat/respond-io-title&title=respond-io-title&language=&tags=github&category=software)
