<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/transaction_entry_index");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("UPLOAD DOKUMEN QC") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index_upload_document/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index_upload_document/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Transaksi") ?></th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Pembuat Nota Timbang") ?></th>
                            <th><?= __("Nama Kasir") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th><?= __("Supplier") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Status") ?></th>
                            <th><?= __("Status Dokumen QC") ?></th>
                            <th width = "75"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["TransactionEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["TransactionEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo emptyToStrip($item["TransactionEntry"]['transaction_number']); ?></td>
                                    <td class="text-center"><?php echo $item["MaterialEntry"]['material_entry_number']; ?></td>
                                    <td class="text-center"><?= $item['MaterialEntry']['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?php echo!empty($item['Employee']['id']) ? $item['Employee']['Account']['Biodata']['full_name'] : "-"; ?></td>
                                    <td class="text-center"><?php echo!empty($item['TransactionEntry']['created_date']) ? $this->Html->cvtTanggalWaktu($item["TransactionEntry"]['created_date']) : "-"; ?></td>
                                    <td class="text-center"><?php echo $item['Supplier']['name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= $item['TransactionEntryStatus']['name'] ?></td>
                                    <td class="text-center"><?= $item['DocumentStatus']['name'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item['TransactionEntry']['transaction_entry_status_id'] == 2) {
                                            ?>
                                            <a href="<?= Router::url("/admin/{$this->params['controller']}/upload_document/" . $item["TransactionEntry"]['id'], true) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Upload Dokumen QC"><i class = "icon-upload"></i></button></a>
                                            <?php
                                        }
                                        ?>
                                        <a data-toggle="modal" data-transentry-id="<?= $item["TransactionEntry"]['id'] ?>" role="button" href="#default-lihatTransactionEntry" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                    </td>         
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
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("TransactionEntry.transaction_number", __("Nomor Transaksi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("TransactionEntry.transaction_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialEntry.material_entry_number", __("Nomor Nota Timbang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("MaterialEntry.material_entry_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Supplier.supplier_name", __("Nama Supplier"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Supplier.supplier_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialEntry.material_entry_date", __("Tanggal Nota Timbang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("MaterialEntry.material_entry_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Dummy.pegawai", __("Nama Pegawai Pembuat Nota Timbang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Dummy.pegawai", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Dummy.kasir", __("Nama Kasir"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("Dummy.kasir", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Nota Timbang") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Material</th>
                                    <th>Size Material</th>
                                    <th>Berat Ikan</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-transaction hidden" data-n="0">
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Dokumen QC") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama File</th>
                                    <th width = "100">Download</th>
                                </tr>
                            <thead>
                            <tbody id="target-upload-dokumen">
                                <tr class="dynamic-row-transaction hidden" data-n="0">
                                </tr>
                            </tbody>
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
            $(".transaction-material-data").html("");
            $("tr#empty").html("");
            $("tr#uploadDokumen").html("");
            $("tr.dynamic-row-transaction").html("");
            var transactionId = $(this).data("transentry-id");
            var e = $("tr.dynamic-row-transaction");
            $.ajax({
                url: BASE_URL + "admin/transaction_entries/view_data_transaction_entry/" + transactionId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (request) {
                    var data = request.data;
                    $("#TransactionEntryTransactionNumber").val(data.TransactionEntry.transaction_number);
                    $("#MaterialEntryMaterialEntryNumber").val(data.MaterialEntry.material_entry_number);
                    $("#SupplierSupplierName").val(data.MaterialEntry.Supplier.name);
                    $("#MaterialEntryMaterialEntryDate").val(cvtTanggal(data.MaterialEntry.created));
                    $("#DummyPegawai").val(data.MaterialEntry.Employee.Account.Biodata.full_name);
                    $("#DummyKasir").val(data.Employee.Account.Biodata.full_name);
                    var emp = data.TransactionMaterialEntry;
                    var shippingCost = data.TransactionEntry.shipping_cost;
                    var grandTotal = data.TransactionEntry.total;
                    var i = 1;
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
                            price: IDR(price.replace(".00", "")),
                            weight: weight,
                            totalMaterialEntry: IDR(totalMaterialEntry)
                        };
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-detail-transaction').append(rendered);
                        e.data("n", n + 1);
                    });
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
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-upload-dokumen">
    <tr id="uploadDokumen">
    <td class="text-center">{{index}}</td>
    <td class="text-center"><input type="text" readonly class="form-control" value="{{fileName}}"></td>
    <td class="text-center">
    <a href="{{href}}"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Download Dokumen"><i class="icon-download"></i></button></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class='dynamic-row transaction-material-data'>
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <input name='data[TransactionMaterialEntry][{{n}}][material_detail_id]' class='form-control' id='TransactionEntry1MaterialId' value="{{name}}" readonly>
    </td>
    <td class="text-center">
    <input name='data[TransactionMaterialEntry][{{n}}][material_size_id]' class='form-control' id='TransactionEntry1MaterialSizeId' value="{{size}}" readonly>
    </td>
    <td class="text-center">
    <div class="input-group">
    <input type='input' name='data[TransactionMaterialEntry][{{n}}][weight]' class='form-control text-right isdecimal qtyIdx totalWeight{{n}}' id='TransactionMaterialEntry{{n}}Weight' value="{{weight}}" readonly/>
    <span class="input-group-addon">Kg</span>
    </div>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-upload-dokumen-nodata">
    <tr id="empty">
    <td class="text-center" colspan="3">Tidak Ada Data</td>
    </tr>
</script>