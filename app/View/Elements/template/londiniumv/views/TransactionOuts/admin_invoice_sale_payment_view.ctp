<?php echo $this->Form->create("TransactionOut", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("INVOICE PENJUALAN") ?>
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Invoice Penjualan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Buyer</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Data Shipment</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-file6"></i> Data Produk</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSale.transaction_out_id", __("Nomor Invoice"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSale.transaction_out_id", array("div" => false, "label" => false, "type" => "hidden", "value" => 0));
                                            ?>
                                            <div class="col-sm-4 has-feedback">
                                                <input type="text" placeholder="Silahkan Cari Nomor Invoice ..." class="form-control typeahead-ajax-transaction">
                                                <i class="icon-search3 form-control-feedback"></i>
                                            </div>
                                            <div class="col-sm-2 control-label">
                                                <label>Total Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp.</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right isdecimal" readonly id="invoice" name="data[PaymentSale][total_invoice_amount]">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00.</button>
                                                    </span>
                                                </div>
                                            </div> 
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
                                            echo $this->Form->label("Shipment.Buyer.company_name", __("Nama Perusahaan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.contact_person", __("Contact Person"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.contact_person", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "contactPerson", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.phone_number", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPhone", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.handphone_number", __("No. Handphone"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.handphone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyHp", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.email", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyEmail", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.address", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyAddress", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Shipment.Buyer.country", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Shipment.Buyer.country", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly"));
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
                                            echo $this->Form->label("ShipmentAgent.name", __("Nama Shipment"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ShipmentAgent.name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "shipmentName", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Container.container_number", __("Nomor Container"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Container.container_number", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "containerNumber", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ShipmentAgent.phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ShipmentAgent.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "shipmentPhone", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("ShipmentAgent.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ShipmentAgent.address", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "shipmentAddress", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ShipmentAgent.city", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ShipmentAgent.city", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "shipmentCity", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("ShipmentAgent.state", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ShipmentAgent.state", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "shipmentState", "class" => "form-control", "readonly"));
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
                                                <th><?= __("Nama Produk") ?></th>
                                                <th><?= __("Produk Size") ?></th>
                                                <th><?= __("Kode Produk") ?></th>
                                                <th><?= __("Jumlah") ?></th>
                                                <th><?= __("Harga Satuan") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <?php
                                            $no = 1;
                                            foreach ($this->data["TransactionMaterialOut"] as $i => $value) {
                                                foreach ($value["Package"]["PackageDetail"] as $k => $values) {
//                                                    debug($values['ProductData']['ProductSize']['Product']['name']);
                                                    ?>
                                                    <tr class="dynamic-row">
                                                        <td class="text-center nomorIdx"><?= $no; ?></td>
                                                        <td class = "text-center">
                                                            <?= $values['ProductData']['ProductSize']['Product']['name'] ?>
                                                        </td>
                                                        <td class = "text-center">
                                                            <?= $values['ProductData']['ProductSize']['name'] ?>
                                                        </td>
                                                        <td class = "text-center">
                                                            <?= $values['ProductData']['ProductSize']['code'] ?>
                                                        </td>
                                                        <td class = "text-center">
                                                            <?= $values['ProductData']['ProductSize']['quantity'] ?>
                                                        </td class = "text-center">
                                                        <td class = "text-center">
                                                            <?= $this->Html->IDR($values['ProductData']['ProductSize']['price']) ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
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
            <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        var transaction = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('invoice_number'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/transaction_outs/list_hutang", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/transaction_outs/list_hutang", true) ?>' + '?q=%QUERY',
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
            display: 'invoice_number',
            source: transaction.ttAdapter(),
            templates: {
                header: '<center><h5>Data Transaksi</h5></center><hr>',
                suggestion: function (context) {
                    return '<p>Nomor Invoice : ' + context.invoice_number + '<br>Total Tagihan : ' + RP(context.total_invoice) + '</p>';
                },
                empty: [
                    '<center><h5>Data Transaksi</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-transaction').bind('typeahead:select', function (ev, suggestion) {
            $('#PaymentSaleTransactionOutId').val(suggestion.id);
            $('#invoice').val(IDR(suggestion.total_invoice));
            $('#PaymentSaleBuyerId').val(suggestion.buyer_id);
            $('#buyerName').val(suggestion.company_name);
            $('#contactPerson').val(suggestion.contact_person);
            $('#companyPhone').val(suggestion.company_phone);
            $('#companyHp').val(suggestion.company_hp);
            $('#companyEmail').val(suggestion.company_email);
            $('#companyAddress').val(suggestion.company_address);
            $('#companyCity').val(suggestion.company_city);
            $('#companyState').val(suggestion.company_state);
            $('#shipmentName').val(suggestion.shipment_name);
            $('#containerNumber').val(suggestion.container_number);
            $('#shipmentPhone').val(suggestion.shipment_phone);
            $('#shipmentAddress').val(suggestion.shipment_address);
            $('#shipmentCity').val(suggestion.shipment_city);
            $('#shipmentState').val(suggestion.shipment_state);

            updateInvoiceRemain(suggestion.invoice_id, suggestion.id, suggestion.total_invoice, suggestion.remaining_invoice);
            console.log(suggestion);
            $("#target-installment").empty();
            viewDetailProduk(suggestion.id);
        });
    });

    function viewDetailProduk(transactionOutId) {
        $.ajax({
            url: BASE_URL + "transaction_material_outs/view_detail_items/" + transactionOutId,
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
                        $.each(item["Package"]["PackageDetail"], function (index, items) {
                            var options = {
                                i: i,
                                product_name: items["ProductData"]["ProductSize"]["Product"]["name"],
                                product_size: items["ProductData"]["ProductSize"]["name"],
                                product_code: items["ProductData"]["ProductSize"]["code"],
                                price: RP(items["ProductData"]["ProductSize"]["price"]),
                                quantity: items["ProductData"]["ProductSize"]["quantity"],
                            };
                            var rendered = Mustache.render(template, options);
                            $('#target-installment').append(rendered);
                        })
                        i++;
                    });
                }
            }
        })
    }

    function updateInvoiceRemain(invoiceId, transactionId, totalAmount, remainingAmount) {
        var result = 0;
        if (invoiceId != 0 && invoiceId != null) {
            console.log("aa");
            $.ajax({
                url: BASE_URL + "payment_sales/get_data_invoice/" + transactionId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    if (data != null && data != '') {
                        remainingAmount = data.PaymentSale.remaining;
                        $("#invoiceLeft").val(IDR(remainingAmount));
                    } else {
                        result = totalAmount - remainingAmount;
                        $("#invoiceLeft").val(IDR(result));
                    }
                }
            });
        } else {
            console.log("bbb");
            $("#invoiceLeft").val("-");
        }
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-installment">
    <tr>
    <td class="text-center">{{i}}</td>
    <td class="text-center">{{product_name}} - {{product_size}}</td> 
    <td class="text-center">{{product_code}}</td> 
    <td class="text-center">{{quantity}}</td>       
    <td class="text-center">{{price}}</td>
    </tr>
</script>