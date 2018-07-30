<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/debt-list");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA HUTANG USAHA") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("debt_list/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("debt_list/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor Transaksi") ?></th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Nama Supplier") ?></th>
                            <th><?= __("Tanggal Nota Timbang") ?></th>
                            <th colspan = "2"><?= __("Total Hutang") ?></th>
                            <th colspan = "2"><?= __("Sisa Hutang") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center">                               
                                        <a data-toggle="modal" data-transentry-id="<?= $item["TransactionEntry"]['id'] ?>" role="button" href="#default-lihatTransactionEntry" class="tip viewData">
                                            <?= $item['TransactionEntry']['transaction_number'] ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= $item["MaterialEntry"]["material_entry_number"]?></td>
                                    <td class="text-center"><?= $item['Supplier']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['MaterialEntry']['weight_date']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['TransactionEntry']['total']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['TransactionEntry']['remaining']) ?></td>

                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>    
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>

<div id="default-lihatTransactionEntry" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA TRANSAKSI BARANG MASUK 
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="transactionList">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("TransactionEntry.transaction_number", __("Nomor Transaksi"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("TransactionEntry.transaction_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialEntry.material_entry_number", __("Nomor Nota Timbang"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("MaterialEntry.material_entry_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Supplier.supplier_name", __("Nama Supplier"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("Supplier.supplier_name", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialEntry.material_entry_date", __("Tanggal Nota Timbang"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("MaterialEntry.material_entry_date", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Dummy.pegawai", __("Nama Pegawai Pembuat Nota Timbang"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("Dummy.pegawai", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Nota Timbang") ?></h6>
                        </div>
                        <br/>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Material</th>
                                    <th>Grade</th>
                                    <th colspan="2">Harga Ikan</th>
                                    <th colspan="2">Berat Ikan</th>
                                    <th colspan="2">Total</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-transaction hidden" data-n="0">
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" align="right">
                                        <strong>Biaya Pengiriman</strong>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                        Rp.
                                    </td>
                                    <td class="text-right" id ="shippingCost" style="border-left-style:none;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                        Rp.
                                    </td>
                                    <td class="text-right" id ="GrandTotal" style="border-left-style:none;">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            var transactionId = $(this).data("transentry-id");
            var e = $("tr.dynamic-row-transaction");
            $.ajax({
                url: BASE_URL + "admin/transaction_entries/view_data_transaction_entry/" + transactionId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (request) {
                    var data = request.data;
                    $("#TransactionEntryTransactionNumber").val(empty_strip(data.TransactionEntry.transaction_number));
                    $("#MaterialEntryMaterialEntryNumber").val(data.MaterialEntry.material_entry_number);
                    $("#SupplierSupplierName").val(data.MaterialEntry.Supplier.name);
                    $("#MaterialEntryMaterialEntryDate").val(cvtWaktu(data.MaterialEntry.created));
                    $("#DummyPegawai").val(data.MaterialEntry.Employee.Account.Biodata.full_name);
                    var emp = data.TransactionMaterialEntry;
                    var shippingCost = data.TransactionEntry.shipping_cost;
                    var grandTotal = data.TransactionEntry.total;
                    var i = 1;
                    //console.log(data);
                    if (emp.length == 0) { //if transaction not exist
                        shippingCost = "";
                        grandTotal = "";
                        $.each(data.MaterialEntry.MaterialEntryGrade, function (index, value) {
                            var name = value.MaterialDetail.Material.name + " " + value.MaterialDetail.name;
                            var size = value.MaterialSize.name;
                            var price = "-";
                            var weight = value.weight;
                            var totalMaterialEntry = "-";
                            var n = e.data("n");
                            var template = $('#tmpl-material-data').html();
                            Mustache.parse(template);
                            var options = {
                                i: i,
                                n: n,
                                name: name,
                                size: size,
                                price: ic_rupiah(price),
                                weight: weight,
                                totalMaterialEntry: "-"
                            };
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction tr.dynamic-row-transaction:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    } else {
                        $.each(emp, function (index, value) {
                            var name = value.MaterialDetail.Material.name + " " + value.MaterialDetail.name;
                            var size = value.MaterialSize.name;
                            var price = value.price;
                            var weight = value.weight;
                            var totalMaterialEntry = price * weight;
                            var n = e.data("n");
                            var template = $('#tmpl-material-data').html();
                            Mustache.parse(template);
                            var options = {
                                i: i,
                                n: n,
                                name: name,
                                size: size,
                                price: ic_rupiah(price),
                                weight: ic_kg(weight),
                                totalMaterialEntry: ic_rupiah(totalMaterialEntry)
                            };
                            i++;
                            var rendered = Mustache.render(template, options);
                            $('#target-detail-transaction tr.dynamic-row-transaction:last').before(rendered);
                            e.data("n", n + 1);
                        });
                    }

                    if (request.data.TransactionEntryFile.length > 0) {
                        var nomor = 1;
                        $.each(request.data.TransactionEntryFile, function (i, value) {
                            var fileName = value.AssetFile.filename;
                            var token = value.AssetFile.token;
                            var fileId = value.AssetFile.id;
                            var template2 = $("#tmpl-upload-dokumen").html();
                            Mustache.parse(template2);
                            var options = {
                                index: nomor,
                                token: token,
                                fileName: fileName,
                                href: BASE_URL + "admin/asset_files/getfile/" + fileId + "/" + token
                            };
                            var rendered = Mustache.render(template2, options);
                            $("#target-upload-dokumen").append(rendered);
                            nomor++;
                        });
                    } else {
                        var template = $("#tmpl-upload-dokumen-nodata").html();
                        Mustache.parse(template);
                        var options = {};
                        var rendered = Mustache.render(template, options);
                        $("#target-upload-dokumen").append(rendered);
                    }
                    if (shippingCost != null && grandTotal != null) {
                        $("#shippingCost").text(ic_rupiah(shippingCost));
                        $("#GrandTotal").text(ic_rupiah(grandTotal));
                    }
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class='dynamic-row transaction-material-data'>
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    {{name}}
    </td>
    <td class="text-center">
    {{size}}
    </td>
    <td class="text-center" style= "width:50px; border-right-style:none;">           
    Rp.
    </td>    
    <td class = "text-right" style="border-left-style:none;">
    {{price}}
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
    {{totalMaterialEntry}}
    </td> 
    </tr>
</script>
