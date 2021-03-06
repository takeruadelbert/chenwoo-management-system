<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Data Tagihan Pembelian Ikan</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA TAGIHAN PEMBELIAN IKAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Transaksi Pembelian</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Supplier</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-box-remove"></i> Data Material</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill0">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['nip']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['Employee']["department_id"])) {
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']["Department"]['name']) ? $this->data['Employee']["Department"]['name'] : "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['Employee']["office_id"])) {
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Employee']["Office"]['name']) ? $this->data['Employee']["Office"]['name'] : "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                            }
                                            ?>
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
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.kwitansi", __("Nomor Kwitansi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.kwitansi", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['PaymentPurchaseMaterialAdditional']['receipt_number']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.po_number", __("Nomor Transaksi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.po_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['PurchaseOrderMaterialAdditional']['po_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-sm-2 control-label">
                                                <label>Total Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <?php
                                                    echo $this->Form->input("Dummy.total_invoice_amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentPurchaseMaterialAdditional']['total_amount'])));
                                                    ?>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2 control-label">
                                                <label>Sisa Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <?php
                                                    echo $this->Form->input("Dummy.remaining", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentPurchaseMaterialAdditional']['remaining'])));
                                                    ?>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.payment_type", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.payment_type", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['PaymentType']['name']));
                                            ?>
                                            <div class="col-sm-2 control-label">
                                                <label>Jumlah Pembayaran</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <?php
                                                    echo $this->Form->input("Dummy.amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentPurchaseMaterialAdditional']['amount'])));
                                                    ?>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.initial_balance", __("Kas"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.initial_balance", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['InitialBalance']['GeneralEntryType']['name']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="text-center">
                                            Keterangan
                                        </div>
                                        <hr/>    
                                        <div id="note" style="padding:0 15px">
                                            <?= $this->data["PaymentPurchaseMaterialAdditional"]["note"] ?>
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
                                            echo $this->Form->label("Dummy.nama_supplier", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nama_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['name']));
                                            ?>
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
                                            echo $this->Form->label("Dummy.phone_number_supplier", __("HP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.phone_number_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_number_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['phone_number']));
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
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['city_id'])) {
                                                echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['City']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city_supplier", "readonly", "value" => "-"));
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
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['state_id'])) {
                                                echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['State']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city_supplier", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.country_supplier", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['country_id'])) {
                                                echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country_supplier", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['Country']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country_supplier", "readonly", "value" => "-"));
                                            }
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
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_city_id'])) {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpCity']['name']));
                                            } else {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_state_id'])) {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpState']['name']));
                                            } else {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSupplier.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['cp_country_id'])) {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['CpCountry']['name']));
                                            } else {
                                                echo $this->Form->input("MaterialAdditionalSupplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div class="tab-pane fade" id="justified-pill3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive stn-table pre-scrollable">
                                    <table width="100%" class="table table-hover table-bordered">                        
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th width="320"><?= __("Nama Material Pembantu") ?></th>
                                                <th width = "200" colspan="2"><?= __("Jumlah") ?></th>
                                                <th width = "230" colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th width = "230" colspan="2"><?= __("Sub Total") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <?php
                                            $subTotal = 0;
                                            foreach ($this->data["PurchaseOrderMaterialAdditional"]['PurchaseOrderMaterialAdditionalDetail'] as $k => $material) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $k + 1 ?></td>
                                                    <td>
                                                        <?= $material["MaterialAdditional"]["full_label"] ?>
                                                    </td> 
                                                    <td class="text-right" style="border-right-style:none;">
                                                        <?= ic_kg($material["quantity"]) ?>
                                                    </td> 
                                                    <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                        <?= $material['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                                                    </td>
                                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                        Rp.
                                                    </td>    
                                                    <td class = "text-right" style="border-left-style:none;">
                                                        <?= ic_rupiah($material["price"]) ?>
                                                    </td>      
                                                    <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                        Rp.
                                                    </td>    
                                                    <td class = "text-right" style="border-left-style:none;">
                                                        <?= ic_rupiah($material["quantity"] * $material['price']) ?>
                                                    </td>  
                                                </tr>
                                                <?php
                                                $subTotal += $material["quantity"] * $material['price'];
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
                                                    <?= ic_rupiah($this->data['PurchaseOrderMaterialAdditional']['shipment_cost']) ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $grandTotal = $subTotal + $this->data['PurchaseOrderMaterialAdditional']['shipment_cost'];
                                            ?>
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