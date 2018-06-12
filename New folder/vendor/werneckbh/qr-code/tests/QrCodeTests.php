<?php

use PHPUnit\Framework\TestCase;

class QrCodeTests extends TestCase
{
    protected $outfilePNG;
    protected $outfileSVG;

    public function setUp()
    {
        parent::setUp();
        $this->outfilePNG = __DIR__ . DIRECTORY_SEPARATOR . 'test.png';
        $this->outfileSVG = __DIR__ . DIRECTORY_SEPARATOR . 'test.svg';
    }

    public function tearDown()
    {
        parent::tearDown();
        if (file_exists($this->outfilePNG)) {
            unlink($this->outfilePNG);
            $this->outfilePNG = null;
        }
        if (file_exists($this->outfileSVG)) {
            unlink($this->outfileSVG);
            $this->outfileSVG = null;
        }
    }

    public function testIfPNGFileIsCreated ()
    {
        \QR_Code\QR_Code::png('QR Code Test Suite', $this->outfilePNG);

        $this->assertTrue(file_exists($this->outfilePNG), "File not found: {$this->outfilePNG}");
    }

    public function testIfCreatedPNGisPNG ()
    {
        \QR_Code\QR_Code::png('QR Code Test Suite', $this->outfilePNG);

        $this->assertTrue(isPng($this->outfilePNG), "{$this->outfilePNG} is *NOT* a PNG");
    }

    public function testIfSVGFileIsCreated ()
    {
        \QR_Code\QR_Code::svg('QR Code Test Suite', $this->outfileSVG);

        $this->assertTrue(file_exists($this->outfileSVG), "File not found: {$this->outfileSVG}");
    }

    public function testIfCreatedSVGisSVG ()
    {
        \QR_Code\QR_Code::svg('QR Code Test Suite', $this->outfileSVG);

        $this->assertTrue(isSvg($this->outfileSVG), "{$this->outfileSVG} is *NOT* a SVG");
    }

    public function testIfQRCalendarWorks ()
    {
        $qr = new \QR_Code\Types\QR_CalendarEvent(
            new \DateTime('next Saturday 7pm'),
            new \DateTime('next Saturday 10pm'),
            'Dinner Date with Jane Doe'
        );
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQREmailWorks ()
    {
        $qr = new \QR_Code\Types\QR_EmailMessage('john.doe@example.com', 'Great News!','QR Code Generator for PHP!');
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQRPhoneWorks ()
    {
        $qr = new \QR_Code\Types\QR_Phone('+55 31 1234-4321');
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQRSmsWorks ()
    {
        $qr = new \QR_Code\Types\QR_Sms('+55 31 1234-4321', 'Text to send');
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQRTextWorks ()
    {
        $qr = new \QR_Code\Types\QR_Text('QR Code Test Suite');
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQRUrlWorks ()
    {
        $qr = new \QR_Code\Types\QR_Url('werneckbh.github.io/qr-code');
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    public function testIfQRmeCardWorks ()
    {
        $qr = new \QR_Code\Types\QR_meCard('John Doe', '1234 Main st.', '+1 001 555-1234', 'john.doe@example.com');
        $this->createQR($qr);

        $this->assertSame($qr->getCodeString(), $this->getPNGReader()->text());
    }

    public function testIfQRvCardWorks ()
    {
        $person = new \QR_Code\Types\vCard\Person('John', 'Doe', 'Mr.', 'john.doe@example.com');

        $phone1 = new \QR_Code\Types\vCard\Phone('HOME', '+1 001 555-1234');
        $phone2 = new \QR_Code\Types\vCard\Phone('WORK', '+1 001 555-4321');
        $phone3 = new \QR_Code\Types\vCard\Phone('WORK', '+1 001 9999-8888', $isCellPhone = true);

        $address = new \QR_Code\Types\vCard\Address('HOME', $isPreferredAddress = true, '1234 Main st.', 'New York', 'NY', '12345', 'USA');

        $qr = new \QR_Code\Types\QR_VCard($person, [$phone1, $phone2, $phone3], [$address]);
        $this->createQR($qr);

        $this->assertSame($qr->getCodeString(), $this->getPNGReader()->text());
    }

    public function testIfQRWifiWorks ()
    {
        $authenticationType = "WPA2";
        $ssId = "MySuperSSID";
        $password = "Y0uC4n7f1nd7h3p4ssw0rd";
        $ssIdisHidden = false;

        $qr = new \QR_Code\Types\QR_WiFi($authenticationType, $ssId, $password, $ssIdisHidden);
        $this->createQR($qr);

        $this->assertTrue($this->getPNGReader()->text() === $qr->getCodeString());
    }

    /**
     * Create QR Code PNG temporary file
     *
     * @param \QR_Code\Util\AbstractGenerator $qr
     */
    private function createQR (\QR_Code\Util\AbstractGenerator $qr)
    {
        $qr->setOutfile($this->outfilePNG)->png();
    }

    /**
     * Get an instance of QrReader with current PNG image
     *
     * @return QrReader
     */
    private function getPNGReader () : QrReader
    {
        return new QrReader($this->outfilePNG);
    }
}