<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/overtimes");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA LEMBUR PEGAWAI") ?>
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
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Departemen") ?></th>
                            <th><?= __("Tanggal Lembur") ?></th>
                            <th><?= __("Waktu Mulai Lembur") ?></th>
                            <th><?= __("Waktu Selesai Lembur") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th><?= __("Status Validasi HR") ?></th>
                            <th width="50"><?= __("Aksi") ?></th>
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
                                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <?php
                                    if (!empty($item['Employee']['department_id'])) {
                                        ?>
                                        <td class="text-center"><?= $item['Employee']["Department"]['name'] ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center"> - </td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['Overtime']['overtime_date']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtJam($item['Overtime']['start_time']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtJam($item['Overtime']['end_time']) ?></td>
                                    <td class="text-center"><?= $item['Overtime']['note'] ?></td>
                                    <td class="text-center" id = "target-change-statuses<?= $i ?>">
                                        <?php
                                        if ($this->Session->read("credential.admin.User.user_group_id") == 24 || $this->Session->read("credential.admin.User.user_group_id") == 27 || $this->Session->read("credential.admin.User.user_group_id") == 52 || $stnAdmin->isDireksi() || $stnAdmin->isAdmin()) {
                                            if ($item['Overtime']['validate_status_id'] == 2) {
                                                echo "Valid";
                                            } else if ($item['Overtime']['validate_status_id'] == 3) {
                                                echo "Tidak Valid";
                                            } else {
                                                echo $this->Html->changeStatusSelect($item['Overtime']['id'], ClassRegistry::init("ValidateStatus")->find("list", array("fields" => array("ValidateStatus.id", "ValidateStatus.name"))), $item['Overtime']['validate_status_id'], Router::url("/admin/overtimes/change_status_validate"), "#target-change-statuses$i");
                                            }
                                        } else {
                                            echo $item['ValidateStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
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

