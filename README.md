# malwr-api
PHP wrapper for public Malwr.com API.

API wrapper baseline code borrowed from [VirusTotal API](https://github.com/jayzeng/virustotal_apiwrapper).

## Usage
- Install via composer (http://getcomposer.org/)

Include the following in your composer.json
```json
{
  "require": {
    "demonslay335/malwr-api": "master"
  }
}
```

```
composer update
```

## Quick Start
```
<?php
require_once('vendors/autoload.php');

$apiKey = 'your_api_key';

$file = new Malwr\File($apiKey);
$resp = $file->add('foo.txt');

var_dump($resp);
?>
```

Sample output:
```
array(3) {
    ["status"] =>
    string(5) "added"
    ["sha256"] =>
    string(64) "14ebd45fc9162f8afc4fd10186a46d2fb9844bf27b9d3217fd9fdb4107f17acd"
    ["uuid"] =>
    string(43) "YWFmYTEwYTIwZjkwNDdiYWJjMmU1MWQ2ZjY1MWU3OTY"
}
```
## Tests
```bash
phpunit --configuration tests/conf/phpunit.xml tests
```