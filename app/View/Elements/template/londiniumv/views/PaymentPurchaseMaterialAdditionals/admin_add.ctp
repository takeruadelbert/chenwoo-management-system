<?php echo $this->Form->create("PaymentPurchaseMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM TRANSAKSI PEMBELIAN MATERIAL PEMBANTU") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Transaksi Pembelian Material Pembantu</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Supplier Material Pembantu</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person Supplier</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-remove"></i> Data Material Pembantu</a></li>
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
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
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
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.purchase_order_material_additional_id", __("Nomor PO Material Pembantu"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.purchase_order_material_additional_id", array("div" => false, "label" => false, "type" => "hidden", "value" => 0));
                                            ?>
                                            <div class="col-sm-4 has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nomor PO Material Pembantu ..." class="form-control typeahead-ajax-po-material-additional">
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
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoice" name="data[PaymentPurchaseMaterialAdditional][total_amount]">
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
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoiceLeft" name="data[PaymentPurchaseMaterialAdditional][remaining]">
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
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.payment_type_id", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.payment_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Pembayaran -", "empty" => ""));
                                            ?>
                                            <div class="col-sm-2 control-label">
                                                <label>Jumlah Pembayaran</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[PaymentPurchaseMaterialAdditional][amount]">
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
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.initial_balance_id", __("Kas"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.initial_balance_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Kas -", "empty" => ""));
                                            ?>
                                            <?php
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.payment_date", __("Tanggal Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.payment_date", array("div" => array("class" => "col-sm-4"), "label" => false,"type"=>"text", "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentPurchaseMaterialAdditional.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentPurchaseMaterialAdditional.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
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
                                                <input type="text" class="form-control" id="supplier" name="data[MaterialAdditionalSupplier][name]" readonly>
                                            </div>
                                            <?php
                                            echo $this->Form->label("Dummy.email_supplier", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.email_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "email", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.address_supplier", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.address_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "address", "readonly"));
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
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.postal_supplier", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.postal_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "postal_supplier", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.phone_number_supplier", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.phone_number_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "id" => "phone_number_supplier", "readonly"));
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
                                                <th><?= __("Nama Material Pembantu") ?></th>
                                                <th width = "250" colspan="2"><?= __("Jumlah") ?></th>
                                                <th width = "250" colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th width = "250" colspan="2"><?= __("Sub Total") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <tr id="init">
                                                <td class = "text-center" colspan = 8>Tidak Ada Data</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" align="right">Biaya Pengiriman</td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right" id = "shipmentCost" style="border-left-style:none;">
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
    var totalAmount = 0;
    $(document).ready(function () {
        var po_material_additional = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('po_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/purchase_order_material_additionals/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        po_material_additional.clearPrefetchCache();
        po_material_additional.initialize(true);
        $('input.typeahead-ajax-po-material-additional').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'po_material_additional',
            display: 'po_number',
            source: po_material_additional.ttAdapter(),
            templates: {
                header: '<center><h5>Data PO Material Pembantu</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Transaksi : ' + context.po_number + '<br>Total Tagihan : ' + RP(context.total) + '<br>Sisa Tagihan : ' + RP(context.remaining) + '<br>Nama Supplier : ' + context.supplier_name + '</p>';
                },
                empty: [
                    '<center><h5>Data PO Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-po-material-additional').bind('typeahead:select', function (ev, suggestion) {
            $('#PaymentPurchaseMaterialAdditionalPurchaseOrderMaterialAdditionalId').val(suggestion.id);
            $('#invoice').val(ic_rupiah(suggestion.total));
            totalAmount = ic_rupiah(suggestion.total);
            $('#supplier').val(suggestion.supplier_name);
            $('#email').val(suggestion.email_supplier);
            $('#address').val(suggestion.address_supplier);
            $('#city_supplier').val(suggestion.city_supplier);
            $('#state_supplier').val(suggestion.state_supplier);
            $('#country_supplier').val(suggestion.country_supplier);
            $('#postal_supplier').val(suggestion.postal_supplier);
            $('#phone_number_supplier').val(suggestion.phone_number_supplier);

            $("#SupplierCpName").val(suggestion.cp_name);
            $("#SupplierCpPosition").val(suggestion.cp_position);
            $("#SupplierCpEmail").val(suggestion.cp_email);
            $("#SupplierCpAddress").val(suggestion.cp_address);
            $("#SupplierCpPhoneNumber").val(suggestion.cp_phone_number);
            $("#SupplierCpCity").val(suggestion.cp_city);
            $("#SupplierCpState").val(suggestion.cp_state);
            $("#SupplierCpCountry").val(suggestion.cp_country);

            updateInvoiceRemain(suggestion.invoice_id, suggestion.id, suggestion.total, suggestion.remaining);
            $("#target-installment").empty();
            viewDetailMaterial(suggestion.id);
        });

        /* Update the remaining invoice amount */
        function updateInvoiceRemain(purchaseId, po_id, totalAmount, remainingAmount) {
            var result = 0;
            if (purchaseId != 0 && purchaseId != null) {
                $.ajax({
                    url: BASE_URL + "payment_purchase_material_additionals/get_data_payment_purchase/" + po_id,
                    type: "GET",
                    dataType: "JSON",
                    data: {},
                    success: function (data) {
                        if (data != null && data != '') {
                            remainingAmount = data.PaymentPurchaseMaterialAdditional.remaining;
                            $("#invoiceLeft").val(ic_rupiah(remainingAmount));
                        } else {
                            result = totalAmount - remainingAmount;
                            $("#invoiceLeft").val(ic_rupiah(result));
                        }
                    }
                });
            } else {
                $("#invoiceLeft").val(ic_rupiah(totalAmount));
            }
        }

        function viewDetailMaterial(poId) {
            var total = 0;
            $.ajax({
                url: BASE_URL + "purchase_order_material_additional_details/view_detail_material_additional/" + poId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    $("#tmpl-installment").html();
                    if (data != null && data != '') {
                        var i = 1;
                        var template = $("#tmpl-installment").html();
                        var shipment_cost = 0;
                        Mustache.parse(template);
                        $("table tr#init").remove();
                        $.each(data, function (index, item) {
                            var options = {
                                i: i,
                                material_name: item.MaterialAdditional.full_label,
                                unit: item.MaterialAdditional.MaterialAdditionalUnit.uniq,
                                quantity: ic_kg(item.PurchaseOrderMaterialAdditionalDetail.quantity),
                                price: ic_rupiah(item.PurchaseOrderMaterialAdditionalDetail.price),
                                prices: ic_rupiah(item.PurchaseOrderMaterialAdditionalDetail.price * item.PurchaseOrderMaterialAdditionalDetail.quantity),
                            };
                            shipment_cost = item.PurchaseOrderMaterialAdditional.shipment_cost;
                            total += item.PurchaseOrderMaterialAdditionalDetail.price * item.PurchaseOrderMaterialAdditionalDetail.quantity;
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                            i++;
                        });
                        total += parseInt(shipment_cost);
                        $("#shipmentCost").text(ic_rupiah(shipment_cost));
                        $('.auto-calculate-grand-total').text(ic_rupiah(total));
                    }
                }
            })
        }
    });
</script>

<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-left">
    {{material_name}}
    </td> 
    <td class="text-right" style="border-right-style:none;">
    {{quantity}}
    </td> 
    <td class = "text-left" style= "width:50px; border-left-style:none;">
    {{unit}}
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