<?php echo $this->Form->create("Freeze", array("class" => "form-horizontal form-separate", "type" => "file", "action" => "add_whole", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PROSES PEMBEKUAN / STYLING WHOLE") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li id="tab-step1"><a href="#data-konversi" data-toggle="tab"><i class="icon-loop"></i> Data Konversi </a></li>
                    <li id="tab-step2a"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Rincian Konversi Yang Dipilih</a></li>
                    <li id="tab-step2b"><a href="#justified-pill3" data-toggle="tab"><i class="fa fa-snowflake-o"></i> Input Hasil Styling </a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade" id="data-konversi">
                        <div>
                            <div class="form-group">
                                <?php
                                echo $this->Form->label("MaterialEntry.material_entry_number", __("Nomor Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("MaterialEntry.material_entry_number", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                echo $this->Form->label("Employee.Account.Biodata.full_name", __("Pembuat Nota Timbang"), array("class" => "col-md-2 control-label"));
                                echo $this->Form->input("Employee.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                ?>
                            </div>
                        </div>
                        <div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Konversi Yang Belum Diproses") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th><?= __("Nomor Konversi") ?></th>
                                                    <th><?= __("Pegawai Pelaksana") ?></th>
                                                    <th><?= __("Waktu Konversi") ?></th>
                                                    <th width="75"><?= __("Berat Total (kg)") ?></th>
                                                    <th width="50"><?= __("Pilih") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <?php
                                                $n = 1;
                                                foreach ($this->data["Conversion"] as $conversion) {
                                                    if (!$conversion['return_order_status']) {
                                                        if (!empty($conversion["Freeze"])) {
                                                            continue;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $n ?></td>
                                                            <td class="text-left"><?= $conversion["no_conversion"] ?></td>
                                                            <td class="text-left"><?= $conversion["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                                                            <td class="text-left"><?= $conversion["created__ic"] ?></td>
                                                            <td class="text-right"><?= $conversion["total"] ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($conversion["validate_status_id"] == 1) {
                                                                    ?>
                                                                    <div class="text-danger" title="Menunggu Validasi Dari Konversi">
                                                                        <i class="icon-warning"></i>
                                                                    </div>
                                                                    <?php
                                                                } else if ($conversion["validate_status_id"] == 3) {
                                                                    ?>
                                                                    <div class="text-danger" title="Data Konversi Ditolak">
                                                                        <i class="icon-warning"></i>
                                                                    </div>
                                                                    <?php
                                                                } else if ($conversion["verify_status_id"] == 1) {
                                                                    ?>
                                                                    <div class="text-danger" title="Menunggu Verifikasi Dari Konversi">
                                                                        <i class="icon-warning"></i>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <label class="radio-inline radio-success">
                                                                        <input type="radio" name="selectconversion" class="styled" value="<?= $conversion["id"] ?>">
                                                                    </label>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $n++;
                                                    }
                                                }
                                                if ($n == 1) {
                                                    ?>
                                                    <tr>
                                                        <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Konversi Keseluruhan") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th><?= __("Nomor Konversi") ?></th>
                                                    <th><?= __("Pegawai Pelaksana") ?></th>
                                                    <th><?= __("Waktu Konversi") ?></th>
                                                    <th width="75"><?= __("Berat Total (kg)") ?></th>
                                                    <th width="125"><?= __("Status") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <?php
                                                if (!empty($this->data["Conversion"])) {
                                                    foreach ($this->data["Conversion"] as $n => $conversion) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $n + 1 ?></td>
                                                            <td class="text-left"><?= $conversion["no_conversion"] ?></td>
                                                            <td class="text-left"><?= $conversion["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                                                            <td class="text-left"><?= $conversion["created__ic"] ?></td>
                                                            <td class="text-right"><?= $conversion["total"] ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                if (empty($conversion["Freeze"])) {
                                                                    ?>
                                                                    <span class="label label-warning">Belum Diproses</span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="label label-success">Selesai</span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td class = "text-center" colspan = 5>Tidak Ada Data</td>
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
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input type="button" value="Next" class="btn btn-success" onclick="step2a();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>           
                    <div class="tab-pane fade in active" id="justified-pill0">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                            echo $this->Form->input("Freeze.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table><div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pelaksana Styling") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Freeze.name", __("Cari Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="has-feedback">
                                                    <?php
                                                    echo $this->Form->input("Freeze.name", array("div" => false, "label" => false, "class" => "form-control typeahead-ajax"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->input("Freeze.operator_id", array("type" => "hidden", "class" => "form-control"));
                                                    ?>
                                                    <i class="icon-search3 form-control-feedback"></i>
                                                </div>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Freeze.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Freeze.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Freeze.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Freeze.start_date", __("Tanggal Mulai Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.start_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Freeze.end_date", __("Tanggal Selesai Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.end_date", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "value" => date("Y-m-d h:i:s")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="block-inner text-danger">
                                    <div class="form-actions text-center">
                                        <input type="button" value="Next" class="btn btn-success" onclick="gotoTab1();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Freeze.freeze_number", __("Nomor Styling"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Freeze.freeze_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "value" => "AUTO GENERATE", "disabled"));
                                            ?>
                                            <div class="col-sm-2 control-label">
                                                <label>Nomor Konversi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Silahkan Cari Nomor Konversi ..." id="conversionNumber" class="form-control typeahead-ajax-transaction" readonly>
                                                <input type="hidden" name="data[Freeze][conversion_id]" id="conversionId">
                                                <input type="hidden" name="data[Freeze][material_entry_id]" id="materialEntryId">
                                            </div>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.weight", __("Berat Konversi"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="conversion_weight" disabled>
                                                    <span class="input-group-addon">Kg</span>
                                                </div>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Dummy.ratio", __("Ratio Konversi"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" id="conversion_ratio" disabled>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive stn-table">
                                    <div class="panel-heading" style="background:#2179cc">
                                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Data Konversi") ?></h6>
                                    </div>
                                    <table width="100%" class="table table-hover table-bordered">                        
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th><?= __("Loin") ?></th>
                                                <th><?= __("Grade") ?></th>
                                                <th><?= __("Alasan Turun Grade") ?></th>
                                                <th><?= __("Berat") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <tr id="init">
                                                <td class = "text-center" colspan = 4>Tidak Ada Data</td>
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
                                        <input type="button" value="Kembali" class="btn btn-info" onclick="backToStep1();">
                                        <input type="button" value="Next" class="btn btn-success" onclick="gotoTab2b();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill3">
                        <div>
                            <div class="form-group">
                                <div class="col-md-4 control-label">
                                    <label>Total Berat Ikan Yang Distyling</label>
                                </div>
                                <div class="col-md-2">
                                    <span class="input-group">
                                        <input type="text" class="form-control text-right" id="processedWeight" disabled value="0">
                                        <span class="input-group-addon"><strong>Kg</strong></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="40%">Produk</th>
                                    <th width="30%">Alasan Turun Grade</th>
                                    <th width="30%">Berat</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-kas-keluar">
                                <tr>
                                    <td colspan="5">
                                        <a class="text-success firstrunclick" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-kas-keluar', 'anakOptions')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-weight" id = "grandTotal" value="0" name="data[Freeze][total_weight]"readonly>
                                            <span class="input-group-addon"> Kg</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">
                                        <strong>Total Ratio</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right auto-calculate-grand-total-ratio tip" id="ratios" value="0" name="data[Freeze][ratio]"  data-toggle = "tooltip" readonly>
                                            <span class="input-group-addon"> %</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class = "freezeNote">
                            <td colspan="12" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Freeze.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("Freeze.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix"));
                                    ?>
                                </div>
                            </td>
                        </div> 
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-actions text-center">
                                    <input type="button" value="Kembali" class="btn btn-info" onclick="gotoTab2a();">
                                    <!--<button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>" style="margin:10px auto;">-->
                                    <button class="btn btn-danger checkdata" id="buttonSubmit"  type="button"  href="#">
                                        <?= __("Simpan") ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            $('#FreezeOperatorId').val(suggestion.id);
            $('#FreezeNip').val(suggestion.nip);
            $('#FreezeOfficeName').val(suggestion.jabatan);
            $('#FreezeDepartmentName').val(suggestion.department);
        });
    })
</script>
<script>
    var data_product = <?= json_encode($listProduct) ?>;
    var rejected_grade_type = <?= $this->Engine->toJSONoptions($rejectedGradeTypes, "- Pilih Alasan Turun Grade -") ?>;
    var weightTotals = 0;
    var hrefButtonUrl = "<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>";
    
    $(".freezeNote").hide();
    $(document).ready(function () {
//        viewDataConversion(getParameterByName("id"));
        disableStep2();
        addThisRow(".firstrunclick", 'detail-kas-keluar', 'anakOptions');
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
            $('select#FreezeDetailProductId').each(function () {
                var ConversionDataMaterialDetailId = $(this).val();
                if (ConversionDataMaterialDetailId == 0) {
                    status = false;
                    $("#s2id_FreezeDetailProductId").attr("data-original-title", "Harus Dipilih!");
                    $("#s2id_FreezeDetailProductId").tooltip("fixTitle");
                    $("#s2id_FreezeDetailProductId").tooltip("show");
                } else {
                    $("#s2id_FreezeDetailProductId").removeAttr("data-original-title");
                    $("#s2id_FreezeDetailProductId").tooltip("hide");
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

    function step1() {
        disableStep2();
        enableStep1();
        gotoTab1();
    }

    function step2a() {
        if (proceedToStep2()) {
            disableStep1();
            enableStep2();
            gotoTab2a();
        }
    }

    function disableStep1() {
        $("#tab-step1").addClass("disabled");
        $("#tab-step1 a").on("click", function (e) {
            return false;
        });
    }

    function disableStep2() {
        $("#tab-step2a").addClass("disabled");
        $("#tab-step2b").addClass("disabled");
        $("#tab-step2a a").on("click", function (e) {
            return false;
        });
        $("#tab-step2b a").on("click", function (e) {
            return false;
        });
    }

    function enableStep1() {
        $("#tab-step1").removeClass("disabled");
        $("#tab-step1 a").unbind("click");
    }

    function enableStep2() {
        $("#tab-step2a").removeClass("disabled");
        $("#tab-step2a a").unbind("click");
        $("#tab-step2b").removeClass("disabled");
        $("#tab-step2b a").unbind("click");
    }

    function gotoTab1() {
        $("#tab-step1 a").trigger("click");
    }
    function gotoTab2a() {
        $("#tab-step2a a").trigger("click");
    }
    function gotoTab2b() {
        $("#tab-step2b a").trigger("click");
    }

    function backToStep1() {
        enableStep1();
        disableStep2();
        gotoTab1();
    }

    function proceedToStep2() {
        if (!$("input[name='selectconversion']:checked").val()) {
            notif("warning", "Data Konversi Belum Dipilih", "growl")
            return false;
        } else {
            if ($("#FreezeOperatorId").val() == "") {
                notif("warning", "Data Pegawai Pelaksana Belum Diisi", "growl");
                return false;
            }
            viewDataConversion($("input[name='selectconversion']:checked").val());
            return true;
        }
    }

    function getParameterByName(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
        if (!results)
            return null;
        if (!results[2])
            return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function viewDataConversion(conversionId) {
        $.ajax({
            url: BASE_URL + "/conversions/view_data_conversion/" + conversionId,
            dataType: "JSON",
            type: "GET",
            data: {},
            beforeSend: function (xhr) {
                ajaxLoadingStart();
            },
            success: function (data) {
                var request = data.data;
                //console.log(request);
                if (request != null && request != '') {
                    if (request.Conversion.return_order_status == 0) {
                        $('input#conversion_ratio').val(request.Conversion.ratio);
                        $('input#conversion_weight').val(request.Conversion.total);
                        $('#processedWeight').val(request.Conversion.total);
                        $('input#conversionId').val(request.Conversion.id);
                        $('input#materialEntryId').val(request.Conversion.material_entry_id);
                        $('input#conversionNumber').val(request.Conversion.no_conversion);
                        var weightTotal = request.Conversion.total;
                        weightTotals = parseFloat(weightTotal);
                        var i = 1;
                        var template = $("#tmpl-installment").html();
                        Mustache.parse(template);
                        $("table tr#init").remove();
                        $('#target-installment').html("");
                        $.each(request.ConversionData, function (index, item) {
                            if (item.rejected_grade_type_id == null) {
                                var rejectedGradeType = "-";
                            } else {
                                var rejectedGradeType = item.RejectedGradeType.name;
                            }
                            var options = {
                                i: i,
                                detail: item.MaterialDetail.name,
                                size: item.MaterialSize.name,
                                quantity: item.material_size_quantity,
                                rejectedGradeType: rejectedGradeType,
                            };
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                            i++;
                        });
                    }
                }
                ajaxLoadingSuccess()
            }
        })
    }

    var products =<?= $this->Engine->toJSONoptions($products) ?>;

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
        $('.produkDeleteTrig').trigger("keyup");
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 1, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        reloadisdecimal();
        fixNumber($(e).parents("tbody"));
        listenerTotalWeight(n);
    }

    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }

    function anakOptions() {
        return {data_product: data_product, rejected_grade_type: rejected_grade_type};
    }

    function listenerTotalWeight(n) {
        var ratio = 0;
        $('.inputWeight' + n).on("keyup change", function () {
            var grandTotal = 0; //parseInt($('#grandTotal').val());
            $('.totalWeight').each(function () {
                if ($(this).val()) {
                    $weight = $(this).val();
                } else {
                    $weight = 0;
                }
                grandTotal += parseFloat($weight);
            });
            ratio = (grandTotal / weightTotals) * 100;
            $("input.auto-calculate-grand-total-weight").val(grandTotal.toFixed(2));
            $("input.auto-calculate-grand-total-ratio").val(ratio.toFixed(2));
            //pengecekan ratio
            var batasAtas = 105;
            var batasBawah = 95;
            if (parseInt(ratio) < batasBawah) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
//                $(".submitButton").attr("disabled", "disabled");
                $(".freezeNote").show();
            } else if (parseInt(ratio) > batasAtas) {
                $("#ratios").attr("data-original-title", "Ratio penurunan/kenaikan harus ±5% dari berat Konversi!")
                        .tooltip('fixTitle')
                        .tooltip('show');
//                $(".submitButton").attr("disabled", "disabled");
                $(".freezeNote").show();
            } else {
                $("#ratios").tooltip('hide');
                $(".freezeNote").hide();
//                $(".submitButton").removeAttr("disabled");
            }
        });
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{detail}}</td> 
    <td class="text-center">{{size}}</td>        
    <td class="text-center">{{rejectedGradeType}}</td>        
    <td class="text-center">{{quantity}} Kg</td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-kas-keluar">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <select class="select-full" name="data[FreezeDetail][{{n}}][product_id]" placeholder="- Pilih Produk -" id='FreezeDetailProductId'>
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
    <select name='data[FreezeDetail][{{n}}][rejected_grade_type_id]' class='select-full' id='FreezeDetailRejectedGradeTypeId'>
    {{#rejected_grade_type}}
    <option value="{{value}}">{{label}}</option>
    {{/rejected_grade_type}}
    </select>
    </td>
    <td>
    <div class="input-group">
    <input name="data[FreezeDetail][{{n}}][weight]" class="form-control totalWeight inputWeight{{n}} produkDeleteTrig text-right validate" data-trigger = "focus" maxlength="255" type="text">                                   
    <span class="input-group-addon">Kg</span>
    </div>
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>