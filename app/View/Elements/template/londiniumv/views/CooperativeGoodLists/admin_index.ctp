<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-good-list");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA BARANG KOPERASI") ?>
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
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Kode Barang") ?></th>
                            <th><?= __("Barcode Barang") ?></th> 
                            <th width="450"><?= __("Nama Barang") ?></th>                  
                            <th><?= __("Kategori Barang") ?></th>
                            <th colspan = "2"><?= __("Harga Rata-Rata Modal") ?></th>
                            <th colspan = "2"><?= __("Harga Jual") ?></th>
                            <th colspan = "2"><?= __("Stok") ?></th>
                            <?php
                            if ($stnAdmin->cooperativeBranchPrivilege()) {
                                ?>
                                <th width = "250"><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
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
                                    <td class="text-center"><?= $item['CooperativeGoodList']['code'] ?></td>
                                    <td class="text-center"><?= $item['CooperativeGoodList']['barcode'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeGoodList']['name'] ?></td>
                                    <td class="text-center"><?= $item['GoodType']['name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>                                    
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeGoodList']['average_capital_price']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeGoodList']['sale_price']) ?></td>
                                    <td class="text-right" style = "border-right-style:none !important"><?= $item['CooperativeGoodList']['stock_number'] ?></td>
                                    <td class="text-right" style = "border-left-style:none !important"><?= $item['CooperativeGoodListUnit']['name'] ?></td>
                                    <?php
                                    if ($stnAdmin->cooperativeBranchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewcoopstock&goodlistid={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" role="button" data-target="#default-view-coop-stock" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
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
    $(document).ready(function () {
        $("#default-view-coop-stock").on("show.bs.modal", function (e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });
    });
</script>