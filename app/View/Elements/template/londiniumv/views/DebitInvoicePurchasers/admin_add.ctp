<?php echo $this->Form->create("DebitInvoicePurchaser", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Penerimaan Kembalian") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="well block" style = "margin-bottom:5px">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Penerimaan Kembalian</a></li>
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
                                                            <div class="has-feedback">
                                                                <input type="text" placeholder="Silahkan Cari Nomor Transaksi ..." class="form-control typeahead-ajax-transaction">
                                                                <input type="hidden" name="data[DebitInvoicePurchaser][transaction_entry_id]" id="transactionId">
                                                                <i class="icon-search3 form-control-feedback"></i>
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
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <?php
                                                        echo $this->Form->label("DebitInvoicePurchaser.initial_balance_id", __("Tipe Kas"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("DebitInvoicePurchaser.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Kas -", "empty" => ""));
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
                                                                <input type="text" class="form-control text-right isdecimal" name="data[DebitInvoicePurchaser][amount]">
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
                                                <div class="form-actions text-center">
                                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                                    <input type="reset" value="Reset" class="btn btn-info">
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                                        <?= __("Simpan") ?>
                                                    </button>
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
                                                        <input type="text" class="form-control" id="supplier" name="data[Supplier][name]" readonly>
                                                    </div>
                                                    <?php
                                                    echo $this->Form->label("Dummy.supplier_type", __("Tipe Supplier"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.supplier_type", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "supplierType", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.email_supplier", __("Email"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.email_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.address_supplier", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.address_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "address", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.postal_supplier", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.postal_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "postal_supplier", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.phone_supplier", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.phone_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_supplier", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "website", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.city_supplier", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.state_supplier", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Dummy.country_supplier", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country", "readonly"));
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
                                                    echo $this->Form->input("Supplier.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_city", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_state", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Supplier.cp_country", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Supplier.cp_country", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
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
                                                <tbody id="target-installment">
                                                    <tr id="init">
                                                        <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                                                    </tr>
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
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('transaction_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_entries/list_lunas", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_entries/list_lunas", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        transaction.clearPrefetchCache();
        transaction.initialize(true);
        $('input.typeahead-ajax-transaction').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'transaction',
            display: 'transaction_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Transaksi : ' + context.transaction_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#transactionId').val(suggestion.id);

            $('#supplier').val(suggestion.supplier_name);
            $('#supplierType').val(suggestion.supplier_type);
            $('#email').val(suggestion.email_supplier);
            $('#address').val(suggestion.address_supplier);
            $('#postal_supplier').val(suggestion.postal_supplier);
            $('#phone_supplier').val(suggestion.phone_number_supplier);
            $('#website').val(suggestion.website);
            $('#city').val(suggestion.city_supplier);
            $('#state').val(suggestion.state_supplier);
            $('#country').val(suggestion.country_supplier);

            $("#SupplierCpName").val(suggestion.cp_name);
            $("#SupplierCpPosition").val(suggestion.cp_position);
            $("#SupplierCpEmail").val(suggestion.cp_email);
            $("#SupplierCpAddress").val(suggestion.cp_address);
            $("#SupplierCpPhoneNumber").val(suggestion.cp_phone_number);
            $("#SupplierCpCity").val(suggestion.cp_city);
            $("#SupplierCpState").val(suggestion.cp_state);
            $("#SupplierCpCountry").val(suggestion.cp_country);

            var totalTagihan = suggestion.total_invoice;
            $('#totalTagihanLocal').val(ic_rupiah(totalTagihan));
            var remaining = Math.abs(suggestion.remaining);
            var totalPembayaran = parseInt(totalTagihan) + parseInt(remaining);
            $('#totalPembayaranLocal').val(ic_rupiah(totalPembayaran));
            $('#sisaPembayaranLocal').val(ic_rupiah(remaining));

            viewDetailMaterial(suggestion.id);
        });
    });
    function viewDetailMaterial(transactionEntryId) {
        var total = 0;
        var shippingCost = 0;
        var grandTotal = 0;
        $.ajax({
            url: BASE_URL + "transaction_material_entries/view_detail_materials/" + transactionEntryId,
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
                            material_name: item.MaterialDetail.name,
                            material_size: item.MaterialSize.name,
                            weight: ic_kg(item.TransactionMaterialEntry.weight),
                            price: ic_rupiah(item.TransactionMaterialEntry.price),
                            prices: ic_rupiah(item.TransactionMaterialEntry.price * item.TransactionMaterialEntry.weight),
                        };
                        total += item.TransactionMaterialEntry.price * item.TransactionMaterialEntry.weight;
                        $('#subTotal').text(ic_rupiah(total));
                        shippingCost = item.TransactionEntry.shipping_cost;
                        $('#shippingCost').text(ic_rupiah(shippingCost));
                        grandTotal = parseInt(item.TransactionEntry.shipping_cost) + parseInt(total);
                        $('.auto-calculate-grand-total').text(ic_rupiah(grandTotal));
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
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
    <td class="text-left">
    {{material_name}} - {{material_size}}
    </td>
    <td class="text-right" style="border-right-style:none;">
    {{weight}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    Kg
    </td>   
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    Rp.
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{price}}
    </td>   
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    Rp.
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{prices}}
    </td>  
    </tr>
</script>