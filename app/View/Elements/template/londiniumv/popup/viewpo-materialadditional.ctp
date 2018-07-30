<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Purchase Order Material Additional</h4>
</div>
<div class="panel-body">
    <div class="block-inner text-danger">
        <h6 class="heading-hr">DATA PURCHASE ORDER MATERIAL PEMBANTU
            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
        </h6>
    </div>
    <div class="well block">
        <div class="tabbable">
            <ul class="nav nav-pills nav-justified">
                <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-user"></i> Data Pegawai Yang Memasukkan Data</a></li>
                <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Purchase Order</a></li>
                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person</a></li>
                <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-box-add"></i> Data Mat. Pembantu Yang Dipesan</a></li>
            </ul>
            <div class="tab-content pill-content" id="tabs">
                <div class="tab-pane fade in active" id="justified-pill0">
                    <table width="100%" class="table table-hover">
                        <tbody>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['nip']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.department", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']['Department']['id']) ? $this->data['Employee']['Department']['name'] : "-"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.office", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']['Office']['id']) ? $this->data['Employee']['Office']['name'] : "-"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>   
                    </table> 
                </div>
                <div class="tab-pane fade" id="justified-pill1">
                    <table width="100%" class="table table-hover">
                        <tbody>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("PurchaseOrderMaterialAdditionalTemp.po_number", __("Nomor PO"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("PurchaseOrderMaterialAdditionalTemp.po_number", array("div" => array("class" => "col-md-8"), 'type' => 'text', "label" => false, "value" => $this->data['PurchaseOrderMaterialAdditional']['po_number'], "class" => " form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("PurchaseOrderMaterialAdditional.po_date", __("Tanggal PO"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("PurchaseOrderMaterialAdditional.po_date", array("div" => array("class" => "col-md-8"), 'type' => 'text', "label" => false, "class" => "datetime form-control", "value" => $this->Html->cvtWaktu($this->data['PurchaseOrderMaterialAdditional']['po_date']), "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("PurchaseOrderMaterialAdditional.material_additional_supplier_id", __("Supplier Material Pembantu"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("PurchaseOrderMaterialAdditional.material_additional_supplier_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "value" => $this->data['MaterialAdditionalSupplier']['name'], "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("PurchaseOrderMaterialAdditional.shipping_cost", __("Biaya Pengiriman"), array("class" => "col-md-4 control-label"));
                                                ?>
                                                <div class = "col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rp.</span>   
                                                        <?php
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.shipping_cost", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "type" => "text", "value" => ic_rupiah($this->data['PurchaseOrderMaterialAdditional']['shipment_cost']), "disabled"));
                                                        ?>
                                                        <span class="input-group-addon">,00.</span>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalSupplier.cp_name", __("Nama"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['MaterialAdditionalSupplier']['cp_name']));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalSupplier.cp_name", __("Jabatan"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled", "value" => $this->data['MaterialAdditionalSupplier']['cp_position']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalSupplier.cp_address", __("Alamat"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_address", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['MaterialAdditionalSupplier']['cp_address']));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalSupplier.cp_phone_number", __("Telepon"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_phone_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['MaterialAdditionalSupplier']['cp_phone_number']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-horizontal">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalSupplier.cp_email", __("Email"), array("class" => "col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_email", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled", "value" => $this->data['MaterialAdditionalSupplier']['cp_email']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="justified-pill3">
                    <table class="table table-hover table-bordered stn-table" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Barang</th>
                                <th width="20%" colspan="2">Jumlah</th>
                                <th width="20%" colspan="2">Harga Satuan</th>
                                <th width="25%" colspan="2">Total</th>
                            </tr>
                        <thead>
                        <tbody id="target-detail-request-order-material-additional">
                            <?php
                            $subTotal = 0;
                            foreach ($this->data['PurchaseOrderMaterialAdditionalDetail'] as $k => $details) {
                                $subTotal += $details["price"] * $details["quantity"];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $k + 1 ?></td>
                                    <td>
                                        <?= $details["MaterialAdditional"]['name']." ".$details["MaterialAdditional"]['size'] ?>
                                    </td>
                                    <td class="text-right" style="border-right-style:none;">
                                        <?= (ic_kg($details["quantity"])) ?>
                                    </td> 
                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                        <?= $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                        Rp.
                                    </td>    
                                    <td class = "text-right" style="border-left-style:none;">
                                        <?= ic_rupiah($details["price"]) ?>
                                    </td> 
                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                        Rp.
                                    </td>    
                                    <td class = "text-right" style="border-left-style:none;">
                                        <?= ic_rupiah($details["price"] * $details["quantity"]) ?>
                                    </td> 
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan = "6" class = "text-right">
                                    <strong>Sub Total </strong>
                                </td>
                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                    Rp.
                                </td>
                                <td class="text-right" id = "subTotal" style="border-left-style:none;">
                                    <?= ic_rupiah($subTotal) ?>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                $pajak = $subTotal * 10 / 100;
                                ?>
                                <td colspan = "6" class = "text-right">
                                    <strong>Pajak (10%)</strong>
                                </td>
                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                    Rp.
                                </td>
                                <td class="text-right" style="border-left-style:none;">
                                    <?= ic_rupiah($pajak) ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan = "6" class = "text-right">
                                    <strong>Grand Total</strong>
                                </td>
                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                    Rp.
                                </td>
                                <td class="text-right" style="border-left-style:none;">
                                    <?= ic_rupiah($subTotal + $pajak) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>
