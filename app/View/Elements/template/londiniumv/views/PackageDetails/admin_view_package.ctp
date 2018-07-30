<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Detail Pengepakan yang sudah Dilakukan per Penjualan") ?>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>

        <div class="table-responsive stn-table">
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-file"></i><?= __("Data Penjualan") ?></h6>
            </div> 
            <table width="100%" class="table table-hover" id="transactionList">
                <tr>
                    <td>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Sale.po_number", __("Nomor PO"), array("class" => "col-md-2 control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $sale['Sale']['po_number'], "disabled"));
                            ?>
                            <?php
                            echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-md-2  control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $sale['Sale']['sale_no'], "disabled"));
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Sale.po_date", __("Tanggal PO"), array("class" => "col-md-2 control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("Sale.po_date", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $this->Html->cvtTanggal($sale['Sale']['created'],false), "disabled"));
                            ?>
                            <?php
                            echo $this->Form->label("Sale.po_number", __("Pembeli"), array("class" => "col-md-2  control-label", "style" => "padding-top:10px;"));
                            echo $this->Form->input("Sale.po_number", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "value" => $sale['Buyer']['company_name'], "disabled"));
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <br/>
            <div class="panel-heading" style="background:#2179cc">
                <h6 class="panel-title" style=" color:#fff"><i class="icon-box-remove"></i><?= __("Detail Penjualan") ?></h6>
            </div>
            <?php
            if ($sale['Buyer']['buyer_type_id'] == 2) {
                ?>
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th><?= __("Produk") ?></th>
                            <th><?= __("Kode Produk") ?></th>
                            <th><?= __("Jumlah Produk (MC)") ?></th>
                            <th><?= __("Isi Per MC (Lbs)") ?></th>
                            <th><?= __("Jumlah (Lbs)") ?></th>
                            <th><?= __("Jumlah (Kg)") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($sale['SaleDetail'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($sale['SaleDetail'] as $n => $item) {
                                ?>
                                <tr>
                                    <td class = "text-center"> <?= $n + 1 ?></td>
                                    <td>
                                        <?= $item['Product']['Parent']['name'] . " - " . $item['Product']['name'] ?>
                                    </td> 
                                    <td>
                                        <?= $item['item_code'] ?>
                                    </td> 
                                    <td class="text-right">        
                                        <?= ic_decimalseperator($item['quantity'], 0) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= ac_lbs($item['McWeight']['lbs']) ?>
                                    </td> 
                                    <td class="text-right">
                                        <?= ac_lbs($item['McWeight']['lbs'] * $item['quantity']) ?>
                                    </td> 
                                    <td class="text-right">
                                        <?= ic_kg($item['nett_weight']) ?>
                                    </td> 
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else if ($sale['Buyer']['buyer_type_id'] == 1) {
                ?>
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Produk</th>
                            <th width="250">Kode Produk</th>
                            <th width="200">Isi Per MC</th>
                            <th width="200">Total Berat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'][0]['Sale']['SaleDetail'] as $item) {
                                ?>
                                <tr>
                                    <td class = "text-center"> <?= $i ?></td>
                                    <td>
                                        <input class='form-control text-left' value="<?= $item['Product']['Parent']['name'] . " - " . $item['Product']['name'] ?>" readonly>
                                    </td> 
                                    <td>
                                        <input class='form-control text-center' value="<?= $item['item_code'] ?>" readonly>
                                    </td> 
                                    <td>
                                        <div class="input-group">            
                                            <input class='form-control text-right' value="<?= $item['McWeight']['lbs'] ?>" readonly>
                                            <span class="input-group-addon"><strong>Lbs</strong></span>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="input-group">            
                                            <input class='form-control text-right' value="<?= $item['nett_weight'] ?>" readonly>
                                            <span class="input-group-addon"><strong>Kg</strong></span>
                                        </div>
                                    </td> 
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <br/>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <div class="panel-heading" style="background:#2179cc">
                    <h6 class="panel-title" style=" color:#fff"><i class="icon-box-add"></i><?= __("Detail Pengepakan yang sudah Dilakukan") ?></h6>
                </div>
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nomor MC") ?></th>
                            <th><?= __("Nama Produk") ?></th>
                            <th><?= __("PDC") ?></th>
                            <th colspan="2"><?= __("Berat Bersih") ?></th>
                            <th colspan="2"><?= __("Berat Kotor") ?></th>
                            <th colspan="2"><?= __("Jumlah Kemasan") ?></th>
                            <th><?= __("Tanggal Dibuat") ?></th>
                            <th width="80"><?= __("Loaded?") ?></th>
                            <th width="50"><?= __("Aksi") ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['rows'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item["PackageDetail"]['id']; ?>">
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?php echo $item['PackageDetail']['package_no']; ?></span></td>
                                    <?php if (!empty($item['Product']['Parent'])) {
                                        ?>
                                        <td class="text-center"><span><?php echo $item['Product']['Parent']['name'] . " " . $item['Product']['name']; ?></span></td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center"><span><?php echo $item['Product']['name'] ?></span></td>
                                        <?php
                                    }
                                    ?>

                                    <td class="text-left">
                                        <?php
                                        foreach ($item['PackageDetailProduct'] as $itemss) {
                                            ?>
                                            <?php echo $itemss['ProductDetail']['batch_number'] . "<br> "; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['nett_weight']); ?> </span></td>
                                    <td class="text-center" width = "30"><span>Kg</span></td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['brut_weight']); ?> </span></td>
                                    <td class="text-center" width = "30"><span>Kg</span></td>
                                    <td class="text-center"><span><?php echo emptyToStrip($item['PackageDetail']['quantity_per_pack']); ?> </span></td>
                                    <td class="text-center" width = "40"><span>Pcs</span></td>
                                    <td class="text-center">
                                        <?php
                                        if ($item["PackageDetail"]['is_filled'] == 1) {
                                            echo $this->Html->cvtTanggal($item["PackageDetail"]['modified']);
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td> 
                                    <td class="text-center">
                                        <?php
                                        if ($item["PackageDetail"]['is_load'] == 1) {
                                            echo "Ya";
                                        } else {
                                            echo "Belum";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a target = "_blank" href = "<?= Router::url("/admin/{$this->params['controller']}/print_trackcode/{$item[Inflector::classify($this->params['controller'])]['id']} ", true) ?>" class = "btn btn-default btn-xs btn-icon btn-icon tip" title = "Cetak Track Code"><i class = "icon-print2"></i></a>
                                    </td> 
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>