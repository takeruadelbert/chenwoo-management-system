<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">DATA PENERIMAAN PIUTANG PENJUALAN MATERIAL PEMBANTU</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">DATA PENERIMAAN PIUTANG PENJUALAN MATERIAL PEMBANTU
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#justified-pill0" data-toggle="tab"><i class="icon-people"></i> Data Pegawai</a></li>
                    <li><a href="#justified-pill1" data-toggle="tab"><i class="icon-vcard"></i> Data Invoice Penjualan</a></li>
                    <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-user"></i> Data Pembeli</a></li>
                    <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-phone2"></i> Data Kontak Person Pembeli</a></li>
                    <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-box-add"></i> Data Penjualan Produk</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="justified-pill0">
                        <div class="panel-heading" style="background:#2179cc">
                            <h6 class="panel-title" style=" color:#fff"><i class="icon-user"></i><?= __("Data Pegawai Yang Memasukkan Data") ?></h6>
                        </div>
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.name", __("Nama Pegawai"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.nip", __("NIP"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.nip", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['nip']));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("Dummy.department_name", __("Departemen"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.department_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => emptyToStrip(@$this->data['Employee']['Department']['name'])));
                                            ?>
                                            <?php
                                            echo $this->Form->label("Dummy.office_name", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("Dummy.office_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "disabled", "value" => emptyToStrip(@$this->data['Employee']['Office']['name'])));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill1">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-sm-2 control-label">
                                                <label>Nomor Kwitansi</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" disabled name="nomor kwitansi" value = "<?= $this->data['PaymentSaleMaterialAdditional']['receipt_number'] ?>">
                                            </div> 
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.material_additional_sale_id", __("Nomor Penjualan"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4">
                                                <input type="text" disabled class="form-control" value="<?= $this->data['MaterialAdditionalSale']['no_sale'] ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="width:200px">
                                        <div class="form-group">
                                            <div class="col-sm-2 control-label">
                                                <label>Total Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right" disabled id="invoice" value="<?= ic_rupiah($this->data['MaterialAdditionalSale']['total']) ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
                                                    </span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2 control-label">
                                                <label>Sisa Tagihan</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right" disabled id="invoiceLeft" value="<?= ic_rupiah($this->data['MaterialAdditionalSale']['total_remaining']) ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentType.name", __("Tipe Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentType.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", 'disabled'));
                                            ?>
                                            <div class="col-sm-2 control-label label-required">
                                                <label>Jumlah</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">Rp</button>
                                                    </span>
                                                    <input type="text" class="form-control text-right" disabled value="<?= ic_rupiah($this->data['PaymentSaleMaterialAdditional']['amount']) ?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button">,00</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("InitialBalance.GeneralEntryType.name", __("Kas"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("InitialBalance.GeneralEntryType.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", 'disabled'));
                                            ?>
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.payment_date", __("Tanggal Pembayaran"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("PaymentSaleMaterialAdditional.payment_date", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "type" => "text", "value" => $this->Html->cvtTanggal($this->data['PaymentSaleMaterialAdditional']['payment_date']), 'disabled'));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("PaymentSaleMaterialAdditional.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            ?>
                                            <div class="col-sm-4 control-label">
                                                <strong><?= $this->data['PaymentSaleMaterialAdditional']['note'] ?></strong>
                                            </div>
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
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.name", __("Nama Pembeli"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "buyerName", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.email", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyEmail", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.address", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyAddress", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.postal_code", __("Kode Pos"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.postal_code", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPostalCode", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.phone_number", __("Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyPhone", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.website", __("Website"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.ebsite", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyWebsite", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.City.name", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.City.name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCity", "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.State.name", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.State.name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyState", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.Country.name", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.Country.name", array("div" => array("class" => "col-sm-4"), "label" => false, "id" => "companyCountry", "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill3">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.cp_name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.cp_name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.cp_position", __("Jabatan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.cp_position", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.cp_address", __("Alamat"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.cp_address", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.cp_phone_number", __("No. Telepon"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.cp_phone_number", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.cp_email", __("Email"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.cp_email", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.CpCity.name", __("Kota"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.CpCity.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.CpState.name", __("Provinsi"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.CpState.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("MaterialAdditionalSale.Supplier.CpCountry.name", __("Negara"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("MaterialAdditionalSale.Supplier.CpCountry.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="justified-pill4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive stn-table">
                                    <table width="100%" class="table table-hover table-bordered">                        
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th><?= __("Nama Material Pembantu") ?></th>
                                                <th width = "200" colspan="2"><?= __("Quantity") ?></th>
                                                <th width = "250" colspan="2"><?= __("Harga Satuan") ?></th>
                                                <th width = "250" colspan="2"><?= __("Total") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="target-installment">
                                            <?php
                                            $total = 0;
                                            $grand_total = 0;
                                            $i = 1;
                                            foreach ($this->data['MaterialAdditionalSale']['MaterialAdditionalSaleDetail'] as $details) {
                                                $total = $details['quantity'] * $details['price'];
                                                $grand_total += $total;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $i ?></td>
                                                    <td>
                                                        <?= $details['MaterialAdditional']['name'] . " " . $details['MaterialAdditional']['size'] ?>
                                                    </td>      
                                                    <td class = "text-right">
                                                        <?= ic_kg($details['quantity']) ?>
                                                    </td>
                                                    <td class="text-right" style= "width:50px; border-left-style:none;">
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
                                                        <?= ic_rupiah($total) ?>
                                                    </td>   
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" align="right">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-center" style= "width:50px; border-right-style:none;"> 
                                                    Rp.
                                                </td>
                                                <td class="text-right auto-calculate-grand-total" style="border-left-style:none;">
                                                    <?= ic_rupiah($grand_total) ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                                
    </div>                                
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>