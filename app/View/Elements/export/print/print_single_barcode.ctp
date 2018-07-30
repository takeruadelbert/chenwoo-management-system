<div style="display:inline-block">
    <div style="margin-bottom: 5px;text-align: center;font-size:11px;">
        <?= $this->data["PackageDetail"]['package_no'] ?>
        <div class="isQRcode"><?= $this->data["PackageDetail"]['package_no'] ?></div>
        <?= $this->data['Product']['Parent']['name'] . "<br/>" . $this->data['Product']['name'] ?>
    </div>
</div>