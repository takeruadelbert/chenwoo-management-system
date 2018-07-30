<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/miss-attendance");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI LUPA ABSEN") ?>
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
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th><?= __("Department") ?></th>
                            <th><?= __("Tanggal Lupa Absen") ?></th>
                            <th><?= __("Jam Lupa Absen") ?></th>
                            <th><?= __("Atasan Langsung") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Status Verifikasi Atasan") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Office']['name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['MissAttendance']['miss_date']) ?></td>
                                    <td class="text-center"><?= $item['MissAttendance']['miss_time'] ?></td>
                                    <td class="text-center"><?= $item['Supervisor']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['MissAttendance']['note'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        echo $item['MissAttendanceStatus']['name'];
                                        ?>
                                    </td>
                                    <td class="text-center" id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['MissAttendance']['supervisor_id'] == $this->Session->read("credential.admin.Employee.id") || $stnAdmin->isAdmin()) {
                                            if ($item['MissAttendance']['verify_status_id'] == 2) {
                                                echo "Ditolak";
                                            } else if ($item['MissAttendance']['verify_status_id'] == 3) {
                                                echo "Disetujui";
                                            } else {
                                                echo $this->Html->changeStatusSelect($item['MissAttendance']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['MissAttendance']['verify_status_id'], Router::url("/admin/miss_attendances/change_status_verify"), "#target-change-status$i");
                                            }
                                        } else {
                                            echo $item['VerifyStatus']['name'];
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

