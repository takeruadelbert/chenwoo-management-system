<?php echo $this->Form->create("MaterialAdditionalSale", array("class" => "form-horizontal form-separate", "action" => "view", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <div class="tab-pane active fade in" id="data-utama">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah Penjualan Material Pembantu") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Penjualan Material Pembantu") ?></h6>
                    </div>
                    <table width="100%" class="table table-hover">
                        <tr>
                            <td colspan="11" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.sale_dt", __("Tanggal Penjualan"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.sale_dt", array("type" => "text", "div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control datepicker", "disabled"));
                                    ?>
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.supplier_id", __("Pembeli"), array("class" => "col-md-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.supplier_id", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Supplier -", "disabled"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:200px">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("MaterialAdditionalSale.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                    echo $this->Form->input("MaterialAdditionalSale.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor-fix", "placeholder" => "Enter text ...", "disabled"));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive stn-table">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Material Pembantu yang Dijual") ?></h6>
                    </div>
                    <table width="100%" class="table table-hover table-bordered stn-table">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th width="20%">Nama Barang</th>
                                <th width="20%">Stock</th>
                                <th width="20%">Jumlah</th>
                                <th width="20%">Harga</th>
                                <th width="20%">Total</th>
                            </tr>
                        </thead>
                        <tbody id="target-product-data">
                            <?php
                            $i = 1;
                            $subtotal = 0;
                            $grandTotal = 0;
                            foreach ($this->data['MaterialAdditionalSaleDetail'] as $index => $details) {
                                ?>
                                <tr class="dynamic-row">
                                    <td class="text-center nomorIdx"><?= $i ?></td>
                                    <td class="text-center">
                                        <select id="selectProduct<?= $i ?>" class='select-full product_id selectProduct' onchange="change_unit(<?= $i ?>)" disabled>
                                            <option value=''>-Pilih Material Pembantu-</option>
                                            <?php
                                            $is_selected = "";
                                            foreach ($materialAdditionals as $materials) {
                                                ?>
                                                <optgroup label="<?= $materials['category'] ?>">
                                                    <?php
                                                    if (!empty($materials['child'])) {
                                                        foreach ($materials['child'] as $childs) {
                                                            if ($childs['id'] == $details['material_additional_id']) {
                                                                $is_selected = "selected";
                                                            } else {
                                                                $is_selected = "";
                                                            }
                                                            ?>
                                                            <option value="<?= $childs['id'] ?>" data-unit="<?= $materials['unit_name'] ?>" data-stock="<?= $childs['stock'] ?>" <?= $is_selected ?>><?= $childs['label'] ?></option> 
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </optgroup>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="input-group">
                                            <input type='text' class='form-control text-right' id='stock<?= $i ?>' value="<?= $details['MaterialAdditional']['quantity'] ?>" disabled/>
                                            <span class="input-group-addon" id="unitStock<?= $i ?>"><?= !empty($details['MaterialAdditional']['MaterialAdditionalUnit']['uniq']) ? $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] : "Pcs" ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="input-group">
                                            <input type='text' class='form-control MaterialAdditionalSaleDetail<?= $i ?>Quantity text-right isdecimaldollar' id='quantity<?= $i ?>' value="<?= $details['quantity'] ?>" disabled/>
                                            <span class="input-group-addon" id="unit<?= $i ?>"><?= !empty($details['MaterialAdditional']['MaterialAdditionalUnit']['uniq']) ? $details['MaterialAdditional']['MaterialAdditionalUnit']['uniq'] : "Pcs" ?></span>
                                        </div>        
                                    </td>
                                    <td class="text-center">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>        
                                            <input type='text' class='form-control MaterialAdditionalSaleDetail<?= $i ?>Price qtyPrice text-right isdecimal' value="<?= ic_rupiah($details['price']) ?>" id="price<?= $i ?>" disabled/>
                                        </div>        
                                    </td>  
                                    <td class="text-center">
                                        <?php
                                        $subtotal = $details['quantity'] * $details['price'];
                                        ?>
                                        <div class="input-group">        
                                            <span class="input-group-addon">Rp</span> 
                                            <input type='text' class='form-control text-right subtotal' id="total<?= $i ?>" readonly value="<?= ic_rupiah($subtotal) ?>"/>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $grandTotal += $subtotal;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right">
                                    <strong>Grand Total</strong>
                                </td>
                                <td colspan="1">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" id="grandTotal" readonly value="<?= ic_rupiah($grandTotal) ?>">
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>