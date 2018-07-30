<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-cash");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA SALDO KOPERASI KAS") ?>
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
                            <th><?= __("Nama Kas") ?></th>
                            <th><?= __("Nomor Rekening") ?></th>
                            <th><?= __("Atas Nama") ?></th>
                            <th><?= __("Bank") ?></th>
                            <th colspan = "2"><?= __("Nominal") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th><?= __("Tipe Kas") ?></th>
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
                                <td class = "text-center" colspan ="11">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CooperativeCash']['name'] ?></td>
                                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['code'] : "-" ?></td>
                                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['on_behalf'] : "-" ?></td>
                                    <td class="text-center"><?= !empty($item['CooperativeBankAccount']['id']) ? $item['CooperativeBankAccount']['BankAccountType']['name'] : "-" ?></td>
                                    <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $this->Html->Rp($item['CooperativeCash']['nominal']) ?></td>
                                    <td class="text-center"><?= $this->Html->cvtTanggal($item['CooperativeCash']['created_date']) ?></td>
                                    <td class="text-center"><?= $item['CashType']['name'] ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-init-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
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
                        <h6 class="heading-hr">DATA SALDO KAS KOPERASI
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
                                        echo $this->Form->label("CooperativeCash.name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("CooperativeCash.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-md-4 control-label">
                                            <label>Nominal</label>
                                        </div>
                                        <div class="col-sm-9 col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">Rp.</button>
                                                </span>
                                                <input type="text" id="nominal" disabled label="false" class="form-control text-right" name="data[CooperativeCash][nominal]" value="<?= !empty($this->data['CooperativeCash']['nominal']) ? $this->data['CooperativeCash']['nominal'] : "" ?>">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">,00.</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-md-4 control-label">
                                            <label>Tipe Kas</label>
                                        </div>
                                        <div class="col-sm-9 col-md-8">
                                            <input type="text" id="tipeKas" disabled label="false" class="form-control">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="form-group">
                                        <?php
                                        echo $this->Form->label("CooperativeCash.created_date", __("Tanggal Dibuat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                        echo $this->Form->input("CooperativeCash.created_date", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
            var initId = $(this).data("init-id");
            $.ajax({
                url: BASE_URL + "cooperative_cashes/view_cash/" + initId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#CooperativeCashName").val(data.CooperativeCash.name);
                    $("#nominal").val(IDR(data.CooperativeCash.nominal));
                    $("#CooperativeCashCreatedDate").val(cvtTanggal(data.CooperativeCash.created_date));
                    $("#tipeKas").val(data.CashType.name);
                }
            })
        });
    });
</script>