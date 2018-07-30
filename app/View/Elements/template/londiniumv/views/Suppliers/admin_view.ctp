<?php echo $this->Form->create("Supplier", array("class" => "form-horizontal form-separate", "action" => "view", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Lihat Supplier") ?>
                    <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <!-- Justified pills -->
            <div class="well block">
                <div class="tabbable">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                        <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-user2"></i> Data Supplier</a></li>
                        <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person </a></li>
                        <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-vcard"></i> Data Perbankan Supplier </a></li>
                        <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-file6"></i> Data Dokumen Supplier </a></li>
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
                                                echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                                echo $this->Form->input("Supplier.employee_id", ["type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")]);
                                                ?>
                                                <?php
                                                echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['nip']));
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
                                                echo $this->Form->label("Supplier.id_supplier", __("ID Supplier"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.id_supplier", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.supplier_type_id", __("Tipe Supplier"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.supplier_type_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Supplier -", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.name", __("Nama Supplier"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.initial", __("Initial Supplier"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.initial", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.address", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.country_id", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.country_id", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "class" => "select-full state-country", "data-state-country-target" => "#SupplierStateId", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.state_id", array("empty" => "- Pilih Provinsi -", "disabled", "div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state state-country-target", "data-city-state-target" => "#SupplierCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.city_id", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.website", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
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
                                                echo $this->Form->label("Supplier.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_address", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.cp_country_id", __("Negara"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_country_id", array("empty" => "- Pilih Provinsi -", "disabled", "div" => array("class" => "col-sm-4"), "options" => $countries, "label" => false, "class" => "select-full state-country", "data-state-country-target" => "#SupplierCpStateId", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.cp_state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_state_id", array("empty" => "- Pilih Provinsi -", "disabled", "div" => array("class" => "col-sm-4"), "options" => $cpStates, "label" => false, "class" => "select-full city-state", "data-city-state-target" => "#SupplierCpCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.cp_city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_city_id", array("div" => array("class" => "col-sm-4"), "disabled", "options" => $cpCities, "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="11" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Supplier.cp_phone_number", __("Nomor Telepon"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_phone_number", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "class" => "form-control"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Supplier.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Supplier.cp_email", array("div" => array("class" => "col-sm-4"), "disabled", "label" => false, "type" => "email", "class" => "form-control"));
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
                                <tbody id="target-detail-perbankan-supplier">
                                    <?php
                                    $no = 1;
                                    $dataN = count($this->data["SupplierBank"]);
                                    foreach ($this->data["SupplierBank"] as $i => $value) {
                                        ?>
                                        <tr class="dynamic-row">
                                            <td class="nomorIdx text-center"><?= $no; ?></td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("SupplierBank.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                                echo $this->Form->input("SupplierBank.$i.bank_name", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "readonly"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("SupplierBank.$i.bank_code", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "readonly"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("SupplierBank.$i.bank_branch", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "readonly"));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("SupplierBank.$i.on_behalf", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "readonly"));
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>    
                        <div class="tab-pane fade" id="justified-pill4">
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="90%">Nama File</th>
                                        <th width="5%">Download File</th>
                                    </tr>
                                <thead>
                                <tbody id="target-detail-kas-keluar">
                                    <?php
                                    $no = 1;
                                    $dataN = count($this->data["SupplierFile"]);
                                    foreach ($this->data["SupplierFile"] as $i => $value) {
                                        ?>
                                        <tr class="dynamic-row">
                                            <td class="nomorIdx text-center"><?= $no; ?></td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("SupplierFile.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false, "readonly"));
                                                echo $this->Form->input("SupplierFile.$i.AssetFile.filename", array("div" => false, "label" => false, "class" => "form-control", "maxlength" => "255", "readonly"));
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a href ='<?= Router::url("/admin/AssetFiles/getfile/" . $this->data["SupplierFile"][$i]['AssetFile']['id'] . "/" . $this->data["SupplierFile"][$i]['AssetFile']['token']) ?>'> 
                                                    <button type="button" class="btn btn-default btn-xs btn-icon tip" name = "Download" value = "Download" title="Download File">
                                                        <i class="icon-download"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
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
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
