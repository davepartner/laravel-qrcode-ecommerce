### vCard v3

A vCard is a digital personal card.

```php
<?php

use QR_Code\Types\vCard\Address;
use QR_Code\Types\vCard\Person;
use QR_Code\Types\vCard\Phone;

use QR_Code\Types\QR_VCard;

$person = new Person('John', 'Doe', 'Mr.', 'john.doe@example.com');

$phone1 = new Phone('HOME', '+1 001 555-1234');
$phone2 = new Phone('WORK', '+1 001 555-4321');
$phone3 = new Phone('WORK', '+1 001 9999-8888', $isCellPhone = true);

$address = new Address('HOME', $isPreferredAddress = true, '1234 Main st.', 'New York', 'NY', '12345', 'USA');

$vCard = new QR_VCard($person, [$phone1, $phone2, $phone3], [$address]);

$vCard->svg();
```
Remember, due to the amount of information, it is better to use SVG.

![vCard QR Code](../../assets/images/v-card.svg)