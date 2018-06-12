<section class="generatedQRCodes">
    <?php
    $ignoreFiles = ['.', '..', '.gitignore', 'test.png', 'test.svg'];
    $files = scandir(TEMP_DIR);

    if (count($files) > count($ignoreFiles)):
        ?>
        <h3>Temporary Directory contents</h3>
        <ul>
            <?php
            foreach ($files as $file) {
                if (!in_array($file, $ignoreFiles)) {
                    echo "\t<li><a href=\"{$PNG_WEB_DIR}{$file}\" target=\"_blank\">{$file}</a></li>\n";
                }
            }
            ?>
        </ul>
        <small style="color: red"><a href="clearTemp.php">Clear Generated Codes</a></small>
    <?php
    endif;
    ?>
</section>