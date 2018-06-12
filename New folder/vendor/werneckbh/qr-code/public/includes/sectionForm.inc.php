<section class="form">
    <h3>QR Code Options</h3>
    <form action="/" method="post">
        <fieldset><legend>Data to Transform</legend>
            <p>
                <textarea id="inputData" name="data" rows="5" cols="40"><?php echo isset($data) ? $data : 'QR Code Generator for PHP' ?></textarea>
            </p>
            <p>
                <label for="selectECLevel">Error Correction Level</label>
                <select id="selectECLevel" name="level">
                    <option value="L" <?php echo $errorCorrectionLevel === 'L' ? ' selected' : ''; ?>>L - smallest</option>
                    <option value="M" <?php echo $errorCorrectionLevel === 'M' ? ' selected' : ''; ?>>M</option>
                    <option value="Q" <?php echo $errorCorrectionLevel === 'Q' ? ' selected' : ''; ?>>Q</option>
                    <option value="H" <?php echo $errorCorrectionLevel === 'H' ? ' selected' : ''; ?>>H - best</option>
                </select>
            </p>
            <p>
                <label for="selectSize">Pixel Size</label>
                <select id="selectSize" name="size">
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        $selected = ($matrixPointSize == $i) ? 'selected' : '';
                        echo "<option value=\"{$i}\" {$selected} >{$i}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="selectOutput">File Format</label>
                <select id="selectOutput" name="output">
                    <option value="png" <?php echo $output === 'png' ? ' selected' : '' ?>>Portable Network Graphics (png)</option>
                    <option value="svg" <?php echo $output === 'svg' ? ' selected' : '' ?>>Scalable Vector Graphics (svg)</option>
                </select>
            </p>
            <p>
                <label for="checkboxShowBenchmark">
                    <input id="checkboxShowBenchmark" type="checkbox" name="benchmark" value="true" <?php echo $showBenchmark ? ' checked="checked"' : '' ?>> Show Benchmark?
                </label>
            </p>
            <input type="submit" name="submit" value="Generate QR Code">
        </fieldset>
    </form>
</section>