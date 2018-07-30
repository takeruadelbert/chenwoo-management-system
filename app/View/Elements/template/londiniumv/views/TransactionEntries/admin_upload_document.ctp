<?php echo $this->Form->create("TransactionEntry", array("class" => "form-horizontal form-separate", "action" => "upload_document", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
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
                                echo $this->Form->input("TransactionEntry.employee_name", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                ?>
                            </div>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.created_date__ic", __("Tanggal Dibuat"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.created_date__ic", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control", "readonly"));
                                ?>                                          
                                <?php
                                echo $this->Form->label("TransactionEntry.due_date__ic", __("Tanggal Jatuh Tempo"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.due_date__ic", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control", "readonly"));
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
                                    <tr>
                                        <th width="50" style="text-align: center;">No</th>
                                        <th style="text-align: center;">Nama Material</th>
                                        <th width="10%" style="text-align: center;">Grade</th>
                                        <th width="12%" style="text-align: center;">Jumlah Ikan</th>
                                        <th width="12%" style="text-align: center;">Total Berat</th>
                                    </tr>
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
                                    $total = 0;
                                    $grandTotal = 0;
                                    $shippingCost = $this->data['TransactionEntry']['shipping_cost'];
                                    foreach ($this->data['TransactionMaterialEntry'] as $index => $grade) {
                                        $total = $grade['price'] * $grade['weight'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td>                                            
                                                <input type="text" class="form-control" value="<?= $grade['MaterialDetail']['Material']['name'] . " " . $grade['MaterialDetail']['name'] ?>" readonly>
                                            </td>
                                            <td>                                            
                                                <input type="text" class="form-control" value="<?= $grade['MaterialSize']['name'] ?>" readonly>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" value="<?= $grade['quantity'] ?>" readonly>
                                                    <span class="input-group-addon"><strong><?= $type ?></strong></span>
                                                </div>                                                
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" value="<?= ic_kg($grade['weight']) ?>" readonly>
                                                    <span class="input-group-addon"><strong>Kg</strong></span>
                                                </div>                                                
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                        $grandTotal += $grade['weight'];
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-right" readonly value="<?= ic_kg($grandTotal) ?>">
                                                <span class="input-group-addon">Kg</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Upload Dokumen QC") ?></h6>
                            </div>
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th >File</th>
                                        <th width="50" style="border-right: 1px solid #ddd">Aksi</th>
                                    </tr>
                                <thead>
                                <tbody id="target-detail-kas-keluar">
                                    <tr>
                                        <td class="text-center nomorIdx">
                                            1
                                        </td>
                                        <td>
                                            <input type="file" class="form-control" name="data[TransactionEntryFile][0][file]">
                                        </td>
                                        <td class="text-center" style="border-right: 1px solid #ddd">
                                            <a href="javascript:void(false)" onclick="deleteThisRows($(this))"><i class="icon-remove3"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRows($(this), 'detail-kas-keluar')" data-n="1" data-k="0"><i class="icon-plus-circle"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel panel-default">
                    <div class="panel-body" id="materialList">
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Status Dokumen QC") ?></h6>
                            </div>
                            <table width="100%" class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("TransactionEntry.document_status_id", __("Status Dokumen QC"), array("class" => "col-md-2 control-label"));
                                                echo $this->Form->input("TransactionEntry.document_status_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Status Dokumen -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
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
            total += parseInt($(this).val().replaceAll(".", ""));
        });
        var shippingCost = parseInt($("#shippingCost").val().replaceAll(".", ""));
        total += shippingCost;
        $("#GrandTotal").val(IDR(total));
    }

    function getTotalHargaIkan(n) {
        $("#ikan" + n).on("change keyup", function () {
            var hargaIkan = parseInt($(this).val().replaceAll(".", ""));
            var berat = $("#weight" + n).val();
            var result = hargaIkan * berat;
            $("#TotalMaterial" + n).val(IDR(result));
            updateGrandTotal();
        });
    }

    //untuk upload dokumen material
    function addThisRows(e, t, optFunc) {
        var n = $(e).data("n");
        var k = $(e).data("k");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {
            i: 2,
            n: n,
            k: k
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        $(e).data("k", k + 1);
        reloadDatePicker();
        reloadSelect2();
        reloadisdecimal()
        fixNumbers($(e).parents("tbody"));
    }
    function fixNumbers(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function deleteThisRows(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="file" class="form-control" name="data[TransactionEntryFile][{{n}}][file]">
    </td>
    <td class="text-center"style="border-right: 1px solid #ddd">
    <a href="javascript:void(false)" onclick="deleteThisRows($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<?php echo $this->Form->end() ?>