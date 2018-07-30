<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Request Order Material Additional</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA REQUEST ORDER MATERIAL PEMBANTU
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <table width="100%" class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="3" style="width:200px">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-horizontal">
                                        <?php
                                        echo $this->Form->label("Employee.Account.Biodata.first_name", __("Pegawai yang Meminta"), array("class" => "col-md-4 control-label"));
                                        echo $this->Form->input("Employee.Account.Biodata.first_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-horizontal">
                                        <?php
                                        echo $this->Form->label("Employee.nip", __("NIK Pelaksana"), array("class" => "col-md-4 control-label"));
                                        echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
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
                                        echo $this->Form->label("RequestOrderMaterialAdditional.ro_date", __("Tanggal RO"), array("class" => "col-md-4 control-label"));
                                        echo $this->Form->input("RequestOrderMaterialAdditional.ro_date", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker", " disabled", "type" => "text", "value" => $this->Html->cvtTanggal($this->data['RequestOrderMaterialAdditional']['ro_date'])));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-horizontal">
                                        <?php
                                        echo $this->Form->label("RequestOrderMaterialAdditional.ro_number", __("Nomor RO"), array("class" => "col-md-4 control-label"));
                                        echo $this->Form->input("RequestOrderMaterialAdditional.ro_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                        ?>
                                    </div>
                                </div>
                            </div>                                
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-heading" style="background:#2179cc;margin-top:20px;">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Material Pembantu Yang Dipesan") ?></h6>
            </div>
            <table class="table table-hover table-bordered stn-table" width="100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="65%">Nama Barang</th>
                        <th colspan = 2>Jumlah</th>
                    </tr>
                <thead>
                <tbody id="target-detail-request-order-material-additional">
                    <?php
                    foreach ($this->data["RequestOrderMaterialAdditionalDetail"] as $k => $requestOrderMaterialAdditionalDetail) {
                        ?>
                        <tr>
                            <td class="text-center"><?= $k + 1 ?></td>
                            <td class = "text-left">
                                <?= $requestOrderMaterialAdditionalDetail['MaterialAdditional']['name']." ".$requestOrderMaterialAdditionalDetail['MaterialAdditional']['size'] ?>
                            </td>
                            <td class="text-right" style = "border-right-style: none">
                                <?= ic_kg($requestOrderMaterialAdditionalDetail['quantity']) ?>  
                            </td>
                            <td class = "text-left" width = "50px" style = "border-left-style: none">
                                <?= $requestOrderMaterialAdditionalDetail['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>    
        </div>
        <!-- /new invoice template -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
        </div>
    </div>
</div>
