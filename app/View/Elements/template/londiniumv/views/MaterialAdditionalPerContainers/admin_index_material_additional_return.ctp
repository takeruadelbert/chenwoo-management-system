<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_additional_return");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PENGEMBALIAN MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_material_additional_return/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_material_additional_return/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
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
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nomor Penjualan") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                                    <td class="text-center"> <a data-toggle = "modal" data-sale-id = "<?= $item["Sale"]['id'] ?>" role = "button" href = "#default-lihatTransactionEntry" class = "viewData"><?php echo $item['Sale']['sale_no']; ?></a></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Sale"]['created'], false); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['MaterialAdditionalReturn']['material_additional_per_container_id'] == $item['MaterialAdditionalPerContainer']['id']) {
                                            echo $item["MaterialAdditionalReturn"]['Employee']['Account']['Biodata']['full_name'];
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"  id = "target-change-status-top<?= $i ?>">
                                        <?php
                                        if (!empty($item['MaterialAdditionalReturn']['material_additional_per_container_id'])) {
                                            if ($item['MaterialAdditionalReturn']['verify_status_id'] == 2) {
                                                echo "Ditolak";
                                            } else if ($item['MaterialAdditionalReturn']['verify_status_id'] == 3) {
                                                echo "Disetujui";
                                            } else {
                                                echo $this->Html->changeStatusSelect($item['MaterialAdditionalReturn']['id'], ClassRegistry::init("VerifyStatus")->find("list", array("fields" => array("VerifyStatus.id", "VerifyStatus.name"))), $item['MaterialAdditionalReturn']['verify_status_id'], Router::url("/admin/material_additional_returns/change_status_verify"), "#target-change-status-top$i");
                                            }
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['MaterialAdditionalReturn']['material_additional_per_container_id'] != $item['MaterialAdditionalPerContainer']['id']) {
                                            ?>
                                            <a href = "<?= Router::url("/admin/material_additional_returns/return/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Pengembalian Material"><i class = "icon-stopwatch"></i></a>
                                            <?php
                                        } else if ($item['MaterialAdditionalReturn']['verify_status_id'] != 3) {
                                            if ($item['MaterialAdditionalReturn']['material_additional_per_container_id'] == $item['MaterialAdditionalPerContainer']['id']) {
                                                ?>
                                                <a href = "<?= Router::url("/admin/material_additional_returns/edit/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Proses Pengembalian Material"><i class = "icon-pencil"></i></a>
                                                <?php
                                            }
                                        }
                                        ?>             
                                        <?php
                                        if ($item['MaterialAdditionalReturn']['material_additional_per_container_id'] == $item['MaterialAdditionalPerContainer']['id']) {
                                            ?>
                                            <a data-toggle="modal" data-target="#default-view-coop-transaction" role="button" href="<?= Router::url("/admin/popups/content?content=viewmaterialadditional-return&id={$item[Inflector::classify($this->params['controller'])]['id']}") ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip viewData" title = "Lihat Data"><i class = "icon-eye7"></i></a>
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
                        <h6 class="heading-hr">LIHAT DATA MATERIAL PEMBANTU PER CONTAINER 
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
                                        echo $this->Form->label("Sale.sale_no", __("Nomor Pembelian"), array("class" => "col-sm-3 col-md-3 control-label"));
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
                                        echo $this->Form->label("Sale.buyer", __("Pembeli"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("Sale.buyer", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kebutuhan Master Karton dan Plastik Untuk 1 PO") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width = "250">Produk</th>
                                    <th>Nama Material Pembantu MC</th>
                                    <th>Jumlah MC</th>
                                    <th>Nama Material Pembantu Plastik</th>
                                    <th>Jumlah Plastik</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-sale hidden" data-n="0">
                                </tr>
                                <tr id="init">
                                    <td class = "text-center" colspan = 4>Tidak Ada Data</td>
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
                    $("#SaleSaleNo").val(data.Sale.sale_no);
                    $("#SalePoNumber").val(data.Sale.po_number);
                    $("#SaleBuyer").val(data.Sale.Buyer.company_name);
                    var emp = data.MaterialAdditionalPerContainerDetail;
                    var n = 1;
                    var i = 1;
                    $.each(emp, function (index, value) {
                        var product = value.Product.Parent.name + " " + value.Product.name;
                        var materialMC = value.MaterialAdditionalMc.name;
                        var materialPlastic = value.MaterialAdditionalPlastic.name;
                        var quantityMC = value.quantity_mc;
                        var quantityPlastic = value.quantity_plastic;
                        var template = $('#tmpl-material-data1').html();
                        $("table tr#init").remove();
                        Mustache.parse(template);
                        var options = {
                            i: i,
                            n: n,
                            product: product,
                            materialMC: materialMC,
                            materialPlastic: materialPlastic,
                            quantityMC: ic_kg(quantityMC),
                            quantityPlastic: ic_kg(quantityPlastic)
                        };
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
    <td class="text-center">
    <div class="input-group" style='width:100%'>
    <input class='form-control' id='SaleDetailProductId' value="{{product}}" readonly>
    </div>
    </td> 
    <td>
    <div class="input-group">            
    <input class='form-control text-left' value="{{materialMC}}" readonly>
    </div>
    </td>
    <td>
    <div class="input-group">            
    <input class='form-control text-right' value="{{quantityMC}}" readonly>
    <span class="input-group-addon"><strong>pcs</strong></span>
    </div>
    </td>
    <td>
    <div class="input-group">            
    <input class='form-control text-left' value="{{materialPlastic}}" readonly>
    </div>
    </td>
    <td>
    <div class="input-group">            
    <input class='form-control text-right' value="{{quantityPlastic}}" readonly>
    <span class="input-group-addon"><strong>pcs</strong></span>
    </div>
    </td>
    </tr>
</script>
