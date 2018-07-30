<?php echo $this->Form->create("CooperativeDeposit", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Setup Bunga Simpanan") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Setup Bunga Simpanan") ?></h6>
                        </div>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Bunga</label>
                                            </div>                                            
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-right" name="data[CooperativeDeposit][interest]" value="<?= $this->data['CooperativeDeposit']['interest'] ?>">
                                                    <span class="input-group-addon"><strong>%</strong></span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width: 200px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Minimal Simpanan</label>
                                            </div>                                            
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeDeposit][bottom_limit]" value="<?= $this->data['CooperativeDeposit']['bottom_limit'] ?>">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-3 col-md-4 control-label">
                                                <label>Maksimal Simpanan</label>
                                            </div>                                            
                                            <div class="col-sm-9 col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                                    <input type="text" class="form-control text-right isdecimal" name="data[CooperativeDeposit][upper_limit]" value="<?= $this->data['CooperativeDeposit']['upper_limit'] ?>">
                                                    <span class="input-group-addon"><strong>,00.</strong></span>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
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