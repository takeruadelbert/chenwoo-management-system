<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/manual-working-count");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA HARI KERJA") ?>
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
                            <th><?= __("Tanggal Kerja") ?></th>
                            <th><?= __("Jenis Kerja") ?></th>
                            <th><?= __("Keterangan") ?></th>
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
                                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Office']['name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['ManualWorkingCount']['working_dt'], false) ?></td>
                                    <td class="text-center"><?= $item['ManualWorkingCountType']['label'] ?></td>
                                    <td class="text-center"><?= emptyToStrip($item['ManualWorkingCount']['note']) ?></td>
                                    <td class="text-center" id = "target-change-statuses<?= $i ?>">
                                        <?php
                                        if ($item['ManualWorkingCount']['manual_working_count_status_id'] == 1) {
                                            if ($stnAdmin->is(["admin", "staff_hrd", "staff_hrd_gaji", "hrd_group_head"])) {
                                                echo $this->Html->changeStatusSelect($item['ManualWorkingCount']['id'], $manualWorkingCountStatuses, $item['ManualWorkingCount']['manual_working_count_status_id'], Router::url("/admin/manual_working_counts/change_status"), "#target-change-statuses$i");
                                            }
                                        } else {
                                            echo $item['ManualWorkingCountStatus']['name'];
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
                                        if ($item['ManualWorkingCount']['manual_working_count_status_id'] == 1) {
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

