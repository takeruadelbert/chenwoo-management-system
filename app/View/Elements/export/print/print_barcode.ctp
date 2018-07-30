<div style="display:inline-block;position:absolute">
    <?php
    foreach ($data['PackageDetail'] as $detail) {
        ?>
        <div style="margin-bottom: 5px;text-align: center;font-size:11px;page-break-inside: avoid;position:relative">
            <div class="isQRcode"><?= $detail['package_no'] ?></div>
            <?= $detail['Product']['Parent']['name'] . "<br/>" . $detail['Product']['name'] ?>
        </div>
        <br>
        <?php
    }
    ?>
    <br>
</div>