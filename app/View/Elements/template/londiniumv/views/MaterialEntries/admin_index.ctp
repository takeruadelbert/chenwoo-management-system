<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_entry_index");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA NOTA TIMBANG") ?>
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
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr style="text-transform:uppercase">
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Tipe Material") ?></th>
                            <th><?= __("Diinput Oleh") ?></th>
                            <th><?= __("Pelaksana") ?></th>
                            <th><?= __("Tanggal Timbang") ?></th>
                            <th><?= __("Nama Supplier") ?></th>
                            <th colspan="2"><?= __("Jumlah Material") ?></th>
                            <th colspan="2"><?= __("Berat Total") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?php echo $item["MaterialEntry"]['material_entry_number']; ?></td>
                                    <td class="text-center"><?php echo $item['MaterialCategory']['name']; ?></td>
                                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <td class="text-left><?= isset($item['Operator']['Account']['Biodata']['full_name']) ? "left" : "center" ?>"><?= emptyToStrip(@$item['Operator']['Account']['Biodata']['full_name']); ?></td>
                                    <td class="text-left"><?php echo $this->Html->cvtTanggal($item["MaterialEntry"]['weight_date']); ?></td>
                                    <td class="text-left"><?php echo $item['Supplier']['name']; ?></td>
                                    <?php
                                    $count = 0;
                                    $total = 0;
                                    $satuan = "";
                                    if ($item['MaterialEntry']['material_category_id'] == 1) {
                                        $satuan = "Ekor";
                                    } else {
                                        $satuan = "Pcs";
                                    }
                                    foreach ($item['MaterialEntryGrade'] as $entryGrade) {
                                        foreach ($entryGrade['MaterialEntryGradeDetail'] as $entrydetail) {
                                            $count++;
                                            $total += $entrydetail['weight'];
                                        }
                                    }
                                    ?>
                                    <td class="text-right" style = "border-right-style : none !important"><?php echo $count; ?></td>
                                    <td class="text-left" style = "border-left-style : none !important" width="10"><?php echo $satuan; ?></td>
                                    <td class="text-right" style = "border-right-style : none !important"><?php echo ic_kg($total); ?></td>
                                    <td class="text-left" style = "border-left-style : none !important" width="10"><?php echo " Kg"; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($roleAccess['edit']) {
                                            if ($item['MaterialEntry']['verify_status_id'] == 1) {
                                                echo $this->Html->changeStatusSelect($item['MaterialEntry']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['MaterialEntry']['verify_status_id'], Router::url("/admin/material_entries/change_status_verify"), "#target-change-status$i");
                                            } else {
                                                echo $item['VerifyStatus']['name'];
                                            }
                                        } else {
                                            echo $item['VerifyStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_nota_timbang_sum/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Print Nota Timbang"><i class = "icon-print2"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_nota_timbang/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Print Nota Timbang (Per Ikan)"><i class = "icon-print2"></i></a>
                                        <a data-toggle="modal" data-materialentry-id="<?= $item["MaterialEntry"]['id'] ?>" role="button" href="#default-lihatMaterialEntry" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data Nota Timbang"><i class="icon-eye7"></i></a>
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
<div id="default-lihatMaterialEntry" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA NOTA TIMBANG
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="transactionList">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialEntry.nomor", __("Nomor Nota Timbang"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialEntry.nomor", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialEntry.supplier", __("Nama Supplier"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialEntry.supplier", array("div" => array("class" => "col-sm-3 col-md-3"), 'type' => "text", "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialEntry.material_category", __("Tipe Material"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialEntry.material_category", array("div" => array("class" => "col-sm-3 col-md-3"), 'type' => "text", "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialEntry.date", __("Tanggal Timbang"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialEntry.date", array("div" => array("class" => "col-sm-3 col-md-3"), 'type' => "text", "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="block-inner text-danger">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Daftar Material") ?></h6>
                            </div>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Material</th>
                                    <th width="100">Grade</th>
                                    <th width="150" colspan="2">Jumlah Ikan</th>
                                    <th width="150" colspan="2">Berat Ikan</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-transaction hidden" data-n="0">
                                </tr>
                            </tbody>
                        </table>
                        <br>
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
            $("tr.transaction-material-data").remove();
            $("tr.material-detail-data-input").remove();
            $(".form-control").val("");
            var materialEntryId = $(this).data("materialentry-id");
            var e = $("tr.dynamic-row-transaction");
            $.ajax({
                url: BASE_URL + "admin/material_entries/view_data_material_entry/" + materialEntryId,
                type: "GET",
                dataType: "JSON",
                data: {},
                beforeSend: function (xhr) {
                    ajaxLoadingStart();
                },
                success: function (request) {
                    var data = request.data;

                    $("#employeeName").val(data.Employee.Account.Biodata.full_name);
                    $("#employeeNip").val(data.Employee.nip);
                    $("#employeeDepartment").val(data.Employee.Department.name);
                    $("#employeePosition").val(data.Employee.Office.name);
                    if (data.Operator.id != null) {
                        $("#operatorName").val(data.Operator.Account.Biodata.full_name);
                        $("#operatorNip").val(data.Operator.nip);
                        $("#operatorDepartment").val(data.Operator.Department.name);
                        $("#operatorPosition").val(data.Operator.Office.name);
                    }
                    $("#MaterialEntryNomor").val(data.MaterialEntry.material_entry_number);
                    $("#MaterialEntrySupplier").val(data.Supplier.name);
                    $("#MaterialEntryMaterialCategory").val(data.MaterialCategory.name);
                    $("#MaterialEntryName").val(data.Employee.Account.Biodata.full_name);
                    $("#MaterialEntryDate").val(cvtTanggal(data.MaterialEntry.weight_date));
                    var emp = data.MaterialEntryGrade;
                    var i = 1;
                    $.each(emp, function (index, value) {
//                        var name = value.MaterialDetail.Material.name + " " + value.MaterialDetail.name;
                        var name = value.MaterialDetail.name;
                        var size = value.MaterialSize.name;
                        var weight = ic_kg(value.weight);
                        var quantity = value.quantity;
                        quantity = quantity.replace(".00", "");
                        var satuan = "";
                        if (data.MaterialCategory.name == "Whole") {
                            satuan = "Ekor";
                        } else {
                            satuan = "Pcs";
                        }
                        var n = e.data("n");
                        var template = $('#tmpl-material-data').html();
                        Mustache.parse(template);
                        var options = {i: i, n: n, name: name, size: size, weight: weight, quantity: quantity, satuan: satuan, materialEntryId: materialEntryId};
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction tr.dynamic-row-transaction:last').before(rendered);
                        e.data("n", n + 1);
                        var detail = value.MaterialEntryGradeDetail;
                        $("td#weight_material_details" + materialEntryId + (n)).append("<div class='panel-heading'><h6 class='panel-title' style = 'padding-top: 5px; padding-bottom: 5px;'>Rincian Berat Ikan:</h6></div>");
                        $.each(detail, function (index, value) {
                            $("td#weight_material_details" + materialEntryId + (n)).append("<div class='col-md-2' style='margin:0px 0px;'><div class='input-group'><input type='text' class='form-control text-right' value='" + ic_kg(value.weight) + "' readonly/><span class='input-group-addon'>Kg</span></div></div>");
                        });
                    });
                    ajaxLoadingSuccess();
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
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td>
    <td class="text-left" style="border-left-style:none; width:50px;">
    {{satuan}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td>   
    <td class="text-left" style="border-left-style:none; width:50px;">
    Kg
    </td>   
    </tr>
    <tr class="material-detail-data-input" id="material-detail-data-input{{n}}">
    <td id="weight_material_details{{materialEntryId}}{{n}}" colspan="7" style="padding-top:0px;">
    </td>
    </tr>
</script>