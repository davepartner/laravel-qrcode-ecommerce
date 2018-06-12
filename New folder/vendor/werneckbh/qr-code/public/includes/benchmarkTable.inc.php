<section class="benchmark">
    <table>
        <caption>Benchmark</caption>
        <tbody>
        <?php foreach ($benchmarkResults as $timeIndex => $result): if ($timeIndex == 'Total') continue; ?>
            <tr>
                <td><?php echo $timeIndex; ?></td>
                <td class="seconds"><?php echo $result; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2" class="cssHack"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>Total</td>
            <td class="seconds"><?php echo $benchmarkResults['Total']; ?></td>
        </tr>
        </tfoot>
    </table>
</section>