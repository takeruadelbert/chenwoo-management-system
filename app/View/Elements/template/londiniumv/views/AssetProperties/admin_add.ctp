<?php echo $this->Form->create("AssetProperty", array("class" => "form-horizontal form-separate", "action" => "add", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("AssetProperty.setup_asset_type_id", __("Tipe Setup Asset"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("AssetProperty.setup_asset_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <div class="form-actions text-center">
                        <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                        <input type="submit" value="<?= __("Lanjut") ?>" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>