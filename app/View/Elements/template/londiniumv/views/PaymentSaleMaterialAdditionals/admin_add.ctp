<?php echo $this->Form->create("PaymentSaleMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM INVOICE PENJUALAN LOKAL") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Invoice Penjualan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pembeli</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person Pembeli</a></li>
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
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
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
                                                <input type="text" class="form-control" readonly name="nomor kwitansi" value = "AUTO GENERATE">
                                            </div> 
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.material_additional_sale_id", __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.material_additional_sale_id", array("div" => false, "label" => false, "type" => "hidden", "value" => 0, "id" => "materialAdditionalSaleId"));
                                            ?>
                                            <div class="col-sm-4 has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nomor Penjualan Material Pembantu ..." class="form-control typeahead-ajax-transaction">
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
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoice" name="data[PaymentSaleMaterialAdditional][total_invoice_amount]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
                                                    </span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2 control-label">
                                                <label>Sisa Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoiceLeft" name="data[PaymentSaleMaterialAdditional][remaining]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
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
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.payment_type_id", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.payment_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Tipe Pembayaran -", "empty" => ""));
                                            ?>
                                            <div class="col-sm-2 control-label label-required">
                                                <label>Jumlah</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[PaymentSaleMaterialAdditional][amount]" required="required">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
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
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.initial_balance_id", __("Kas Tujuan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.initial_balance_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "data-placeholder" => "- Pilih Kas -", "empty" => ""));
                                            ?>
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.payment_date", __("Tanggal Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.payment_date", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control datepicker", "type" => "text", "value" => date("Y-m-d")));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.note", array("div" => array("class" => "col-sm-10"), "label" => false, "id" => "user1", "class" => "ckeditor-fix", "placeholder" => "Enter text ..."));
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
                                            <?php
                                            echo $this->Form->label("Dummy.supplier_name", __("Nama Pembeli"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.supplier_name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly"));
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
                                                <th width = "200" colspan="2"><?= __("Quantity") ?></th>
                                                <th width = "250" colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th width = "250" colspan="2"><?= __("Total") ?></th>
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
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
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
        var sale = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('no_sale'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/material_additional_sales/list_hutang", true) ?>' + '?q=%QUERY',
            remote: {
                url: '<?= Router::url("/admin/material_additional_sales/list_hutang", true) ?>' + '?q=%QUERY',
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
            display: 'no_sale',
            source: sale.ttAdapter(),
            templates: {
                header: '<center><h5>Data Penjualan Material Pembantu</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Invoice : ' + context.no_sale + '<br>Total Tagihan : Rp. ' + ic_rupiah(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Penjualan Material Pembantu</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#materialAdditionalSaleId').val(suggestion.id);
            var invoice = suggestion.total_invoice;
            $('#invoice').val(ic_rupiah(invoice));
            totalInvoice = suggestion.total_invoice;
            $('#PaymentSaleMaterialAdditionalSupplierId').val(suggestion.supplier_id);
            $('#buyerName').val(suggestion.supplier_name);
            $('#contactPerson').val(suggestion.contact_person);
            $('#companyPhone').val(suggestion.company_phone);
            $('#companyHp').val(suggestion.company_hp);
            $('#companyEmail').val(suggestion.company_email);
            $('#companyAddress').val(suggestion.company_address);
            $('#companyCity').val(suggestion.company_city);
            $('#companyState').val(suggestion.company_state);
            $('#companyCountry').val(suggestion.company_country);

            //data cp buyer
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
            viewDetailProduk(suggestion.id);
        });
    });
    function viewDetailProduk(material_additional_sale_id) {
        $.ajax({
            url: BASE_URL + "admin/material_additional_sales/get_data_material_additional_sale/" + material_additional_sale_id,
            dataType: "JSON",
            type: "GET",
            data: {},
            success: function (data) {
                $("#tmpl-installment").html();
                var grand_total = 0;
                if (data != null && data != '') {
                    var i = 1;
                    var template = $("#tmpl-installment").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(data.data.MaterialAdditionalSaleDetail, function (index, item) {
                        var options = {
                            i: i,
                            name: item.MaterialAdditional.name + " " + item.MaterialAdditional.size,
                            quantity: ic_kg(item.quantity),
                            unit: item.MaterialAdditional.MaterialAdditionalUnit.uniq,
                            price: ic_rupiah(item.price),
                            total: ic_rupiah(item.quantity * item.price)
                        };
                        grand_total += item.quantity * item.price;
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
                        i++;
                    });
                    $('.auto-calculate-grand-total').text(ic_rupiah(grand_total));
                }
            }
        })
    }

    function updateInvoiceRemain(invoiceId, materialAdditionalSaleId, totalAmount, remainingAmount) {
        var result = 0;
        if (invoiceId != 0 && invoiceId != null) {
            $.ajax({
                url: BASE_URL + "/admin/payment_sale_material_additionals/get_data_invoice/" + materialAdditionalSaleId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    if (data != null && data != '') {
                        remainingAmount = data.PaymentSaleMaterialAdditional.remaining;
                        $("#invoiceLeft").val(ic_rupiah(remainingAmount));
                    } else {
                        result = totalAmount - remainingAmount;
                        $("#invoiceLeft").val(ic_rupiah(result));
                    }
                }
            });
        } else {
            $("#invoiceLeft").val(ic_rupiah(totalInvoice));
        }
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td>
    {{name}}
    </td>      
    <td class = "text-right">
    {{quantity}}
    </td>
    <td class="text-right" style= "width:50px; border-left-style:none;">
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
    {{total}}
    </td>   
    </tr>
</script>