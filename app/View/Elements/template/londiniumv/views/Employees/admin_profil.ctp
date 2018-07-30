<style>
    select{
        padding: 11px 50px 11px 10px;
        background: rgba(255,255,255,1);
        border-radius: 7px;
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        border: 0;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        color: #8ba2d4;
    }
</style>
<div class="row">
    <div class="col-lg-2">
        <!-- Profile links -->
        <div class="block">
            <div class="block">
                <div class="thumbnail">
                    <div class="thumb"><img alt="" src="<?= Router::url('/', true) . $this->Session->read("credential.admin.User.profile_picture") ?>">
                        <div class="thumb-options"><span><a onclick="modalChangepp()" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a><a onclick="modalDeletepp()" class="btn btn-icon btn-success"><i class="icon-remove"></i></a></span></div>
                    </div>
                    <div class="caption text-center">
                        <h6><?= $this->Echo->fullName($this->Session->read("credential.admin.Biodata")) ?> <small><?= $this->Echo->userGroup($this->Session->read("credential.admin.User.user_group_id")) ?></small></h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- /profile links -->
    </div>
    <div class="col-md-10">
        <div class="panel">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr">PROFIL PEGAWAI
                        <div class="pull-right">
                        </div>
                        <small class="display-block"><?= _APP_CORPORATE_FULL?></small>
                    </h6>
                </div>
                <!-- Justified pills -->
                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-mail-send"></i> Data Login </a></li>
                            <li class=""><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i> Data Pribadi </a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade active in" id="justified-pill1"><table width="100%" class="table table-hover">
                                    <tbody><tr>
                                            <td colspan="11" style="width:200px">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("Account.User.username", __("Username"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Account.User.username", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                    <?php
                                                    echo $this->Form->label("Account.User.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                                    echo $this->Form->input("Account.User.email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table table-hover">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.first_name", __("Nama Depan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.first_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.last_name", __("Nama Belakang"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.last_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.gelar_depan", __("Gelar Depan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.gelar_depan", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.gelar_belakang", __("Gelar Belakang"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.gelar_belakang", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.tempat_lahir_kota", __("Tempat Lahir"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.tempat_lahir_kota", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.tanggal_lahir", __("Tanggal Lahir"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.tanggal_lahir", array("div" => array("class" => "col-sm-4"), "label" => false, "type" => "text", "class" => "form-control datepicker", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.religion_id", __("Agama"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.religion_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "empty" => "", "placeholder" => "- Pilih Agama -", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.gender_id", __("Jenis Kelamin"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.gender_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "empty" => "", "placeholder" => "- Pilih Jenis Kelamin -", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.state_id", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.state_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.city_id", __("Kota"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.city_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.handphone", __("No Handphone"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.handphone", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                                <?php
                                                echo $this->Form->label("Account.Biodata.phone", __("No Telp (Rumah)"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.phone", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Account.Biodata.marital_status_id", __("Status Pernikahan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Account.Biodata.marital_status_id", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
</div>
<?php echo $this->Form->end() ?>