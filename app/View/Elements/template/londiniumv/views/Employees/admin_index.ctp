<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/employee");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PEGAWAI") ?>
                <div class="pull-right">
                    <a href="<?= Router::url("print_employee_biodata", true) ?>" target="_blank">
                        <button class="btn btn-xs btn-default" type="button">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak Data Pegawai") ?>
                        </button>
                    </a>&nbsp;
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
                            <th><?= __("Foto") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("NIK") ?></th>
                            <th><?= __("Department") ?></th>
                            <th><?= __("Jabatan") ?></th>
                            <th><?= __("Tanggal Mulai Kerja") ?></th>
                            <th><?= __("Jenis Kelamin") ?></th>
                            <th><?= __("Tipe Pegawai") ?></th>
                            <th><?= __("Cabang") ?></th>
                            <th width="125"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan ="12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Employee"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Employee"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td><center><img src="<?= Router::url($item['User']['profile_picture'], true) ?>" height="45"></center></td>
                            <td><?= $this->Echo->fullName($item['Biodata']) ?></td>
                            <td class="text-center"><?= $this->Echo->empty_strip($item['Employee']['nip']) ?></td>
                            <td><?= emptyToStrip(@$item['Employee']['Department']['name']) ?></td>
                            <td><?= emptyToStrip(@$item['Employee']['Office']['name']) ?></td>
                            <td class="text-center"><?= $this->Echo->empty_strip($this->Html->cvtTanggal($item['Employee']['tmt'])) ?></td>
                            <td class="text-center"><?= emptyToStrip(@$item['Biodata']['Gender']['name']) ?></td>
                            <td class="text-center"><?= emptyToStrip(@$item['Employee']['EmployeeType']['name']) ?></td>
                            <td><?= emptyToStrip(@$item['Employee']['BranchOffice']['name']) ?></td>
                            <td class="text-center">
                                <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_profile/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Print Data Pegawai"><i class = "icon-print2"></i></a>
                                <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>">
                                    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-eye7"></i></button>
                                </a>
                                <a href="<?= Router::url("/admin/{$this->params['controller']}/update_salary/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>">
                                    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Update Gaji Pokok"><i class="icon-coin"></i></button>
                                </a>
                                <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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

