<?php include __DIR__ . "/includes/header.inc.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code Generator for PHP</title>

    <link rel="stylesheet" href="styles.css">

</head>
<body>
<section class="header">
    <h3><a href="https://github.com/werneckbh/qr-code" target="_blank">QR Code Generator for PHP</a></h3>
</section>

<section class="content">
    PNG File: <a href="/">Show Example</a><br>
    SVG File: <a href="/?output=svg">Show Example</a>
</section>

<?php

include __DIR__. '/includes/sectionForm.inc.php';
include __DIR__. '/includes/sectionResults.inc.php';
if ($showBenchmark) include __DIR__ . '/includes/benchmarkTable.inc.php';
include __DIR__. '/includes/sectionTemporaryDirectory.inc.php';

?>


<script type="text/javascript" language="JavaScript">
    document.getElementById('inputData').onkeyup = function (event) {
      if (this.value === '') {
        this.value = 'QR Code Generator for PHP!';
      }
    }
</script>

</body>
</html>