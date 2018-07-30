<?php echo $this->Form->create("CashIn", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Kas Masuk Internal") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file"></i>Data Kas Masuk</a></li>
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
                                                            echo $this->Form->label("Creator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Creator']['Account']['Biodata']['full_name']));
                                                            echo $this->Form->input("CashIn.creator_id", array("type" => "hidden", "value" => $this->data['Creator']['id']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Creator']['nip']));
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
                                                            echo $this->Form->label("Creator.Department.name", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Department.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Creator']['Department']['id']) ? $this->data['Creator']["Department"]['name'] : "-"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Office.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($this->data['Creator']['Office']['id']) ? $this->data['Creator']['Office']['name'] : "-"));
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
                                                        echo $this->Form->label("CashIn.cash_in_number", __("Nomor Kas Masuk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.cash_in_number", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "readonly"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label">
                                                            <label>Nominal</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <?php
                                                                if ($this->data['CashIn']['currency_id'] == 2) {
                                                                    ?>
                                                                    <span class="input-group-addon"><strong>$</strong></span>
                                                                    <input type="text" class="form-control text-right isdecimaldollar" name="data[CashIn][amount]"value="<?= $this->data['CashIn']['amount'] ?>" readonly>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                    <input type="text" class="form-control text-right isdecimal" name="data[CashIn][amount]"value="<?= $this->data['CashIn']['amount'] ?>" readonly>
                                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                                    <?php
                                                                }
                                                                ?>
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
                                                        echo $this->Form->label("CashIn.initial_balance_id", __("Tipe Kas Yang Digunakan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Kas -", "disabled"));
                                                        echo $this->Form->input("CashIn.initial_balance_id", array("type" => "hidden", "value" => $this->data['CashIn']['initial_balance_id']));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CashIn.created_datetime", __("Tanggal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.created_datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "readonly"));
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
                                                echo $this->Form->label("CashIn.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("CashIn.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor fix"));
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
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="reset" value="Reset" class="btn btn-info">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                            <?= __("Simpan") ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>