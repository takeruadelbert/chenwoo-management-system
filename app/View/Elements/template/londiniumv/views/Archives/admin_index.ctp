<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/archive");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA ARSIP") ?>
                <div class="pull-right">
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
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
                            <th><?= __("ID Dokumen") ?></th>
                            <?php
                            if ($this->StnAdmin->is("admin", $this->Session->read("credential.admin")) || $this->Sidispop->jabatanOf(["kadis"], $this->Session->read("credential.admin"))) {
                                ?>
                                <th><?= __("Department") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Nama Dokumen") ?></th>
                            <th><?= __("Jenis Dokumen") ?></th>
                            <th><?= __("Tipe Dokumen") ?></th>
                            <th><?= __("Tanggal Upload") ?></th>
                            <th><?= __("Oleh") ?></th>
                            <th><?= __("Hits") ?></th>
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
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Archive']['nomor_dokumen'] ?></td>
                                    <?php
                                    if ($this->StnAdmin->is("admin", $this->Session->read("credential.admin")) || $this->Sidispop->jabatanOf(["kadis"], $this->Session->read("credential.admin"))) {
                                        ?>
                                        <td class="text-center"><?= $item['Department']['name'] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $item['Archive']['name'] ?></td>
                                    <td class="text-center"><?= $item['DocumentType']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->getEkstensi($item['AssetFile']['ext']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['Archive']['created']) ?></td>
                                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['AssetFile']['hit'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/asset_files/getfile/" . $item['AssetFile']['id'] . "/" . $item['AssetFile']['token'], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Dokumen"><i class="icon-download"></i></button></a>
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

