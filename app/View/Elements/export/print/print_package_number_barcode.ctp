<div style="width:100%;margin:0;padding:0">
    <?php
    foreach ($data as $items) {
        ?>
        <div style="width:75px;float:left;padding:2px;border:1px black solid;">
            <span class="isQRcode"><?= $items['PackageDetail']['package_no'] ?></span>
            <div style="text-align: center;font-weight: bold"><?= $items['PackageDetail']['package_no'] ?></div>
        </div>
        <?php
    }
    ?>
</div>