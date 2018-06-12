[![Build Status](https://travis-ci.org/werneckbh/qr-code.svg?branch=master)](https://travis-ci.org/werneckbh/qr-code)
[![Maintainability](https://api.codeclimate.com/v1/badges/156d614b78d88ec7bfe9/maintainability)](https://codeclimate.com/github/werneckbh/qr-code/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/156d614b78d88ec7bfe9/test_coverage)](https://codeclimate.com/github/werneckbh/qr-code/test_coverage)

# QR Code Generator for PHP

 Based on the popular library [PHP QR Code](http://phpqrcode.sourceforge.net), this package lets you create several different QR Codes.

 **Note**  
 Due to the number of permutations this library does, it is normal to have more than one QR Code for the same information.
   
 To demonstrate this behavior, start a server at the **public** folder, enter some data and hit the **Generate QR Code** button a few times.
  
 Each time you hit the button there is a chance a different QR Code with the same encoded information will be generated. 
 Independently of the number of permutations, this package will generate one and only one PNG or SVG file for each content, overwriting the latest one every time.

 ## Installation

 Install using **composer**:

 ```bash
 $ composer require werneckbh/qr-code
 ```

 ## QR Code Types

 QR Code Generator for PHP supports the following QR Codes:

  - Calendar Event
  - Email Message
  - Phone
  - SMS
  - Text
  - URL
  - meCard
  - vCard v3
  - Wi-fi Network Settings
  
  Make sure you check the [Documentation](https://werneckbh.github.io/qr-code/) for further instructions.
  
 ## [Contributing](CONTRIBUTING.md)
 
 To contribute to this project, please do the following:
 
  - Fork it
  - Create a new branch for your contribution
  - Test it! Make sure it works and it won't break the master code
  - Send pull request
  
  Contributors will be added to package descriptor. Make sure you abide to the [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md)
  
  
  ## [License](LICENSE.md)
  
  **(MIT)**
  
  Copyright 2018 Bruno Vaula Werneck
  
  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
  
  The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
  
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.