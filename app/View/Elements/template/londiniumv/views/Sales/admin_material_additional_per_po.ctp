<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/sale");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Data Permintaan Material Pembantu Ke Gudang") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("material_additional_per_po/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("material_additional_per_po/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Pembeli") ?></th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status Request Barang") ?></th>
                            <th><?= __("Status Gudang") ?></th>
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
                                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Sale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['Buyer']['company_name']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Sale"]['created'], false); ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php
                                        if (count($item['MaterialAdditionalPerContainer']) == 0) {
                                            echo "Harap Input Data Material Pembantu!";
                                        } else {
                                            echo $item['MaterialAdditionalPerContainer'][0]['VerifyStatus']['name'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center" id = "target-change-gudang<?= $i ?>">
                                        <?php
                                        echo emptyToStrip(@$item['MaterialAdditionalPerContainer'][0]['GudangStatus']['name']);
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if (count($item['MaterialAdditionalPerContainer']) == 0) {
                                            ?>
                                            <a href="<?= Router::url('/admin/material_additional_per_containers/add?id=' . $item["Sale"]['id'], true) ?>" class = ""><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Input Rincian Material Pembantu"><i class = "icon-pencil3"></i></button></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a data-toggle="modal" data-sale-id="<?= $item["Sale"]['id'] ?>" role="button" href="#default-lihatTransactionEntry" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                            <?php
                                        }
                                        ?>
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
<div id="default-lihatTransactionEntry" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">DATA PERMINTAAN MATERIAL PEMBANTU BERDASARKAN PENJUALAN
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="transactionList">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label(null, __("Pembeli"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input(null, array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled", "id" => "dummypembeli"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kebutuhan Material Pembantu") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width = "250">Produk</th>
                                    <th>Nama Material Pembantu MC</th>
                                    <th colspan="2">Jumlah MC</th>
                                    <th>Nama Material Pembantu Plastik</th>
                                    <th colspan="2">Jumlah Plastik</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-sale hidden" data-n="0">
                                </tr>
                                <tr id="init">
                                    <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                                </tr>
                            </tbody>
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
            $("tr.transaction-material-data").html("");
            var saleId = $(this).data("sale-id");
            var e = $("tr.dynamic-row-sale");
            $.ajax({
                url: BASE_URL + "admin/material_additional_per_containers/view_data_per_po/" + saleId,
                type: "GET",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    ajaxLoadingStart();
                },
                data: {},
                success: function (data) {
                    console.log(data);
                    $("#SaleSaleNo").val(data.Sale.sale_no);
                    $("#SalePoNumber").val(data.Sale.po_number);
                    $("#dummypembeli").val(data.Sale.Buyer.company_name);
                    var emp = data.MaterialAdditionalPerContainerDetail;
                    var n = 1;
                    var i = 1;
                    $.each(emp, function (index, value) {
                        var product = value.Product.Parent.name + " " + value.Product.name;
                        var materialMC = value.MaterialAdditionalMc.name;
                        var unitMC = value.MaterialAdditionalMc.MaterialAdditionalUnit.name;
                        var materialPlastic = value.MaterialAdditionalPlastic.name;
                        var unitPlastic = value.MaterialAdditionalPlastic.MaterialAdditionalUnit.name;
                        var quantityMC = ic_rupiah(value.quantity_mc);
                        var quantityPlastic = ic_rupiah(value.quantity_plastic);
                        var template = $('#tmpl-material-data1').html();
                        $("table tr#init").remove();
                        Mustache.parse(template);
                        var options = {i: i, n: n, product: product, materialMC: materialMC, unitMC: unitMC, unitPlastic: unitPlastic, materialPlastic: materialPlastic, quantityMC: quantityMC, quantityPlastic: quantityPlastic};
                        i++;
                        n++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction tr.dynamic-row-sale:last').before(rendered);
                    });
                    ajaxLoadingSuccess();
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data1">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{product}}
    </td> 
    <td class = "text-left">          
    {{materialMC}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{quantityMC}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unitMC}}
    </td>  
    <td class = "text-left">  
    {{materialPlastic}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{quantityPlastic}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unitPlastic}}
    </td>  
    </tr>
</script>
