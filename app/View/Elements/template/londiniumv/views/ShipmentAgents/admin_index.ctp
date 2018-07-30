<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/shipment_agent");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA AGEN PENGIRIMAN") ?>
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
                            <th><?= __("Nama Agen") ?></th>
                            <th><?= __("Telepon") ?></th>
                            <th><?= __("Alamat") ?></th>
                            <th><?= __("Negara") ?></th>
                            <th><?= __("Provinsi") ?></th>
                            <th><?= __("Kota") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["ShipmentAgent"]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["ShipmentAgent"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?php echo $item['ShipmentAgent']['name']; ?></td>
                                    <td class="text-left"><?php echo $item["ShipmentAgent"]["phone_number"]; ?></td>
                                    <td class="text-left"><?php echo $item["ShipmentAgent"]["address"]; ?></td>
                                    <td class="text-left"><?php echo $item["Country"]['name']; ?></td>
                                    <td class="text-left"><?php echo $item["State"]['name']; ?></td>
                                    <td class="text-left"><?php echo $item["City"]['name']; ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-agent-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatijin" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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

<div id="default-lihatijin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA AGEN PENGIRIMAN
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                                <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Agen</a></li>
                                <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i> Data Perbankan </a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill2">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.name", __("Nama Agen"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("Country.name", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Country.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("State.name", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("State.name", array("empty" => "- Pilih Provinsi -", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("City.name", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("City.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "type" => "number", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.email", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "email", "class" => "form-control", "disabled"));
                                                        ?>
                                                        <?php
                                                        echo $this->Form->label("ShipmentAgent.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("ShipmentAgent.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="justified-pill3">
                                    <table class="table table-hover table-bordered stn-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th width="20%">Nama Bank</th>
                                                <th width="20%">Nomor Rekening</th>
                                                <th width="20%">Cabang Bank</th>
                                                <th width="30%">Nama Pemilik Rekening</th>
                                            </tr>
                                        <thead>
                                        <tbody id="target-detail-perbankan-buyer">
                                        </tbody>
                                    </table>
                                </div>   
                            </div>
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
            $("#target-detail-perbankan-buyer").html("");
            var agentId = $(this).data("agent-id");
            $.ajax({
                url: BASE_URL + "shipment_agents/view_data_shipment_agent/" + agentId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    console.log(data);
                    $("#DummyName").val(data.Employee.Account.Biodata.full_name);
                    $("#DummyNip").val(data.Employee.nip);
                    $("#DummyDepartmentName").val(data.Employee.Department.name);
                    $("#DummyOfficeName").val(data.Employee.Office.name);

                    $("#ShipmentAgentName").val(data.ShipmentAgent.name);
                    $("#ShipmentAgentAddress").val(data.ShipmentAgent.address);
                    $("#CountryName").val(data.Country.name);
                    $("#StateName").val(data.State.name);
                    $("#CityName").val(data.City.name);
                    $("#ShipmentAgentPostalCode").val(data.ShipmentAgent.postal_code);
                    $("#ShipmentAgentPhoneNumber").val(data.ShipmentAgent.phone_number);
                    $("#ShipmentAgentEmail").val(data.ShipmentAgent.email);
                    $("#ShipmentAgentWebsite").val(data.ShipmentAgent.website);

                    $.each(data.ShipmentAgentBank, function (index, value) {
                        var bankName = value.bank_name;
                        var bankCode = value.bank_code;
                        var bankBranch = value.bank_branch;
                        var onBehalf = value.on_behalf;

                        var template = $("#tmpl-detail-perbankan-buyer").html();
                        Mustache.parse(template);
                        var options = {
                            index: index + 1,
                            bankName: bankName,
                            bankCode: bankCode,
                            bankBranch: bankBranch,
                            onBehalf: onBehalf
                        };
                        var rendered = Mustache.render(template, options);
                        $("#target-detail-perbankan-buyer").append(rendered);
                    });
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-perbankan-buyer">
    <tr>
    <td class="text-center">
    {{index}}
    </td>
    <td>
    <input class="form-control" maxlength="255" type="text" disabled value="{{bankName}}">                                    
    </td>
    <td>
    <input class="form-control" maxlength="255" type="text" disabled value="{{bankCode}}">                                    
    </td>
    <td>
    <input class="form-control" maxlength="255" type="text" disabled value="{{bankBranch}}">                                    
    </td>
    <td>
    <input class="form-control" maxlength="255" type="text" disabled value="{{onBehalf}}">                                    
    </td>
    </tr>
</script>