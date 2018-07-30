<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/general_entry_type");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA KODE AKUN BUKU BESAR") ?>
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
                            <th width="150"><?= __("Kode") ?></th>
                            <th><?= __("Uraian") ?></th>
                            <th width="200"><?= __("Klasifikasi") ?></th>
                            <th colspan="2"><?= __("Saldo Awal") ?></th>
                            <th colspan="2"><?= __("Saldo Akhir") ?></th>
                            <th width="100"><?= __("Mata Uang") ?></th>
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
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["GeneralEntryType"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["GeneralEntryType"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= emptyToStrip($item['GeneralEntryType']['code']) ?></td>
                                    <td class="text-left"><?php echo $item["GeneralEntryType"]['name']; ?></td>
                                    <td class="text-left"><?= emptyToStrip($item['Parent']['name']) ?></td>
                                    <?php
                                    if (!empty($item['Currency']['uniq_name'])) {
                                        if ($item['Currency']['uniq_name'] == "Rp") {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['GeneralEntryType']['initial_balance']) ?> </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $item['GeneralEntryType']['initial_balance'] ?> </td>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <td colspan="2" class="text-center">-</td>
                                        <?php
                                    }
                                    if (!empty($item['Currency']['uniq_name'])) {
                                        if ($item['Currency']['uniq_name'] == "Rp") {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['GeneralEntryType']['latest_balance']) ?> </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="text-center" style = "border-right-style:none !important" width = "50">$ </td>
                                            <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['GeneralEntryType']['latest_balance']) ?> </td>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <td colspan="2" class="text-center">-</td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-center"><?= emptyToStrip($item['Currency']['name']) ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-kodeakun-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/edit", ["editUrl" => Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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
    <div class="modal-dialog modal-lg-6">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA KODE AKUN BUKU BESAR
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("GeneralEntryType.code", __("Kode"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GeneralEntryType.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("GeneralEntryType.name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GeneralEntryType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("GeneralEntryType.parent", __("Parent"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GeneralEntryType.parent", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("GeneralEntryType.currency", __("Mata Uang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("GeneralEntryType.currency", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "currency"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-md-4 control-label">
                                            <label>Saldo Awal</label>
                                        </div>
                                        <div class="col-sm-9 col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">Rp.</button>
                                                    <button class="btn btn-default dollar" type="button">$</button>
                                                </span>
                                                <input type="text" label="false" class="form-control text-right" disabled id="initialBalance">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default rupiah" type="button">,00.</button>
                                                </span>
                                            </div>
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
            var kodeAkunId = $(this).data("kodeakun-id");
            $.ajax({
                url: BASE_URL + "general_entry_types/view_general_entry_types/" + kodeAkunId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#GeneralEntryTypeCode").val(data.GeneralEntryType.code);
                    $("#GeneralEntryTypeName").val(data.GeneralEntryType.name);
                    $("#GeneralEntryTypeParent").val(data.Parent.name);
                    if (data.GeneralEntryType.currency_id == 1) {
                        $(".rupiah").show();
                        $(".dollar").hide();
                    } else {
                        $(".rupiah").hide();
                        $(".dollar").show();
                    }
                    $("#initialBalance").val(IDR(data.GeneralEntryType.initial_balance));
                    $("#currency").val(data.GeneralEntryType.currency_id);
                }
            })
        });
    });
</script>