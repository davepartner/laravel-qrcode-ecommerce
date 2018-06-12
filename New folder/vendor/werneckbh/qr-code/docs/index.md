### What is a QR Code?

**_QR Code_** is short for **_Quick Response Code_**. It is a type of barcode that can store more information than the standard vertical lines barcode.  
<small>For a detailed explanation on QR Codes, please visit <a href="https://en.wikipedia.org/wiki/QR_code" target="_blank">https://en.wikipedia.org/wiki/QR_code</a></small>

### What does it look like?

A QR Code is a squared image with seemingly random dots. It may look like this:

![QR Code Example](assets/images/QRCODE.png)

If you use your QR Code reader of choice, it should show you the message   
**QR Code Generator for PHP!**

### What is QR Code Generator for PHP?

QR Code Generator for PHP is a standalone package for creating QR Codes in PHP. It does not depend on any external sources, like some other generators use <a href="https://developers.google.com/chart/infographics/docs/qr_codes" target="_blank">Google Graphs API</a>. It does, however, require PHP version **7.1** or higher.

It supports the following formats:

 - Portable Network Graphics (PNG)
 - Scalable Vector Graphics (SVG)
 
### <a id="examples">Examples</a>
 
 - [Generic use](examples/generic-use)
 - [Calendar Event](examples/calendar-event)
 - [Email Message](examples/email-message)
 - [Phone](examples/phone)
 - [SMS](examples/sms)
 - [Text](examples/text)
 - [URL](examples/url)
 - [meCard](examples/me-card)
 - [vCard v3](examples/v-card)
 - [Wi-fi Network Settings](examples/wi-fi)
 
### Note

Because of the number of permutations the QR Code permits, it is common to be able to generate different QR Code images for conveying the same information.

Try scanning these codes:

![Same Code, Different Image](assets/images/random1.png)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;![Same Code, Different Image](assets/images/random2.png)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;![Same Code, Different Image](assets/images/random3.png)

---

QR Code Generator for PHP is [licensed](https://github.com/werneckbh/qr-code/blob/master/LICENSE.md) under <a href="https://tldrlegal.com/license/mit-license" target="_blank">MIT</a>. 