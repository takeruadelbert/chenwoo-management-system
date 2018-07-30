<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/treatment_validate");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("NOTIFIKASI TREATMENT YANG TIDAK SESUAI RATIO") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_validate/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_validate/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
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
                            <th><?= __("Nomor Treatment") ?></th>
                            <th><?= __("Nomor Styling") ?></th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Tanggal Nota Timbang") ?></th>
                            <th colspan = 2><?= __("Berat Treatment") ?></th>
                            <th><?= __("Ratio Treatment") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status Verifikasi") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th width="100"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 15>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Treatment']['treatment_number'] ?></td>
                                    <td class="text-center"><?= $item['Freeze']['freeze_number'] ?></td>
                                    <td class="text-center"><?= $item['MaterialEntry']['material_entry_number'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) ?></td>
                                    <td class="text-right"><?= $item['Treatment']['total'] ?> </td>
                                    <td class="text-center">Kg</td>
                                    <td class="text-center"><?= $item['Treatment']['ratio'] ?> %</td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['Treatment']['created']) ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['Treatment']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['Treatment']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['Treatment']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['Treatment']['verify_status_id'], Router::url("/admin/treatments/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Treatment']['note']); ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-supplier-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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

<div id="default-lihatdata" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style = "width :1200px; margin-left:auto; margin-right : auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PROSES TREATMENT (RETOUCHING)
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Login Pegawai</a></li>
                                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pegawai Pelaksana</a></li>
                                <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-stopwatch"></i> Data Treatment</a></li>
                                <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-file6"></i> Data Rincian Treatment</a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
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
                                                        echo $this->Form->label("Operator.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
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
                                                        echo $this->Form->label("Operator.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Operator.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Operator.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill3">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.treatment_number", __("Nomor Treatment"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.treatment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <div class="col-sm-2 control-label">
                                                            <label>Nomor Styling</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="transactionNumber" disabled>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <div class="col-sm-2 control-label label-required">
                                                            <label>Berat Styling</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="beratPembekuan" disabled>
                                                                <span class="input-group-addon"><strong>Kg</strong></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 control-label label-required">
                                                            <label>Ratio Styling</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control text-right" id="ratioPembekuan" disabled>
                                                                <span class="input-group-addon"><strong>%</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Treatment.status", __("Status"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Treatment.status", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Treatment.verified", __("Diverifikasi Oleh"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Treatment.verified", array("type" => "text", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill4">
                                    <table class="table table-hover table-bordered stn-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th width = "50">No</th>
                                                <th>Jenis Produk</th>
                                                <th width = "200">Alasan Turun Grade</th>
                                                <th width = "200">Berat Styling</th>
                                                <th width = "200">Berat Treatment</th>
                                                <th width = "200">Selisih</th>
                                            </tr>
                                        <thead>
                                        <tbody id="target-treatment-detail">
                                            <tr class="temp">
                                                <td colspan="6" class="text-center">Tidak Ada Data</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="right">
                                                    <strong>Total Berat Treatment</strong>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right totalWeightTreatment" value="0" name="data[Treatment][total]" readonly>
                                                        <span class="input-group-addon"><strong> Kg</strong></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="right">
                                                    <strong>Total Selisih Berat</strong>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right totalDifferWeight" value="0" readonly>
                                                        <span class="input-group-addon"><strong>Kg</strong></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="right">
                                                    <strong>Total Ratio</strong>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right tip" id="ratio" value="0" name="data[Treatment][ratio]" data-toogle="tooltip" readonly>
                                                        <span class="input-group-addon"><strong> %</strong></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br/>
                                    <div class = "treatmentNote">
                                        <td colspan="12" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Treatment.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                ?>
                                                <div id ="TreatmentNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                                </div>
                                            </div>
                                        </td>
                                    </div> 
                                </div>
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
            var supplierId = $(this).data("supplier-id");
            $.ajax({
                url: BASE_URL + "treatments/view_data_treatment/" + supplierId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#DummyName").val(data.Employee.Account.Biodata.full_name);
                    $("#DummyNip").val(data.Employee.nip);
                    $("#DummyDepartmentName").val(data.Employee.Department.name);
                    $("#DummyOfficeName").val(data.Employee.Office.name);

                    $("#OperatorName").val(data.Operator.Account.Biodata.full_name);
                    $("#OperatorNip").val(data.Operator.nip);
                    $("#OperatorDepartmentName").val(data.Operator.Department.name);
                    $("#OperatorOfficeName").val(data.Operator.Office.name);

                    $("#transactionNumber").val(data.Freeze.freeze_number);
                    $("#beratPembekuan").val(data.Freeze.total_weight);
                    $("#ratioPembekuan").val(data.Freeze.ratio);
                    $("#DummyTreatmentNumber").val(data.Treatment.treatment_number);
                    if (data.Treatment.note == "" || data.Treatment.note == null || data.Treatment.note.length == 0) {
                        $(".treatmentNote").hide();
                    } else {
                        $(".treatmentNote").show();
                        $('#TreatmentNote').html(data.Treatment.note);
                    }

                    if (data != null && data != '') {
                        $(".temp").remove();
                        $('#target-treatment-detail').html("");
                        /* get data freeze detail */
                        var totalFreezeWeight = 0;
                        var freezeDetailWeight = [];
                        $.each(data.Freeze.FreezeDetail, function (index, value) {
                            freezeDetailWeight[index] = value.weight;
                            totalFreezeWeight += parseFloat(value.weight);
                        });

                        /* adding treatment detail data to table */
                        var i = 1;
                        var totalWeightTreatment = 0;
                        var totalSelisihBerat = 0;
                        var ratio = 0;
                        $.each(data.TreatmentDetail, function (index, value) {
                            var productName = value.Product.Parent.name + " " + value.Product.name;
                            var weightTreatment = value.weight;
                            var freezeWeight = freezeDetailWeight[index];
                            if (value.rejected_grade_type_id == null) {
                                var reject_type = "-";
                            } else {
                                var reject_type = value.RejectedGradeType.name;
                            }
                            var differWeight = 0;
                            if (freezeWeight != null) {
                                differWeight = Math.abs(weightTreatment - freezeWeight);
                            }
                            totalWeightTreatment += parseFloat(weightTreatment);
                            totalSelisihBerat += parseFloat(differWeight);
                            var n = $("#target-treatment-detail tr.dynamic-row").size();
                            var template = $('#tmpl-treatment-detail').html();
                            Mustache.parse(template);
                            var options = {
                                i: i,
                                n: n,
                                productName: productName,
                                weightTreatment: (weightTreatment),
                                freezeWeight: (freezeWeight),
                                differWeight: (differWeight).toFixed(2),
                                reject_type: reject_type,
                            };
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-treatment-detail').append(rendered);
                        });
                        $(".totalWeightTreatment").val(IDR(totalWeightTreatment.toFixed(2)));
                        $(".totalDifferWeight").val(IDR(totalSelisihBerat.toFixed(2)));
                        ratio = totalWeightTreatment / totalFreezeWeight * 100;
                        $("#ratio").val(ratio.toFixed(2));

                        if (data.VerifiedBy.id != null && data.VerifiedBy.id != "") {
                            $("#TreatmentStatus").val(data.VerifyStatus.name);
                            $("#TreatmentVerified").val(data.VerifiedBy.Account.Biodata.full_name);
                        }
                    }
                }
            })
        });
        reloadStyled();
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-detail">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="text" class="form-control" readonly id="product{{n}}" value="{{productName}}">
    </td>
    <td>
    <input type="text" class="form-control text-center" readonly value="{{reject_type}}">
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right freezeWeight" name="data[Dummy][{{n}}][freezeWeight]" id="freezeWeight{{n}}" readonly value="{{freezeWeight}}">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-right weightTreatment" name="data[TreatmentDetail][{{n}}][weight]" id="treatmentWeight{{n}}" value="{{weightTreatment}}" readonly>
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                 
    </td>
    <td>
    <div class="input-group">        
    <input type="text" class="form-control text-right differWeight" name="data[Dummy][{{n}}][differWeight]" id="differWeight{{n}}" readonly value="{{differWeight}}">
    <span class="input-group-addon"><strong>Kg</strong></span>
    </div>                                  
    </td>
    </tr>
</script>