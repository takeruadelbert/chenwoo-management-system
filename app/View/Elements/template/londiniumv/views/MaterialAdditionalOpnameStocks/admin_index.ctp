<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material_additional-stock-opname");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA STOK OPNAME MATERIAL PEMBANTU") ?>
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
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
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
                            <th width="170"><?= __("Nomor Stok Opname") ?></th>
                            <th><?= __("Nama Material Pembantu") ?></th>
                            <th width="150" colspan = 2><?= __("Stok") ?></th>
                            <th width="150" colspan = 2><?= __("Selisih Stok") ?></th>
                            <th><?= __("Tanggal Stok Opname") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("NIK") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th width = "250"><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['MaterialAdditionalOpnameStock']['opname_stock_number'] ?></td>
                                    <td class="text-left"><?= $item['MaterialAdditional']['name']." ".$item['MaterialAdditional']['size'] ?></td>
                                    <td class="text-right" style ="border-right:none"><?= ic_kg($item['MaterialAdditionalOpnameStock']['stock_number']) ?></td>
                                    <td class="text-left" width = "30" style ="border-left:none"><?= $item['MaterialAdditional']['MaterialAdditionalUnit']['name'] ?></td>
                                    <td class="text-right" style ="border-right:none"><?= ic_kg($item['MaterialAdditionalOpnameStock']['stock_difference']) ?></td>
                                    <td class="text-left" width = "30" style ="border-left:none"><?= $item['MaterialAdditional']['MaterialAdditionalUnit']['name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['MaterialAdditionalOpnameStock']['opname_date']) ?></td>
                                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo emptyToStrip($item["BranchOffice"]['name']); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-type-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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

<div id="default-lihatdata" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA STOK OPNAME MATERIAL PEMBANTU
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.name", __("Nama Material Pembantu"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.category", __("Kategori Material Pembantu"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.category", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>                                
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.stock_number", __("Stok Sistem"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                ?>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <?php
                                                        echo $this->Form->input("Dummy.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "currentStock", "data-stock" => 0, "class" => "form-control text-right", "disabled", "id" => "sistem"));
                                                        ?>
                                                        <span class="input-group-addon" id = "unit">&nbsp</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalOpnameStock.stock_number", __("Stok Fisik"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                ?>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <?php
                                                        echo $this->Form->input("MaterialAdditionalOpnameStock.stock_number", array("div" => array("class" => ""), "label" => false, "id" => "physicStock", "type" => "text", "class" => "form-control text-right", "disabled", "id" => "fisik"));
                                                        ?>
                                                        <span class="input-group-addon" id = "unit1">&nbsp</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalOpnameStock.stock_difference", __("Selisih Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                ?>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <?php
                                                        echo $this->Form->input("MaterialAdditionalOpnameStock.stock_difference", array("div" => array("class" => ""), "type" => "text", "label" => false, "class" => "form-control text-right", "readonly", "id" => "differ"));
                                                        ?>
                                                        <span class="input-group-addon" id = "unit2">&nbsp</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("MaterialAdditionalOpnameStock.opname_date", __("Tanggal Stok Opname"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("MaterialAdditionalOpnameStock.opname_date", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "type" => "text", "class" => "form-control", "disabled", "id" => "date"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("MaterialAdditionalOpnameStock.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                        ?>
                                        <div id ="MaterialAdditionalOpnameStockNote" style = "padding-top:10px !important;padding-left:165px !important;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
            var typeId = $(this).data("type-id");
            $.ajax({
                url: BASE_URL + "material_additional_opname_stocks/view_data_opname_stock/" + typeId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#DummyName").val(data.MaterialAdditional.full_label);
                    $("#DummyCategory").val(data.MaterialAdditional.MaterialAdditionalCategory.name);
                    $("#fisik").val((ic_kg(data.MaterialAdditionalOpnameStock.stock_number)));
                    var stock_fisik = data.MaterialAdditionalOpnameStock.stock_number;
                    var selisih = (data.MaterialAdditionalOpnameStock.stock_difference);
                    $("#differ").val(ic_kg(selisih));
                    var stock_sistem = parseFloat(stock_fisik - selisih);
                    $("#sistem").val(ic_kg(stock_sistem));
                    $("#date").val(cvtWaktu(data.MaterialAdditionalOpnameStock.opname_date));
                    $('#MaterialAdditionalOpnameStockNote').html(data.MaterialAdditionalOpnameStock.note);
                    $("#unit").html(data.MaterialAdditional.MaterialAdditionalUnit.name);
                    $("#unit1").html(data.MaterialAdditional.MaterialAdditionalUnit.name);
                    $("#unit2").html(data.MaterialAdditional.MaterialAdditionalUnit.name);
                }
            })
        });
    });
</script>