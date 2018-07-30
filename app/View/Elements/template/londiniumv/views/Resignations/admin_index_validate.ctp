<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/resignation_validate");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI PEGAWAI KELUAR") ?>
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
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th><?= __("Department") ?></th>
                            <th><?= __("Tanggal Pengunduran Diri") ?></th>
                            <th><?= __("Keterangan") ?> </th>
                            <th><?= __("Status Verifikasi") ?> </th>
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
                                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class = "text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class = "text-center"><?= $item['Employee']['nip'] ?></td>
                                    <td class = "text-center"><?= $item['Employee']['Office']['name'] ?> </td>
                                    <td class = "text-center"><?= $item['Employee']['Department']['name'] ?> </td>
                                    <td class = "text-center"><?= $this->Html->cvtHariTanggal($item['Resignation']['resignation_date']) ?> </td>
                                    <td class = "text-center"><?= $item['ResignationType']['name'] ?></td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['Resignation']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['Resignation']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['Resignation']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['Resignation']['verify_status_id'], Router::url("/admin/resignations/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-resignation-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatpensiun" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data Pengunduran Diri"><i class="icon-eye7"></i></a>
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

<div id="default-lihatpensiun" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA PENGUNDURAN DIRI
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
                                        echo $this->Form->label("Resignation.type", __("Jenis Pengunduran Diri"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Resignation.type", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Resignation.resignation_date", __("Tanggal Pengunduran Diri"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Resignation.resignation_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Resignation.resignation_note", __("Keterangan Pengunduran Diri"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        ?>
                                        <div id ="ResignationResignationNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                        </div>
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
            var resignationId = $(this).data("resignation-id");
            $.ajax({
                url: BASE_URL + "resignations/view_data_resignation/" + resignationId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#EmployeeName").val(data.Employee.Account.Biodata.full_name);
                    $("#ResignationType").val(data.ResignationType.name);
                    $("#ResignationResignationDate").val(cvtTanggal(data.Resignation.resignation_date));
                    $('#ResignationResignationNote').html(data.Resignation.resignation_note);
                }
            })
        });
    });
</script>