<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/transaction_out");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA INVOICE PENJUALAN") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("invoice_sale_payment/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("invoice_sale_payment/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
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
                            <th><?= __("Nomor Invoice") ?></th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Nama Pembeli") ?></th>
                            <th colspan = "2"><?= __("Total Tagihan") ?></th>
                            <th><?= __("Tanggal Jatuh Tempo") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
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
                                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["Sale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Sale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['Sale']['sale_no'] ?></td>
                                    <td class="text-center"><?= $item['Sale']['po_number'] ?></td>
                                    <td class="text-left"><?= $item['Buyer']['company_name'] ?></td>
                                    <?php
                                    if ($item['Buyer']['buyer_type_id'] == 1) {
                                        ?>
                                        <td class="text-center" style = "border-right:none !important">Rp.</td>
                                        <td class="text-right" style = "border-left:none !important"><?php echo ic_rupiah($item['Sale']['grand_total']); ?></td>
                                        <?php
                                    } else if ($item['Buyer']['buyer_type_id'] == 2) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['Sale']['grand_total']) ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['Sale']['due_date']) ?></td>  
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>                           
                                    <td class="text-center">
                                        <a data-toggle="modal" data-invoice-id="<?= $item["Sale"]['id'] ?>" role="button" href="#default-lihatInvoice" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>    
                                        <?php
                                        if ($item['Buyer']['buyer_type_id'] == 2) {
                                            ?>
                                            <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_invoice_sale_payment/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Invoice Penjualan"><i class = "icon-print2"></i></a>
                                            <?php
                                        } else if ($item['Buyer']['buyer_type_id'] == 1) {
                                            ?>
                                            <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_invoice_sale_payment_local/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Invoice Penjualan"><i class = "icon-print2"></i></a>
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

<div id="default-lihatInvoice" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:1200px; margin-left:auto; margin-right:auto; margin-top: 50px">
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
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Invoice Penjualan</a></li>
                                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Pembeli</a></li>
                                <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Data Contact Person Pembeli</a></li>
                                <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-file6"></i> Data Pengiriman Barang</a></li>
                                <li><a href="#justified-pill5" data-toggle="tab"><i class="icon-file6"></i> Data Penjualan</a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan Produk"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id = "tagihan_local">
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Sale.grand_total", __("Total Tagihan"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class = "col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">Rp.</span>
                                                                </span>
                                                                <input type="text" class="form-control text-right" name="data[Sale][grand_total]" id = "SaleGrandTotalLocal" readonly>
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">,00.</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo $this->Form->label("Sale.shipping_cost", __("Biaya Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class = "col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">Rp.</span>
                                                                </span>
                                                                <input type="text" class="form-control text-right" name="data[Sale][shipping_cost]" id = "SaleShippingCostLocal" readonly>
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">,00.</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id = "tagihan_export">
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Sale.grand_total", __("Total Tagihan"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class = "col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">$</span>
                                                                </span>
                                                                <input type="text" class="form-control text-right" name="data[Sale][grand_total]" id = "SaleGrandTotalExport" readonly>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo $this->Form->label("Sale.shipping_cost", __("Biaya Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                        ?>
                                                        <div class = "col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default" type="button">$</span>
                                                                </span>
                                                                <input type="text" class="form-control text-right" name="data[Sale][shipping_cost]" id = "SaleShippingCostExport" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Sale.due_date", __("Tanggal Jatuh Tempo"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Sale.due_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datepicker", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Sale.shipment_payment_type", __("Tipe Pembayaran Shipment"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Sale.shipment_payment_type", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill2">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.company_name", __("Nama Perusahaan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.phone_number", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.country", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill3">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Buyer.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Buyer.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill4">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Shipment.shipment_number", __("Nomor Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Shipment.shipment_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Shipment.shipment_agent_name", __("Agen Pengiriman"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Shipment.shipment_agent_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
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
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill5">
                                    <div class="panel-heading" style="background:#2179cc">
                                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penjualan") ?></h6>
                                    </div>
                                    <table width="100%" class="table table-hover table-bordered stn-table" id = "tableType1">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th width="250">Produk</th>
                                                <th>Kode Produk</th>
                                                <th colspan="2">Isi Per MC</th>
                                                <th colspan="2">Total Berat</th>
                                                <th colspan="2">Harga Produk (Rp / Kg)</th>
                                                <th colspan="2">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-detail-transaction1">
                                            <tr class="dynamic-row-sale1 hidden" data-n="0">
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr id = "tr_sub_total">
                                                <td colspan="9" align="right">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right subTotalLocal" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                            <tr id = "tr_biaya_pengiriman">
                                                <td colspan="9" align="right">
                                                    <strong>Biaya Pengiriman</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right shipmentCostLocal" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right grandTotalLocal" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table width="100%" class="table table-hover table-bordered stn-table" id = "tableType2">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th width = "250">Produk</th>
                                                <th>Kode Produk</th>
                                                <th colspan="2">Jumlah Produk (MC)</th>
                                                <th colspan="2">Isi Per MC</th>
                                                <th colspan="2">Jumlah (Lbs)</th>
                                                <th colspan="2">Total Berat</th>
                                                <th colspan="2">Harga Produk ($ / Lbs)</th>
                                                <th colspan="2">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-detail-transaction2">
                                            <tr class="dynamic-row-sale2 hidden" data-n="0">
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr id = "tr_sub_total_export">
                                                <td colspan="13" align="right">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    $
                                                </td>
                                                <td class="text-right subTotalExport" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                            <tr id = "tr_biaya_pengiriman_export">
                                                <td colspan="13" align="right">
                                                    <strong>Biaya Pengiriman</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    $
                                                </td>
                                                <td class="text-right shipmentCostExport" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="13" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    $
                                                </td>
                                                <td class="text-right grandTotalExport" style="border-left-style:none;">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
    $("#tableType1").hide();
    $("#tableType2").hide();
    $("#tagihan_local").hide();
    $("#tagihan_export").hide();
    $(document).ready(function () {
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            var invoiceId = $(this).data("invoice-id");
            var e = $("tr.dynamic-row-shipment");
            $.ajax({
                url: BASE_URL + "admin/sales/view_data_sale/" + invoiceId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    var subTotal = 0;
                    //data sale
                    $("#SaleSaleNo").val(data.Sale.sale_no);
                    $("#SalePoNumber").val(data.Sale.po_number);
                    $("#SaleDueDate").val(cvtTanggal(data.Sale.due_date));
                    $("#SaleShipmentPaymentType").val(data.ShipmentPaymentType.name);

                    //data buyer
                    $("#BuyerCompanyName").val(data.Buyer.company_name);
                    $("#BuyerEmail").val(data.Buyer.email);
                    $("#BuyerAddress").val(data.Buyer.address);
                    $("#BuyerPhoneNumber").val(data.Buyer.phone_number);
                    $("#BuyerWebsite").val(data.Buyer.website);
                    $("#BuyerCity").val(data.Buyer.City.name);
                    $("#BuyerState").val(data.Buyer.State.name);
                    $("#BuyerCountry").val(data.Buyer.Country.name);

                    //data cp buyer
                    $("#BuyerCpName").val(data.Buyer.cp_name);
                    $("#BuyerCpPosition").val(data.Buyer.cp_position);
                    $("#BuyerCpEmail").val(data.Buyer.cp_email);
                    $("#BuyerCpAddress").val(data.Buyer.cp_address);
                    $("#BuyerCpPhoneNumber").val(data.Buyer.cp_phone_number);
                    $("#BuyerCpCity").val(data.Buyer.CpCity.name);
                    $("#BuyerCpState").val(data.Buyer.CpState.name);
                    $("#BuyerCpCountry").val(data.Buyer.CpCountry.name);

                    //data shipment
                    $("#tableExport").hide();
                    $("#ShipmentShipmentNumber").val(data.Shipment.shipment_number);
                    $("#ShipmentShipmentAgentName").val(data.Shipment.ShipmentAgent.name); //data.ShipmentAgent.name
                    $("#ShipmentShipmentDate").val(cvtTanggal(data.Shipment.shipment_date));
                    $("#ShipmentSealNumber").val(data.Shipment.seal_number);
                    $("#ShipmentContainerNumber").val(data.Shipment.container_number);
                    $("#ShipmentFromDock").val(data.Shipment.from_dock);
                    $("#ShipmentToDock").val(data.Shipment.to_dock);
                    if (data.Buyer.buyer_type_id == 1) {
                        $("#tagihan_local").show();
                        $("#tagihan_export").hide();
                        var grand = data.Sale.grand_total;
                        var grandTotal = grand.replace(".00", "");
                        $("#SaleGrandTotalLocal").val(ic_rupiah(grandTotal));
                        var shipping = data.Sale.shipping_cost;
                        var shippingCost = shipping.replace(".00", "");
                        $("#SaleShippingCostLocal").val(ic_rupiah(shippingCost));
                        $("#tableType1").show();
                        $("#tableType2").hide();
                        var emp = data.SaleDetail;
                        var i = 1;
                        $.each(emp, function (index, value) {
                            var product = value.Product.name;
                            var parent = value.Product.Parent.name;
                            var weight = ic_kg(value.nett_weight);
                            var price = value.price;
                            var prices = ic_rupiah(price.replace(".00", ""));
                            var item_code = value.item_code;
                            var mc_weight = ic_rupiah(value.McWeight.lbs);
                            var unit = value.Product.ProductUnit.name;
                            var sub_total = ic_rupiah(weight * price);
                            if (data.Sale.shipment_payment_type_id == 2) {
                                $("#tr_sub_total").show();
                                $("#tr_biaya_pengiriman").show();
                                $('.shipmentCostLocal').text(ic_rupiah(shippingCost));
                                subTotal = parseInt(subTotal) + parseInt(weight * price);
                                $('.subTotalLocal').text(ic_rupiah(subTotal));
                                $('.grandTotalLocal').text(ic_rupiah(parseInt(subTotal) + parseInt(shippingCost)));
                            } else {
                                $("#tr_sub_total").hide();
                                $("#tr_biaya_pengiriman").hide();
                                subTotal = parseInt(subTotal) + parseInt(weight * price);
                                $('.grandTotalLocal').text(ic_rupiah(parseInt(subTotal)));
                            }
                            var n = e.data("n");
                            var template = $('#tmpl-material-data1').html();
                            Mustache.parse(template);
                            var options = {i: i, n: n, parent: parent, unit: unit, product: product, weight: weight, prices: prices, item_code: item_code, mc_weight: mc_weight, sub_total: sub_total};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction1 tr.dynamic-row-sale1:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    } else if (data.Buyer.buyer_type_id == 2) {
                        $("#tagihan_local").hide();
                        $("#tagihan_export").show();
                        var grand = data.Sale.grand_total;
                        var grandTotal = grand;
                        $("#SaleGrandTotalExport").val((grandTotal));
                        var shipping = data.Sale.shipping_cost;
                        var shippingCost = shipping;
                        $("#SaleShippingCostExport").val((shippingCost));

                        $("#tableExport").show();
                        $("#ShipmentNomorBl").val(data.Shipment.bl_number);
                        $("#ShipmentFdaReg").val(data.Shipment.fda_reg_no);
                        $("#tableType1").hide();
                        $("#tableType2").show();
                        var emp = data.SaleDetail;
                        var i = 1;
                        $.each(emp, function (index, value) {
                            var product = value.Product.name;
                            var parent = value.Product.Parent.name;
                            var quantity = ic_rupiah(value.quantity);
                            var weight = ic_kg(value.nett_weight);
                            var item_code = value.item_code;
                            var mc_weight = ic_rupiah(value.McWeight.lbs);
                            var total_lbs = ic_rupiah(mc_weight * quantity);
                            var price = ac_dollar(value.price);
                            var unit = value.Product.ProductUnit.name;
                            var sub_total = ac_dollar(total_lbs * price);
                            if (data.Sale.shipment_payment_type_id == 2) {
                                $("#tr_sub_total_export").show();
                                $("#tr_biaya_pengiriman_export").show();
                                $('.shipmentCostExport').text(ac_dollar(shippingCost));
                                subTotal = parseFloat(subTotal) + parseFloat(total_lbs * price);
                                $('.subTotalExport').text(ac_dollar(subTotal));
                                $('.grandTotalExport').text((parseFloat(subTotal) + parseFloat(shippingCost)));
                            } else {
                                $("#tr_sub_total_export").hide();
                                $("#tr_biaya_pengiriman_export").hide();
                                subTotal = parseFloat(subTotal) + parseFloat(total_lbs * price);
                                $('.grandTotalExport').text(ac_dollar(subTotal));
                            }
                            var n = e.data("n");
                            var template = $('#tmpl-material-data2').html();
                            Mustache.parse(template);
                            var options = {i: i, n: n, parent: parent, unit: unit, product: product, quantity: quantity, weight: weight, price: price, sub_total: sub_total, total_lbs: total_lbs, item_code: item_code, mc_weight: mc_weight};
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction2 tr.dynamic-row-sale2:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    }
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data1">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{parent}} - {{product}}
    </td> 
    <td class="text-center">
    {{item_code}}
    </td> 
    <td class="text-right" style="border-right-style:none;">
    {{mc_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Lbs
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unit}}
    </td>    
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    Rp.
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{prices}}
    </td>  
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    Rp.
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{sub_total}}
    </td> 
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-material-data2">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-left">
    {{parent}} - {{product}}
    </td> 
    <td class="text-center">
    {{item_code}}
    </td> 
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    MC
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{mc_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Lbs
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{total_lbs}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Lbs
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unit}}
    </td>      
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    $
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{price}}
    </td>     
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    $
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{sub_total}}
    </td> 
    </tr>
</script>
