<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">LIHAT DATA BARANG KOPERASI - <?= $this->data["CooperativeGoodList"]["name"] ?></h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">LIHAT DATA BARANG KOPERASI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-pills nav-justified">                   
                    <li class="active"><a href="#tab-main" data-toggle="tab"><i class="icon-file6"></i> Data Barang</a></li>
                    <li><a href="#tab-detail" data-toggle="tab"><i class="icon-coin"></i> Rincian Modal</a></li>
                </ul>
                <div class="tab-content pill-content">
                    <div class="tab-pane fade in active" id="tab-main">
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeGoodList.code", __("Kode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeGoodList.code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "code"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeGoodList.barcode", __("Barcode Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeGoodList.barcode", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "barcode"));
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
                                                echo $this->Form->label("CooperativeGoodList.name", __("Nama Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeGoodList.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "id" => "goodName"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("GoodType.name", __("Kategori Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("GoodType.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Harga Rata-Rata Modal</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>Rp.</strong></span>
                                                        <input type="text" class="form-control text-right isdecimal" value="<?= $this->Html->dotNumberSeperator($this->data["CooperativeGoodList"]["average_capital_price"]) ?>" disabled id="modal">
                                                        <span class="input-group-addon"><strong>,00.</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Harga Jual</label>
                                                </div>
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>Rp.</strong></span>
                                                        <input type="text" class="form-control text-right isdecimal" value="<?= $this->Html->dotNumberSeperator($this->data["CooperativeGoodList"]["sale_price"]) ?>" disabled id="jual">
                                                        <span class="input-group-addon"><strong>,00.</strong></span>
                                                    </div>
                                                </div>
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
                                                echo $this->Form->label("CooperativeGoodList.stock_number", __("Stok"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeGoodList.stock_number", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control text-right", "disabled", "id" => "stock"));
                                                ?>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CooperativeGoodListUnit.name", __("Satuan Barang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("CooperativeGoodListUnit.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>                               
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group" >
                                        <div class="text-center">
                                            <b>Keterangan</b>
                                        </div>
                                        <hr/>    
                                        <div id="note" style="padding:0 15px">
                                            <?= $this->data["CooperativeGoodList"]["note"] ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-detail">
                        <table width="100%" class="table table-hover stn-table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th colspan="2">Harga</th>
                                    <th colspan = "2">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $cooperativeGoodListDetails = $this->data["CooperativeGoodListDetail"];
                                array_multisort(array_column($cooperativeGoodListDetails, "capital_price"), SORT_ASC, $cooperativeGoodListDetails);
                                foreach ($cooperativeGoodListDetails as $k => $cooperativeGoodListDetail) {
                                    $total+=$cooperativeGoodListDetail["stock_number"];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $k + 1 ?></td>
                                        <td class="text-right" width="50" style="border-right:none !important">Rp.</td>
                                        <td class="text-right" style="border-left:none !important"><?= $this->Html->Rp($cooperativeGoodListDetail["capital_price"]) ?></td>
                                        <td class="text-right" style = "border-right-style:none !important"><?= $this->Html->dotNumberSeperator($cooperativeGoodListDetail["stock_number"]) ?></td>
                                        <td class="text-right" style = "border-left-style:none !important" width = "75"><?= $cooperativeGoodListDetail["CooperativeGoodList"]["CooperativeGoodListUnit"]['name'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><b>Total</b></td>
                                    <td class="text-right" style = "border-right-style:none !important"><b><?= $this->Html->dotNumberSeperator($total) ?></b></td>
                                    <td class="text-right" style = "border-left-style:none !important" width = "75"><b><?= $this->data["CooperativeGoodListUnit"]['name'] ?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>                             
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>