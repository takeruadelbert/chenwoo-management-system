<?php echo $this->Form->create("PurchaseOrderMaterialAdditional", array("class" => "form-horizontal form-separate", "action" => "entry_edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Request Order Material Additional</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA MATERIAL PEMBANTU YANG TELAH MASUK GUDANG
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-file6"></i> Data Request Order</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->label("PurchaseOrderMaterialAdditional.po_number", __("Nomor PO"), array("class" => "col-md-4 control-label"));
                                                    echo $this->Form->input("PurchaseOrderMaterialAdditional.po_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>                                
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-heading" style="background:#2179cc;margin-top:20px;">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Rekap Barang yang Masuk Gudang") ?></h6>
                        </div>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="39%">Nama Barang</th>
                                    <th width="30%" colspan = 2>Jumlah</th>
                                    <th width="30%">Tanggal Barang Masuk</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-request-order-material-additional">
                                <?php
                                $i = 1;
                                if (!empty($this->data['MaterialAdditionalEntry'])) {
                                    $i=0;
                                    foreach ($this->data['MaterialAdditionalEntry'] as $c => $data) {
                                        foreach ($this->data['MaterialAdditionalEntry'][$c]['MaterialAdditionalEntryDetail'] as $k => $detail) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $i ?></td>
                                                <td>
                                                    <?= $detail['MaterialAdditional']['name']." ".$detail['MaterialAdditional']['size'] ?>
                                                </td>
                                                <td style = "width: 150px; text-align: right; border-right-style: none;">
                                                    <?= ic_kg($detail['quantity_entry']) ?>
                                                </td>
                                                <td style = "width: 50px; text-align: left; border-left-style: none;">
                                                    <?php
                                                        if($detail['MaterialAdditional']['MaterialAdditionalUnit']['uniq']==null){
                                                                echo "-";
                                                        }else{
                                                                echo $detail['MaterialAdditional']['MaterialAdditionalUnit']['uniq'];
                                                        }
                                                    ?>
                                                </td>
                                                <td class = "text-center">
                                                    <?php
                                                    echo $this->Form->label("MaterialAdditionalEntry.$i.entry_date", __("Tanggal Input"), array("class" => "col-md-3 control-label"));
                                                    echo $this->Form->input("MaterialAdditionalEntry.$i.entry_date", array("type" => "text", "div" => array("class" => "col-md-6"), "value" => !empty($detail['entry_date']) ? $detail['entry_date'] : date("Y-m-d H:i:s"), "label" => false, "class" => "form-control datetime"));
                                                    echo $this->Form->input("MaterialAdditionalEntry.$i.id", array("type" => "hidden", "div" => array("class" => "col-md-6"), "value" => $detail['id'], "label" => false, "class" => "form-control"));
                                                    $i++;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan = "5">Tidak ada data</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>    
                    </div>                    
                </div>
            </div>
        </div>
        <!-- /new invoice template -->
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
