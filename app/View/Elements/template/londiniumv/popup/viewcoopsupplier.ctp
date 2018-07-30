<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">FORM</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA SUPPLIER KOPERASI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <!-- Justified pills -->
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-office"></i> Data Supplier</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Kontak Person</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-file"></i> Data Perbankan</a></li>
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
                                                    echo $this->Form->label("CooperativeSupplier.name", __("Nama Supplier"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.phone", __("Nomor Telepon"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.phone", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    echo $this->Form->label("CooperativeSupplier.email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.email", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control","disabled"=>true));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplierType.name", __("Tipe Supplier"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplierType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control","disabled"=>true));
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
                                                    echo $this->Form->label("State.name", __("Provinsi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("State.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("City.name", __("Kota"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("City.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    echo $this->Form->label("CooperativeSupplier.address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.address", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="justified-pill2">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.cp_name", __("Nama Lengkap"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.cp_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.cp_hp", __("Nomor Handphone"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.cp_hp", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    echo $this->Form->label("CooperativeSupplier.cp_email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.cp_email", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.cp_address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.cp_address", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="justified-pill3">
                        <div class="table-responsive">
                            <table width="100%" class="table">
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.bank_name", __("Nama Bank"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.bank_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.bank_account", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.bank_account", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                    echo $this->Form->label("CooperativeSupplier.bank_branch", __("Cabang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.bank_branch", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("CooperativeSupplier.bank_on_behalf", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                    echo $this->Form->input("CooperativeSupplier.bank_on_behalf", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                    ?>
                                                </div>
                                            </div>
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
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>
