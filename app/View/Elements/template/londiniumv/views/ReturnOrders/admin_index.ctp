<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/return_order");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Pengembalian Barang Ke Gudang") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Pengembalian") ?></th>
                            <th><?= __("Nomor Nota Timbang") ?></th>
                            <th><?= __("Status Pengembalian") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th><?= __("Penanggung Jawab") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ReturnOrder"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["ReturnOrder"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['ReturnOrder']['return_number']; ?></td>
                                    <td class="text-center"><?php echo $item['MaterialEntry']['material_entry_number']; ?></td>
                                    <td class="text-center"><?php echo $item['ReturnOrderStatus']['name']; ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item['ReturnOrder']['created']); ?></td>
                                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                                        <?php
                                    }
                                    ?>         
                                    <td class="text-center">
                                        <a data-toggle="modal" data-return-id="<?= $item["ReturnOrder"]['id'] ?>" role="button" href="#default-lihatReturnOrder" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
<div id="default-lihatReturnOrder" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA PENGEMBALIAN IKAN 
                            <small class="display-block">PT. Chenwoo Fishery Makassar</small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover" id="packageList">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("ReturnOrder.return_number", __("Nomor Pengembalian"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("ReturnOrder.return_number", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("ReturnOrder.employee", __("Penanggung Jawab"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("ReturnOrder.employee", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Pengembalian") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nomor Nota Timbang</th>
                                    <th>Material</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-transaction">
                                <tr class="dynamic-row-conversion hidden" data-n="0">
                                </tr>
                                <tr>
                                    <td colspan="5" align="right">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" class="form-control text-right" id="GrandTotal" name="data[ReturnOrder][total]" readonly>
                                            <span class="input-group-addon">,00</span>
                                        </div>
                                    </td>
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
    var grandTotal = 0;
    $(document).ready(function () {
        $(".viewData").click(function () {
            $("tr.transaction-material-data").html("");
            var returnId = $(this).data("return-id");
            var e = $("tr.dynamic-row-conversion");
            $.ajax({
                url: BASE_URL + "admin/return_orders/view_data_return_order/" + returnId,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    var data = response.data;
                    $("#ReturnOrderReturnNumber").val(data.ReturnOrder.return_number);
                    $("#ReturnOrderEmployee").val(data.Employee.Account.Biodata.first_name + " " + data.Employee.Account.Biodata.last_name);
                    var i = 1;
                    if (data.ReturnOrderDetail > 0) { //if whole return konversion
                        var emp = data.ReturnOrderDetail;
                        $.each(emp, function (index, value) {
                            $.each(value.Conversion.MaterialEntry.TransactionEntry.TransactionMaterialEntry, function (index, detail) {
                                var no = value.Conversion.MaterialEntry.material_entry_number;
                                var name = detail.MaterialDetail.Material.name + " " + detail.MaterialDetail.name;
                                var weight = detail.weight + " " + detail.MaterialDetail.Unit.uniq;
                                var price = detail.price;
                                var total = parseFloat(weight) * parseInt(price);
                                grandTotal += parseInt(total);
                                var n = e.data("n");
                                var template = $('#tmpl-material-data').html();
                                Mustache.parse(template);
                                var options = {i: i, n: n, no: no, name: name, weight: weight, price: ic_rupiah(price), total: ic_rupiah(total)};
                                i++;
                                var rendered = Mustache.render(template, options);
                                $('#target-detail-transaction tr.dynamic-row-conversion:last').before(rendered);
                                e.data("n", n + 1);
                            });
                        });
                        $("#GrandTotal").val(IDR(grandTotal));
                    }else{
                        var emp = data.MaterialEntry.TransactionEntry.TransactionMaterialEntry;
                        $.each(emp, function (index, detail) {
                            //$.each(value.MaterialEntry.TransactionEntry.TransactionMaterialEntry, function (index, detail) {
                                console.log(detail);
                                var no =data.MaterialEntry.material_entry_number;
                                var name = detail.MaterialDetail.Material.name + " " + detail.MaterialDetail.name;
                                var weight = detail.weight + " " + detail.MaterialDetail.Unit.uniq;
                                var price = detail.price;
                                var total = parseFloat(weight) * parseInt(price);
                                grandTotal += parseInt(total);
                                var n = e.data("n");
                                var template = $('#tmpl-material-data').html();
                                Mustache.parse(template);
                                var options = {i: i, n: n, no: no, name: name, weight: weight, price: ic_rupiah(price), total: ic_rupiah(total)};
                                i++;
                                var rendered = Mustache.render(template, options);
                                $('#target-detail-transaction tr.dynamic-row-conversion:last').before(rendered);
                                e.data("n", n + 1);
                            //});
                        });
                        $("#GrandTotal").val(IDR(grandTotal));
                    }

                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row transaction-material-data">
    <td class="text-center nomorIdx">{{i}}</td>
    <td class="text-center">
    <input class='form-control' id='ConversionDataMaterialDetailId' value="{{no}}">
    </td> 
    <td>
    <input class='form-control' id='ConversionDataMaterialSizeId' value="{{name}}">
    </td>
    <td><input type='text' class='form-control TotalMaterial' value="{{weight}}"/></td><td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input class='form-control addon-field text-right' value="{{price}}" disabled>
    <span class="input-group-addon">,00</span>
    </div>
    </td><td class="text-center">
    <div class="input-group">
    <span class="input-group-addon">Rp.</span>
    <input class='form-control addon-field text-right' value="{{total}}" disabled>
    <span class="input-group-addon">,00</span>
    </div>
    </td>          
    </tr>
</script>

