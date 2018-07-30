<?php echo $this->Form->create("Treatment", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM UBAH PROSES TREATMENT / RETOUCHING") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Treatment</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Data Rincian Treatment</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Treatment") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Operator.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Department.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Operator.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Operator.Office.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.start_date", __("Tanggal Mulai Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.start_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Treatment.end_date", __("Tanggal Selesai Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.end_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.treatment_number", __("Nomor Treatment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Treatment.treatment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            //echo $this->Form->label("TreatmentSourceDetail.0.FreezeDetail.Freeze.freeze_number", __("Nomor Styling"), array("class" => "col-sm-2 control-label"));
                                            //echo $this->Form->input("TreatmentSourceDetail.0.FreezeDetail.Freeze.freeze_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Treatment Source") ?></h6>
                        </div>
                        <div class="table-responsive stn-table">
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No.</th>
                                        <th>Jenis Produk</th>
                                        <th colspan="2">Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $weight_difference = 0;
                                    $totalWeightTreatment=0;
                                    foreach ($this->data['TreatmentSourceDetail'] as $index => $details) {
                                        $totalWeightTreatment+=$details['weight'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td><?= $details['Product']['Parent']['name'] . "-" . $details['Product']['name'] ?></td>

                                            <td class="text-right" style="border-right-style:none;">
                                                <?= $details['weight'] ?>
                                            </td> 
                                            <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                Kg
                                            </td> 
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Produk</th>
                                    <th width = "250">Alasan Turun Grade</th>
                                    <th width = "250">Berat Styling</th>
                                    <th width = "250">Berat Treatment</th>
                                    <th width = "250">Selisih</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-treatment-detail">
                                <tr id="addRow">
                                    <td colspan="7">
                                        <a class="text-success firstrunclick" href="javascript:void(false)" onclick="addThisRow($(this), 'treatment-detail')" data-n="0"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Berat Treatment</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right totalWeightTreatment" value="" name="data[Treatment][total]" readonly> <!--<?$totalBeratTreatment ?>-->
                                            <span class="input-group-addon"><strong> Kg</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Selisih Berat</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right totalDifferWeight" value="" readonly> <!--<?$totalSelisihBerat ?>-->
                                            <span class="input-group-addon"><strong>Kg</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Total Ratio</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right tip" id="ratio" value="<?= $this->data['Treatment']['ratio'] ?>" name="data[Treatment][ratio]" data-toogle="tooltip" readonly>
                                            <span class="input-group-addon"><strong> %</strong></span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class = "treatmentNote">
                            <td colspan="12" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Treatment.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("Treatment.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
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
<?php
$listProduct = [];
foreach ($products as $product) {
    $childs = [];
    foreach ($product["Child"] as $child) {
        $childs[] = [
            "id" => $child["id"],
            "label" => $product["Product"]["name"] . " " . $child["name"],
        ];
    }
    $listProduct[] = [
        "id" => $product["Product"]["id"],
        "label" => $product["Product"]["name"],
        "child" => $childs,
    ];
}
?>
<script>
    var data_product = <?= json_encode($listProduct) ?>;
    var products = <?= $this->Engine->toJSONoptions($products) ?>;
    var rejected_grade_type = <?= $this->Engine->toJSONoptions($rejectedGradeTypes, "- Pilih Alasan Turun Grade -") ?>;
    var stylingCurrentWeight = <?= $totalWeightTreatment ?>;
    $(document).ready(function () {
        //addThisRow(".firstrunclick",'treatment-detail');
        callForTreatmentData();
    });  
    
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        $(".weightTreatment").trigger("keyup");
    }
    
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 1, n: n, data_product: data_product, rejected_grade_type: rejected_grade_type};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
        $(".treatmentNote").hide();
        getTotalBerat(n);
    }
    
    function callForTreatmentData() {
        var count = <?php echo count($rows['TreatmentDetail']) ?>;
        var data = <?php echo json_encode($rows['TreatmentDetail']) ?>;
        $.each(data, function (index, value) {
            addThisRow(".firstrunclick", 'treatment-detail');
            $("#TreatmentDetail" + index + "Id").val(value.id);
            $("#TreatmentDetail" + index + "product_id").select2("val", value.product_id);
            $("#TreatmentDetailRejectedGradeTypeId" + index).select2("val", value.rejected_grade_type_id);
            $("#treatmentWeight" + index).val(value.weight);
        });
    }
    
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
        return {products: products, rejected_grade_type: rejected_grade_type};
    }

    function getTotalBerat(n) {
        $("#treatmentWeight" + n).on("change keyup", function () {
            var totalBerat = 0;
            /* updating total weight treatment field */
            $(".weightTreatment").each(function () {
                if ($(this).val()) {
                    var wt = $(this).val();
                } else {
                    var wt = 0;
                }
                totalBerat += parseFloat(wt);
            });
            $(".totalWeightTreatment").val(totalBerat.toFixed(2));

            /* updating total difference between freezed weight and treatment weight */
            var totalDifferWeight = 0;
            var differEachRow = Math.abs($("#treatmentWeight" + n).val() - $("#freezeWeight" + n).val());
            $("#differWeight" + n).val(differEachRow.toFixed(2));

            /* get total of freezed weights */
//            var totalFreezeWeight = 0;
//            $(".freezeWeight").each(function () {
//                totalFreezeWeight += parseFloat($(this).val());
//            });

            /* updating the total differece weight field */
            var totalDifferWeight = Math.abs(totalBerat - stylingCurrentWeight);
            $(".totalDifferWeight").val(totalDifferWeight.toFixed(2));

            /* set the ratio result */
            var ratio = totalBerat / stylingCurrentWeight * 100;
            $("#ratio").val(ratio.toFixed(2));

            /* check the suitable ratio if it's more than ±5% from freezed ratio */
            var freezedRatio = parseFloat($("#ratioPembekuan").val());
            var tRatio = parseFloat($("#ratio").val());
            var top_quartile = 105;
            var bottom_quartile = 95;
            if (tRatio >= bottom_quartile && tRatio <= top_quartile) {
                $("#ratio").removeAttr("data-original-title");
                $("#ratio").tooltip("hide");
                $(".treatmentNote").hide();
            } else {
                $("#ratio").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Pembekuan!");
                $("#ratio").tooltip("fixTitle");
                $("#ratio").tooltip("show");
                $(".treatmentNote").show();
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    function calcCurrentWeight(n) {
        //alert("aa");
        //$("#data1").html();
        stylingCurrentWeight = 0;
        var remainingWeight = $("#remainingWeight" + n).val();
        var currentWeight = $("#currentProductWeight" + n).val();
        if (currentWeight != "") {
            remainingWeight = parseFloat($("#remainingWeight" + n).val());
            currentWeight = parseFloat($("#currentProductWeight" + n).val());
            if (currentWeight > remainingWeight) {
                $("#currentProductWeight" + n).val("0")
                alert("Kesalahan! Berat yang diproses lebih besar dari berat tersedia!");
            } else {
                $(".currentProductWeight").each(function () {
                    if (parseFloat($(this).val()) != "") {
                        stylingCurrentWeight += parseFloat($(this).val());
                    }
                });
            }
        }
    }

    function unDisabled(n) {
        $('input.currentProductWeight').each(function () {
            $(this).attr("disabled", true);
            $(this).val("0")
        });
        $('input.currentFreezeId').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentFreezeDetailId').each(function () {
            $(this).attr("disabled", true);
        });
        $('input.currentProductWeightId').each(function () {
            $(this).attr("disabled", true);
        });
        $("#currentProductWeight" + n).removeAttr("disabled");
        $("#currentFreezeId" + n).removeAttr("disabled");
        $("#currentFreezeDetailId" + n).removeAttr("disabled");
        $("#currentProductWeightId" + n).removeAttr("disabled");
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-detail">
    <tr id="data1">
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="hidden" class="form-control" name="data[TreatmentDetail][{{n}}][id]" id="TreatmentDetail{{n}}Id" value = "0" readonly>
    <select name="data[TreatmentDetail][{{n}}][product_id]" class="select-full productSelected" id="TreatmentDetail{{n}}product_id" required="required" empty="" placeholder="- Pilih Jenis Produk -">
    <option value='0'>-Pilih Produk-</option>
    {{#data_product}}
    <optgroup label="{{label}}">
    {{#child}}
    <option value="{{id}}" data-id="{{n}}">{{label}}</option>
    {{/child}}
    </optgroup>
    {{/data_product}}
    </select>
    </td>
    <td>
    <select name='data[TreatmentDetail][{{n}}][rejected_grade_type_id]' class='select-full' id='TreatmentDetailRejectedGradeTypeId{{n}}'>
    {{#rejected_grade_type}}
    <option value="{{value}}">{{label}}</option>
    {{/rejected_grade_type}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right freezeWeight" name="data[Dummy][{{n}}][freezeWeight]" id="freezeWeight{{n}}" value = "0" readonly>
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right weightTreatment" name="data[TreatmentDetail][{{n}}][weight]" id="treatmentWeight{{n}}">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                 
    </td>
    <td>
    <div class="input-group">        
    <input type="text" class="form-control text-right differWeight" name="data[Dummy][{{n}}][differWeight]" id="differWeight{{n}}" readonly value="0">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                  
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3 remove"></i></a>
    </td>
    </tr>
</script>