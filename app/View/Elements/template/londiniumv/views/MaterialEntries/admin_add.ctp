<?php echo $this->Form->create("MaterialEntry", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Pembuatan Nota Timbang") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>

            <div class="panel panel-default">
                <div class="panel-body" id="materialList">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <br>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Employee.id", __("Nama"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Employee.id", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                            ?>
                            <?php
                            echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                            ?>
                        </div>    
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Employee.department", __("Departemen"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Employee.department", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                            ?>
                            <?php
                            echo $this->Form->label("Employee.office", __("Jabatan"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Employee.office", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" id="materialList">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai Pelaksana") ?></h6>
                        </div>
                        <br>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-sm-2 control-label"));
                            ?>
                            <div class="col-sm-4">
                                <div class="has-feedback">
                                    <?php
                                    echo $this->Form->input("Dummy.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax", "empty" => "", "placeholder" => "Cari Nama Pegawai ..."));
                                    ?>
                                    <?php
                                    echo $this->Form->input("MaterialEntry.operator_id", array("type" => "hidden", "class" => "form-control"));
                                    ?>
                                    <i class="icon-search3 form-control-feedback"></i>
                                </div>
                            </div>
                            <?php
                            echo $this->Form->label("Operator.nip", __("NIP"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                            ?>
                        </div>    
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Operator.department", __("Departemen"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Operator.department", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                            ?>
                            <?php
                            echo $this->Form->label("Operator.office", __("Jabatan"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("Operator.office", array("div" => array("class" => "col-md-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" id="materialList">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Nota Timbang") ?></h6>
                        </div>
                        <br>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("MaterialEntry.supplier_id", __("Supplier"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("MaterialEntry.supplier_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full", "placeholder" => "- Pilih Supplier -", "id" => "supplierId"));
                            ?>
                            <?php
                            echo $this->Form->label("MaterialEntry.material_category_id", __("Tipe Material"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("MaterialEntry.material_category_id", array("div" => array("class" => "col-md-4"), "empty" => "", "label" => false, "class" => "select-full materialCategories", "id" => "matCats", "placeholder" => "- Pilih Tipe Material -"));
                            ?>
                        </div>    
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("MaterialEntry.weight_date", __("Tanggal Timbang"), array("class" => "col-md-2 control-label"));
                            echo $this->Form->input("MaterialEntry.weight_date", array("div" => array("class" => "col-md-4"), "type" => "text", "empty" => "", "value" => date("Y-m-d H:i:s"), "label" => false, "class" => "datepicker form-control"));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" id="materialList">
                    <div class="table-responsive stn-table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Ikan") ?></h6>
                        </div>
                        <br>
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%" style="text-align: center;">No</th>
                                    <th width="25%" style="text-align: center;">Nama Material</th>
                                    <th width="20%" style="text-align: center;">Grade</th>
                                    <th width="15%" style="text-align: center;">Jumlah <span id="satuanjumlah">Ikan</span></th>
                                    <th width="20%" style="text-align: center;">Total Berat</th>
                                    <th width="5%" style="text-align: center; border-right: 1px solid #ddd">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="target-material-data">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;">
                                        Grand Total
                                    </td>
                                    <td>
                                        <div class="input-group">
                                        <input type='text' name='data[Dummy][{{n}}][total]' class='form-control text-right isdecimal qtyIdx grandTotalWeight' id='Dummy{{n}}GrandTotalWeight' readonly/>
                                        <span class="input-group-addon">Kg</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
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
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger checkdata" id="buttonSubmit"  type="button"  href="#"> <!--onclick="return validateData()" data-toggle="modal"  data-target="#add"   href="<php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>"-->
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<?php
$listSize = [];
$listMaterialWhole = [];
$listMaterialColly = [];
$listMaterialDasar = [];
foreach ($dataMaterialSize as $size) {
    $listSize[] = [
        "id" => $size["MaterialSize"]["id"],
        "label" => $size["MaterialSize"]["name"],
    ];
}
foreach ($dataMaterialWhole as $materialWhole) {
    $childs = [];
    foreach ($materialWhole['MaterialDetail'] as $detail) {
        $childs[] = [
            "id" => $detail["id"],
            "label" => $detail['name'],
        ];
    }
    $listMaterialWhole[] = [
        "id" => "",
        "label" => $materialWhole["Material"]["name"],
        "child" => $childs,
    ];
}
foreach ($dataMaterialColly as $materialColly) {
    $childs = [];
    foreach ($materialColly['MaterialDetail'] as $detail) {
        $childs[] = [
            "id" => $detail["id"],
            "label" => $detail['name'],
        ];
    }
    $listMaterialColly[] = [
        "id" => "",
        "label" => $materialColly["Material"]["name"],
        "child" => $childs,
    ];
}
foreach ($dataMaterialDasar as $materialDasar) {
    $childs = [];
    foreach ($materialDasar['MaterialDetail'] as $detail) {
        $childs[] = [
            "id" => $detail["id"],
            "label" => $detail['name'],
        ];
    }
    $listMaterialDasar[] = [
        "id" => "",
        "label" => $materialColly["Material"]["name"],
        "child" => $childs,
    ];
}
?>
<script>
    $(document).ready(function () {
        var employees = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('full_name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/employees/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/employees/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        employees.clearPrefetchCache();
        employees.initialize(true);
        $('input.typeahead-ajax').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'employees',
            display: 'full_name',
            source: employees.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pegawai</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nama : ' + context.full_name + '<br>NIP : ' + context.nip + '<br>Jabatan : ' + context.jabatan + '<br>Department : ' + context.department + '<br/>Cabang : ' + context.branch_office + '</p>';
                },
                empty: [
                    '<center><h5>Data Pegawai</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax').bind('typeahead:select', function (ev, suggestion) {
            $('#MaterialEntryOperatorId').val(suggestion.id).trigger("change");
            $('#OperatorNip').val(suggestion.nip);
            $('#OperatorDepartment').val(suggestion.jabatan);
            $('#OperatorOffice').val(suggestion.department);
        });
//        $(".checkdata").on("click", function () {
//            var ispassed = true;
//            $('input.basket').each(function () {
//                if ($(this).val() == "") {
//                    alert("Harap isi Basket ikan!");
//                    ispassed = false;
//                }
//            });
//            return ispassed;
//        })
    })
</script>
<script>
    var count = 1;
    var data_material_size = <?= json_encode($listSize) ?>;
    var data_materialWhole = <?= json_encode($listMaterialWhole) ?>;
    var data_materialColly = <?= json_encode($listMaterialColly) ?>;
    var data_materialDasar = <?= json_encode($listMaterialDasar) ?>;
    var list_materials = "";
    var hrefButtonUrl = "<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>";
    $(document).ready(function () {
        $("#MaterialEntryOperatorId, #matCats, #supplierId").on("change", function () {
            if ($("#MaterialEntryOperatorId").val() != "" && $("#matCats").val() != "") {
                $("tr.material-data-input").remove();
                $("tr.material-detail-data-input").remove();
                addThisRow(".firstrunclick", 'material-data', "");
            } else {
                if ($("#MaterialEntryOperatorId").val() == "") {
                    notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
                }
                if ($("#matCats").val() == "") {
                    notif("warning", "Tipe material belum dipilih.", "growl");
                }
                if ($("#supplierId").val() == "") {
                    notif("warning", "Supplier belum dipilih.", "growl");
                }
            }
        });
        $("#buttonSubmit").click(function () {
            var status = true;
            //check value
            $('.validate[type="text"]').each(function () {
                if ($.trim($(this).val()) == '') {
                    status = false;
                    $(this).css({
                        "border": "1px solid red",
                        "background": "#FFCECE"
                    });

                } else {
                    $(this).css({
                        "border": "",
                        "background": ""
                    });
                }

            });
            if ($('#MaterialEntryOperatorId').val() == "") {
                status = false;
                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
            }
            if ($("#matCats").val() == "") {
                status = false;
                notif("warning", "Tipe material belum dipilih.", "growl");
            }
            if ($("#supplierId").val() == "") {
                status = false;
                notif("warning", "Supplier belum dipilih.", "growl");
            }
            $('select#MaterialEntryGradeId').each(function () {
                var MaterialEntryGradeId = $(this).val();
                if (MaterialEntryGradeId == 0) {
                    status = false;
                    $("#s2id_MaterialEntryGradeId").attr("data-original-title", "Harus Dipilih!");
                    $("#s2id_MaterialEntryGradeId").tooltip("fixTitle");
                    $("#s2id_MaterialEntryGradeId").tooltip("show");
                } else {
                    $("#s2id_MaterialEntryGradeId").removeAttr("data-original-title");
                    $("#s2id_MaterialEntryGradeId").tooltip("hide");
                }
            });
            $('select#MaterialEntryGradeSizeId').each(function () {
                var MaterialEntryGradeId = $(this).val();
                if (MaterialEntryGradeId == 0) {
                    status = false;
                    $("#s2id_MaterialEntryGradeSizeId").attr("data-original-title", "Harus Dipilih!");
                    $("#s2id_MaterialEntryGradeSizeId").tooltip("fixTitle");
                    $("#s2id_MaterialEntryGradeSizeId").tooltip("show");
                } else {
                    $("#s2id_MaterialEntryGradeSizeId").removeAttr("data-original-title");
                    $("#s2id_MaterialEntryGradeSizeId").tooltip("hide");
                }
            });
            if (status == true) {
                $("#buttonSubmit").attr("href", hrefButtonUrl);
                $("#buttonSubmit").attr("data-toggle", "modal");
                $("#buttonSubmit").attr("data-target", "#add");
                $("#buttonSubmit").click();
                //$("#formSubmit").submit();
                return true;
            } else {
                return false;
                alert("Harap Check Field yang Kosong!");
            }
        });
    });

    function setOptionTipeMaterial() {
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
//        var type = parseInt($("#MaterialEntryMaterialCategoryId").val());
        $("#weight_material_details" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan (Sesuai Nota Timbang):</h6></div>");
//        if (type == 2) {
//            $("#weight_material_details" + n).append("<div class = 'form-group' style='padding-top: 5px;padding-bottom: 5px'><div style='display:block;margin:5px;' class='col-md-12'><label class='col-md-2 control-label label-required'>Basket Ikan</label><div class='col-md-4'><input type='text' placeholder ='basket " + "' class='form-control col-md-2 basket basket" + n + "' name='data[MaterialEntryGrade][" + n + "][basket]' id='basket" + n + "'></div></div></div>");
//        } else {
//            $("#weight_material_details" + n).append("<div style='display:block;margin:5px;visibility:hidden;height:0px;' class='col-md-12'><label class='col-md-2 control-label label-required'>Basket Ikan</label><div class='col-md-2'><input type='text' placeholder ='basket " + "' value='-' class='form-control col-md-2 basket basket" + n + "' name='data[MaterialEntryGrade][" + n + "][basket]' id='basket" + n + "'></div></div>");
//        }
        for (i = 0; i < count; i++) {
            $("#weight_material_details" + n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='" + data_satuan + " " + (i + 1) + "' class='form-control isDecimal validate beratTimbangan" + n + "" + i + "' name='data[MaterialEntryGrade][" + n + "][MaterialEntryGradeDetail][" + i + "][weight]' id='beratTimbangan" + n + "" + i + "Weight' onkeyup='calculateWeight(" + n + ")'><span class='input-group-addon'>Kg</span></div></div>");
        }
    }

    function calculateWeight(n) {
        var total = 0;
        var grandTotal = 0;
        var count = parseInt($("input.MaterialEntryGrade" + n + "Quantity").val());
        for (i = 0; i < count; i++) {
            if ($("input.beratTimbangan" + n + i).val() != "") {
                total += parseFloat($("input.beratTimbangan" + n + i).val());
            }

        }
        $("input.totalWeight" + n).val(total.toFixed(2));
        $("input.totalRemainingWeight" + n).val(total.toFixed(2));
        $('input.totalWeight').each(function () {
            grandTotal += parseFloat($(this).val());       
        });
        $("input.grandTotalWeight").val(grandTotal.toFixed(2));
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
        //Check selected categories
        var tipeMaterial = $("#matCats").val();
        if (tipeMaterial != "") {
            if (tipeMaterial == 1) {
                data_material = data_materialWhole;
                data_satuan = "Ikan";
                $("#satuanjumlah").html(data_satuan);
            } else if (tipeMaterial == 2) {
                data_material = data_materialColly;
                data_satuan = "Pcs";
                $("#satuanjumlah").html(data_satuan);
            }else if (tipeMaterial == 3) {
                data_material = data_materialDasar;
                data_satuan = "Pcs";
                $("#satuanjumlah").html(data_satuan);
            }
            
            var options = {i: 2, n: n, data_material: data_material, data_material_size: data_material_size, data_satuan: data_satuan};
            var rendered = Mustache.render(template, options);
            $('#target-' + t).append(rendered);
            $(e).data("n", n + 1);
            fixNumber($('#target-' + t));
            reloadSelect2();
            listenerProduk($('#target-' + t).find("tr").last(), n);
            count++;
        } else {
            if ($("#MaterialEntryOperatorId").val() == "") {
                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
            }
            if ($("#matCats").val() == "") {
                notif("warning", "Tipe material belum dipilih.", "growl");
            }
            if ($("#supplierId").val() == "") {
                notif("warning", "Supplier belum dipilih.", "growl");
            }
        }
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row material-data-input">
    <td class="text-center nomorIdx">{{n}}</td>
    <td class="text-center">
    <select name='data[MaterialEntryGrade][{{n}}][material_detail_id]' class='select-full' id='MaterialEntryGradeId' placeholder = "- Pilih Material -">
    <option value='0'>-Pilih Material-</option>
    {{#data_material}}
    <optgroup label="{{label}}">
    {{#child}}
    <option value="{{id}}" data-id="{{n}}">{{label}}</option>
    {{/child}}
    {{/data_material}}
    </select>
    </td>
    <td class="text-center">
    <select name='data[MaterialEntryGrade][{{n}}][material_size_id]' class='select-full' id='MaterialEntryGradeSizeId'>
    <option value='0'>-Pilih Grade-</option>
    {{#data_material_size}}
    <option value="{{id}}">{{label}}</option>
    {{/data_material_size}}
    </select>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[MaterialEntryGrade][{{n}}][quantity]' class='form-control idx MaterialEntryGrade{{n}}Quantity text-right validate' id='MaterialEntryGrade{{n}}Quantity' onkeyup="showDetails({{n}})"/>
    <span class="input-group-addon" class='satuanCategoryMaterial'>{{data_satuan}}</span>   
    </div>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='text' name='data[MaterialEntryGrade][{{n}}][weight]' class='form-control text-right isdecimal qtyIdx totalWeight totalWeight{{n}}' id='MaterialEntryGrade{{n}}Weight' readonly/>
    <span class="input-group-addon">Kg</span>
    </div>
    <input type='hidden' name='data[MaterialEntryGrade][{{n}}][remaining_weight]' class='form-control isdecimal qtyIdx totalRemainingWeight{{n}}' id='MaterialEntryGrade{{n}}RemainingWeight' readonly/>
    </td>
    <td align="center" style ="border-right:1px solid #ddd">
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
