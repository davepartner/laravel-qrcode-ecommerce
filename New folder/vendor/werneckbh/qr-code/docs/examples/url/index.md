### URL

You can create a QR Code for having a device open a browser page to a website address.

```php
<?php

use QR_Code\Types\QR_Url;

$url = new QR_Url('https://werneckbh.github.io/qr-code/');

$url->setSize(8)->setMargin(2)->png();
```

Note that by setting a bigger pixel size, you get a larger image.

![URL QR Code](../../assets/images/url.png)