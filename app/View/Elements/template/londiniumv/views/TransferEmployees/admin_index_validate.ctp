<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/transfer-employee-validate");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI MUTASI / KENAIKAN JABATAN PEGAWAI") ?>
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
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("NIP") ?></th>
                            <th><?= __("Jabatan Asal") ?></th>
                            <th><?= __("Department Asal") ?></th>
                            <th><?= __("Cabang Asal") ?></th>
                            <th><?= __("Jabatan Tujuan") ?></th>
                            <th><?= __("Department Tujuan") ?></th>
                            <th><?= __("Cabang Tujuan") ?></th>
                            <th><?= __("Tanggal Mutasi") ?></th>
                            <th><?= __("Keterangan") ?> </th>
                            <th><?= __("Status Verifikasi") ?></th>
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
                                <td class = "text-center" colspan = "14">Tidak Ada Data</td>
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
                                    <td class="text-center">
                                        <?= empty($item['OriginOffice']['name']) ? $item["Employee"]["Office"]["name"] : $item['OriginOffice']['name'] ?> 
                                    </td>
                                    <td class="text-center">
                                        <?= empty($item['OriginDepartment']['name']) ? $item["Employee"]["Department"]["name"] : $item['OriginDepartment']['name'] ?> 
                                    </td>
                                    <td class="text-center">
                                        <?= empty($item['OriginBranchOffice']['name']) ? $item["Employee"]["BranchOffice"]["name"] : $item['OriginBranchOffice']['name'] ?> 
                                    </td>
                                    <td class="text-center">
                                        <?= $item['Department']['name'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item['Office']['name'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $item['BranchOffice']['name'] ?>
                                    </td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['TransferEmployee']['tanggal_sk_mutasi']) ?> </td>
                                    <td class="text-center"><?= $item['TransferEmployeeType']['name'] ?></td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['TransferEmployee']['verify_status_id'] == 2) {
                                            echo "Ditolak";
                                        } else if ($item['TransferEmployee']['verify_status_id'] == 3) {
                                            echo "Disetujui";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['TransferEmployee']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['TransferEmployee']['verify_status_id'], Router::url("/admin/transfer_employees/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
                                                <?php
                                                if ($item['TransferEmployee']['verify_status_id'] == 1) {
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

<script>
    function reactiveEmployee(e, empId) {
        $.ajax({
            type: "PUT",
            url: BASE_URL + "admin/employees/change_status_work",
            data: {id: empId, status: 1},
            dataType: "JSON",
            success: function (data) {
                $(e).remove();
                alert("Pegawai diaktifkan lagi");
            },
            error: function () {

            }
        })
    }
</script>