<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/salary-allowance");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA TUNJANGAN GAJI PEGAWAI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" title="Print Data" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i>
                        Print
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" title="Ekspor Ke Excel" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
                            <th class="text-center" width="20%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama Pegawai") ?></th>
                            <th class="text-center" width="20%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Detail Tunjangan") ?></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td>
                                        <ul>
                                            <?php
                                            foreach ($item['SalaryAllowanceDetail'] as $details) {
                                                ?>
                                                <li><?= $details['ParameterSalary']['name'] ?></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-target="#default-view-salary-allowance" href="<?= Router::url("/admin/popups/content?content=viewsalaryallowance&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" class="btn btn-default btn-xs btn-icon btn-icon tip" title="Lihat Data Tunjangan Pegawai"><i class="icon-eye7"></i></a>
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah Data Tunjangan Pegawai"><i class="icon-pencil"></i></button></a>
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