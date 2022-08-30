Respond.io Client
======
> ⚠️ WORK IN PROGRESS ⚠️

**respond-io-client** is the unofficial package for the [respond.io messaging platform API](https://respond.io). Pull requests welcome.

## Installation
`composer require repat/respond-io-client`

## Usage
The library will generally throw Guzzle's Exceptions, see [Contacts API Error Codes](https://docs.respond.io/developer-api/contacts-api#error-codes) and [Messages API Error Codes](https://docs.respond.io/developer-api/messages-api#error-codes) in their [documentation](https://docs.respond.io/).

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

/*
|--------------------------------------------------------------------------
| Get Contacts
|--------------------------------------------------------------------------
*/
// If you know the ID
$client->getContactById($id);

// Search by field
$customFieldName = 'phone';
$customFieldValue = '+15551234567';
$client->getContactByCustomField($customFieldName, $customFieldValue);

/*
|--------------------------------------------------------------------------
| Update Contacts
|--------------------------------------------------------------------------
*/
$fields = [
	'phone' => '+15557654321',
];

$client->updateContact($id, $fields);

/*
|--------------------------------------------------------------------------
| Tags
|--------------------------------------------------------------------------
*/

$tags = ['foo', 'bar'];

$client->addTag($id, $tags);
$client->removeTag($id, $tags);

/*
|--------------------------------------------------------------------------
| Create Contact
|--------------------------------------------------------------------------
*/
$fields = [
	'firstName' => 'John',
	'lastName' => 'Doe',
	'phone' => '+15551234567',
	'email' => 'test@example.com'
	//
];

$client->createContact($fields);
```

### Messages

```php
/*
|--------------------------------------------------------------------------
| Text
|--------------------------------------------------------------------------
*/

$client->sendText($id, $text);

/*
|--------------------------------------------------------------------------
| Attachments
|--------------------------------------------------------------------------
*/
$type = Client::TYPE_IMAGE; // 'image'

// OR:
// $type = Client::TYPE_AUDIO; // 'audio'
// $type = Client::TYPE_VIDEO; // 'video'
// $type = Client::TYPE_FILE; // 'file

$url = 'https://repat.de/Bilder/repat40x40.png';

$client->sendAttachment($id, $type, $url);

/*
|--------------------------------------------------------------------------
| Quick Reply
|--------------------------------------------------------------------------
*/

$title = 'Would you like Foo, Bar or Baz?';
$replies = ['Foo', 'Bar', 'Baz'];

$client->sendQuickReply($id, $title, $replies);
```

## ToDo

* Composer / Packagist release
* Tests
* [Message Template API](https://docs.respond.io/developer-api/messages-api/message-template-api)

## License
* MIT

## Version
* Version 0.1

## Contact
#### repat
* Homepage: [repat.de](https://repat.de)
* e-mail: repat@repat.de
* Twitter: [@repat123](https://twitter.com/repat123 "repat123 on twitter")
* other communication/social media

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=repat&url=https://github.com/repat/respond-io-title&title=respond-io-title&language=&tags=github&category=software)
