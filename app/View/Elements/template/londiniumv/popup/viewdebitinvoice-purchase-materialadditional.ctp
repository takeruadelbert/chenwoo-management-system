<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Data Penerimaan Kembalian Material Pembantu</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENERIMAAN KEMBALIAN MATERIAL PEMBANTU
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Penerimaan Kelebihan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Supplier Material Pembantu</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-phone5"></i> Data Kontak Person Supplier</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-add"></i> Data Material Pembantu</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Nomor PO Material Pembantu</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->data['PurchaseOrderMaterialAdditional']['po_number'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Total Tagihan</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp.</button>
                                                        </span>
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat($this->data['PurchaseOrderMaterialAdditional']['total']) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div> 
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Total Pembayaran</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp.</button>
                                                        </span>
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat($this->data['PurchaseOrderMaterialAdditional']['total'] + abs($this->data['PurchaseOrderMaterialAdditional']['remaining'])) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Kelebihan Pembayaran</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp.</button>
                                                        </span>
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat(abs($this->data['PurchaseOrderMaterialAdditional']['remaining'])) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <?php
                                                echo $this->Form->label("DebitInvoicePurchaserMaterialAdditional.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                ?>
                                                <div class="col-sm-9 col-md-8">
                                                    <input type="text" class="form-control" readonly  value = "<?= $this->data['InitialBalance']['GeneralEntryType']['name'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Nominal</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp.</button>
                                                        </span>
                                                        <input type="text" class="form-control text-right" readonly  value = "<?= $this->Html->berat($this->data['DebitInvoicePurchaserMaterialAdditional']['amount']) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> 
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-sm-2 control-label">
                                                <label>Nama MaterialAdditionalSupplier</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="supplier" name="data[MaterialAdditionalSupplier][name]" readonly value = "<?= $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['name'] ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.email_supplier", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.email_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['email']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.address_supplier", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.address_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "address", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['address']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.postal_supplier", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.postal_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "postal_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['postal_code']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.phone_supplier", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.phone_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['phone_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "website", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['website']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.city_supplier", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']["City"]['name']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.state_supplier", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']["State"]['name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.country_supplier", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']["Country"]['name']));
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
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_position']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_address']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_phone_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_email']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpCity']['name']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpState']['name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSupplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpCountry']['name']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive stn-table">
                                    <table width="100%" class="table table-hover table-bordered">                        
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th><?= __("Nama Material") ?></th>
                                                <th width="200" colspan="2"><?= __("Jumlah") ?></th>
                                                <th width="200" colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th width="200" colspan="2"><?= __("Sub Total") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <?php
                                            $subTotal = 0;
                                            $shippingCost = 0;
                                            $grandTotal = 0;
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional'])) {
                                                foreach ($this->data['PurchaseOrderMaterialAdditional']['PurchaseOrderMaterialAdditionalDetail'] as $k => $detail) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <?= $detail['MaterialAdditional']['name']." ".$detail['MaterialAdditional']['size'] ?>
                                                        </td>
                                                        <td class="text-right" style="border-right-style:none;">
                                                            <?= ic_kg($detail['quantity']) ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                            <?= $detail['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                            Rp.
                                                        </td>    
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ic_rupiah($detail['price']) ?>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                            Rp.
                                                        </td>    
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ic_rupiah($detail['price'] * $detail['quantity']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $subTotal += $detail['price'] * $detail['quantity'];
                                                    $grandTotal = $subTotal + $shippingCost;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td class="text-center" colspan = "8">Tidak ada data</td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" align="right">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right" id = "subTotal" style="border-left-style:none;">
                                                    <?= ic_rupiah($subTotal) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" align="right">
                                                    <strong>Biaya Pengiriman</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right" id = "shippingCost" style="border-left-style:none;">
                                                    <?= ic_rupiah($shippingCost) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right" id = "grandTotal" style="border-left-style:none;">
                                                    <?= ic_rupiah($grandTotal) ?>
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
        </div>                                
    </div>                                
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>