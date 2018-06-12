### Text QR Code

You can use the core library to create Text QR Codes, but for more flexibility, use **QR_Text**

```php
<?php

use QR_Code\Types\QR_Text;

(new QR_Text('QR Code Generator for PHP!'))->png();
```

to get

![Text QR Code](../../assets/images/text.png)