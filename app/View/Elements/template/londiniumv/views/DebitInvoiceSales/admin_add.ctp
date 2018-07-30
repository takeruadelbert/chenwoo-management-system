<?php echo $this->Form->create("DebitInvoiceSale", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Penerimaan Kelebihan") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block" style = "margin-bottom:5px">
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
                                                            <div class="has-feedback">
                                                                <input type="text" placeholder="Silahkan Cari Nomor Penjualan Produk ..." class="form-control typeahead-ajax-transaction">
                                                                <input type="hidden" name="data[DebitInvoiceSale][sale_id]" id="saleId">
                                                                <input type="hidden" name="data[DebitInvoiceSale][buyer_type_id]" id="buyerTypeId">
                                                                <input type="hidden" name="data[DebitInvoiceSale][branch_office_id]" id="branchOfficeId">
                                                                <i class="icon-search3 form-control-feedback"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="totalTagihan">
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="totalPembayaran">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id = tagihan-local>
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="totalTagihanLocal">
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="totalPembayaranLocal">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="button">,00.</button>
                                                                </span>
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="sisaPembayaran">
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
                                                                <input type="text" class="form-control text-right isdecimal" readonly id="sisaPembayaranLocal">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="button">,00.</button>
                                                                </span>
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
                                                        echo $this->Form->input("DebitInvoiceSale.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "options" => $initialBalancesDollar, "id" => "initialBalanceExport", "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Kas -", "empty" => ""));
                                                        ?>
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
                                                                <input type="text" class="form-control text-right" name="data[DebitInvoiceSale][amount]" id = "amountExport">
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
                                                        echo $this->Form->input("DebitInvoiceSale.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "options" => $initialBalancesRupiah, "id" => "initialBalanceLocal", "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Kas -", "empty" => ""));
                                                        ?>
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
                                                                <input type="text" class="form-control text-right isdecimal" name="data[DebitInvoiceSale][amount]" id = "amountLocal">
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
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_name", __("Nama Perusahaan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_email", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyEmail", "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_address", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyAddress", "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPostalCode", "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_phone", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_phone", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPhone", "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_website", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyWebsite", "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.company_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.company_country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCountry", "class" => "form-control", "readonly"));
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
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="table-responsive stn-table">
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
                                                    <tr id="init">
                                                        <td class = "text-center" colspan = 15>Tidak Ada Data</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr id="sub_total">
                                                        <td colspan="13" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            $
                                                        </td>
                                                        <td class="text-right auto-calculate-sub-total" style="border-left-style:none;">
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
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
                                                    <tr id="init">
                                                        <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr id="sub_total-local">
                                                        <td colspan="9" align="right">
                                                            <strong>Sub Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp
                                                        </td>
                                                        <td class="text-right auto-calculate-sub-total" style="border-left-style:none;">
                                                        </td>
                                                    </tr>
                                                    <tr id="shipping_cost-local">
                                                        <td colspan="9" align="right">
                                                            <strong>Biaya Pengiriman</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp
                                                        </td>
                                                        <td class="text-right shipping_cost" style="border-left-style:none;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9" align="right">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                            Rp
                                                        </td>
                                                        <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
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
            <div class="form-actions text-center" style = "margin-bottom:15px">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $('.table-export').hide();
        $('.table-local').hide();
        $('#tagihan-export').hide();
        $('#tagihan-local').hide();
        $('#sisa-tagihan-export').hide();
        $('#sisa-tagihan-local').hide();
        $('#initial-balance').hide();
        $('#initial-balance-local').hide();
        $('#initialBalanceLocal').attr("disabled", "disabled");
        $('#initialBalanceExport').attr("disabled", "disabled");
        $('#amountLocal').attr("disabled", "disabled");
        $('#amountExport').attr("disabled", "disabled");
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('sale_no'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/sales/list_lunas", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/sales/list_lunas", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        sale.clearPrefetchCache();
        sale.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'sale',
            display: 'sale_no',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Penjualan Produk</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Penjualan Produk : ' + context.sale_no + '<br>Total Tagihan : ' + (context.grand_total) + '</p>';
                },
                empty: [
                    '<center><h5>Data Penjualan Produk</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#saleId').val(suggestion.id);
            $('#buyerTypeId').val(suggestion.buyer_type_id);
            $('#branchOfficeId').val(suggestion.branch_office_id);

            //data buyer
            $('#buyerName').val(suggestion.company_name);
            $('#companyPhone').val(suggestion.company_phone);
            $('#companyWebsite').val(suggestion.company_website);
            $('#companyEmail').val(suggestion.company_email);
            $('#companyAddress').val(suggestion.company_address);
            $('#companyPostalCode').val(suggestion.company_postal_code);
            $('#companyCity').val(suggestion.company_city);
            $('#companyState').val(suggestion.company_state);
            $('#companyCountry').val(suggestion.company_country);

            //data cp buyer
            $("#BuyerCpName").val(suggestion.cp_name);
            $("#BuyerCpPosition").val(suggestion.cp_position);
            $("#BuyerCpEmail").val(suggestion.cp_email);
            $("#BuyerCpAddress").val(suggestion.cp_address);
            $("#BuyerCpPhoneNumber").val(suggestion.cp_phone_number);
            $("#BuyerCpCity").val(suggestion.cp_city);
            $("#BuyerCpState").val(suggestion.cp_state);
            $("#BuyerCpCountry").val(suggestion.cp_country);

            $('#initial-balance').show();
            if (suggestion.buyer_type_id == 2) {
                $('#initialBalanceLocal').attr("disabled", "disabled");
                $('#initialBalanceExport').removeAttr("disabled");
                $('#amountLocal').attr("disabled", "disabled");
                $('#amountExport').removeAttr("disabled");
                $('.table-export').show();
                $('.table-local').hide();
                $('#tagihan-export').show();
                $('#tagihan-local').hide();
                $('#sisa-tagihan-export').show();
                $('#sisa-tagihan-local').hide();
                $('#initial-balance').show();
                $('#initial-balance-local').hide();
                $("#target-installment").empty();
                var totalTagihan = suggestion.grand_total;
                $('#totalTagihan').val(ac_dollar(totalTagihan));
                var remaining = Math.abs(suggestion.remaining);
                var totalPembayaran = parseFloat(totalTagihan) + parseFloat(remaining);
                $('#totalPembayaran').val(ac_dollar(totalPembayaran));
                $('#sisaPembayaran').val(ac_dollar(remaining));
                viewDetailProdukEksport(suggestion.id);
            } else {
                $('#initialBalanceExport').attr("disabled", "disabled");
                $('#initialBalanceLocal').removeAttr("disabled");
                $('#amountExport').attr("disabled", "disabled");
                $('#amountLocal').removeAttr("disabled");
                $('.table-export').hide();
                $('.table-local').show();
                $('#tagihan-export').hide();
                $('#tagihan-local').show();
                $('#sisa-tagihan-export').hide();
                $('#sisa-tagihan-local').show();
                $('#initial-balance').hide();
                $('#initial-balance-local').show();
                $("#target-installment-local").empty();
                var totalTagihan = suggestion.grand_total;
                $('#totalTagihanLocal').val(ic_rupiah(totalTagihan));
                var remaining = Math.abs(suggestion.remaining);
                var totalPembayaran = parseInt(totalTagihan) + parseInt(remaining);
                $('#totalPembayaranLocal').val(ic_rupiah(totalPembayaran));
                $('#sisaPembayaranLocal').val(ic_rupiah(remaining));
                viewDetailProdukLocal(suggestion.id);
            }

        });
    });

    function viewDetailProdukEksport(saleId) {
        var total = 0;
        $.ajax({
            url: BASE_URL + "sale_details/view_detail_products/" + saleId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                $("#tmpl-installment").html();
                if (data != null && data != '') {
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(data, function (index, item) {
                        var options = {
                            i: i,
                            product_name: item["Product"]["Parent"]["name"] + " - " + item["Product"]["name"],
                            product_code: item["Product"]["code"],
                            quantity: ic_rupiah(item["SaleDetail"]["quantity"]),
                            mc_weight: item["McWeight"]["lbs"],
                            total_lbs: ic_rupiah(item["SaleDetail"]["quantity"] * item["McWeight"]["lbs"]),
                            weight: ic_kg(item["SaleDetail"]["nett_weight"]),
                            price: ac_dollar(item["SaleDetail"]["price"]),
                            prices: ac_dollar(item["SaleDetail"]["price"] * item["SaleDetail"]["quantity"] * item["McWeight"]["lbs"]),
                        };
                        if (data[0]["Sale"]["shipment_payment_type_id"] == 1) {
                            $("#sub_total").hide();
                            $("#shipping_cost").hide();
                            total += item["SaleDetail"]["price"] * item["SaleDetail"]["quantity"] * item["McWeight"]["lbs"];
                            $('.auto-calculate-grand-total').text(ac_dollar(total));
                        } else {
                            $("#sub_total").show();
                            total += item["SaleDetail"]["price"] * item["SaleDetail"]["quantity"] * item["McWeight"]["lbs"];
                            $('.auto-calculate-sub-total').text(ac_dollar(total));
                            $("#shipping_cost").show();
                            $(".shipping_cost").text(ac_dollar(data[0]["Sale"]["shipping_cost"]));
                            var grandTotal = parseFloat(total) + parseFloat(data[0]["Sale"]["shipping_cost"]);
                            $('.auto-calculate-grand-total').text(ac_dollar(grandTotal));
                        }
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
                        i++;
                    });
                }
            }
        })
    }
    function viewDetailProdukLocal(saleId) {
        var total = 0;
        $.ajax({
            url: BASE_URL + "sale_details/view_detail_products/" + saleId,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                $("#shipping_cost-local").hide();
                $("#sub_total-local").hide();
                $("#tmpl-installment-local").html();
                if (data != null && data != '') {
                    var i = 1;
                    var template = $("#tmpl-installment-local").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(data, function (index, item) {
                        var price = item["SaleDetail"]["price"];
                        var prices = (item["SaleDetail"]["price"] * item["SaleDetail"]["nett_weight"]);
                        var options = {
                            i: i,
                            product_name: item["Product"]["Parent"]["name"] + " - " + item["Product"]["name"],
                            product_code: item["Product"]["code"],
                            price: ic_rupiah(price),
                            quantity: ic_kg(item["SaleDetail"]["nett_weight"]),
                            mc_weight: item["McWeight"]["lbs"],
                            prices: ic_rupiah(prices),
                        };
                        if (data[0]["Sale"]["shipment_payment_type_id"] == 1) {
                            $("#shipping_cost-local").hide();
                            $("#sub_total-local").hide();
                            total += item["SaleDetail"]["price"] * item["SaleDetail"]["nett_weight"];
                            $('.auto-calculate-grand-total').text(ic_rupiah(total));
                        } else {
                            total += item["SaleDetail"]["price"] * item["SaleDetail"]["nett_weight"];
                            $('.auto-calculate-sub-total').text(ic_rupiah(total));
                            $("#shipping_cost-local").show();
                            $(".shipping_cost").text(ic_rupiah(data[0]["Sale"]["shipping_cost"]));
                            $("#sub_total-local").show();
                            var grandTotal = parseInt(total) + parseInt(data[0]["Sale"]["shipping_cost"]);
                            $('.auto-calculate-grand-total').text(ic_rupiah(grandTotal));
                        }
                        var rendered = Mustache.render(template, options);
                        $('#target-installment-local').append(rendered);
                        i++;
                    });
                }
            }
        })
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td>
    {{product_name}}
    </td> 
    <td class="text-center">
    {{product_code}}
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Pcs
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{mc_weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Lbs
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{total_lbs}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Lbs
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Kg
    </td>  
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    $
    </td>    
    <td class="text-right" style="border-left-style:none;">  
    {{price}}
    </td> 
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    $
    </td>  
    <td class="text-right" style="border-left-style:none;">  
    {{prices}}
    </td>     
    </tr>
</script>

<script type="x-tmpl-mustache" id="tmpl-installment-local">
    <tr>
    <td class="text-center">{{i}}</td>
    <td>
    {{product_name}}
    </td> 
    <td class = "text-center">
    {{product_code}}
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{mc_weight}}
    </td>
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Lbs
    </td> 
    <td class = "text-right" style= "border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">     
    Kg
    </td>  
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    Rp.
    </td>      
    <td class="text-right" style="border-left-style:none;">  
    {{price}}
    </td> 
    <td class = "text-center" style= "width:50px; border-right-style:none;">
    Rp.
    </td>   
    <td class="text-right" style="border-left-style:none;">  
    {{prices}}
    </td>   
    </tr>
</script>