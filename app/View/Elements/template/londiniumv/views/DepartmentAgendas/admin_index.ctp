<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/department-agenda");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA AGENDA DEPARTEMEN") ?>
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
                <small class="display-block"></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50" rowspan="2"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50" rowspan="2">No</th>
                            <th rowspan="2"><?= __("Nama Departemen") ?></th>
                            <th rowspan="2"><?= __("Judul Agenda") ?></th>
                            <th rowspan="2"><?= __("Deskripsi Agenda") ?></th>
                            <th colspan="2"><?= __("Waktu Mulai") ?> </th>
                            <th colspan="2"><?= __("Waktu Selesai") ?></th>
                            <th rowspan="2" width="100"><?= __("Aksi") ?></th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
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
                                <td class = "text-center" colspan ="10">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $data) {
                                foreach ($data as $item) {
                                    ?>
                                    <tr id="row-<?= $i ?>" class="removeRow<?php echo $item['id']; ?>">
                                        <td class="text-center"><input type="checkbox" name="data[DepartmentAgenda][checkbox][]" value="<?php echo $item['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $this->Echo->department($item['department_id']) ?> </td>
                                        <td class="text-center"><?= $item['title'] ?></td>
                                        <td class="text-center"><?= $item['description'] ?></td>
                                        <?php
                                        if ($item['all_day'] == false) {
                                            ?>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['start']) ?></td>
                                            <td class="text-center"><?= $this->Html->cvtJam($item['start']) ?></td>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['end']) ?></td>
                                            <td class="text-center"><?= $this->Html->cvtJam($item['end']) ?></td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['start']) ?></td>
                                            <td class="text-center"><?= __("00:00") ?></td>
                                            <td class="text-center"><?= $this->Html->cvtTanggal($item['end']) ?></td>
                                            <td class="text-center"><?= __("23:59") ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td class="text-center">
                                            <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Detail"><i class="icon-file"></i></button></a>
                                            <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
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