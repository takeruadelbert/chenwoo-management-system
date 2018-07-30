<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cash-mutation");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA MUTASI KAS") ?>
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
                            <th><?= __("Dari") ?></th>
                            <th><?= __("Tujuan") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th><?= __("Nama Pegawai") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Keterangan") ?></th>
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
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CashTransfered']['GeneralEntryType']['name'] ?></td>
                                    <td class="text-left"><?= $item['CashReceived']['GeneralEntryType']['name'] ?></td>
                                    <?php
                                    if ($item['CashMutation']['currency_id'] == 1) {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ic_rupiah($item['CashMutation']['nominal']) ?></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center" style = "border-right-style:none !important" width = "50">$</td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= ac_dollar($item['CashMutation']['nominal']) ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center"><?= $this->Html->cvtWaktu($item['CashMutation']['transfer_date']) ?></td>
                                    <td class="text-center"><?= $item['CashMutation']['note'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-init-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <!--<a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>-->
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
                        <h6 class="heading-hr">DATA MUTASI KAS
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kas Koperasi") ?></h6>
                            </div>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Kas Kirim</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <input type="text" class="form-control" disabled id="transferedCash">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Kas Terima</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">                                                
                                                    <input type="text" class="form-control" id="receivedCash" disabled>
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
                                                echo $this->Form->label("Dummy.account", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.account", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.account2", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.account2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Dummy.on_behalf", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.on_behalf", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.on_behalf2", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.on_behalf2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Dummy.bank", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.bank", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.bank2", __("Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Dummy.bank2", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>                        
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Mutasi Kas") ?></h6>
                            </div>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Nominal</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" id="currency">Rp.</button>
                                                        </span>
                                                        <input type="text" label="false" class="form-control text-right" disabled id="nominal">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" id="cent">,00.</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CashMutation.transfer_date", __("Tanggal Mutasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CashMutation.transfer_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "date"));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("CashMutation.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                        ?>
                                        <div id ="CashMutationNote" style = "padding-top:10px !important;padding-left:165px !important;">
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
            var initId = $(this).data("init-id");
            $.ajax({
                url: BASE_URL + "cash_mutations/view_cash_mutation/" + initId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
//                    console.log(data);
                    $("#transferedCash").val(data.CashTransfered.GeneralEntryType.name);
                    $("#DummyAccount").val(data.CashTransfered.BankAccount.code);
                    $("#DummyOnBehalf").val(data.CashTransfered.BankAccount.on_behalf);
                    $("#DummyBank").val(data.CashTransfered.BankAccount.BankAccountType.name);
                    $("#receivedCash").val(data.CashReceived.GeneralEntryType.name);
                    $("#DummyAccount2").val(data.CashReceived.BankAccount.code);
                    $("#DummyOnBehalf2").val(data.CashReceived.BankAccount.on_behalf);
                    $("#DummyBank2").val(data.CashReceived.BankAccount.BankAccountType.name);
                    $("#date").val(cvtWaktu(data.CashMutation.transfer_date));
                    $('#CashMutationNote').html(data.CashMutation.note);
                    if (data.CashMutation.currency_id == 1) {
                        $("#currency").text("Rp.");
                        $("#cent").show();
                    } else {
                        $("#currency").text("$");
                        $("#cent").hide();
                    }
                    $("#nominal").val(IDR(data.CashMutation.nominal));
                }
            })
        });
    });
</script>