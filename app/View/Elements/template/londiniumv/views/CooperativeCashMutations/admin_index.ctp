<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-cash-mutation");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA MUTASI KAS KOPERASI") ?>
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
                            <th><?= __("Nomor Mutasi") ?></th>
                            <th><?= __("Dari") ?></th>
                            <th><?= __("Tujuan") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th><?= __("Pegawai Pelaksana") ?></th>
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
                                <td class = "text-center" colspan = "10">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CooperativeCashMutation']['id_number'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeCashTransfered']['name'] ?></td>
                                    <td class="text-left"><?= $item['CooperativeCashReceived']['name'] ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCashMutation']['nominal']) ?></td>
                                    <td class="text-left"><?= $this->Html->cvtWaktu($item['CooperativeCashMutation']['transfer_date']) ?></td>
                                    <td class="text-left"><?= $item['Creator']['Account']['Biodata']['full_name'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-init-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
                <h4 class="modal-title">DATA MUTASI KAS KOPERASI - <span class="nomor_mutasi"></span></h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">DATA MUTASI KAS KOPERASI
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Pegawai") ?></h6>
                                </div>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("Dummy.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("Dummy.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    echo $this->Form->label("Dummy.departemen", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("Dummy.departemen", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("Dummy.office", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                        <input type="text" class="form-control" id="transferedCash" disabled>
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
                                                    <?php
                                                    echo $this->Form->label("CooperativeCashMutation.id_number", __("Nomor Mutasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashMutation.id_number", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control nomor_mutasi", "readonly"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-sm-3 col-md-4 control-label label-required">
                                                        <label>Nominal</label>
                                                    </div>
                                                    <div class="col-sm-9 col-md-8">
                                                        <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">Rp.</button>
                                                            </span>
                                                            <input type="text" class="form-control text-right" disabled id="nominal">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button">,00.</button>
                                                            </span>
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
                                                    echo $this->Form->label("CooperativeCashMutation.transfer_date", __("Tanggal Mutasi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeCashMutation.transfer_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "readonly", "id" => "date"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div id="note" style="padding:0 15px">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
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
                url: BASE_URL + "cooperative_cash_mutations/view_cash_mutation/" + initId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#DummyNip").val(data.Creator.nip);
                    $("#DummyName").val(data.Creator.Account.Biodata.full_name);
                    $("#DummyDepartemen").val(data.Creator.Department.name);
                    $("#DummyOffice").val(data.Creator.Office.name);
                    $("#transferedCash").val(data.CooperativeCashTransfered.name);
                    $("#DummyAccount").val(data.CooperativeCashTransfered.CooperativeBankAccount.code);
                    $("#DummyOnBehalf").val(data.CooperativeCashTransfered.CooperativeBankAccount.on_behalf);
                    $("#DummyBank").val(data.CooperativeCashTransfered.CooperativeBankAccount.BankAccountType.name);
                    $("#receivedCash").val(data.CooperativeCashReceived.name);
                    $(".nomor_mutasi").val(data.CooperativeCashMutation.id_number);
                    if (data.CooperativeCashReceived.cooperative_bank_account_id == null) {
                        var temp = "-";
                        $("#DummyAccount2").val(temp);
                        $("#DummyOnBehalf2").val(temp);
                        $("#DummyBank2").val(temp);
                    } else {
                        $("#DummyAccount2").val(data.CooperativeCashReceived.CooperativeBankAccount.code);
                        $("#DummyOnBehalf2").val(data.CooperativeCashReceived.CooperativeBankAccount.on_behalf);
                        $("#DummyBank2").val(data.CooperativeCashReceived.CooperativeBankAccount.BankAccountType.name);
                    }

                    $("#date").val(cvtWaktu(data.CooperativeCashMutation.transfer_date));
                    $("#note").val(data.CooperativeCashMutation.note);
                    $("#nominal").val(IDR(data.CooperativeCashMutation.nominal));
                }
            })
        });
    });
</script>