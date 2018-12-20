# SwedishPhoneFormatter

```php
<?php
use SwedishPhoneFormatter\SwedishPhoneFormatter;

$formatter = new SwedishPhoneFormatter();

$formatter->format('081234567');  // '08-123 45 67'

// Changes the area code separator
$formatter->format('081234567', ' ');  // '08 123 45 67'

// Removes +46 country prefix and extension numbers
$formatter->format('+46 (0) 81234567');  // '08-123 45 67'

// Doesn’t try to format foreign numbers
$formatter->format('+1-202-555-0144');  // '+1-202-555-0144'

// Doesnt’t try to format non-formattable strings
$formatter->format('foobar');  // 'foobar'

// Supports number grouping for numbers without area codes
$formatter->format('112');  // '112'
$formatter->format('1177');  // '1177'
$formatter->format('11414');  // '114 14'
$formatter->format('123 456');  // '12 34 56'
$formatter->format('1234567');  // '123 45 67'
$formatter->format('12345678');  // '123 456 78'
?>
```
