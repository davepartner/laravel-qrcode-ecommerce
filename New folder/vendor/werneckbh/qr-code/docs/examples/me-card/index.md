### meCard

A meCard is a simplified digital personal card, like this:

```php
<?php

use QR_Code\Types\QR_meCard;

$card = new QR_meCard('John Doe', '1234 Main st.', '+1 001 555-1234', 'john.doe@example.com');

$card->png();
```
And get this:

![meCard QR Code](../../assets/images/me-card.png)