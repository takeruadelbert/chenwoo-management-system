<?php echo $this->Form->create("PaymentPurchaseMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "payment_debt_material_additional/", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM TRANSAKSI PEMBAYARAN HUTANG MATERIAL PEMBANTU") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <?php
        foreach ($dataPOMaterialAdditional as $i => $poMaterialAdditional) {
        ?>
        <div class="well block">
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-file5"></i><?= __("Data Purchase Order Material Pembantu - " . $poMaterialAdditional['PurchaseOrderMaterialAdditional']['po_number']) ?></h6>
            </div>
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group"> 
                                <?php
                                echo $this->Form->label(null, __("Nomor Transaksi Pembayaran Hutang"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input(null, array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                echo $this->Form->input("PaymentPurchaseMaterialAdditional.$i.purchase_order_material_additional_id", ['type' => "hidden", "value" => $poMaterialAdditional['PurchaseOrderMaterialAdditional']['id']]);
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Total Tagihan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right isdecimal" readonly name="data[PaymentPurchaseMaterialAdditional][<?= $i ?>][total_amount]" value="<?= $poMaterialAdditional['PurchaseOrderMaterialAdditional']['total'] ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-sm-2 control-label">
                                    <label>Sisa Tagihan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right isdecimal" readonly name="data[PaymentPurchaseMaterialAdditional][<?= $i ?>][remaining]" value="<?= $poMaterialAdditional['PurchaseOrderMaterialAdditional']['remaining'] ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("PaymentPurchaseMaterialAdditional.$i.payment_type_id", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("PaymentPurchaseMaterialAdditional.$i.payment_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Pembayaran -", "empty" => ""));
                                ?>
                                <div class="col-sm-2 control-label">
                                    <label>Jumlah Pembayaran</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right isdecimal" name="data[PaymentPurchaseMaterialAdditional][<?= $i ?>][amount]">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("PaymentPurchaseMaterialAdditional.$i.initial_balance_id", __("Kas"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("PaymentPurchaseMaterialAdditional.$i.initial_balance_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Kas -", "empty" => ""));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("PaymentPurchaseMaterialAdditional.$i.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("PaymentPurchaseMaterialAdditional.$i.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="reset" value="Reset" class="btn btn-info">
            <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                <?= __("Simpan") ?>
            </button>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>