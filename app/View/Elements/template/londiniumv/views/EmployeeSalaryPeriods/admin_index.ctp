<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee_salary_period");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA GAJI PEGAWAI HARIAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th rowspan="2" width="50">No</th>
                            <th rowspan="2"><?= __("Periode") ?></th>
                            <th rowspan="2"><?= __("Dibuat") ?></th>
                            <th colspan="2"><?= __("Diketahui") ?></th>
                            <th colspan="2"><?= __("Diperiksa") ?></th>
                            <th colspan="2"><?= __("Disetujui") ?></th>
                            <th rowspan="2" width="120"><?= __("Aksi") ?></th>
                        </tr>
                        <tr>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Oleh") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Oleh") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Oleh") ?></th>
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
                                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $this->Html->cvtTanggal($item['EmployeeSalaryPeriod']['start_dt'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalaryPeriod']['end_dt'], false) ?></td>
                                    <td><?= e_isset(@$item["CreateBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                                    <td id="target-change-status-known<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeSalaryPeriod']['known_status_id'] == 1 && ($stnAdmin->is(["admin", "hrd_group_head"]))) {
                                            echo $this->Html->changeStatusSelect($item['EmployeeSalaryPeriod']['id'], $employeeSalaryPeriodStatuses, $item['EmployeeSalaryPeriod']['known_status_id'], Router::url("/admin/employee_salary_periods/change_status?type=known"), "#target-change-status-known$i");
                                        } else {
                                            echo $item["KnownStatus"]["name"];
                                        }
                                        ?>
                                    </td>
                                    <td  id="target-change-status-known<?= $i ?>-by"><?= e_isset(@$item["KnownBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                                    <td id="target-change-status-verify<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeSalaryPeriod']['verify_status_id'] == 1 && $item['EmployeeSalaryPeriod']['known_status_id'] == 3 && ($stnAdmin->is(["admin", "internal_control"]))) {
                                            echo $this->Html->changeStatusSelect($item['EmployeeSalaryPeriod']['id'], $employeeSalaryPeriodStatuses, $item['EmployeeSalaryPeriod']['verify_status_id'], Router::url("/admin/employee_salary_periods/change_status?type=verify"), "#target-change-status-verify$i");
                                        } else {
                                            echo $item["VerifyStatus"]["name"];
                                        }
                                        ?>
                                    </td>
                                    <td id="target-change-status-verify<?= $i ?>-by"><?= e_isset(@$item["VerifyBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                                    <td id="target-change-status-approve<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeSalaryPeriod']['approve_status_id'] == 1 && $item['EmployeeSalaryPeriod']['verify_status_id'] == 3 && $item['EmployeeSalaryPeriod']['known_status_id'] == 3 && ($stnAdmin->is(["admin", "general_manager","staff_keuangan","finance_manager"]))) {
                                            echo $this->Html->changeStatusSelect($item['EmployeeSalaryPeriod']['id'], $employeeSalaryPeriodStatuses, $item['EmployeeSalaryPeriod']['approve_status_id'], Router::url("/admin/employee_salary_periods/change_status?type=approve"), "#target-change-status-approve$i");
                                        } else {
                                            echo $item["ApproveStatus"]["name"];
                                        }
                                        ?>
                                    </td>
                                    <td id="target-change-status-approve<?= $i ?>-by"><?= e_isset(@$item["ApproveBy"]["Account"]["Biodata"]["full_name"]) ?></td>
                                    <td class="text-center">
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}/print", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Print Rekap Gaji"><i class="icon-print2"></i></a>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}/excel", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Export Excel"><i class="icon-file-excel"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_receipt_salary/{$item[Inflector::classify($this->params['controller'])]['id']}?q=print", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Slip Gaji"><i class = "icon-print2"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_receipt_salary/{$item[Inflector::classify($this->params['controller'])]['id']}?q=excel", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Export Excel Slip Gaji"><i class = "icon-file-excel"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_receipt_salary_with_upper_average_salary/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Slip Gaji Di Atas <?= $this->Html->IDR(_AVERAGE_SALARY) ?>"><i class = "icon-print2"></i></a>
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_receipt_salary_with_lower_average_salary/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Slip Gaji Di Bawah <?= $this->Html->IDR(_AVERAGE_SALARY) ?>"><i class = "icon-print2"></i></a>
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

<div id="default-lihatlibur" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA HARI LIBUR
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
                                        echo $this->Form->label("Holiday.name", __("Nama Hari Libur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Holiday.name", array("type" => "Text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Holiday.start_date", __("Tanggal Mulai Libur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Holiday.start_date", array("type" => "Text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Holiday.end_date", __("Tanggal Akhir Libur"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Holiday.end_date", array("type" => "Text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
            var holidayId = $(this).data("holiday-id");
            $.ajax({
                url: BASE_URL + "holidays/view_data_holiday/" + holidayId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#HolidayName").val(data.Holiday.name);
                    $("#HolidayStartDate").val(cvtTanggal(data.Holiday.start_date));
                    $("#HolidayEndDate").val(cvtTanggal(data.Holiday.end_date));
                }
            });
        });
    });
</script>
