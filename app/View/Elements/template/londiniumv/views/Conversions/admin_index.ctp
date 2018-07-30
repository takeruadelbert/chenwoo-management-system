<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/conversion-top");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA KONVERSI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Nomor Konversi") ?></th>
                            <th><?= __("Ratio Konversi") ?></th>
                            <th><?= __("Tanggal Mulai Konversi") ?></th>
                            <th><?= __("Tanggal Selesai Konversi") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Status Validasi") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th><?= __("Aksi") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan ="14">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Conversion"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Conversion"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                                    <td class="text-center"><?= $item['Conversion']['no_conversion'] ?></td>
                                    <td class="text-center"><?php echo emptyToStrip($item['Conversion']['ratio'] . " %"); ?></td>
                                    <td class="text-center"><?php echo emptyToStrip($this->Html->cvtTanggal($item['Conversion']['start_date'])) ?></td>
                                    <td class="text-center"><?php echo emptyToStrip($this->Html->cvtTanggal($item['Conversion']['end_date'])) ?></td>
                                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                                    <td class="text-center"><?php echo $this->Echo->empty_strip($item['MaterialEntry']['Supplier']['name']); ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        echo $item['VerifyStatus']['name'];
                                        ?>
                                    </td>
                                    <td class="text-center"  id = "target-change-statuses<?= $i ?>">
                                        <?php
                                        if ($roleAccess['edit']) {
                                            if ($item['Conversion']['validate_status_id'] == 1) {
                                                echo $this->Html->changeStatusSelect($item['Conversion']['id'], ClassRegistry::init("ValidateStatus")->find("list", array("fields" => array("ValidateStatus.id", "ValidateStatus.name"))), $item['Conversion']['validate_status_id'], Router::url("/admin/conversions/change_status_validate"), "#target-change-statuses$i");
                                            } else {
                                                echo $item['ValidateStatus']['name'];
                                            }
                                        } else {
                                            echo $item['ValidateStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Conversion']['note']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['Conversion']['validate_status_id'] != 2) {
                                            ?>
                                            <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($item['Conversion']['id'])) {
                                            ?>
                                            <a data-toggle="modal" data-conversion-id="<?= $item["Conversion"]['id'] ?>" role="button" href="#default-lihatConversion" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                            <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>
<div id="default-lihatConversion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PEMROSESAN IKAN 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <br>
                        <div class = "form-group">
                            <div class = "col-md-2">
                                <label class = "control-label">Nama Pegawai </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="employeeName" disabled/>
                            </div>
                            <div class = "col-md-2">
                                <label class = "control-label">NIP </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="employeeNip" disabled/>
                            </div>
                        </div>
                        <div class = "form-group">
                            <div class = "col-md-2">
                                <label class = "control-label">Departemen </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="employeeDepartment" disabled/>
                            </div>
                            <div class = "col-md-2">
                                <label class = "control-label">Jabatan </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="employeePosition" disabled/>
                            </div>
                        </div>

                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai Pelaksana") ?></h6>
                        </div>
                        <br>
                        <div class = "form-group">
                            <div class = "col-md-2">
                                <label class = "control-label">Nama Pegawai </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="operatorName" disabled/>
                            </div>
                            <div class = "col-md-2">
                                <label class = "control-label">NIP </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="operatorNip" disabled/>
                            </div>
                        </div>
                        <div class = "form-group">
                            <div class = "col-md-2">
                                <label class = "control-label">Departemen </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="operatorDepartment" disabled/>
                            </div>
                            <div class = "col-md-2">
                                <label class = "control-label">Jabatan </label>
                            </div>
                            <div class = "col-md-4">
                                <input type='text' class='form-control' id="operatorPosition" disabled/>
                            </div>
                        </div>

                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Hasil Konversi Ikan") ?></h6>
                        </div>             
                        <br/>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Conversion.no_conversion", __("Nomor Konversi"), array("class" => "col-sm-2 control-label"));
                            echo $this->Form->input("Conversion.no_conversion", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                            echo $this->Form->label("Conversion.date", __("Tanggal Konversi"), array("class" => "col-sm-2 control-label"));
                            echo $this->Form->input("Conversion.date", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                            ?>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width = "300">Nama Material</th>
                                    <th width = "175">Grade</th>
                                    <th width = "175">Alasan Turun Grade</th>
                                    <th width = "150" colspan = "2">Berat Ikan</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-conversion hidden" data-n="0">
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class='text-right'><b>Berat Konversi</b></td>
                                    <td class="text-right" id='totalBeratKonversi'  style="border-right-style:none;">
                                    </td> 
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                        Kg
                                    </td>  
                                </tr>
                                <tr>
                                    <td colspan="4" class='text-right'><b>Ratio Konversi</b></td>
                                    <td class="text-right" id='ratioKonversi'  style="border-right-style:none;">
                                    </td> 
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                        %
                                    </td>  
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Ikan Yang Diproses") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Material</th>
                                    <th width = "200">Grade</th>
                                    <th width = "200" colspan = "2">Berat Ikan</th>
                                </tr>
                            </thead>
                            <tbody id="target-processed-material">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class='text-right'><b>Berat Total Ikan Yang Diproses</b></td>
                                    <td class="text-right" id='totalBerat'  style="border-right-style:none;">
                                    </td> 
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                        Kg
                                    </td>  
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Keterangan") ?></h6>
                        </div>
                        <div class="row">
                            <div class='col-md-12'>
                                <textarea class="form-control text-center" disabled style="font-weight:bold;" id='note'></textarea>
                                <!--<div class='text-center'><br><b><p id = "note"></p></b></div>-->
                            </div>
                        </div>
                    </div>                                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>
<script>
    $(document).ready(function () {
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            $("#target-processed-material").html("");
            var conversionId = $(this).data("conversion-id");
            var e = $("tr.dynamic-row-conversion");
            $.ajax({
                url: BASE_URL + "conversions/view_data_conversion/" + conversionId,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    var data = response.data;
                    $("#ConversionNoConversion").val(data.Conversion.no_conversion);
                    $("#ConversionDate").val(cvtWaktu(data.Conversion.created));

                    $("#employeeName").val(data.Employee.Account.Biodata.full_name);
                    $("#employeeNip").val(data.Employee.nip);
                    $("#employeeDepartment").val(data.Employee.Department.name);
                    $("#employeePosition").val(data.Employee.Office.name);

                    $("#operatorName").val(data.Operator.Account.Biodata.full_name);
                    $("#operatorNip").val(data.Operator.nip);
                    $("#operatorDepartment").val(data.Operator.Department.name);
                    $("#operatorOffice").val(data.Operator.Office.name);

                    var emp = data.ConversionData;
                    var i = 1;
                    $.each(emp, function (index, value) {
//                        var name = value.MaterialDetail.Material.name + " " + value.MaterialDetail.name;
                        var name = value.MaterialDetail.name;
                        var size = value.MaterialSize.name;
                        var weight = value.material_size_quantity;
                        if (value.rejected_grade_type_id == null) {
                            var rejectedGradeType = "-";
                        } else {
                            var rejectedGradeType = value.RejectedGradeType.name;
                        }
                        var n = e.data("n");
                        var template = $('#tmpl-material-data').html();
                        Mustache.parse(template);
                        var options = {
                            i: i,
                            n: n,
                            name: name,
                            size: size,
                            rejectedGradeType: rejectedGradeType,
                            weight: ic_kg(weight),
                        };
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction tr.dynamic-row-conversion:last').before(rendered);
                        e.data("n", n + 1);
                    });
                    $("#totalBeratKonversi").text(ic_kg(data.Conversion.total));
                    $("#ratioKonversi").text(ic_persen(data.Conversion.ratio));

                    var temp = data.Conversion.note;
                    if (temp != null && temp != "") {
                        var note = temp.replace(/<(?:.|\n)*?>/gm, '');
                    } else {
                        var note = "Tidak Ada Keterangan";
                    }
                    $("#note").val(note);

                    var processedWeight = 0;
                    $.each(data.MaterialEntryGradeDetail, function (index, value) {
                        var grade = value.MaterialEntryGrade.MaterialDetail.name;
                        var size = value.MaterialEntryGrade.MaterialSize.name;
                        var weight = value.weight;
                        var template = $("#tmpl-processed-material").html();
                        Mustache.parse(template);
                        var options = {
                            index: index + 1,
                            weight: ic_kg(weight),
                            grade: grade,
                            size: size
                        };
                        var rendered = Mustache.render(template, options);
                        $("#target-processed-material").append(rendered);
                        processedWeight += parseFloat(weight);
                    });
                    $("#totalBerat").text(ic_kg(processedWeight));
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{name}}
    </td> 
    <td class="text-center">
    {{size}}
    </td>
    <td class="text-center">
    {{rejectedGradeType}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>       
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-processed-material">
    <tr>
    <td class="text-center nomorIdx">{{index}}</td>
    <td class="text-left">
    {{grade}}
    </td> 
    <td class="text-center">
    {{size}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>        
    </tr>
</script>