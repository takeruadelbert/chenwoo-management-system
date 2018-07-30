<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/closing-book");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA TUTUP BUKU AKHIR BULAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("tutup_buku_akhir_bulan/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("tutup_buku_akhir_bulan/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add_tutup_buku_akhir_bulan", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tutup Buku") ?>
                        </button>
                    </a>
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
                            <th><?= __("Tanggal Tutup Buku") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th><?= __("Kode COA") ?></th>
                            <th><?= __("COA") ?></th>                            
                            <th colspan="2"><?= __("Saldo Sebelumnya") ?></th>
                            <th colspan="2"><?= __("Saldo Sekarang") ?></th>
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
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['ClosingBook']['closing_datetime']) ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= !empty($item['Employee']['Office']['id']) ? $item['Employee']['Office']['name'] : "-" ?></td>
                                    <td class="text-center"><?= emptyToStrip($item['GeneralEntryType']['code']) ?></td>
                                    <td class="text-center"><?= $item['GeneralEntryType']['name'] ?></td>                                    
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['ClosingBook']['previous_balance']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['ClosingBook']['current_balance']) ?></td>
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