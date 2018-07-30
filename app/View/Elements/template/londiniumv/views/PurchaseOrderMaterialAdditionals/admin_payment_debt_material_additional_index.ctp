<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_additional_supplier");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Supplier Material Pembantu") ?>
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
                            <th width="150"><?= __("ID Supplier Material Pembantu") ?></th>
                            <th width="150"><?= __("Nama Supplier Material Pembantu") ?></th>
                            <th><?= __("Alamat") ?></th>
                            <th><?= __("Provinsi") ?></th>
                            <th><?= __("Kota") ?></th>
                            <th><?= __("Negara") ?></th>
                            <th><?= __("No. Telepon") ?></th>
                            <th><?= __("Email") ?></th>
                            <th><?= __("Website") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['id_supplier'] ?></td>
                                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['name'] ?></td>
                                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['address'] ?></td>
                                    <td class="text-center"><?= !empty($item['MaterialAdditionalSupplier']['city_id']) ? $item['MaterialAdditionalSupplier']['City']['name'] : "-" ?></td>
                                    <td class="text-center"><?= !empty($item['MaterialAdditionalSupplier']['state_id']) ? $item['MaterialAdditionalSupplier']['State']['name'] : "-" ?></td>
                                    <td class="text-center"><?= !empty($item['MaterialAdditionalSupplier']['country_id']) ? $item['MaterialAdditionalSupplier']['Country']['name'] : "-" ?></td>
                                    <td class="text-center"><?= $item['MaterialAdditionalSupplier']['phone_number'] ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['MaterialAdditionalSupplier']['email']) ?></td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['MaterialAdditionalSupplier']['website']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/setup_payment_debt_material_additional/{$item['MaterialAdditionalSupplier']['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Pembayaran Hutang"><i class="icon-coin"></i></button></a>
                                        <a data-toggle="modal" data-target="#default-view-payment-debt-material-additional" href="<?= Router::url("/admin/popups/content?content=viewpaymentdebt-materialadditional&id={$item['MaterialAdditionalSupplier']['id']}") ?>" class="ajax-modal"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data Pembayaran"><i class="icon-eye7"></i></button></a>
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