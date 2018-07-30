<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cash-in");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA KAS MASUK") ?>
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
        <div class="table-responsive pre-scrollable stn-table" style="max-height: 400px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Kas Masuk") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Tipe Kas") ?></th>
                            <th><?= __("Keterangan") ?></th>
                            <th width="150"><?= __("Aksi") ?></th>
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
                                    <td class="text-center"><?= $item['CashIn']['cash_in_number'] ?></td>
                                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($item['CashIn']['currency_id'] == 1) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CashIn']['amount']) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$</td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['CashIn']['amount']) ?></td>
                                        <?php
                                    }
                                    ?>                                
                                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CashIn']['created_datetime']) ?></td>
                                    <td class="text-left"><?= $item['InitialBalance']['GeneralEntryType']['name'] ?></td>
                                    <td class="text-center"><?= emptyToStrip(@$item['CashIn']['note']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
                                        <a target="_blank" href="<?= Router::url("/admin/{$this->params['controller']}/print_cash_in_receipt/{$item[Inflector::classify($this->params['controller'])]['id']}", true) ?>" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Print Bukti Kas Masuk Internal"><i class="icon-print2"></i></a>
                                        <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]); ?>
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