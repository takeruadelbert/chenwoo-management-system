<?php echo $this->Form->create("Buyer", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Ubah Pembeli") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <!-- Justified pills -->
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-mail-send"></i> Data Pegawai</a></li>
                        <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Pembeli</a></li>
                        <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person </a></li>
                        <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-vcard"></i> Data Perbankan Pembeli </a></li>
                    </ul>
                    <div class="tab-content pill-content">
                        <div class="tab-pane fade in active" id="justified-pill0">
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                echo $this->Form->input("Buyer.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
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
                                                if (empty($this->data['Employee']['Department'])) {
                                                    echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                                } else {
                                                    echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Department']['name']));
                                                }
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                if (empty($this->data['Employee']['Department'])) {
                                                    echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => "-"));
                                                } else {
                                                    echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Office']['name']));
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="justified-pill1">
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.id_buyer", __("ID Pembeli"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.id_buyer", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.buyer_type_id", __("Tipe Pembeli"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.buyer_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Pembeli -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.company_name", __("Nama Pembeli"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.company_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.company_uniq_name", __("Initial Pembeli"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.company_uniq_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.country_id", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.country_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full state-country", "data-state-country-target" => "#BuyerStateId", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.state_id", array("empty" => "- Pilih Provinsi -", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state state-country-target", "data-city-state-target" => "#BuyerCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.city_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.email", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "email", "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
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
                                                echo $this->Form->label("Buyer.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.cp_country_id", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_country_id", array("empty" => "- Pilih Provinsi -", "div" => array("class" => "col-sm-4"), "options" => $countries, "label" => false, "class" => "select-full state-country", "data-state-country-target" => "#BuyerCpStateId", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.cp_state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_state_id", array("empty" => "- Pilih Provinsi -", "div" => array("class" => "col-sm-4"), "options" => $cpStates, "label" => false, "class" => "select-full city-state", "data-city-state-target" => "#BuyerCpCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.cp_city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_city_id", array("div" => array("class" => "col-sm-4"), "options" => $cpCities, "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Buyer.cp_phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Buyer.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Buyer.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "email", "class" => "form-control"));
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
                                <tbody id="target-detail-perbankan-buyer"> <?php
                                    $no = 1;
                                    $dataN = count($this->data["BuyerBank"]);
                                    foreach ($this->data["BuyerBank"] as $i => $value) {
                                        ?>
                                        <tr class="dynamic-row">
                                            <td class="nomorIdx text-center"><?= $no; ?></td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("BuyerBank.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                                echo $this->Form->input("BuyerBank.$i.bank_name", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("BuyerBank.$i.bank_code", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("BuyerBank.$i.bank_branch", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("BuyerBank.$i.on_behalf", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255"));
                                                ?>
                                            </td>
                                            <td class="text-center" style = "border-right:1px solid #ddd">
                                                <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                    <i class="icon-remove3"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="6">
                                            <a class="text-success firstrunclick1" href="javascript:void(false)" onclick="addThisRow($(this), 'detail-perbankan-buyer', 'anakOptions')" data-n="<?= $dataN ?>"><i class="icon-plus-circle"></i></a>
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
    <input name="data[BuyerBank][{{n}}][bank_name]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankName">                                    
    </td>
    <td>
    <input name="data[BuyerBank][{{n}}][bank_code]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankCode">                                    
    </td>
    <td>
    <input name="data[BuyerBank][{{n}}][bank_branch]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}BankBranch">                                    
    </td>
    <td>
    <input name="data[BuyerBank][{{n}}][on_behalf]" class="form-control" maxlength="255" type="text" id="BuyerBank{{n}}OnBehalf">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>