<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Penyusutan Aset</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENYUSUTAN ASET
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-file5"></i><?= __("Data Penyusutan Aset") ?></h6>
            </div>
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Nama Aset</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" disabled value="<?= $this->data['AssetProperty']['name'] ?>">
                                </div> 
                                <div class="col-sm-2 control-label">
                                    <label>Nominal Aset</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right" readonly value="<?= ic_rupiah($this->data['AssetProperty']['nominal']) ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Nominal Aset Sekarang</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right" readonly value="<?= ic_rupiah($this->data['DepreciationAsset']['current_nominal']) ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Durasi Penyusutan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" disabled value="<?= $this->data['DepreciationAsset']['depreciation_duration'] ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">bulan</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-2 control-label">
                                    <label>Nominal Penyusutan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right" readonly value="<?= ic_rupiah($this->data['DepreciationAsset']['depreciation_amount']) ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /new invoice template -->
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
</div>
