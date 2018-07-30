<?php echo $this->Form->create("PurchaseOrderMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "process_order/" . $dataRequestOrderMaterials['RequestOrderMaterialAdditional']['id'], "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Purchase Order Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                            <li id="tab-step2a"><a href="#justified-pill3" data-toggle="tab" id="test"><i class="icon-file6"></i> Data Purchase Order </a></li>
                        </ul>
                        <div class="tab-content pill-content" id="tabs">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']['id']) ? $this->data['Employee']['Account']['Biodata']['full_name'] : $this->Session->read("credential.admin.Biodata.full_name")));
                                    echo $this->Form->input("PurchaseOrderMaterialAdditional.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                    ?>
                                    <?php
                                    echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']['id']) ? $this->data['Employee']['nip'] : $this->Session->read("credential.admin.Employee.nip")));
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $department = "";
                                    $office = "";
                                    if (!empty($this->data['Employee']['Department']['name'])) {
                                        $department = $this->data['Employee']['Department']['name'];
                                    } else {
                                        $department = $this->Session->read("credential.admin.Employee.Department.name");
                                    }
                                    if (!empty($this->data['Employee']['Office']['name'])) {
                                        $office = $this->data['Employee']['Office']['name'];
                                    } else {
                                        $office = $this->Session->read("credential.admin.Employee.Office.name");
                                    }
                                    echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.department", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => $department));
                                    ?>
                                    <?php
                                    echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("Dummy.office", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled", "value" => $office));
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill3">
                                <div>
                                    <div class="panel panel-default">
                                        <div class="panel-body" id="materialList">
                                            <div class="table-responsive stn-table">
                                                <div>                                                    
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditionalTemp.po_number", __("Nomor PO"), array("class" => "col-md-3 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditionalTemp.po_number", array("div" => array("class" => "col-md-3"), 'type' => 'text', "label" => false, "value" => !empty($this->data['PurchaseOrderMaterialAdditional']['id']) ? $this->data['PurchaseOrderMaterialAdditional']['po_number'] : "AUTO GENERATE", "class" => " form-control", "disabled"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.request_order_material_additional_id", ["type" => "hidden", "value" => $dataRequestOrderMaterials['RequestOrderMaterialAdditional']['id']]);
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditional.po_date", __("Tanggal PO"), array("class" => "col-md-3 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.po_date", array("div" => array("class" => "col-md-3"), 'type' => 'text', "label" => false, "class" => "datetime form-control", "value" => !empty($this->data['PurchaseOrderMaterialAdditional']['po_date']) ? $this->data['PurchaseOrderMaterialAdditional']['po_date'] : date("Y-m-d H:i:s")));
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditional.material_additional_supplier_id", __("Supplier Material Pembantu"), array("class" => "col-md-3 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.material_additional_supplier_id", array("div" => array("class" => "col-md-3"), "empty" => "", "placeholder" => "- Pilih Supplier -", "label" => false, "class" => "select-full"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu Yang Belum Diproses") ?></h6>
                                                </div>
                                                <table width="100%" class="table table-hover table-bordered">
                                                    <tr>
                                                        <th width="1%" style="text-align: center;">No</th>
                                                        <th width="25%" style="text-align: center;">Nama</th>
                                                        <th width="15%" style="text-align: center;">Jumlah</th>
                                                        <th width="20%">Harga Per Pcs</th>
                                                        <th width="20%">Total</th>
                                                        <th width="5%">Aksi</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($dataRequestOrderMaterials['RequestOrderMaterialAdditionalDetail'] as $index => $details) {
                                                            if (!$details['is_used']) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $i ?></td>
                                                                    <td>
                                                                        <input type='text' class="form-control" value="<?= $details['MaterialAdditional']['name']." ".$details['MaterialAdditional']['size'] ?>" readonly>
                                                                        <input type="hidden" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][material_additional_id]" value="<?= $details['MaterialAdditional']['id'] ?>">
                                                                        <input type="hidden" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][request_order_material_additional_detail_id]" value="<?= $details['id'] ?>">
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group" style = "width: 100%">
                                                                            <input type='text' class='form-control text-right' value="<?= ic_number_reverse(ic_kg($details['quantity'])) ?>" id="quantity<?= $index ?>" readonly/>
                                                                            <input type='hidden' value="<?= $details['quantity'] ?>" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][quantity]"/>
                                                                            <input type='hidden' value="<?= $details['quantity'] ?>" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][quantity_remaining]"/>
                                                                            <span class="input-group-addon" style = "width: 50px; text-align: left;"><?= $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?></span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Rp.</span>
                                                                            <input type="text" class="form-control text-right isdecimal" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][price]" id="hargaPO<?= $index ?>" onkeyup="getTotalHarga(<?= $index ?>)">
                                                                            <span class="input-group-addon">,00.</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Rp.</span>
                                                                            <input type="text" class="form-control text-right total" id="total<?= $index ?>" disabled value="0">
                                                                            <span class="input-group-addon">,00.</span>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <label class="checkbox-inline checkbox-success">
                                                                            <input type="checkbox" class="styled" name="data[PurchaseOrderMaterialAdditionalDetail][<?= $index ?>][is_used]" id="isUsed<?= $index ?>" value="1" onclick="getTotalHarga(<?= $index ?>);uncheckRemovePrice(<?= $index ?>)">
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-right"><strong>Biaya Kirim</strong></td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">Rp.</span>
                                                                    <input type="text" class="form-control text-right isdecimal" onkeyup="getGrandTotal()" name="data[PurchaseOrderMaterialAdditional][shipment_cost]" id="shipmentCost">
                                                                    <span class="input-group-addon">,00.</span>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">Rp.</span>
                                                                    <input type="text" class="form-control text-right" readonly id="grandTotal" value = "0">
                                                                    <span class="input-group-addon">,00.</span>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <br><br>
                                            <div class="table-responsive stn-table">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu Yang Sudah Diproses") ?></h6>
                                                </div>
                                                <table width="100%" class="table table-hover table-bordered">
                                                    <tr>
                                                        <th width="1%" style="text-align: center;">No</th>
                                                        <th width="35%" style="text-align: center;">Nama</th>
                                                        <th width="15%" colspan="2" style="text-align: center;">Jumlah</th>
                                                        <th width="20%" colspan="2">Harga Per Pcs</th>
                                                        <th width="20%" colspan="2">Total</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $total = 0;
                                                        if (!empty($this->data['PurchaseOrderMaterialAdditionalDetail'])) {
                                                            foreach ($this->data['PurchaseOrderMaterialAdditionalDetail'] as $index => $details) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?= $i ?></td>
                                                                    <td>
                                                                        <?= $details['MaterialAdditional']['name']." ".$details['MaterialAdditional']['size'] ?>
                                                                    </td>
                                                                    <td class="text-right" style="border-right-style:none;">
                                                                        <?= (ic_kg($details['quantity'])) ?>
                                                                    </td> 
                                                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                                        <?= $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                                                                    </td>
                                                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                                        Rp.
                                                                    </td>    
                                                                    <td class = "text-right" style="border-left-style:none;">
                                                                        <?= ic_rupiah($details['price']) ?>
                                                                    </td>
                                                                    <?php
                                                                    $total = $details['price'] * $details['quantity'];
                                                                    ?>
                                                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                                        Rp.
                                                                    </td>    
                                                                    <td class = "text-right" style="border-left-style:none;">
                                                                        <?= ic_rupiah($total) ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    $(document).ready(function () {

    });

    function getTotalHarga(n) {
        var jmlh = $("#quantity" + n).val();
        var jumlah = parseFloat(jmlh);
        if($("#isUsed" + n).is(':checked')) {
            if ($("#hargaPO" + n).val() == "") {
                var harga = 0;
                var total = harga * jumlah;
            } else {
                var harga = $("#hargaPO" + n).val();
                var fixHarga = parseInt(replaceAll(harga, ".", ""));
                var total = fixHarga * jumlah;
            }
        }
        $("#total" + n).val(ic_rupiah(total));
        getGrandTotal();
    }
    
    function uncheckRemovePrice(n){
        if(!$("#isUsed" + n).is(':checked')){
            $("#hargaPO" + n).val(0);
        }    
    }

    function getGrandTotal() {
        var grandTotal = 0;
        $.each($(".total"), function () {
            var total = parseInt(replaceAll($(this).val(), ".", ""));
            grandTotal += total;
        });
        if ($("#shipmentCost").val() == "") {
            var shipmentCost = 0;
        } else {
            var shipCost = $("#shipmentCost").val();
            var shipmentCost = parseInt(replaceAll(shipCost, ".", ""));
        }
        grandTotal += shipmentCost;
        $("#grandTotal").val(IDR(grandTotal));
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }
</script>