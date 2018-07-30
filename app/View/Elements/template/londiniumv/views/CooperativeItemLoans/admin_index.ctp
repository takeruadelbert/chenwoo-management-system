<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-item-loan");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Data Hutang Sembako") ?>
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
                            <th width="10">No</th>
                            <th width="300"><?= __("Nama Pegawai") ?></th>
                            <th width="200"><?= __("Nik Pegawai") ?></th>
                            <th width="200"><?= __("Jumlah Hutang (Rp)") ?></th>
                            <th width="200"><?= __("Terbayar (Rp)") ?></th>
                            <th width="200"><?= __("Sisa Hutang (Rp)") ?></th>
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
                                <td class = "text-center" colspan ="7">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['Employee']["Account"]["Biodata"]["full_name"] ?></td>
                                    <td class="text-left"><?= $item['Employee']["nip"] ?></td>
                                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['total_loan']) ?></td>
                                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['paid']) ?></td>
                                    <td class="text-right"><?= ic_rupiah($item['CooperativeItemLoan']['remaining']) ?></td>
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