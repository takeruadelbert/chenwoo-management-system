<?php echo $this->Form->create("PaymentPurchase", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM TRANSAKSI PEMBELIAN") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Transaksi Pembelian</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Supplier</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person Supplier</a></li>
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
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                            echo $this->Form->input("PaymentPurchase.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
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
                                            <div class="col-sm-2 control-label">
                                                <label>Nomor Kwitansi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" readonly name="nomor invoice" value = "AUTO GENERATE">
                                            </div> 
                                            <?php
                                            echo $this->Form->label("PaymentPurchase.transaction_entry_id", __("Nomor Timbang / Transaksi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchase.transaction_entry_id", array("div" => false, "label" => false, "type" => "hidden", "value" => 0));
                                            ?>
                                            <div class="col-sm-4 has-feedback">
                                                <input type="text" placeholder="Cari Nomor Timbang / Transaksi..." class="form-control typeahead-ajax-transaction">
                                                <i class="icon-search3 form-control-feedback"></i>
                                            </div>
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
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoice" name="data[PaymentPurchase][total_invoice_amount]">
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
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoiceLeft" name="data[PaymentPurchase][remaining]">
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
                                            echo $this->Form->label("PaymentPurchase.payment_type_id", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchase.payment_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Pembayaran -", "empty" => ""));
                                            ?>
                                            <div class="col-sm-2 control-label">
                                                <label>Jumlah Pembayaran</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[PaymentPurchase][amount]">
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
                                            echo $this->Form->label("PaymentPurchase.initial_balance_id", __("Kas"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchase.initial_balance_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Kas -", "empty" => ""));
                                            ?>
                                            <?php
                                            echo $this->Form->label("PaymentPurchase.payment_date", __("Tanggal Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchase.payment_date", array("div" => array("class" => "col-sm-4"), "label" => false,"type"=>"text", "class" => "form-control datepicker", 'value' => date("Y-m-d")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentPurchase.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchase.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
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
                                            echo $this->Form->label("Dummy.phone_number_supplier", __("HP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.phone_number_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_number_supplier", "readonly"));
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
                                            echo $this->Form->input("Dummy.city_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "city_supplier", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.state_supplier", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.state_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "state_supplier", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.country_supplier", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.country_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "country_supplier", "readonly"));
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
                    <div class="tab-pane fade" id="justified-pill3">
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
                                                <td class="text-right" id="subTotal" style="border-left-style:none;">
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right auto-calculate-grand-total" id="grandTotal" style="border-left-style:none;">
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
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="reset" value="Reset" class="btn btn-info">
            <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                <?= __("Simpan") ?>
            </button>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var totalInvoice = 0;
    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('transaction_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_entries/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_entries/list", true) ?>' + '?q=%QUERY',
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
                    return '<p>Nomor Transaksi : ' + context.transaction_number + '<br>Nomor Nota Timbang : ' + context.material_entry_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '<br>Nama Supplier : ' + context.supplier_name + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            console.log(suggestion);
            $('#PaymentPurchaseTransactionEntryId').val(suggestion.id);
            $('#invoice').val(ic_rupiah(suggestion.total_invoice));
            totalInvoice = ic_rupiah(suggestion.total_invoice);
            $('#supplier').val(suggestion.supplier_name);
            $('#supplierType').val(suggestion.supplier_type);
            $('#email').val(suggestion.email_supplier);
            $('#address').val(suggestion.address_supplier);
            $('#city_supplier').val(suggestion.city_supplier);
            $('#state_supplier').val(suggestion.state_supplier);
            $('#country_supplier').val(suggestion.country_supplier);
            $('#postal_supplier').val(suggestion.postal_supplier);
            $('#website').val(suggestion.website);
            $('#phone_number_supplier').val(suggestion.phone_number_supplier);

            $("#SupplierCpName").val(suggestion.cp_name);
            $("#SupplierCpPosition").val(suggestion.cp_position);
            $("#SupplierCpEmail").val(suggestion.cp_email);
            $("#SupplierCpAddress").val(suggestion.cp_address);
            $("#SupplierCpPhoneNumber").val(suggestion.cp_phone_number);
            $("#SupplierCpCity").val(suggestion.cp_city);
            $("#SupplierCpState").val(suggestion.cp_state);
            $("#SupplierCpCountry").val(suggestion.cp_country);

            updateInvoiceRemain(suggestion.invoice_id, suggestion.id, suggestion.total_invoice, suggestion.remaining_invoice);
            $("#target-installment").empty();
            viewDetailMaterial(suggestion.id);
        });

        /* Update the remaining invoice amount */
        function updateInvoiceRemain(invoiceId, transactionId, totalAmount, remainingAmount) {
            var result = 0;
            if (invoiceId != 0 && invoiceId != null) {
                $.ajax({
                    url: BASE_URL + "payment_purchases/get_data_invoice/" + transactionId,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function (data) {
                        if (data != null && data != '') {
                            remainingAmount = data.PaymentPurchase.remaining;
                            $("#invoiceLeft").val(ic_rupiah(remainingAmount));
                        } else {
                            result = totalAmount - remainingAmount;
                            $("#invoiceLeft").val(ic_rupiah(result));
                        }
                    }
                });
            } else {
                $("#invoiceLeft").val(totalInvoice);
            }
        }

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
    });
</script>

<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td>
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
