<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/material-additional-sale");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("VALIDASI PENJUALAN MATERIAL PEMBANTU") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
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
                            <th><?= __("Nomor Penjualan Material Pembantu") ?></th>
                            <th><?= __("Nama Pembeli") ?></th>
                            <th colspan = "2"><?= __("total") ?></th>
                            <th><?= __("Penanggung Jawab") ?></th>
                            <th><?= __("Tanggal Penjualan") ?></th>
                            <th><?= __("Status") ?></th>
                            <th width="100"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 10>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["MaterialAdditionalSale"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["MaterialAdditionalSale"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?php echo $item["MaterialAdditionalSale"]['no_sale']; ?></td>
                                    <td class='text-center'><?= $item['Supplier']['name'] ?></td>
                                    <td class="text-left" style = "border-left-style: none !important;" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-right-style: none !important;"><?php echo ic_rupiah($item["MaterialAdditionalSale"]['total']); ?></td>
                                    <td class="text-center"><?php echo $item['Employee']['Account']['Biodata']['full_name']; ?></td>
                                    <td class="text-center"><?php echo!empty($item['MaterialAdditionalSale']['sale_dt']) ? $this->Html->cvtTanggal($item['MaterialAdditionalSale']['sale_dt']) : "-"; ?></td>
                                    <td class="text-center" id="statusValidate<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><?= $item['ValidateStatus']['name'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data"><i class="icon-file"></i></button></a>
                                        <?php
                                        if ($item['MaterialAdditionalSale']['validate_status_id'] == 1) {
                                            ?>
                                            <a id="confirmbutton-<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" data-toggle="modal" role="button" href="#confirmation" class="btn btn-default btn-xs btn-icon btn-icon tip confirmSale" title="" data-original-title="Validasi Penjualan Material Pembantu" data-sale-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>"><i class="icon-checkmark3"></i></a>
                                            <?php
                                        }
                                        ?>
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

<!-- Material Additional Validation Confirmation -->
<div id="confirmation" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">KONFIRMASI VALIDASI PENJUALAN MATERIAL PEMBANTU
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <table width="100%" class="table table-hover">
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="form-group form-horizontal">
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.validate_status_id", __("Status Validasi"), array("class" => "col-sm-4 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.validate_status_id", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Status -", "id" => "validateStatus", "options" => $validateStatusWithoutFirstOptions));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal" id="closeForm">Tutup Form</button>
                    <button type="button" class="btn btn-success save" data-dismiss="modal">Simpan</button>
                </div>
            </div>
            <!-- /new invoice template -->
        </div>
    </div>
</div>
<!-- /Material Additional Validation Confirmation -->

<script>
    $(document).ready(function () {
        $(".cash").hide();
        var validateStatusId;
        $("#validateStatus").on("change", function () {
            validateStatusId = $(this).val();
        });

        $(".confirmSale").click(function () {
            var saleId = $(this).data("sale-id");
            $(".save").click(function () {
                $.ajax({
                    url: BASE_URL + "admin/material_additional_sales/change_status_validate/" + validateStatusId + "/" + saleId,
                    type: "PUT",
                    dataType: "JSON",
                    data: {},
                    beforeSend: function (xhr) {
                        ajaxLoadingStart();
                        $(".save").unbind("click");
                    },
                    success: function (response) {
                        if (response.status == 207) {
                            $("#statusValidate" + saleId).html(response.data.status_label);
                            $("#confirmbutton-" + saleId).remove();
                            notif("notice", response.message, 'growl');
                        } else {
                            notif("warning", response.message, "growl");
                        }
                        ajaxLoadingSuccess();
                    }
                });
            });
            $("#closeForm, #close").click(function () {
                $(".save").unbind("click");
            });
        });
    });
</script>