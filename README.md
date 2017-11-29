# buchin/searchterm
Detect search keywords if referer coming from search engine

## Installation
```bash
composer require buchin/searchterm dev-master
```

## Usage
```php
<?php
use Buchin\SearchTerm\SearchTerm;

$term = SearchTerm::get();

/*
Example result:
(string) "ketela mambu"
*/

$isCameFromSE = SearchTerm::isCameFromSearchEngine();
/*
Example result:
(true)
*/
```
