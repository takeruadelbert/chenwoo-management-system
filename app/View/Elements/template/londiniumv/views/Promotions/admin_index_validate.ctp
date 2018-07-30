<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/promotions_validate");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI KENAIKAN JABATAN") ?>
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
                            <th><?= __("Jenis Kenaikan Jabatan") ?></th>
                            <th><?= __("Jabatan Baru") ?></th>
                            <th><?= __("No. SK Kenaikan Jabatan") ?></th>
                            <th><?= __("Tanggal Kenaikan Jabatan") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Office']['name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['Department']['name'] ?></td>
                                    <td class="text-center"><?= $item['PromotionType']['name'] ?></td>
                                    <td class="text-center"><?= $item['CurrentOffice']['name'] ?></td>
                                    <td class="text-center"><?= $item['Promotion']['no_sk_promotion'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Promotion']['promotion_date']) ?></td>
                                    <td class="text-center" id="target-change-status<?= $i ?>">
                                        <?php
                                        if ($roleAccess['edit']) {
                                            if ($item['Promotion']['promotion_status_id'] != 1) {
                                                echo $item['PromotionStatus']['name'];
                                            } else {
                                                ?>
                                                <?= $this->Html->changeStatusSelect($item[Inflector::classify($this->params['controller'])]['id'], $promotionStatuses, $item[Inflector::classify($this->params['controller'])]['promotion_status_id'], Router::url("/admin/promotions/change_status", true), "#target-change-status$i") ?>
                                                <?php
                                            }
                                        } else {
                                            echo $item['PromotionStatus']['name'];
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

