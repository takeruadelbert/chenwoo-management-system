<?php echo $this->Form->create("ShipmentAgent", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Agen Pengiriman") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
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
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                echo $this->Form->input("ShipmentAgent.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
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
                                                echo $this->Form->input("ShipmentAgent.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.country_id", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.country_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full state-country", "data-state-country-target" => "#ShipmentAgentStateId", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.state_id", array("empty" => "- Pilih Provinsi -", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state state-country-target", "data-city-state-target" => "#ShipmentAgentCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.city_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "type" => "number"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.email", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "email", "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("ShipmentAgent.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("ShipmentAgent.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
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
                                        <th width="5%">Aksi</th>
                                    </tr>
                                <thead>
                                <tbody id="target-detail-perbankan-buyer">
                                    <tr>
                                        <td colspan="6">
                                            <a class="text-success firstrunclick1" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-perbankan-buyer', 'anakOptions')" data-n="0"><i class="icon-plus-circle"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        addThisRow(".firstrunclick1", "detail-perbankan-buyer", "anakOptions");
    });
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {
            i: 2,
            n: n,
        };
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        fixNumber($(e).parents("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
        return {
        };
    }
    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-detail-perbankan-buyer">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input name="data[ShipmentAgentBank][{{n}}][bank_name]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankName">                                    
    </td>
    <td>
    <input name="data[ShipmentAgentBank][{{n}}][bank_code]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankCode">                                    
    </td>
    <td>
    <input name="data[ShipmentAgentBank][{{n}}][bank_branch]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankBranch">                                    
    </td>
    <td>
    <input name="data[ShipmentAgentBank][{{n}}][on_behalf]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}OnBehalf">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>