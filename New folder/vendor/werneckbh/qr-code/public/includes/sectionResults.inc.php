<section class="header">
    <h3>
        Results<br>
        <small><a href="temp/<?php echo basename($filename); ?>" target="_blank"><?php echo basename($filename); ?></a></small>
    </h3>
</section>

<section class="qrCode">
    <h4>(original)</h4>
    <img src="<?php echo '/../'.$PNG_WEB_DIR.basename($filename); ?>" alt="QR Code">
</section>

<section class="qrCode">
    <h4>Scaled (200x200px)</h4>
    <img src="<?php echo '/../'.$PNG_WEB_DIR.basename($filename); ?>" alt="QR Code" style="width: 200px; height: 200px;">
</section>

<section class="qrCode">
    <h4>Scaled (400x400px)</h4>
    <img src="<?php echo '/../'.$PNG_WEB_DIR.basename($filename); ?>" alt="QR Code" style="width: 400px; height: 400px;">
</section>