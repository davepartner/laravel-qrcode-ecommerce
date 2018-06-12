### Email Message

In the case-use you want a device to send an email message, you can do this:

```php
<?php

use QR_Code\Types\QR_EmailMessage;

$to = 'john.doe@example.com';
$subject = 'QR Code Message';
$body = 'This email was created from a QR Code!';

$email = new QR_EmailMessage($to, $body, $subject);

$email->setOutfile('/path/to/email-qr-code.png')->png();
```

In this example we would have saved the PNG code to _//your-project/path/to/email-qr-code.png_ and produced the following QR Code:

![Email Message QR Code](../../assets/images/email-message.png)