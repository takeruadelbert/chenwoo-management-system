<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/miss-attendance");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA LUPA ABSEN") ?>
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
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th><?= __("Department") ?></th>
                            <th><?= __("Jenis Lupa Absen") ?></th>
                            <th><?= __("Tanggal Lupa Absen") ?></th>
                            <th><?= __("Jam Lupa Absen") ?></th>
                            <th><?= __("Atasan Langsung") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Status Verifikasi Atasan") ?></th>
                            <th><?= __("Status Validasi HR") ?></th>
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
                                <td class = "text-center" colspan = 14>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= e_isset(@$item['Employee']['Office']['name']) ?></td>
                                    <td class="text-center"><?= e_isset(@$item['Employee']['Department']['name']) ?></td>
                                    <td class="text-center"><?= $item['AttendanceType']['label'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['MissAttendance']['miss_date']) ?></td>
                                    <td class="text-center"><?= $item['MissAttendance']['miss_time'] ?></td>
                                    <td class="text-center"><?= $item['Supervisor']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['MissAttendance']['note'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        echo $item['MissAttendanceStatus']['name'];
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        echo $item['VerifyStatus']['name'];
                                        ?>
                                    </td>
                                    <td class="text-center" id = "target-change-statuses<?= $i ?>">
                                        <?php
                                        if ($item['MissAttendance']['verify_status_id'] == 3) {
                                            if ($stnAdmin->is(["admin", "staff_hrd", "staff_hrd_gaji", "hrd_group_head"])) {
                                                if ($item['MissAttendance']['validate_status_id'] == 2) {
                                                    echo "Valid";
                                                } else if ($item['MissAttendance']['validate_status_id'] == 3) {
                                                    echo "Tidak Valid";
                                                } else {
                                                    echo $this->Html->changeStatusSelect($item['MissAttendance']['id'], ClassRegistry::init("ValidateStatus")->find("list", array("fields" => array("ValidateStatus.id", "ValidateStatus.name"))), $item['MissAttendance']['validate_status_id'], Router::url("/admin/miss_attendances/change_status_validate"), "#target-change-statuses$i");
                                                }
                                            } else {
                                                echo $item['ValidateStatus']['name'];
                                            }
                                        } else {
                                            echo $item['ValidateStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>">
                                            <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail">
                                                <i class="icon-file"></i>
                                            </button>
                                        </a>
                                        <?php
                                        if ($item['MissAttendance']['validate_status_id'] == 1) {
                                            ?>
                                            <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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

