<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_additional_entry");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Masukan Material Pembantu") ?>
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
                </div>
                <small class="display-block"></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Barang Masuk") ?></th>
                            <th><?= __("Nomor PO") ?></th>
                            <th><?= __("Penanggung Jawab") ?></th>
                            <th><?= __("Pemasok") ?></th>
                            <th><?= __("Tanggal Barang Masuk") ?></th>
                            
                            <th width="50"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialAdditionalEntry"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialAdditionalEntry"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item["MaterialAdditionalEntry"]['no_entry']; ?></td>
                                    <td class="text-center"><?php echo $item["PurchaseOrderMaterialAdditional"]['po_number']; ?></td>
                                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <td class="text-center"><?php echo emptyToStrip($item['PurchaseOrderMaterialAdditional']['MaterialAdditionalSupplier']['name']); ?></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggal($item['MaterialAdditionalEntry']['created']); ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-material-entry-id="<?= $item["MaterialAdditionalEntry"]['id'] ?>" role="button" href="#default-lihatMaterialAdditionalEntry" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
<div id="default-lihatMaterialAdditionalEntry" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA MASUK MATERIAL PEMBANTU 
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
                                        echo $this->Form->label("MaterialAdditionalEntry.no_entry", __("Nomor Barang Masuk"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialAdditionalEntry.no_entry", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialAdditionalEntry.material_additional_supplier_id", __("Pemasok"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialAdditionalEntry.material_additional_supplier_id", array("div" => array("class" => "col-sm-3 col-md-3"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialAdditionalEntry.employee_id", __("Penanggung Jawab"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialAdditionalEntry.employee_id", array("div" => array("class" => "col-sm-3 col-md-3"),"type"=>"text", "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                        <?php
                                        echo $this->Form->label("MaterialAdditionalEntry.created", __("Tanggal Dibuat"), array("class" => "col-sm-3 col-md-3 control-label"));
                                        echo $this->Form->input("MaterialAdditionalEntry.created", array("div" => array("class" => "col-sm-3 col-md-3"),"type"=>"text", "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="block-inner text-danger">
                            <h3>Data Barang Masuk</h3>
                        </div>
                        <table width="100%" class="table table-hover table-bordered stn-table">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Material Pembantu</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="target-detail-entry">
                                <tr class="dynamic-row-entry hidden" data-n="0">
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
            $("tr.material-additional").html("");
            var materialEntryId = $(this).data("material-entry-id");
            var e = $("tr.dynamic-row-entry");
            $.ajax({
                url: BASE_URL + "admin/material_additional_entries/view_data_material_additional_entry/" + materialEntryId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#MaterialAdditionalEntryNoEntry").val(data.MaterialAdditionalEntry.no_entry);
                    $("#MaterialAdditionalEntryEmployeeId").val(data.Employee.Account.Biodata.first_name+" "+data.Employee.Account.Biodata.last_name);
                    $("#MaterialAdditionalEntryCreated").val(data.MaterialAdditionalEntry.created);
                    var emp = data.MaterialAdditionalEntryDetail;
                    var i = 1;
                    $.each(emp, function (index, value) {
                        var product = value.MaterialAdditional.name;
                        var quantity = value.quantity_entry+" "+value.MaterialAdditional.MaterialAdditionalUnit.uniq;
                        var n = e.data("n");
                        var template = $('#tmpl-treatment-material').html();
                        Mustache.parse(template);
                        var options = {i: i, n: n, product: product, quantity: quantity};
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('.dynamic-row-entry').before(rendered);
                        e.data("n", n + 1);
                    });
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-treatment-material">
    <tr class="dynamic-row material-additional">
        <td class="text-center nomorIdx">{{i}}</td>
        <td class="text-center">
            <input class='form-control' value="{{product}}" disabled>
        </td> 
        <td class="text-center">
            <input class='form-control' value="{{quantity}}" disabled>
        </td>       
    </tr>
</script>