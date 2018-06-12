### SMS

Did you know you can have people send SMS by scanning a QR Code?

```php
<?php

use QR_Code\Types\QR_Sms;

$sms = new QR_Sms('+55 (31) 1234-5678', 'Text to send!');

$sms->png();
```
Try scanning this with your smartphone!

![SMS QR Code](../../assets/images/sms.png)
