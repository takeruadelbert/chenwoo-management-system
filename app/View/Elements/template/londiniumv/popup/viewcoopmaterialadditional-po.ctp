<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Purchase Order Material Additional</h4>
</div>
<div class="panel-body">
    <div class="block-inner text-danger">
        <h6 class="heading-hr">DATA PURCHASE ORDER MATERIAL PEMBANTU
            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
        </h6>
    </div>
    <?php
    if (!empty($this->data['PurchaseOrderMaterialAdditional'])) {
        ?>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <?php
                    foreach ($this->data['PurchaseOrderMaterialAdditional'] as $i => $pomatadss) {
                        if ($i == 0) {
                            $is_active = "active";
                        } else {
                            $is_active = "";
                        }
                        ?>
                        <li class="<?= $is_active ?>"><a href="#justified-pill<?= $i ?>" data-toggle="tab"><i class="icon-file6"></i> Purchase Order - <?= $pomatadss['po_number'] ?></a></li>
                        <?php
                        $i++;
                    }
                    ?>
                </ul>
                <div class="tab-content pill-content" id="tabs">
                    <?php
                    foreach ($this->data['PurchaseOrderMaterialAdditional'] as $i => $pomatads) {
                        if ($i == 0) {
                            $is_active = "active";
                        } else {
                            $is_active = "";
                        }
                        ?>
                        <div class="tab-pane fade in  <?= $is_active ?>" id="justified-pill<?= $i ?>">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("Dummy.name", __("Nama"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $pomatads['Employee']['Account']['Biodata']['full_name']));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $pomatads['Employee']['nip']));
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
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("Dummy.department", __("Departemen"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("Dummy.department", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($pomatads['Employee']['Department']['id']) ? $pomatads['Employee']['Department']['name'] : "-"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("Dummy.office", __("Jabatan"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("Dummy.office", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => !empty($pomatads['Employee']['Office']['id']) ? $pomatads['Employee']['Office']['name'] : "-"));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>   
                            </table> 
                            <br>
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-file6"></i><?= __("Data Purchase Order") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditionalTemp.po_number", __("Nomor PO"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditionalTemp.po_number", array("div" => array("class" => "col-md-8"), 'type' => 'text', "label" => false, "value" => $pomatads['po_number'], "class" => " form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditional.po_date", __("Tanggal PO"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.po_date", array("div" => array("class" => "col-md-8"), 'type' => 'text', "label" => false, "class" => "datetime form-control", "value" => $this->Html->cvtWaktu($pomatads['po_date']), "disabled"));
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
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditional.material_additional_supplier_id", __("Supplier Material Pembantu"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("PurchaseOrderMaterialAdditional.material_additional_supplier_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "value" => $pomatads['MaterialAdditionalSupplier']['name'], "disabled"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("PurchaseOrderMaterialAdditional.shipping_cost", __("Biaya Pengiriman"), array("class" => "col-md-4 control-label"));
                                                        ?>
                                                        <div class = "col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">Rp.</span>   
                                                                <?php
                                                                echo $this->Form->input("PurchaseOrderMaterialAdditional.shipping_cost", array("div" => array("class" => ""), "label" => false, "class" => "form-control text-right", "type" => "text", "value" => ic_rupiah($pomatads['shipment_cost']), "disabled"));
                                                                ?>
                                                                <span class="input-group-addon">,00.</span>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>   
                            <br>
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-phone2"></i><?= __("Data Kontak Person Supplier") ?></h6>
                            </div>
                            <table width="100%" class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("MaterialAdditionalSupplier.cp_name", __("Nama"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("MaterialAdditionalSupplier.cp_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $pomatads['MaterialAdditionalSupplier']['cp_name']));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("MaterialAdditionalSupplier.cp_name", __("Jabatan"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("MaterialAdditionalSupplier.cp_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled", "value" => $pomatads['MaterialAdditionalSupplier']['cp_position']));
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
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("MaterialAdditionalSupplier.cp_address", __("Alamat"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("MaterialAdditionalSupplier.cp_address", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $pomatads['MaterialAdditionalSupplier']['cp_address']));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("MaterialAdditionalSupplier.cp_phone_number", __("Telepon"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("MaterialAdditionalSupplier.cp_phone_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $pomatads['MaterialAdditionalSupplier']['cp_phone_number']));
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
                                                    <div class="form-group form-horizontal">
                                                        <?php
                                                        echo $this->Form->label("MaterialAdditionalSupplier.cp_email", __("Email"), array("class" => "col-md-4 control-label"));
                                                        echo $this->Form->input("MaterialAdditionalSupplier.cp_email", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "type" => "text", "disabled", "value" => $pomatads['MaterialAdditionalSupplier']['cp_email']));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>      
                            <div class="panel-heading" style="background:#2179cc;margin-top:20px;">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-box-add"></i><?= __("Data Material Pembantu Yang Dipesan") ?></h6>
                            </div>
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Barang</th>
                                        <th width="20%" colspan="2">Jumlah</th>
                                        <th width="20%" colspan="2">Harga Satuan</th>
                                        <th width="25%" colspan="2">Total</th>
                                    </tr>
                                <thead>
                                <tbody id="target-detail-request-order-material-additional">
                                    <?php
                                    $subTotal = 0;
                                    foreach ($pomatads['PurchaseOrderMaterialAdditionalDetail'] as $k => $details) {
                                        $subTotal += $details["price"] * $details["quantity"];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $k + 1 ?></td>
                                            <td>
                                                <?= $details["MaterialAdditional"]['name']." ".$details["MaterialAdditional"]['size'] ?>
                                            </td>
                                            <td class="text-right" style="border-right-style:none;">
                                                <?= (ic_kg($details["quantity"])) ?>
                                            </td> 
                                            <td class = "text-left" style= "width:50px; border-left-style:none;">
                                                <?= $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                                            </td>
                                            <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                Rp.
                                            </td>    
                                            <td class = "text-right" style="border-left-style:none;">
                                                <?= ic_rupiah($details['price']) ?>
                                            </td>
                                            <td class="text-center" style= "width:50px; border-right-style:none;">           
                                                Rp.
                                            </td>    
                                            <td class = "text-right" style="border-left-style:none;">
                                                <?= ic_rupiah($details["price"] * $details["quantity"]) ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan = "6" class = "text-right">
                                            <strong>Sub Total </strong>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                            Rp.
                                        </td>
                                        <td class="text-right" id = "subTotal" style="border-left-style:none;">
                                            <?= ic_rupiah($subTotal) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $pajak = $subTotal * 10 / 100;
                                        ?>
                                        <td colspan = "6" class = "text-right">
                                            <strong>Pajak (10%)</strong>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                            Rp.
                                        </td>
                                        <td class="text-right" id = "subTotal" style="border-left-style:none;">
                                            <?= ic_rupiah($pajak) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan = "6" class = "text-right">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                            Rp.
                                        </td>
                                        <td class="text-right" id = "subTotal" style="border-left-style:none;">
                                            <?= ic_rupiah($subTotal + $pajak) ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- /new invoice template -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>
