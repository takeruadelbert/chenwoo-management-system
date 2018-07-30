<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Hisotri Produk</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA HISTORI PRODUK
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block form-horizontal">
            <?php
            if (!empty($this->data['ProductHistory']['treatment_id'])) {
                ?>
                <table width="100%" class="table table-hover">
                    <tbody>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Treatment.treatment_number", __("Nomor Treatment"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("Treatment.treatment_number", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductHistory.history_datetime", __("Tanggal"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("ProductHistory.history_datetime", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text", "value" => $this->Html->cvtWaktu($this->data['ProductHistory']['history_datetime'])));
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
                                            echo $this->Form->label("ProductHistoryType.name", __("Tipe"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("ProductHistoryType.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="block-inner text-danger">
                            <h6 class="heading-hr"><?= __("DATA PRODUK TREATMENT") ?>
                            </h6>
                        </div>
                        <div class="table-responsive stn-table">
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Produk</th>
                                        <th colspan="2">Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $total_weight = 0;
                                    foreach ($this->data['Treatment']['TreatmentDetail'] as $details) {
                                        $total_weight += $details['weight'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center"><?= $details['Product']['Parent']['name'] . " " . $details['Product']['name'] ?></td>
                                            <td class="text-right" style = "border-right: none !important"><?= ic_kg($details['weight']) ?></td>
                                            <td width = "50" class = "text-center">Kg</td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><strong>Total Berat</strong></td>
                                        <td class="text-right" style = "border-right: none !important"><?= ic_kg($total_weight) ?></td>
                                        <td width = "50" class = "text-center">Kg</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <table width="100%" class="table table-hover">
                    <tbody>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Shipment.Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("Shipment.Sale.sale_no", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ProductHistory.history_datetime", __("Tanggal"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("ProductHistory.history_datetime", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text", "value" => $this->Html->cvtWaktu($this->data['ProductHistory']['history_datetime'])));
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
                                            echo $this->Form->label("ProductHistoryType.name", __("Tipe"), array("class" => "col-md-4 control-label"));
                                            echo $this->Form->input("ProductHistoryType.name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", " disabled", "type" => "text"));
                                            ?>
                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="block-inner text-danger">
                            <h6 class="heading-hr"><?= __("DATA PENJUALAN PRODUK") ?>
                            </h6>
                        </div>
                        <div class="table-responsive stn-table">
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Produk</th>
                                        <th colspan="2">Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $total_weight = 0;
                                    foreach ($this->data['Shipment']['Sale']['SaleDetail'] as $details) {
                                        $total_weight += $details['fulfill_weight'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i ?></td>
                                            <td class="text-center"><?= $details['Product']['Parent']['name'] . " " . $details['Product']['name'] ?></td>
                                            <td class="text-right" style = "border-right: none !important"><?= ic_kg($details['fulfill_weight']) ?></td>
                                            <td width = "50" class = "text-center">Kg</td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><strong>Total Berat</strong></td>
                                        <td class="text-right" style = "border-right: none !important"><?= ic_kg($total_weight) ?></td>
                                        <td width = "50" class = "text-center">Kg</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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