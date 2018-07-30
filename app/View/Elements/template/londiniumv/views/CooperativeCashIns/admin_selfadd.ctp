<?php echo $this->Form->create("CooperativeCashIn", array("class" => "form-horizontal form-separate", "action" => "selfadd", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Pemasukan Koperasi") ?>                
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Login</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file"></i>Data Pemasukan</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label(null, __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label(null, __("NIK"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
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
                                                            echo $this->Form->label(null, __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label(null, __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input(null, array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table">
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CooperativeCashIn.cash_in_number", __("Nomor Kas Masuk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CooperativeCashIn.cash_in_number", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => "AUTO GENERATE"));
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
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right isdecimal" name="data[CooperativeCashIn][amount]" required="required">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
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
                                                        echo $this->Form->label("CooperativeCashIn.cooperative_cash_id", __("Kas Tujuan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CooperativeCashIn.cooperative_cash_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kas -"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CooperativeCashIn.general_entry_type_id", __("Jenis Pemasukan"), array("class" => "col-sm-3 col-md-4 control-label label-required"));
                                                        echo $this->Form->input("CooperativeCashIn.general_entry_type_id", array("options" => $inCooperativeGeneralEntryTypes, "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Pemasukan -", "required" => true));
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
                                                        echo $this->Form->label("CooperativeCashIn.created_datetime", __("Tanggal & Waktu"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CooperativeCashIn.created_datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
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
                                                echo $this->Form->label("CooperativeCashIn.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("CooperativeCashIn.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor fix"));
                                                ?>
                                            </div>                           
                                        </td>
                                    </tr>
                                </table>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="block-inner text-danger">
                                            <div class="form-actions text-center">
                                                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                                <input type="reset" value="Reset" class="btn btn-info">
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                                                    <?= __("Simpan") ?>
                                                </button>&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>