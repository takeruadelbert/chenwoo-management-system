<?php echo $this->Form->create("PurchaseOrderMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "setup_payment_debt_material_additional/" . $material_additional_supplier_id, "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Penambahan Data Pembayaran Hutang Material Pembantu") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <table width="100%" class="table table-hover table-bordered stn-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th><?= __("Nomor Transaksi") ?></th>
                        <th colspan = "2"><?= __("Total Hutang") ?></th>
                        <th colspan = "2"><?= __("Sisa Pembayaran") ?></th>
                        <th><?= __("Supplier") ?></th>
                        <th width='50'><?= __("Diproses") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (empty($data)) {
                        ?>
                        <tr>
                            <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                        </tr>
                        <?php
                    } else {
                        foreach ($data as $index => $item) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td class="text-center"><?= $item["PurchaseOrderMaterialAdditional"]['po_number'] ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "100"><?= ic_rupiah($item["PurchaseOrderMaterialAdditional"]['total']) ?></td>
                                <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                <td class="text-right" style = "border-left-style:none !important" width = "100"><?= ic_rupiah($item["PurchaseOrderMaterialAdditional"]['remaining']) ?></td>
                                <td class="text-center"><?= $item['MaterialAdditionalSupplier']['name']; ?></td>
                                <td class="text-center">
                                    <label class="checkbox-inline checkbox-success">
                                        <input type="checkbox" class="styled isProcess<?= $index ?>" onchange="get_transaction_entry_id(<?= $index ?>)">
                                    </label>
                                </td>         
                            </tr>
                            <input type='hidden' class='transactionEntryId<?= $index ?>' name='data[PurchaseOrderMaterialAdditional][<?= $index ?>][purchase_order_material_additional_id]' value='<?= $item['PurchaseOrderMaterialAdditional']['id'] ?>' disabled>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>    
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <input type="submit" value="Lanjut" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    $(document).ready(function() {
        
    });
    
    function get_transaction_entry_id(index) {
        if($(".isProcess" + index).is(":checked")) {
            $(".transactionEntryId" + index).removeAttr("disabled");
        } else {
            $(".transactionEntryId" + index).attr("disabled", "disabled");
        }
    }
</script>