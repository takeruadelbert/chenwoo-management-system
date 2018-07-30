<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/shipment");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PENGIRIMAN BARANG") ?>
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
                            <th><?= __("No. Pengiriman") ?></th>
                            <th><?= __("No. Penjualan") ?></th>
                            <th><?= __("No. PO") ?></th>
                            <th><?= __("Nama Pembeli") ?></th>
                            <th><?= __("Asal") ?></th>
                            <th><?= __("Tujuan") ?></th>
                            <th><?= __("Tanggal Pengiriman") ?></th>
                            <th><?= __("Status Pengiriman") ?></th>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Shipment"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Shipment"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['Shipment']['shipment_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['sale_no']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Sale']['Buyer']['company_name']; ?></td>
                                    <td class="text-center"><?php echo $item['Shipment']['from_dock']; ?></td>
                                    <td class="text-center"><?php echo $item['Shipment']['to_dock']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item["Shipment"]['shipment_date']); ?></td>
                                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                                        <?php
                                        if ($item['Shipment']['shipment_status_id'] == 2) {
                                            echo "Delivered";
                                        } else {
                                            echo $this->Html->changeStatusSelect($item['Shipment']['id'], ClassRegistry::init("ShipmentStatus")->find("list", array("fields" => array("ShipmentStatus.id", "ShipmentStatus.name"))), $item['Shipment']['shipment_status_id'], Router::url("/admin/shipments/change_status_verify"), "#target-change-status$i");
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"> 
                                        <a data-toggle="modal" data-shipment-id="<?= $item["Shipment"]['id'] ?>" role="button" href="#default-lihatShipment" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>    
                                        <a target="_blank" href="<?= Router::url("/admin/package_details/view_package?sale_id={$item['Sale']['id']}&type=shipment") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data Paket"><i class="icon-file-check"></i></button></a>
                                        <?php
                                        if ($item['Shipment']['shipment_status_id'] == 1) {
                                            ?>
                                            <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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
<div id="default-lihatShipment" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width: 1200px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA PENGIRIMAN BARANG 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-mail-send"></i> Data Pengiriman</a></li>
                                <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-box-remove"></i> Detail Penjualan </a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill0">   
                                    <table width="100%" class="table table-hover">
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.sale_number", __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.sale_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.shipment_number", __("Nomor Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.shipment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.po_number", __("Nomor PO"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.po_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.buyer", __("Pembeli"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.buyer", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.shipment_agent_name", __("Agent Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.shipment_agent_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.shipment_date", __("Tanggal Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.shipment_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.seal_number", __("Nomor Segel"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.seal_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.container_number", __("Nomor Kontainer"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.container_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.from_dock", __("Dermaga Asal"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.from_dock", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.to_dock", __("Dermaga Tujuan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.to_dock", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id = "tableExport">
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Shipment.nomor_bl", __("Nomor B/L"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.nomor_bl", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Shipment.fda_reg", __("Nomor FDA REG"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Shipment.fda_reg", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill1"> 
                                    <div class="table-responsive stn-table">
                                        <div class="panel-heading" style="background:#2179cc">
                                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Penjualan") ?></h6>
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th><?= __("Nama Produk") ?></th>
                                                    <th width="150" colspan="2"><?= __("Jumlah MC Diorder") ?></th>
                                                    <th width="150" colspan="2"><?= __("Jumlah MC Terpenuhi") ?></th>
                                                    <th width="150" colspan="2"><?= __("Berat Pemesanan") ?></th>
                                                    <th width="150" colspan="2"><?= __("Berat Terpenuhi") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-detail-transaction">
                                                <tr class="dynamic-row-shipment hidden" data-n="0">
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>         
                            </div>     
                        </div>     
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
            var shipmentId = $(this).data("shipment-id");
            var e = $("tr.dynamic-row-shipment");
            $.ajax({
                url: BASE_URL + "admin/shipments/get_shipment_details/" + shipmentId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#tableExport").hide();
                    $("#ShipmentSaleNumber").val(data.Sale.sale_no); //data.ShipmentAgent.name
                    $("#ShipmentShipmentNumber").val(data.Shipment.shipment_number);
                    $("#ShipmentPoNumber").val(data.Sale.po_number);
                    $("#ShipmentBuyer").val(data.Sale.Buyer.company_name);
                    $("#ShipmentShipmentAgentName").val(data.ShipmentAgent.name); //data.ShipmentAgent.name
                    $("#ShipmentShipmentDate").val(cvtTanggal(data.Shipment.shipment_date));
                    $("#ShipmentSealNumber").val(data.Shipment.seal_number);
                    $("#ShipmentContainerNumber").val(data.Shipment.container_number);
                    $("#ShipmentFromDock").val(data.Shipment.from_dock);
                    $("#ShipmentToDock").val(data.Shipment.to_dock);
                    if (data.Sale.Buyer.buyer_type_id == 2) {
                        $("#tableExport").show();
                        $("#ShipmentNomorBl").val(data.Shipment.bl_number);
                        $("#ShipmentFdaReg").val(data.Shipment.fda_reg_no);
                    }
                    var emp = data.Sale.SaleDetail;
                    var i = 1;
                    $.each(emp, function (indexPackage, valuePackage) {
                        var product = valuePackage.Product.Parent.name + " " + valuePackage.Product.name;
                        var quantity = ic_rupiah(valuePackage.quantity);
                        var quantityPrd = ic_rupiah(valuePackage.quantity_production);
                        var nettWeight = ic_kg(valuePackage.nett_weight);
                        var fullfillWeight = ic_kg(valuePackage.fulfill_weight);
                        var unit = valuePackage.Product.ProductUnit.name;
                        var n = e.data("n");
                        var template = $('#tmpl-material-data').html();
                        Mustache.parse(template);
                        var options = {i: i, n: n, fullfillWeight: fullfillWeight, product: product, nettWeight: nettWeight, quantity: quantity, quantityPrd: quantityPrd, unit: unit};
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction tr.dynamic-row-shipment:last').before(rendered);
                        e.data("n", n + 1);
                    });
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{product}}
    </td> 
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    MC
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{quantityPrd}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    MC
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{nettWeight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unit}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{fullfillWeight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unit}}
    </td>
    </tr>
</script>

