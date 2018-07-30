<?php echo $this->Form->create("Employee", array("class" => "form-horizontal form-separate", "action" => "profil_edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<!-- /callout -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("FORM PEGAWAI") ?>                
                <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i>Biodata Pegawai</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file6"></i>Data Akun Pegawai</a></li>
                </ul>
                <?php
                echo $this->Form->input("Employee.id", array("type" => "hidden", "class" => "form-control"));
                echo $this->Form->input("Account.id", array("type" => "hidden", "class" => "form-control"));
                echo $this->Form->input("Account.Biodata.id", array("type" => "hidden", "class" => "form-control"));
                echo $this->Form->input("Account.User.id", array("type" => "hidden", "class" => "form-control"));
                ?>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill2">
                        <div class="table-responsive">
                            <table width="100%" class="table table-hover">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.first_name", __("Nama Depan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.first_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.last_name", __("Nama Belakang"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.last_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.gelar_depan", __("Gelar Depan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.gelar_depan", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.gelar_belakang", __("Gelar Belakang"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.gelar_belakang", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.tempat_lahir_kota", __("Tempat Lahir"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.tempat_lahir_kota", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.tanggal_lahir", __("Tanggal Lahir"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.tanggal_lahir", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.religion_id", __("Agama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.religion_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Agama -"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.gender_id", __("Jenis Kelamin"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.gender_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Kelamin -"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.state_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state", "data-city-state-target" => "#AccountBiodataCityId", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.city_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full city-state-target", "empty" => "", "placeholder" => "- Pilih Kota -"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.handphone", __("No Handphone"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.handphone", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.Biodata.phone", __("No Telp (Rumah)"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.phone", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.Biodata.marital_status_id", __("Status Pernikahan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Account.Biodata.marital_status_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Status Pernikahan -"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <div class="table-responsive">
                            <table width="100%" class="table table-hover">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Account.User.username", __("Username"), array("class" => "col-md-2 control-label"));
                                            echo $this->Form->input("Account.User.username", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Account.User.user_group_id", __("User Group"), array("class" => "col-md-2 control-label"));
                                            echo $this->Form->input("Account.User.user_group_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>            
            <!-- /justified pills -->
        </div>
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            <input type="reset" value="Reset" class="btn btn-info">
            <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                <?= __("Simpan") ?>
            </button>&nbsp;
        </div>
    </div>
</div>
<!-- /page content -->
<?php echo $this->Form->end() ?>