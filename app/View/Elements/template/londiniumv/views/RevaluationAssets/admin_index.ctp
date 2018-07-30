<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/revaluation-asset");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Penyusutan Aset") ?>
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
                            <th width="300"><?= __("Nama Aset") ?></th>
                            <th colspan="2"><?= __("Nominal Sebelum Revaluasi") ?></th>
                            <th colspan="2"><?= __("Nominal Setelah Revaluasi") ?></th>
                            <th width="200"><?= __("Tanggal Revaluasi") ?></th>
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
                                <td class = "text-center" colspan = 9>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["RevaluationAsset"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["RevaluationAsset"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item["AssetProperty"]['GeneralEntryType']['name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->RpWithRemoveCent($item['RevaluationAsset']['previous_nominal']) ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->RpWithRemoveCent($item['RevaluationAsset']['revaluation_nominal']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['RevaluationAsset']['revaluation_date']) ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-asset-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihattipebuyer" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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

<div id="default-lihattipebuyer" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA ASSET
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("Dummy.asset", __("Nama Aset"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("Dummy.asset", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control asset", "disabled"));
                                        ?>
                                        <div class="col-md-2 control-label">
                                            <label>Nominal Aset</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                                </span>
                                                <input type="text" label="false" class="form-control text-right previousNominal" readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="col-md-2 control-label">
                                            <label>Nominal Revaluasi Aset</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                                </span>
                                                <input type="text" label="false" class="form-control text-right revaluationNominal" disabled>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </div>
                                        <?php
                                        echo $this->Form->label("RevaluationAsset.revaluation_date", __("Tanggal Revaluasi Aset"), array("class" => "col-md-2 control-label"));
                                        echo $this->Form->input("RevaluationAsset.revaluation_date", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
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
            var buyerTypeId = $(this).data("asset-id");
            $.ajax({
                url: BASE_URL + "admin/revaluation_assets/view_revaluation_asset/" + buyerTypeId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $(".asset").val(data.AssetProperty.name);
                    $(".previousNominal").val(IDR(data.RevaluationAsset.previous_nominal));
                    $(".revaluationNominal").val(IDR(data.RevaluationAsset.revaluation_nominal));
                    $("#RevaluationAssetRevaluationDate").val(cvtTanggal(data.RevaluationAsset.revaluation_date));
                }
            });
        });
    });
</script>
