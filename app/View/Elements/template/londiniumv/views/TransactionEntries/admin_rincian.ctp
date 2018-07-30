<?php echo $this->Form->create("TransactionEntry", array("class" => "form-horizontal form-separate", "action" => "rincian", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Penambahan Transaksi Barang Masuk") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("Dummy.material_entry", __("Nomor Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("Dummy.material_entry", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "value" => $this->data['MaterialEntry']['material_entry_number'], "readonly"));
                                echo $this->Form->input("TransactionEntry.material_category_id", array("div" => array("class" => "col-md-4"), "type" => "hidden", "label" => false, "value" => $this->data['MaterialCategory']['id']));
                                echo $this->Form->input("TransactionEntry.material_entry_id", ["type" => "hidden", "value" => $this->data['MaterialEntry']['id']]);
                                ?>
                                <?php
                                echo $this->Form->label("Dummy.material_entry_date", __("Tanggal Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("Dummy.material_entry_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control", "readonly", "value" => $this->Html->cvtTanggal($this->data['MaterialEntry']['created'])));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.employee_name", __("Nama Pegawai Pembuat Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.employee_name", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly", "value" => $this->data['MaterialEntry']['Employee']['Account']['Biodata']['full_name']));
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.supplier_name", __("Supplier"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("TransactionEntry.supplier_name", array("div" => array("class" => "col-sm-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Supplier']['name']));
                                ?>
                                <?php
                                echo $this->Form->label("TransactionEntry.employee_name", __("Nama Pegawai Kasir"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.employee_name", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                ?>
                            </div>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.created_date", __("Tanggal Dibuat"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.created_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control datetime", "readonly", "value" => date("Y-m-d H:i:s")));
                                ?>                                          
                                <?php
                                echo $this->Form->label("TransactionEntry.due_date", __("Tanggal Jatuh Tempo"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.due_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                ?>
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style="color:#fff"><i class="icon-menu2"></i><?= __("Detail Nota Timbang") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                <th width="10px" style="text-align: center;">No</th>
                                <th width="250px" style="text-align: center;">Nama Material</th>
                                <th width="75px" style="text-align: center;">Grade</th>
                                <th width="100px" style="text-align: center;">Jumlah Ikan (ekor)</th>
                                <th width="200px" style="text-align: center;">Harga Ikan (per Kg)</th>
                                <th width="180px" style="text-align: center;">Berat Ikan (Satuan Kilogram)</th>
                                <th width="200px" style="text-align: center;">Total</th>
                                </thead>
                                <tbody id="target-material-data">
                                    <?php
                                    $i = 1;
                                    $type = "";
                                    if ($this->data['MaterialCategory']['id'] == 1) {
                                        $type = "Ekor";
                                    } else {
                                        $type = "Pcs";
                                    }
                                    foreach ($this->data['MaterialEntry']['MaterialEntryGrade'] as $index => $grade) {
                                        ?>
                                    <input type="hidden" name="data[TransactionMaterialEntry][<?= $index ?>][material_detail_id]" value="<?= $grade['MaterialDetail']['id'] ?>" class="form-control">
                                    <input type="hidden" class="form-control" value="<?= $grade['MaterialSize']['id'] ?>" name="data[TransactionMaterialEntry][<?= $index ?>][material_size_id]">
                                    <tr>
                                        <td class = "text-center">
                                            <?= $i ?>
                                        </td>
                                        <td>   
                                            <input class ="form-control text-left" value = "<?= $grade['MaterialDetail']['Material']['name'] . " " . $grade['MaterialDetail']['name'] ?>" disabled>                                         
                                        </td>
                                        <td>                                            
                                            <input class ="form-control text-left" value = "<?= $grade['MaterialSize']['name'] ?>" disabled>                                         
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-right" value="<?= $grade['quantity'] ?>" readonly name="data[TransactionMaterialEntry][<?= $index ?>][quantity]">
                                                <span class="input-group-addon"><strong><?= $type ?></strong></span>
                                            </div>                                                
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type='text' name="data[TransactionMaterialEntry][<?= $index ?>][price]" class='form-control text-right isdecimal' id="ikan<?= $index ?>" onkeyup="getTotalHargaIkan(<?= $index ?>)"/>
                                                <span class="input-group-addon">,00</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type='text' name='data[TransactionMaterialEntry][<?= $index ?>][weight]' class='form-control text-right qtyIdx' id='weight<?= $index ?>' value="<?= $grade['weight'] ?>" readonly/>
                                                <span class="input-group-addon"><strong>Kg.</strong></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type='text' class='form-control text-right TotalMaterial' id="TotalMaterial<?= $index ?>" value="0" readonly/>
                                                <span class="input-group-addon">,00</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8" style="display:none;">
                                            <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'material-data', '')" data-n="1"><i class="icon-plus-circle"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">
                                            <strong>Biaya Pengiriman</strong>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <?php
                                                echo $this->Form->input("TransactionEntry.shipping_cost", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "id" => "shippingCost", "type" => "text"));
                                                ?>
                                                <span class="input-group-addon">,00</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="right">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control text-right" id="GrandTotal" name="data[TransactionEntry][total]"readonly>
                                                <span class="input-group-addon">,00</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#shippingCost").on("change keyup", function () {
            updateGrandTotal();
        });
    });

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function updateGrandTotal() {
        var total = 0;
        $(".TotalMaterial").each(function () {
            total += parseFloat($(this).val().replaceAll(".", ""));
        });
        var shippingCost = parseFloat($("#shippingCost").val().replaceAll(".", ""));
        total += shippingCost;
        $("#GrandTotal").val(ic_rupiah(total));
    }

    function getTotalHargaIkan(n) {
        $("#ikan" + n).on("change keyup", function () {
            var hargaIkan = parseFloat($(this).val().replaceAll(".", ""));
            var berat = parseFloat($("#weight" + n).val());
            var result = hargaIkan * berat;
            $("#TotalMaterial" + n).val(ic_rupiah(result));
            updateGrandTotal();
        });
    }
</script>
<?php echo $this->Form->end() ?>