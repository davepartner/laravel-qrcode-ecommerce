### Phone Contact

As demonstrated in [Generic Use](../generic-use) example, to create a Phone QR Code is as simple as this:

```php
<?php

use QR_Code\QR_Code;

QR_Code::png('TEL:+55 31 1234-5678');
```

And that should give you:

![Raster QR Phone Contact](../../assets/images/phone.png)

However, if you want more flexibility, you can do this:

```php
<?php

use QR_Code\Types\QR_Phone;

$phone = new QR_Phone('+55 31 1234-5678');

$phone->setErrorCorrectionLevel('M')
    ->setMargin(2)
    ->setSize(5)
    ->png();
```

Which should give you:

![Phone Contact QR Code](../../assets/images/phone-ecc-m.png)