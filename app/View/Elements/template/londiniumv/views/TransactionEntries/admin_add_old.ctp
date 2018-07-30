<?php echo $this->Form->create("TransactionEntry", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
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
                                echo $this->Form->label("TransactionEntry.material_entry_id", __("Nomor Nota Timbang"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("TransactionEntry.material_entry_id", array("div" => array("class" => "col-sm-4"), "empty" => "", "label" => false, "class" => "select-full", "placeholder" => "- Pilih Nomor Nota Timbang -", "onchange" => "generateMaterialEntry()", "id" => "materialEntryId"));
                                ?>
                                <?php
                                echo $this->Form->label("TransactionEntry.due_date", __("Tanggal Jatuh Tempo"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.due_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                ?>
                            </div>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.supplier_name", __("Supplier"), array("class" => "col-sm-2 control-label"));
                                echo $this->Form->input("TransactionEntry.supplier_name", array("div" => array("class" => "col-sm-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly"));
                                echo $this->Form->input("TransactionEntry.supplier_id", array("div" => array("class" => "col-md-4"), "type" => "hidden", "label" => false));
                                echo $this->Form->input("TransactionEntry.material_category_id", array("div" => array("class" => "col-md-4"), "type" => "hidden", "label" => false, "class" => "materialCategories", "onChange" => "setOptionTipeMaterial(this)"));
                                ?>
                                <?php
                                echo $this->Form->label("TransactionEntry.material_entry_date", __("Tanggal Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.material_entry_date", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "type" => "text", "class" => "form-control datepicker", "readonly"));
                                ?>
                            </div>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("TransactionEntry.employee_name", __("Nama Pegawai"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("TransactionEntry.employee_name", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "form-control", "readonly"));
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
                                <th width="1%" style="text-align: center;">No</th>
                                <th width="15%" style="text-align: center;">Nama Material</th>
                                <th width="10%" style="text-align: center;">Grade</th>
                                <th width="12%" style="text-align: center;">Jumlah Ikan (ekor)</th>
                                <th width="17%" style="text-align: center;">Harga Ikan (per Kg)</th>
                                <th width="11%" style="text-align: center;">Berat Ikan (Satuan Kilogram)</th>
                                <th width="20%" style="text-align: center;">Total</th>
                                </thead>
                                <tbody id="target-material-data">

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
                                                <span class="input-group-addon">.00</span>
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
                                                <input type="text" class="form-control text-right isdecimal auto-calculate-grand-total-produk-data" id="GrandTotal" name="data[TransactionEntry][total]"readonly>
                                                <span class="input-group-addon">.00</span>
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
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Upload Dokumen QC") ?></h6>
            </div>
            <table class="table table-hover table-bordered stn-table" width="100%">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="25%">File</th>
                        <th width="3%" style="border-right: 1px solid #ddd">Aksi</th>
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
                            <a class="text-success dataN0" href="javascript:void(false)" onclick="addThisRows($(this), 'detail-kas-keluar', 'anakOptions')" data-n="1" data-k="0"><i class="icon-plus-circle"></i></a>
                        </td>
                    </tr>
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
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php
$listSize = [];
$listMaterialWhole = [];
$listMaterialColly = [];
foreach ($dataMaterialSize as $size) {
    $listSize[] = [
        "id" => $size["MaterialSize"]["id"],
        "label" => $size["MaterialSize"]["name"],
    ];
}
foreach ($dataMaterialWhole as $materialWhole) {
    foreach ($materialWhole['MaterialDetail'] as $detail) {
        $listMaterialWhole[] = [
            "id" => $detail["id"],
            "label" => $materialWhole["Material"]["name"] . $detail['name'],
        ];
    }
}
foreach ($dataMaterialColly as $materialColly) {
    foreach ($materialColly['MaterialDetail'] as $detail) {
        $listMaterialColly[] = [
            "id" => $detail["id"],
            "label" => $materialColly["Material"]["name"] . $detail['name'],
        ];
    }
}
?>
<script>
    var count = 1;
    var data_material_size = <?= json_encode($listSize) ?>;
    var data_materialWhole = <?= json_encode($listMaterialWhole) ?>;
    var data_materialColly = <?= json_encode($listMaterialColly) ?>;
    var list_materials = "";
    $(document).ready(function () {
        //addThisRow(".firstrunclick", 'material-data', '');
    });

    function generateMaterialEntry() {
        $("tbody.target-material-data").html("");
        var id = $('#materialEntryId').val();
        $.ajax({
            url: BASE_URL + "admin/material_entries/get_data_material_entry/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                var request = data.data;
                $("input#TransactionEntrySupplierId").val(request['MaterialEntry']['supplier_id']);
                $("input#TransactionEntryMaterialCategoryId").val(request['MaterialEntry']['material_category_id']);
                $("input#TransactionEntryMaterialEntryDate").val(cvtTanggal(request['MaterialEntry']['created']));
                $("input#TransactionEntrySupplierName").val(request['Supplier']['name']);
                $("input#TransactionEntryEmployeeName").val(request['Employee']['Account']['Biodata']['full_name']);
                for (i = 0; i < request['MaterialEntryGrade'].length; i++) {
                    addThisRow(".firstrunclick", 'material-data', request['MaterialEntry']['material_category_id']);
                    var weight = request['MaterialEntryGrade'][i]['weight'] + "";
                    $("input#TransactionMaterialEntry" + (i + 1) + "Weight").val(weight.replace(".", ","));
                    $("input#TransactionMaterialEntry" + (i + 1) + "RemainingWeight").val(request['MaterialEntryGrade'][i]['weight']);
                    $("input#TransactionMaterialEntry" + (i + 1) + "Quantity").val(request['MaterialEntryGrade'][i]['quantity'].replace(".00", ""));
//                    alert(request['MaterialEntryGrade'][i]['quantity']);
                    $("select#TransactionEntry" + (i + 1) + "MaterialId").select2("val", request['MaterialEntryGrade'][i]['MaterialDetail']['id']);
                    $("select#TransactionEntry" + (i + 1) + "MaterialSizeId").select2("val", request['MaterialEntryGrade'][i]['MaterialSize']['id']);
                    $("input#TransactionMaterialEntryTemp" + (i + 1) + "material_detail_id").val(request['MaterialEntryGrade'][i]['MaterialDetail']['Material']['name'] + " - " + request['MaterialEntryGrade'][i]['MaterialDetail']['name']);
                    $("input#TransactionMaterialEntryTemp" + (i + 1) + "material_size_id").val(request['MaterialEntryGrade'][i]['MaterialSize']['name']);
                }
            }
        });
    }

    function setOptionTipeMaterial(tipe) {
        $("tr.material-data-input").remove();
        $("tr.material-detail-data-input").remove();
        addThisRow(".firstrunclick", 'material-data', "");
    }

    function addMaterial() {
        list_materials = "<select name='data[TransactionMaterialEntry][" + count + "][material_id]' class='form-control' id='TransactionEntry1MaterialId'>";
        list_materials += "<option value='0'>-Pilih Material-</option>";
        for (i = 0; i < data_material_no.length; i++) {
            list_materials += "<option value='" + data_material_no[i] + "'>" + data_material_nama[i] + "</option>";
        }
        list_materials += "</select>";
        //$("#materialList").append("<div class='form-group'><label for='TransactionEntryMaterial[" + count + "]id' class='col-md-2 control-label'>Nama Material "+count+"</label><div class='col-md-2'>"+list_materials+"</div><label for='TransactionEntryMaterial[" + count + "]id' class='col-md-2 control-label'>Jumlah Material "+count+"</label><div class='col-md-2'><input type='input' name='data[TransactionMaterialEntry][" + count + "][quantity]' class='form-control' id='TransactionMaterialEntry" + count + "Quantity' onkeyup='updateTotal()'/></div><label for='TransactionEntryMaterial[" + count + "]id' class='col-md-2 control-label'>Harga Material "+count+"</label><div class='col-md-2'><input type='input' name='data[TransactionMaterialEntry][" + count + "][price]' class='form-control' id='TransactionMaterialEntry" + count + "Price' onkeyup='updateTotal()'/></div></div>");
        count++;
    }

    function updateTotal(n) {
        var total = 0;
        if (document.getElementById("TransactionMaterialEntry" + n + "Weight").value != null && document.getElementById("TransactionMaterialEntry" + n + "Price").value != null) {
            $weight = document.getElementById("TransactionMaterialEntry" + n + "Weight").value;
            $price = document.getElementById("TransactionMaterialEntry" + n + "Price").value;
            document.getElementById("TotalMaterial" + n).value = IDR(parseInt(parseInt($weight) * parseInt($price.replaceAll('.', ''))));
        }
        $('input.TotalMaterial').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt.replaceAll('.', ''));
        });
        total += parseInt($("input#TransactionEntryShippingCost").val().replaceAll('.', ''));
        $("input.auto-calculate-grand-total-produk-data").val(IDR(total));
    }

    function showDetails(n) {
        document.getElementById("weight_material_details" + n).innerHTML = "";
        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
        $("#weight_material_details" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan (Sesuai Nota Timbang):</h6></div>");
        for (i = 0; i < count; i++) {
            $("#weight_material_details" + n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='Ikan " + (i + 1) + "' class='form-control isDecimal beratTimbangan" + n + "" + i + "' name='data[TransactionMaterialEntry][" + n + "][TransactionMaterialEntryDetail][" + i + "][weight]' id='beratTimbangan" + n + "" + i + "Weight' onkeyup='calculateWeight(" + n + ")'><span class='input-group-addon'>Kg</span></div></div>");
        }

    }

    function calculateWeight(n) {
        var total = 0;
        var count = parseInt($("input.TransactionMaterialEntry" + n + "Quantity").val());
        for (i = 0; i < count; i++) {
            if ($("input.beratTimbangan" + n + i).val() != "") {
                total += parseInt($("input.beratTimbangan" + n + i).val());
            }

        }
        $("input.totalWeight" + n).val(total);
        $("input.totalRemainingWeight" + n).val(total);
    }

    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e, n) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        $("tr#material-detail-data-input" + n).remove();
        count--;
        //$("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
        fixNumber(tbody);
        updateTotal(0);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".qtyIdx").attr("id", "TransactionMaterialEntry" + i + "Weight");
            $(this).find(".qtyPrice").attr("id", "TransactionMaterialEntry" + i + "Price");
            $(this).find(".TotalMaterial").attr("id", "TotalMaterial" + i);
            i++;
        })
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var data_material = null;
        var data_satuan = null;
        //Check selected categories
        if (optFunc == "") {
            optFunc = $("select.materialCategories").map(function () {
                return this.value;
            }).get();
        }
        if (optFunc == 1) {
            data_material = data_materialWhole;
            data_satuan = "Ekor";
        } else {
            data_material = data_materialColly;
            data_satuan = "Pcs";
        }
        var options = {i: 2, n: n, data_material: data_material, data_material_size: data_material_size, data_satuan: data_satuan};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
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
    function anakOptions() {
        return {};
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <input type="input" class='form-control' name='data[TransactionMaterialEntryTemp][{{n}}][material_detail_id]' id="TransactionMaterialEntryTemp{{n}}material_detail_id" value='' readonly/>             
    <select name='data[TransactionMaterialEntry][{{n}}][material_detail_id]' class='select-full' id='TransactionEntry{{n}}MaterialId' style="visibility:hidden;height:0px;display:none;" readonly>
    <option value='0'>-Pilih Material-</option>
    {{#data_material}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material}}
    </select>
    </td>
    <td class="text-center">
    <input type="input" class='form-control' name='data[TransactionMaterialEntryTemp][{{n}}][material_size_id]' id="TransactionMaterialEntryTemp{{n}}material_size_id" value='' readonly/>
    <select name='data[TransactionMaterialEntry][{{n}}][material_size_id]' class='select-full' id='TransactionEntry{{n}}MaterialSizeId' style="visibility:hidden;height:0px;display:none;" readonly>
    <option value='0'>-Pilih Size-</option>
    {{#data_material_size}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material_size}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name='data[TransactionMaterialEntry][{{n}}][quantity]' class='form-control idx TransactionMaterialEntry{{n}}Quantity text-right' id='TransactionMaterialEntry{{n}}Quantity' readonly/> <!--onkeyup="showDetails({{n}})"-->
    <span class="input-group-addon" class='satuanCategoryMaterial'>{{data_satuan}}</span>   
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type='input' name="data[TransactionMaterialEntry][{{n}}][price]" class='form-control isdecimal qtyPrice text-right' id="TransactionMaterialEntry{{n}}Price" onkeyup='updateTotal({{n}})'/>
    <span class="input-group-addon">.00</span>
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name='data[TransactionMaterialEntry][{{n}}][weight]' class='form-control text-right qtyIdx totalWeight{{n}}' id='TransactionMaterialEntry{{n}}Weight' onkeyup='updateTotal({{n}})' readonly/>
    <span class="input-group-addon">Kg</span>
    </div>
    <input type='hidden' name='data[TransactionMaterialEntry][{{n}}][remaining_weight]' class='form-control qtyIdx totalRemainingWeight{{n}}' id='TransactionMaterialEntry{{n}}RemainingWeight' readonly/>
    </td>
    <td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input type='input' name="[Total]" class='form-control text-right TotalMaterial' id="TotalMaterial{{n}}" readonly/>
    <span class="input-group-addon">.00</span>
    </div>  
    </tr>
    <tr class="material-detail-data-input" id="material-detail-data-input{{n}}">
    <!--<td id="weight_material_details{{n}}" colspan="8">
    </td>-->
    </tr>

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
