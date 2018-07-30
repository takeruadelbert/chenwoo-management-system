<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee-data-withdrawal");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PENARIKAN SIMPANAN PEGAWAI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("withdrawal/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("withdrawal/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add_withdrawal", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("No Transaksi") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("No Rekening") ?></th>
                            <th><?= __("Operator") ?></th>
                            <th colspan = "2"><?= __("Jumlah Penarikan") ?></th>
                            <th><?= __("Tgl Penarikan") ?></th>
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
                                <td class = "text-center" colspan = "11">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataDeposit']['id_number'] ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['EmployeeBalance']['account_number'] ?></td>
                                    <td class="text-center"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "25">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['EmployeeDataDeposit']['amount__ic'] ?></td>
                                    <td class="text-center"><?= $item['EmployeeDataDeposit']['transaction_date__ic'] ?></td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['EmployeeDataDeposit']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['EmployeeDataDeposit']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['EmployeeDataDeposit']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['EmployeeDataDeposit']['verify_status_id'], Router::url("/admin/employee_data_deposits/change_status_verify_withdrawal"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal"  data-target="#default-view-coop-transaction" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-smpt&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" class="btn btn-default btn-xs btn-icon btn-icon" title="Lihat Data Penarikan Simpanan"><i class="icon-eye7"></i></a>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/print_withdrawal/{$item[Inflector::classify($this->params['controller'])]['id']}", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Print Bukti Penarikan Simpanan"><i class="icon-print2"></i></a>

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