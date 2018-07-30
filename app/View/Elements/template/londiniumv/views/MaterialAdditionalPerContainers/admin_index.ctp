<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_additional_per_container");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PERMINTAAN MATERIAL PEMBANTU KE GUDANG") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Tanggal Permintaan") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status Dari Top Management") ?></th>
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
                                <td class = "text-center" colspan = "7">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialAdditionalPerContainer"]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item["Sale"]['po_number']; ?></td>
                                    <td class="text-left"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["MaterialAdditionalPerContainer"]['created']); ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-left"  id = "target-change-status-top<?= $i ?>">
                                        <?php
                                        if ($item['MaterialAdditionalPerContainer']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['MaterialAdditionalPerContainer']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['MaterialAdditionalPerContainer']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['MaterialAdditionalPerContainer']['verify_status_id'], Router::url("/admin/material_additional_per_containers/change_status_verify"), "#target-change-status-top$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_material_additional/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Print Material Pembantu"><i class = "icon-print2"></i></a>
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