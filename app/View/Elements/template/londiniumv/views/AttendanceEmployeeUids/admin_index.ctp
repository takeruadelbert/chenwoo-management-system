<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/attendance-employee-uid");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA UID ABSENSI PEGAWAI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#multipledelete" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm', true); ?>">
                        <i class="icon-file-remove"></i> 
                        <?= __("Hapus Data") ?>
                    </button>&nbsp;
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Mesin Absensi") ?></th>
                            <th width="50"><?= __("UID") ?></th>
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
                                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['AttendanceMachine']['label'] ?></td>
                                    <td class="text-center"><?= $item['AttendanceEmployeeUid']['uid'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-uid-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatuid" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data UID Pegawai"><i class="icon-eye7"></i></a>
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
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


<div id="default-lihatuid" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT UID ABSENSI PEGAWAI
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Employee.name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Employee.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("AttendanceEmployeeUid.machine", __("Mesin Absensi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("AttendanceEmployeeUid.machine", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("AttendanceEmployeeUid.uid", __("UID"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("AttendanceEmployeeUid.uid", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
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
            var uidId = $(this).data("uid-id");
            $.ajax({
                url: BASE_URL + "attendance_employee_uids/view_data_uid_pegawai/" + uidId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#EmployeeName").val(data.Employee.Account.Biodata.full_name);
                    $("#AttendanceEmployeeUidMachine").val(data.AttendanceMachine.name + " - " + data.AttendanceMachine.ipv4);
                    $("#AttendanceEmployeeUidUid").val(data.AttendanceEmployeeUid.uid);
                }
            })
        });
    });
</script>