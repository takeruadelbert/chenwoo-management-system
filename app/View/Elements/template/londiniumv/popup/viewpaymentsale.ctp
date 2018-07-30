<?php
//debug($this->data);
//die;
?>
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
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Invoice Penjualan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pembeli</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-add"></i> Data Penjualan Produk</a></li>
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

                                            echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => emptyToStrip(@$this->data['Employee']["Department"]['name'])));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));

                                            echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => emptyToStrip(@$this->data['Employee']["Office"]['name'])));
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
                                            echo $this->Form->input("Dummy.kwitansi", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['PaymentSale']['receipt_number']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.sale_no", __("Nomor PO"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.sale_no", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Sale']['sale_no']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                if ($this->data['Sale']['Buyer']['buyer_type_id'] == 1) {
                                    ?>
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
                                                        echo $this->Form->input("Dummy.total_invoice_amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentSale']['total_invoice_amount'])));
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
                                                        echo $this->Form->input("Dummy.remaining", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentSale']['remaining'])));
                                                        ?>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <div class="col-sm-2 control-label">
                                                    <label>Total Tagihan</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <?php
                                                        echo $this->Form->input("Dummy.total_invoice_amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right ", "disabled", "value" => ac_dollar($this->data['PaymentSale']['total_invoice_amount'])));
                                                        ?>
                                                    </div>
                                                </div> 
                                                <div class="col-sm-2 control-label">
                                                    <label>Sisa Tagihan</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <?php
                                                        echo $this->Form->input("Dummy.remaining", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right ", "disabled", "value" => ac_dollar($this->data['PaymentSale']['remaining'])));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSale.shipment_payment_type", __("Tipe Pembayaran Shipment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSale.shipment_payment_type", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "shipmentPaymentType", "readonly", "value" => $this->data['Sale']['ShipmentPaymentType']["name"]));
                                            ?>
                                            <?php
                                            if ($this->data['Sale']['Buyer']['buyer_type_id'] == 1) {
                                                ?>
                                                <div class="col-sm-2 control-label">
                                                    <label>Biaya Pengiriman</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">Rp</button>
                                                        </span>
                                                        <?php
                                                        echo $this->Form->input("Dummy.shipping_cost", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['Sale']['shipping_cost'])));
                                                        ?>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-sm-2 control-label">
                                                    <label>Biaya Pengiriman</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <?php
                                                        echo $this->Form->input("Dummy.shipping_cost", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "disabled", "value" => ac_dollar($this->data['Sale']['shipping_cost'])));
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSale.payment_type", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSale.payment_type", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['PaymentType']['name']));
                                            ?>
                                            <?php
                                            if ($this->data['Sale']['Buyer']['buyer_type_id'] == 1) {
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
                                                        echo $this->Form->input("Dummy.amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right isdecimal", "disabled", "value" => ic_rupiah($this->data['PaymentSale']['amount'])));
                                                        ?>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col-sm-2 control-label">
                                                    <label>Jumlah Pembayaran</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button">$</button>
                                                        </span>
                                                        <?php
                                                        echo $this->Form->input("Dummy.amount", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "disabled", "value" => ac_dollar($this->data['PaymentSale']['amount'])));
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSale.initial_balance", __("Kas"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSale.initial_balance", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['InitialBalance']['GeneralEntryType']['name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("PaymentSale.payment_date", __("Tanggal Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSale.payment_date", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control datepicker", "type" => "text", "disabled"));
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
                                            <?= $this->data["PaymentSale"]["note"] ?>
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
                                            echo $this->Form->label("Dummy.company_name", __("Nama Perusahaan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['company_name']));
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
                                            if (!empty($this->data['Sale']['Buyer']['city_id'])) {
                                                echo $this->Form->input("Dummy.company_city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['City']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.company_city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.company_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['Sale']['Buyer']['state_id'])) {
                                                echo $this->Form->input("Dummy.company_state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['State']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.company_state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => "-"));
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
                                            if (!empty($this->data['Sale']['Buyer']['country_id'])) {
                                                echo $this->Form->input("Dummy.company_country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCountry", "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['Country']['name']));
                                            } else {
                                                echo $this->Form->input("Dummy.company_country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly", "value" => "-"));
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
                                            if (!empty($this->data['Sale']['Buyer']['cp_city_id'])) {
                                                echo $this->Form->input("Buyer.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpCity']['name']));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
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
                                            if (!empty($this->data['Sale']['Buyer']['cp_state_id'])) {
                                                echo $this->Form->input("Buyer.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpState']['name']));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                            <?php
                                            echo $this->Form->label("Buyer.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            if (!empty($this->data['Sale']['Buyer']['cp_country_id'])) {
                                                echo $this->Form->input("Buyer.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => $this->data['Sale']['Buyer']['CpCountry']['name']));
                                            } else {
                                                echo $this->Form->input("Buyer.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly", "value" => "-"));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div class="tab-pane fade" id="justified-pill4">
                        <?php
                        if ($this->data['Sale']['Buyer']['buyer_type_id'] == 1) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive stn-table pre-scrollable">
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th width="250"><?= __("Produk") ?></th>
                                                    <th width = "150"><?= __("Kode Produk") ?></th>
                                                    <th width = "150" colspan="2"><?= __("Isi Per Mc") ?></th>
                                                    <th width = "150" colspan="2"><?= __("Total Berat") ?></th>
                                                    <th width = "230" colspan="2"><?= __("Harga Produk (Rp / Kg)") ?></th>
                                                    <th width = "230" colspan="2"><?= __("Total") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-installment">
                                                <?php
                                                $subTotal = 0;
                                                foreach ($this->data["Sale"]['SaleDetail'] as $k => $item) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <?= $item["Product"]['Parent']["name"] ?> - <?= $item["Product"]["name"] ?>
                                                        </td> 
                                                        <td class="text-center">
                                                            <?= $item["Product"]['code'] ?>
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;"> 
                                                            <?= $item["McWeight"]['lbs'] ?>
                                                        </td>  
                                                        <td class = "text-left" style= "width:50px !important; border-left-style:none;">
                                                            Lbs
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;"> 
                                                            <?= $item['nett_weight'] ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px !important; border-left-style:none;">
                                                            Kg
                                                        </td>  
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td> 
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ic_rupiah($item["price"]) ?>
                                                        </td>   
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>   
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ic_rupiah($item["nett_weight"] * $item['price']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $subTotal += $item["nett_weight"] * $item['price'];
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                if ($this->data['Sale']['shipment_payment_type_id'] == 1) {
                                                    ?>
                                                    <tr>
                                                        <td colspan = "9" align = "right">
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
                                                } else {
                                                    ?> 
                                                    <tr id="sub_total">
                                                        <td colspan="9" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right auto-calculate-sub-total" style="border-left-style:none;">
                                                        </td>
                                                    </tr>
                                                    <tr id="shipping_cost">
                                                        <td colspan="9" align="right">
                                                            <strong>Biaya Pengiriman</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right shipping_cost" style="border-left-style:none;">
                                                        </td>
                                                    </tr> 
                                                    <?php
                                                    $grandTotal = $subTotal + $this->data['Sale']['shipping_cost'];
                                                    ?>
                                                    <tr>
                                                        <td colspan="9" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp.
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive stn-table pre-scrollable">
                                        <table width="100%" class="table table-hover table-bordered">                        
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th width="250"><?= __("Produk") ?></th>
                                                    <th width="150"><?= __("Kode Produk") ?></th>
                                                    <th width="150" colspan="2"><?= __("Jumlah Produk (MC)") ?></th>
                                                    <th width="200" colspan="2"><?= __("Isi Per Mc") ?></th>
                                                    <th width="150" colspan="2"><?= __("Jumlah (Lbs)") ?></th>
                                                    <th width="150" colspan="2"><?= __("Total Berat") ?></th>
                                                    <th width="200" colspan="2"><?= __("Harga Produk ($ / Lbs)") ?></th>
                                                    <th width="200" colspan="2"><?= __("Total") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="target-installment"><?php
                                                $subTotal = 0;
                                                foreach ($this->data["Sale"]['SaleDetail'] as $k => $item) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <?= $item["Product"]['Parent']["name"] ?> - <?= $item["Product"]["name"] ?>
                                                        </td> 
                                                        <td class="text-center">
                                                            <?= $item["Product"]['code'] ?>
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;">   
                                                            <?= ic_decimalseperator($item["quantity"]) ?>
                                                        </td>
                                                        <td class = "text-left" style= "width:50px !important; border-left-style:none;">
                                                            Pcs
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;">   
                                                            <?= $item["McWeight"]['lbs'] ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px !important; border-left-style:none;">
                                                            Lbs
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;">   
                                                            <?= ic_decimalseperator($item["McWeight"]['lbs'] * $item["quantity"]) ?>
                                                        </td> 
                                                        <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                            Lbs
                                                        </td> 
                                                        <td class="text-right" style="border-right-style:none;">   
                                                            <?= ic_kg($item['nett_weight']) ?>
                                                        </td>   
                                                        <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                            Kg
                                                        </td>   
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>  
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ac_dollar($item["price"]) ?>
                                                        </td>   
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>     
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ac_dollar($item["McWeight"]['lbs'] * $item["quantity"] * $item['price']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $subTotal += $item["McWeight"]['lbs'] * $item["quantity"] * $item['price'];
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <?php
                                                if ($this->data['Sale']['shipment_payment_type_id'] == 1) {
                                                    ?>
                                                    <tr>
                                                        <td colspan = "13" align = "right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ac_dollar($subTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?> 
                                                    <tr id="sub_total">
                                                        <td colspan="13" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class = "text-right" style="border-left-style:none;">
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
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ac_dollar($this->data['Sale']['shipping_cost']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $grandTotal = $subTotal + $this->data['Sale']['shipping_cost'];
                                                    ?>
                                                    <tr>
                                                        <td colspan="13" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class = "text-right" style="border-left-style:none;">
                                                            <?= ac_dollar($grandTotal) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>                                
        </div>                                
    </div>                                
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>