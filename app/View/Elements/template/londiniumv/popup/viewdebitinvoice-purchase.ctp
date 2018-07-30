<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Data Penerimaan Kembalian</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENERIMAAN KEMBALIAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Penerimaan Kelebihan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Supplier</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-user2"></i> Data Kontak Person Supplier</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-add"></i> Data Material</a></li>
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
                                                    <label>Nomor Transaksi</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->data['TransactionEntry']['transaction_number'] ?>">
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
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat($this->data['TransactionEntry']['total']) ?>">
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
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat($this->data['TransactionEntry']['total'] + abs($this->data['TransactionEntry']['remaining'])) ?>">
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
                                                        <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->Html->berat(abs($this->data['TransactionEntry']['remaining'])) ?>">
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
                                                echo $this->Form->label("DebitInvoicePurchaser.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                                        <input type="text" class="form-control text-right" readonly  value = "<?= $this->Html->berat($this->data['DebitInvoicePurchaser']['amount']) ?>">
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
                                                <label>Nama Supplier</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="supplier" name="data[Supplier][name]" readonly value = "<?= $this->data['TransactionEntry']['Supplier']['name'] ?>">
                                            </div>
                                            <?php
                                            echo $this->Form->label("Dummy.supplier_type", __("Tipe Supplier"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.supplier_type", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly", "value" => !empty($this->data['TransactionEntry']['supplier_type_id']) ? $this->data['TransactionEntry']['Supplier']['SupplierType']['name'] : "-"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.email_supplier", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.email_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['email']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.address_supplier", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.address_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "address", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['address']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.postal_supplier", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.postal_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "postal_supplier", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['postal_code']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.phone_supplier", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.phone_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_supplier", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['phone_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "website", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['website']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.city_supplier", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['city_id'])) {
                                                echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city", "readonly", "value" => $this->data['TransactionEntry']['Supplier']["City"]['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city", "readonly", "value" => "-"));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.state_supplier", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['state_id'])) {
                                                echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state", "readonly", "value" => $this->data['TransactionEntry']['Supplier']["State"]['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.country_supplier", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['country_id'])) {
                                                echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country", "readonly", "value" => $this->data['TransactionEntry']['Supplier']["Country"]['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country", "readonly", "value" => "-"));
                                            }
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
                                            echo $this->Form->label("Supplier.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Supplier.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['cp_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Supplier.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Supplier.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['cp_position']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Supplier.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Supplier.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['cp_address']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Supplier.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Supplier.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['cp_phone_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Supplier.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Supplier.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['cp_email']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Supplier.cp_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['cp_city_id'])) {
                                                echo $this->Form->input("Supplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['CpCity']['name']));
                                            } else {
                                                echo $this->Form->input("Supplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Supplier.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['cp_state_id'])) {
                                                echo $this->Form->input("Supplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['CpState']['name']));
                                            } else {
                                                echo $this->Form->input("Supplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Supplier.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['TransactionEntry']['Supplier']['cp_country_id'])) {
                                                echo $this->Form->input("Supplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['TransactionEntry']['Supplier']['CpCountry']['name']));
                                            } else {
                                                echo $this->Form->input("Supplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
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
                                                <th colspan="2"><?= __("Jumlah") ?></th>
                                                <th colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th colspan="2"><?= __("Sub Total") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment"><?php
                                            $subTotal = 0;
                                            $shippingCost = $this->data['TransactionEntry']['shipping_cost'];
                                            $grandTotal = 0;
                                            if (!empty($this->data['TransactionEntry'])) {
                                                foreach ($this->data['TransactionEntry']['TransactionMaterialEntry'] as $k => $detail) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <?= $detail['MaterialDetail']['name'] ?> - <?= $detail['MaterialSize']['name'] ?>
                                                        </td>
                                                        <td class="text-right" style="border-right-style:none;">
                                                            <?= ic_kg($detail['weight']) ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                            Kg
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
                                                            <?= ic_rupiah($detail['price'] * $detail['weight']) ?>
                                                        </td>   
                                                    </tr>
                                                    <?php
                                                    $subTotal += $detail['price'] * $detail['weight'];
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
                                                <td class="text-right auto-calculate-sub-total" id="subTotal" style="border-left-style:none;">
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
                                                <td class="text-right" id="shippingCost" style="border-left-style:none;">
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
                                                <td class="text-right auto-calculate-grand-total" id = "grandTotal" style="border-left-style:none;">
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