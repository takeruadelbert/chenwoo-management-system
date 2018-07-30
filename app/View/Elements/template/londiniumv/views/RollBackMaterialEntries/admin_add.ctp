<?php echo $this->Form->create("RollBackMaterialEntry", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Perubahan Transaksi Barang Masuk") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Transaksi yang akan diubah") ?></h6>
            </div>
            <div>
                <div class="form-group">
                    <?php
                    echo $this->Form->label("RollBackMaterialEntry.material_entry_id", __("Data Material yang Salah"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("RollBackMaterialEntry.material_entry_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full", "placeholder" => "- Pilih Pemasok -"));
                    ?>
                </div>    
            </div>
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Transaksi Baru") ?></h6>
            </div>
            <div id="materialList">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("MaterialEntry.supplier_id", __("Pemasok"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("MaterialEntry.supplier_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full", "placeholder" => "- Pilih Pemasok -"));
                    ?>
                    <?php
                    echo $this->Form->label("MaterialEntry.material_category_id", __("Tipe Material"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("MaterialEntry.material_category_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full materialCategories", "onChange" => "setOptionTipeMaterial(this)", "placeholder" => "- Pilih Tipe Material -"));
                    ?>
                </div>    
            </div>
            <div>
                <div class="panel panel-default">
                        <div class="panel-body" id="materialList">
                            <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Ikan") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                <th width="1%" style="text-align: center;">No</th>
                                <th width="25%" style="text-align: center;">Nama Material</th>
                                <th width="20%" style="text-align: center;">Size Material</th>
                                <th width="15%" style="text-align: center;">Jumlah Ikan</th>
                                <th width="20%" style="text-align: center;">Berat Ikan (Satuan Kilogram)</th>
                                <th width="5%" style="text-align: center;">Aksi</th>
                                </thead>
                                <tbody id="target-material-data">

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <tr>
                                        <td colspan="8">
                                            <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this, 'material-data', '')" data-n="1"><i class="icon-plus-circle"></i></a>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
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

    function setOptionTipeMaterial(tipe) {
        $("tr.material-data-input").remove();
        $("tr.material-detail-data-input").remove();  
        addThisRow(".firstrunclick", 'material-data', "");
    }

    function addMaterial() {
        list_materials = "<select name='data[MaterialEntryGrade][" + count + "][material_id]' class='form-control' id='MaterialEntry1MaterialId'>";
        list_materials += "<option value='0'>-Pilih Material-</option>";
        for (i = 0; i < data_material_no.length; i++) {
            list_materials += "<option value='" + data_material_no[i] + "'>" + data_material_nama[i] + "</option>";
        }
        list_materials += "</select>";
        count++;
    }

    function updateTotal(n) {
        var total = 0;
        if (document.getElementById("MaterialEntryGrade" + n + "Weight").value != null && document.getElementById("MaterialEntryGrade" + n + "Price").value != null) {
            $weight = document.getElementById("MaterialEntryGrade" + n + "Weight").value;
            $price = document.getElementById("MaterialEntryGrade" + n + "Price").value;
            document.getElementById("TotalMaterial" + n).value = IDR(parseInt(parseInt($weight.replaceAll('.', '')) * parseInt($price.replaceAll('.', ''))));
        }
        $('input.TotalMaterial').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt.replaceAll('.', ''));
        });
        $("input.auto-calculate-grand-total-produk-data").val(IDR(total));
    }

    function showDetails(n) {
        document.getElementById("weight_material_details" + n).innerHTML = "";
        var count = parseInt($("input.MaterialEntryGrade" + n + "Quantity").val());
        $("#weight_material_details" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan (Sesuai Nota Timbang):</h6></div>");
        for (i = 0; i < count; i++) {
            $("#weight_material_details" + n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='Ikan " + (i + 1) + "' class='form-control isDecimal beratTimbangan" + n + "" + i + "' name='data[MaterialEntryGrade][" + n + "][MaterialEntryGradeDetail][" + i + "][weight]' id='beratTimbangan" + n + "" + i + "Weight' onkeyup='calculateWeight(" + n + ")'><span class='input-group-addon'>Kg</span></div></div>");
        }

    }

    function calculateWeight(n) {
        var total = 0;
        var count = parseInt($("input.MaterialEntryGrade" + n + "Quantity").val());
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

    function deleteThisRow(e,n) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        $("tr#material-detail-data-input"+n).remove();
        count--;
        //$("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
        fixNumber(tbody);
        updateTotal(0);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".qtyIdx").attr("id", "MaterialEntryGrade" + i + "Weight");
            $(this).find(".qtyPrice").attr("id", "MaterialEntryGrade" + i + "Price");
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
        var optFunc = $("select.materialCategories").map(function(){
                    return this.value;
                }).get();
        if (optFunc == 1) {
            data_material = data_materialWhole;
            data_satuan = "Ekor";
        } else {
            data_material = data_materialColly;
            data_satuan = "Pcs";
        }
        var options = {i: 2, n: n, data_material: data_material, data_material_size: data_material_size,data_satuan:data_satuan};
        var rendered = Mustache.render(template, options);
        $('#target-' + t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-' + t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-' + t).find("tr").last(), n);
        count++;
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[MaterialEntryGrade][{{n}}][material_detail_id]' class='select-full' id='MaterialEntryGradeId' placeholder = "- Pilih Material -">
    <option value='0'>-Pilih Material-</option>
    {{#data_material}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material}}
    </select>
    </td>
    <td class="text-center">
    <select name='data[MaterialEntryGrade][{{n}}][material_size_id]' class='select-full' id='MaterialEntryGradeSizeId'>
    <option value='0'>-Pilih Size-</option>
    {{#data_material_size}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material_size}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name='data[MaterialEntryGrade][{{n}}][quantity]' class='form-control idx MaterialEntryGrade{{n}}Quantity text-right' id='MaterialEntryGrade{{n}}Quantity' onkeyup="showDetails({{n}})"/>
    <span class="input-group-addon" class='satuanCategoryMaterial'>{{data_satuan}}</span>   
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name='data[MaterialEntryGrade][{{n}}][weight]' class='form-control text-right isdecimal qtyIdx totalWeight{{n}}' id='MaterialEntryGrade{{n}}Weight' onkeyup='updateTotal({{n}})' readonly/>
    <span class="input-group-addon">Kg</span>
    </div>
    <input type='hidden' name='data[MaterialEntryGrade][{{n}}][remaining_weight]' class='form-control isdecimal qtyIdx totalRemainingWeight{{n}}' id='MaterialEntryGrade{{n}}RemainingWeight' readonly/>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this),{{n}})">
    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
    <i class="icon-remove3"></i>
    </button>
    </a>
    </td>   
    </tr>
    <tr class="material-detail-data-input" id="material-detail-data-input{{n}}">
    <td id="weight_material_details{{n}}" colspan="8">
    </td>
    </tr>

</script>
<?php echo $this->Form->end() ?>
