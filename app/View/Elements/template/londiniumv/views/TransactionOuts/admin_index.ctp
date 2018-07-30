<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/transaction_out_index");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Transaction Out") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/report/ ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip"><i class = "icon-print2"></i> Cetak Laporan</a>
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
                            <th><?= __("Nomor Invoice") ?></th>
                            <th><?= __("Total Transaksi") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th><?= __("Aksi") ?></th>
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
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["TransactionOut"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["TransactionOut"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item["TransactionOut"]['invoice_number']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->IDR($item["TransactionOut"]['total']); ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["TransactionOut"]['created']); ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-transaction-id="<?= $item["TransactionOut"]['id'] ?>" role="button" href="#default-lihatpackage" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
<div id="default-lihatpackage" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA BARANG KELUAR 
                            <small class="display-block">PT. Chenwoo Fishery Makassar</small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="productList">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("TransactionOut.invoice_number", __("Nomor Penjualan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("TransactionOut.invoice_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
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
            var transactionId = $(this).data("transaction-id");
            $.ajax({
                url: BASE_URL + "admin/transaction_outs/view_data_transaction_outs/" + transactionId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#TransactionOutInvoiceNumber").val(data.TransactionOut.invoice_number);
                    //for(i=0;i<data['TransactionMaterialOut'].length;i++){
                        //alert(data['PackageDetail'][i]['ProductData']['ProductSize']['name']);
                       // $("#productList").append("<tr><td><div class='form-group'><label class='col-sm-3 col-md-4 control-label label-required'>Barang "+(i+1)+"</label><div class='col-sm-9 col-md-8 required'>"+data['PackageDetail'][i]['ProductData']['ProductSize']['name']+" - "+data['PackageDetail'][i]['ProductData']['ProductSize']['Product']['name']+"</div></div></td></tr>");
                    //}
                    var count=1;
                    for(i=0;i<data['TransactionMaterialOut'].length;i++){
                        for(j=0;j<data['TransactionMaterialOut'][i]['Package']['PackageDetail'].length;j++){
                            $("#productList").append("<tr><td><div class='form-group'><label class='col-sm-3 col-md-4 control-label label-required'>Barang "+(count)+"</label><div class='col-sm-9 col-md-8 required'>"+data['TransactionMaterialOut'][i]['Package']['PackageDetail'][j]['ProductData']['ProductSize']['Product']['name']+" - "+data['TransactionMaterialOut'][i]['Package']['PackageDetail'][j]['ProductData']['ProductSize']['name']+"</div></div></td></tr>");
                            count++;
                        }
                    }
                    
                }
            });
        });
    });
</script>



