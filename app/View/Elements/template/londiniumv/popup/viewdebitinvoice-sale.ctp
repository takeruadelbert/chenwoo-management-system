<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Data Penerimaan Kelebihan</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENERIMAAN KELEBIHAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Penerimaan Kelebihan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pembeli</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-user2"></i> Data Contact Person Pembeli</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-add"></i> Data Produk</a></li>
                </ul>   
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="col-sm-3 col-md-4 control-label label-required">
                                                    <label>Nomor Penjualan Produk</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <input type="text" class="form-control text-right isdecimal" readonly value = "<?= $this->data['Sale']['sale_no'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                if ($this->data['Sale']['Buyer']['buyer_type_id'] == 2) {
                                    ?>
                                    <tr id = tagihan-export>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="col-sm-3 col-md-4 control-label label-required">
                                                        <label>Total Tagihan</label>
                                                    </div>
                                                    <div class="col-sm-9 col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">$</button>
                                                            </span>
                                                            <input type="text" class="form-control text-right isdecimal" readonly id="totalTagihan" value = "<?= $this->data['Sale']['grand_total'] ?>">
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
                                                                <button class="btn btn-default" type="button">$</button>
                                                            </span>
                                                            <input type="text" class="form-control text-right isdecimal" readonly id="totalPembayaran" value = "<?= $this->data['Sale']['grand_total'] + abs($this->data['Sale']['remaining']) ?>">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id = sisa-tagihan-export>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="col-sm-3 col-md-4 control-label label-required">
                                                        <label>Kelebihan Pembayaran</label>
                                                    </div>
                                                    <div class="col-sm-9 col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">$</button>
                                                            </span>
                                                            <input type="text" class="form-control text-right isdecimal" readonly id="sisaPembayaran" value = "<?= abs($this->data['Sale']['remaining']) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id = initial-balance>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <?php
                                                    echo $this->Form->label("DebitInvoiceSale.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                                                <button class="btn btn-default" type="button">$</button>
                                                            </span>
                                                            <?php
                                                            echo $this->Form->input("DebitInvoiceSale.amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr id = tagihan-local>
                                        <td colspan = "11" style = "width:200px">
                                            <div class = "form-group">
                                                <div class = "col-md-6">
                                                    <div class = "col-sm-3 col-md-4 control-label label-required">
                                                        <label>Total Tagihan</label>
                                                    </div>
                                                    <div class = "col-sm-9 col-md-8">
                                                        <div class = "input-group">
                                                            <span class = "input-group-btn">
                                                                <button class = "btn btn-default" type = "button">Rp.</button>
                                                            </span>
                                                            <input type = "text" class = "form-control text-right isdecimal" readonly id = "totalTagihanLocal" value = "<?= $this->Html->berat(str_replace(".00", "", $this->data['Sale']['grand_total'])) ?>">
                                                            <span class = "input-group-btn">
                                                                <button class = "btn btn-default" type = "button">, 00.</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class = "col-md-6">
                                                    <div class = "col-sm-3 col-md-4 control-label label-required">
                                                        <label>Total Pembayaran</label>
                                                    </div>
                                                    <div class = "col-sm-9 col-md-8">
                                                        <div class = "input-group">
                                                            <span class = "input-group-btn">
                                                                <button class = "btn btn-default" type = "button">Rp.</button>
                                                            </span>
                                                            <input type = "text" class = "form-control text-right isdecimal" readonly id = "totalPembayaranLocal" value = "<?= $this->Html->berat($this->data['Sale']['grand_total'] + abs($this->data['Sale']['remaining'])) ?>">
                                                            <span class = "input-group-btn">
                                                                <button class = "btn btn-default" type = "button">, 00.</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id = sisa-tagihan-local>
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
                                                            <input type="text" class="form-control text-right isdecimal" readonly id="sisaPembayaranLocal" value = "<?= $this->Html->berat(abs($this->data['Sale']['remaining'])) ?>">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">,00.</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id = initial-balance-local>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <?php
                                                    echo $this->Form->label("DebitInvoiceSale.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
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
                                                            <input type="text" class="form-control text-right" readonly  value = "<?= $this->Html->berat($this->data['DebitInvoiceSale']['amount']) ?>">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">,00.</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div> 
                    </div> 
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Buyer.company_name", __("Nama Perusahaan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['company_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.company_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_email", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyEmail", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['email']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.company_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_address", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyAddress", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['address']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.company_postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPostalCode", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['postal_code']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.company_phone", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_phone", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPhone", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['phone_number']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.company_website", __("Website"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_website", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyWebsite", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['website']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.company_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['city_id'] == null) {
                                                echo $this->Form->input("Dummy.company_city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.company_city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['City']['name']));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.company_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['state_id'] == null) {
                                                echo $this->Form->input("Dummy.company_state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.company_state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['State']['name']));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.company_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['country_id'] == null) {
                                                echo $this->Form->input("Dummy.company_country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCountry", "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Dummy.company_country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCountry", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['Country']['name']));
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
                                            echo $this->Form->label("Buyer.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['cp_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Buyer.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['cp_position']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Buyer.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['cp_address']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Buyer.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['cp_phone_number']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Buyer.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Buyer.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['cp_email']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Buyer.cp_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['cp_city_id'] == null) {
                                                echo $this->Form->input("Buyer.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpCity']['name']));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Buyer.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['cp_state_id'] == null) {
                                                echo $this->Form->input("Buyer.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpState']['name']));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Buyer.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if ($this->data['Sale']['Buyer']['cp_country_id'] == null) {
                                                echo $this->Form->input("Buyer.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpCountry']['name']));
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
                                    <?php
                                    if ($this->data['Sale']['Buyer']['buyer_type_id'] == 2) {
                                        ?>
                                        <table width="100%" class="table table-hover table-bordered table-export">                        
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th><?= __("Produk") ?></th>
                                                    <th width="15%"><?= __("Kode Produk") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Jumlah Produk (MC)") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Isi Per Mc") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Jumlah (Lbs)") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Total Berat") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Harga Produk ($ / Lbs)") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Total") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-installment">
                                                <?php
                                                $subTotal = 0;
                                                $shippingCost = $this->data['Sale']['shipping_cost'];
                                                $grandTotal = 0;
                                                if (!empty($this->data['Sale'])) {
                                                    foreach ($this->data['Sale']['SaleDetail'] as $k => $detail) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $k + 1 ?></td>
                                                            <td>
                                                                <?= $detail['Product']['Parent']['name'] ?> - <?= $detail['Product']['name'] ?>
                                                            </td>
                                                            <td class = "text-center">
                                                                <?= $detail['Product']['code'] ?>
                                                            </td>
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= ic_decimalseperator($detail['quantity']) ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Pcs
                                                            </td> 
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= $detail['McWeight']['lbs'] ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Lbs
                                                            </td> 
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= ic_decimalseperator($detail['McWeight']['lbs'] * $detail['quantity']) ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Lbs
                                                            </td> 
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= ic_kg($detail['nett_weight']) ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Kg
                                                            </td> 
                                                            <td class = "text-center" style= "width:50px; border-right-style:none;">
                                                                $
                                                            </td>    
                                                            <td class="text-right" style="border-left-style:none;">  
                                                                <?= ac_dollar($detail['price']) ?>
                                                            </td> 
                                                            <td class = "text-center" style= "width:50px; border-right-style:none;">
                                                                $
                                                            </td>    
                                                            <td class="text-right" style="border-left-style:none;">  
                                                                <?= ac_dollar($detail['price'] * $detail['McWeight']['lbs'] * $detail['quantity']) ?>
                                                            </td> 
                                                        </tr>
                                                        <?php
                                                        $subTotal += $detail['price'] * $detail['McWeight']['lbs'] * $detail['quantity'];
                                                        $grandTotal = $subTotal + $shippingCost;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" colspan = "15">Tidak ada data</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                if ($this->data['Sale']['shipment_payment_type_id'] == 2) {
                                                    ?>
                                                    <tr id="sub_total">
                                                        <td colspan="13" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class="text-right auto-calculate-sub-total" style="border-left-style:none;">
                                                            <?= ac_dollar($subTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="shipping_cost">
                                                        <td colspan="13" align="right">
                                                            <strong>Biaya Pengiriman</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class="text-right shipping_cost" style="border-left-style:none;">
                                                            <?= ac_dollar($shippingCost) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="13" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                            <?= ac_dollar($grandTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="13" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                            <?= ac_dollar($subTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tfoot>
                                        </table>
                                        <?php
                                    } else {
                                        ?>
                                        <table width="100%" class="table table-hover table-bordered table-local">                        
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th><?= __("Produk") ?></th>
                                                    <th width="15%"><?= __("Kode Produk") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Isi Per Mc") ?></th>
                                                    <th width="10%" colspan="2"><?= __("Total Berat") ?></th>
                                                    <th width="15%" colspan="2"><?= __("Harga Produk (Rp / Kg)") ?></th>
                                                    <th width="15%" colspan="2"><?= __("Total") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-installment-local">
                                                <?php
                                                $subTotal = 0;
                                                $shippingCost = $this->data['Sale']['shipping_cost'];
                                                $grandTotal = 0;
                                                if (!empty($this->data['Sale'])) {
                                                    foreach ($this->data['Sale']['SaleDetail'] as $k => $detail) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $k + 1 ?></td>
                                                            <td>
                                                                <?= $detail['Product']['Parent']['name'] ?> - <?= $detail['Product']['name'] ?>
                                                            </td>
                                                            <td class = "text-center">
                                                                <?= $detail['Product']['code'] ?>
                                                            </td>
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= $detail['McWeight']['lbs'] ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Lbs
                                                            </td>  
                                                            <td class = "text-right" style= "border-right-style:none;">
                                                                <?= ic_kg($detail['nett_weight']) ?>
                                                            </td> 
                                                            <td class = "text-left" style= "width:50px; border-left-style:none;">     
                                                                Kg
                                                            </td> 
                                                            <td class = "text-center" style= "width:50px; border-right-style:none;">
                                                                Rp.
                                                            </td>    
                                                            <td class="text-right" style="border-left-style:none;">  
                                                                <?= ic_rupiah($detail['price']) ?>
                                                            </td> 
                                                            <td class = "text-center" style= "width:50px; border-right-style:none;">
                                                                Rp.
                                                            </td>    
                                                            <td class="text-right" style="border-left-style:none;">  
                                                                <?= ic_rupiah($detail['price'] * $detail['nett_weight']) ?>
                                                            </td>  
                                                        </tr>
                                                        <?php
                                                        $subTotal += $detail['price'] * $detail['nett_weight'];
                                                        $grandTotal = $subTotal + $shippingCost;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" colspan = "11">Tidak ada data</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                if ($this->data['Sale']['shipment_payment_type_id'] == 2) {
                                                    ?> <tr id="sub_total-local">
                                                        <td colspan="9" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right auto-calculate-sub-total" style="border-left-style:none;">
                                                            <?= ic_rupiah($subTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <tr id="shipping_cost-local">
                                                        <td colspan="9" align="right">
                                                            <strong>Biaya Pengiriman</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right shipping_cost" style="border-left-style:none;">
                                                            <?= ic_rupiah($shippingCost) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                            <?= ic_rupiah($grandTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="9" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                            <?= ic_rupiah($subTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tfoot>
                                        </table>
                                        <?php
                                    }
                                    ?>
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