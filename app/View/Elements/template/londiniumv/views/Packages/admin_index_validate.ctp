<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/package");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Paket") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/daily_packaging/ ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip"><i class = "icon-print2"></i> Cetak Laporan Pengemasan</a>
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/form_packaging/ ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip"><i class = "icon-print2"></i> Cetak Form Pengemasan</a>
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
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor MC") ?></th>
                            <th><?= __("Nama Produk") ?></th>
                            <th><?= __("Berat") ?></th>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <!--<th width="100"><?__("Aksi") ?></th>-->
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                foreach ($item['PackageDetail'] as $detail) {
                                    ?>

                                    <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Package"]['id']; ?>">
                                        <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Package"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><span class="isQRcode"><?php echo $detail['package_no']; ?></span></td>
                                        <td class="text-center"><span><?php echo $detail['Product']['Parent']['name'] . " " . $detail['Product']['name']; ?></span></td>
                                        <td class="text-center"><span><?php echo $detail['nett_weight']; ?> Kg</span></td>
                                        <td class="text-center">
                                            <span>
                                                <?php
                                                if ($detail['used'] == 1) {
                                                    echo "Dalam Pengiriman";
                                                } else {
                                                    echo "Dalam Gudang";
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Package"]['created']); ?></td>
                                        <td class="text-center">
                                            <!--<a href="<?Router::url("/admin/{$this->params['controller']}/print_qr_code/{$detail['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Print QRCode"><i class="icon-print2"></i></button></a>-->
                                            <?php //$this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/view", ["editUrl" => Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                            <?php //$this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete", ["editUrl" => Router::url("/admin/{$this->params['controller']}/delete/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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

<div id="default-lihatpackage" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PAKET 
                            <small class="display-block">PT. Chenwoo Fishery Makassar</small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="packageList">
                        </table>
                    </div>                                
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        $(".viewData").click(function () {
            var packageId = $(this).data("package-id");
            $.ajax({
                url: BASE_URL + "packages/view_data_package/" + packageId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#PackagePackageNo").val(data.Package.package_no);

                }
            });
        });
    });
</script>
