<?php echo $this->Form->create("State", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Lihat State") ?>

                        <small class="display-block">Form Modul</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data State") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("State.name", __("Nama State"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("State.name", array("div" => array("class" => "col-sm-9 col-md-8"), "disabled", "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("State.country_id", __("Negara"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("State.country_id", array("div" => array("class" => "col-sm-9 col-md-8"), "disabled", "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kota") ?></h6>
                    </div>
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <td width="1%" align="center" valign="middle" bgcolor="#feffc2">No</td>
                                <td width="20%" align="center" valign="middle" bgcolor="#feffc2">Nama Kota</td>
                                <td width="20%" align="center" valign="middle" bgcolor="#feffc2">Kode Pos</td>
                            </tr>
                        </thead>
                        <tbody id="target-modullink"><?php
                            foreach ($this->data["City"] as $k => $item) {
                                ?>
                                <tr>
                                    <?= $this->Form->hidden("City.$k.id") ?>
                                    <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                                    <td>
                                        <div class="false">
                                            <?= $this->Form->input("City.$k.name", [ "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="false">
                                            <?= $this->Form->input("City.$k.postal_code", [ "div" => false, "class" => "form-control", "label" => false, "disabled"]) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>  
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="text-center">
                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>