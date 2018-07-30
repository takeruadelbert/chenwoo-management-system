<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Transaksi Penjualan Produk Tambahan</h4>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENJUALAN PRODUK TAMBAHAN
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file6"></i>Data Penjualan Produk Tambahan</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Employee.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">                                            
                                            <?php
                                            echo $this->Form->label("Employee.Office.name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Office.name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Employee.Department.name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Employee.Department.name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                    <div class="tab-pane fade" id="justified-pill2">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label('SaleProductAdditional.reference_number', __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("SaleProductAdditional.reference_number", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                            <?php
                                            echo $this->Form->label('Purchaser.Account.Biodata.full_name', __("Nama Pembeli"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Purchaser.Account.Biodata.full_name", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.payment_type", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.payment_type", array("div" => array("class" => "col-sm-4"), "type" => "tex", "label" => false, "class" => "form-control", "disabled", "value" => emptyToStrip(@$this->data['PaymentType']['name'])));
                                            ?>
                                            <?php
                                            if(!empty($this->data['SaleProductAdditional']['initial_balance_id'])) {
                                                echo $this->Form->label("Dummy.initial_balance", __("Kas"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("Dummy.initial_balance", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control", "disabled", "value" => $this->data['InitialBalance']['GeneralEntryType']['name']));
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("SaleProductAdditional.sale_date", __("Tanggal Penjualan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("SaleProductAdditional.sale_date", array("div" => array("class" => "col-sm-4"), "type" => "text", "label" => false, "class" => "form-control datetime", "disabled", "value" => !empty($this->data['SaleProductAdditional']['sale_date']) ? $this->data['SaleProductAdditional']['sale_date'] : "-"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Produk Tambahan</th>
                                    <th>Berat</th>
                                    <th>Harga Per Kg</th>
                                    <th>Total</th>
                                </tr>
                            <thead>
                            <tbody id="target-detail-penjualan">
                                <?php
                                $i = 1;
                                $grandTotal = 0;
                                foreach ($this->data['SaleProductAdditionalDetail'] as $detail) {
                                    $total = $detail['weight'] * $detail['nominal'];
                                    $grandTotal += $total;
                                ?>
                                <tr>
                                    <td class="text-center nomorIdx">
                                        <?= $i ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->input("Dummy.name", array("div" => false, "label" => false, "class" => "form-control", "disabled", "value" => $detail['ProductAdditional']['name'])) ?>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right" disabled value="<?= ic_kg($detail['weight']) ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Kg.</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Rp.</button>
                                            </span>
                                            <input type="text" class="form-control text-right" disabled value="<?= ic_rupiah($detail['nominal']) ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Rp.</button>
                                            </span>
                                            <input type="text" class="form-control text-right" disabled value="<?= ic_rupiah($total) ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Rp.</button>
                                            </span>
                                            <input type="text" class="form-control text-right" disabled value="<?= ic_rupiah($grandTotal) ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">,00.</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /new invoice template -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
        </div>
    </div>
</div>
