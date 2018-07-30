<?php echo $this->Form->create("CooperativeSupplier", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Data Supplier Koperasi") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
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
                                                            echo $this->Form->input("CooperativeSupplier.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.phone", __("Nomor Telepon"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.phone", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                                            echo $this->Form->input("CooperativeSupplier.email", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.cooperative_supplier_type_id", __("Tipe Supplier"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.cooperative_supplier_type_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Supplier -"));
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
                                                            echo $this->Form->label("CooperativeSupplier.state_id", __("Provinsi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.state_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full autolist", "data-autolist-target" => "#CooperativeSupplierCityId", "data-autolist-url" => Router::url("/admin/cities/list/", true), "data-autolist-emptylabel" => "", "empty" => "", "placeholder" => "- Pilih Provinsi -"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.city_id", __("Kota"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.city_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Kota -"));
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
                                                            echo $this->Form->input("CooperativeSupplier.address", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                                            echo $this->Form->input("CooperativeSupplier.cp_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.cp_hp", __("Nomor Handphone"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.cp_hp", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                                            echo $this->Form->input("CooperativeSupplier.cp_email", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.cp_address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.cp_address", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                                            echo $this->Form->input("CooperativeSupplier.bank_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.bank_account", __("Nomor Rekening"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.bank_account", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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
                                                            echo $this->Form->input("CooperativeSupplier.bank_branch", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("CooperativeSupplier.bank_on_behalf", __("Atas Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("CooperativeSupplier.bank_on_behalf", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
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