<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Pembayaran Hutang Material Pembantu</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PEMBAYARAN HUTANG MATERIAL PEMBANTU
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <?php
            foreach ($this->data['PurchaseOrderMaterialAdditional'] as $i => $poMaterialAdditional) {
        ?>
        <div class="well block">
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-file5"></i><?= __("Data Purchase Order Material Pembantu - " . $poMaterialAdditional['po_number']) ?></h6>
            </div>
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="11" style="width:200px">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Total Tagihan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right" readonly value="<?= ic_rupiah($poMaterialAdditional['total']) ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">,00.</button>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-sm-2 control-label">
                                    <label>Sisa Tagihan</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Rp.</button>
                                        </span>
                                        <input type="text" class="form-control text-right" readonly value="<?= ic_rupiah($poMaterialAdditional['remaining']) ?>">
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
        <?php
            }
        ?>
    </div>
    <!-- /new invoice template -->
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
</div>
