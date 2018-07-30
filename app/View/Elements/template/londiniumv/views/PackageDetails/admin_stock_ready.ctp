<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/package_stock_ready");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Stok Produk Siap Jual") ?>
                <div class="pull-right">
                    <a target="_blank" href="<?= Router::url("/admin/package_details/set_sale_package") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Set Paket Penjualan"><i class="icon-marker">Set Penjualan Paket</i></button></a>
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?= __("Nama") ?></th>
                            <?php
                            if ($stnAdmin->branchPrivilege()) {
                                ?>
                                <th><?= __("Cabang") ?></th>
                                <?php
                            }
                            ?>
                            <th><?= __("Satuan") ?></th>
                            <th><?= __("Jumlah Ketersediaan") ?></th>
                            <th width="50"><?= __("Aksi") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $arrayProduct = [];
                        $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                        $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                        $i = ($limit * $page) - ($limit - 1);
                        if (empty($data['dataProducts'])) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
//                            foreach ($data['dataProducts'] as $item) {
//                                if($arrayProduct==null){
//                                        array_push($arrayProduct,['id'=>$item['PackageDetail']['id'],'id_product'=>$item['Product']['id'],'package_no'=>$item['PackageDetail']['package_no'],'label'=>$item['Product']['Parent']['name']." ".$item['Product']['name'],'productUnit'=>$item['Product']['ProductUnit']['name'],'count'=>1]);
//                                }else{
//                                    for($i=0;$i<count($arrayProduct);$i++){
//                                        if($arrayProduct[$i]['id_product']==$item['Product']['id']){
//                                            $tempCount = $arrayProduct[$i]['count'];
//                                            $arrayProduct[$i]['count'] = $tempCount+1;
//                                            $i=count($arrayProduct)+1;
//                                        }
//                                        if($i==count($arrayProduct)-1){
//                                            array_push($arrayProduct,['id'=>$item['PackageDetail']['id'],'id_product'=>$item['Product']['id'],'package_no'=>$item['PackageDetail']['package_no'],'label'=>$item['Product']['Parent']['name']." ".$item['Product']['name'],'productUnit'=>$item['Product']['ProductUnit']['name'],'count'=>1]);
//                                        }
//                                    }
//                                }
//                            }
                            $no = 1;
                            $total = 0;
                            foreach ($data['dataProducts'] as $item) {
                                $total+=$item[0]['count'];
                                ?>
                                <tr id="row-<?= $no ?>">
                                    <td class="text-center"><?= $no ?></td>
                                    <td><?php
                                        if ($item['Product']['id'] != null) {
                                            echo $item['Product']['name'] . " " . $item['Product']['Parent']['name'];
                                        } else {
                                            echo "Belum Terdefinisi";
                                        }
                                        ?></td>
                                    <?php
                                    if ($stnAdmin->branchPrivilege()) {
                                        ?>
                                        <td class="text-left"><?php echo $item["BranchOffice"]['name']; ?></td>
                                        <?php
                                    }
                                    ?>  
                                    <td class="text-center"><?php
                                        if ($item['Product']['id'] != null) {
                                            echo $item['Product']['ProductUnit']['name'];
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                    <td class="text-center"><?php echo $item[0]['count'] . " MC"; ?></td>
                                    <td class="text-center"> 
                                        <!--<a data-toggle="modal" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="" data-original-title="Lihat Paket" data-product-id="<? $item['id_product'] ?>"><i class="icon-eye7"></i></a>-->
                                        <a target="_blank" href="<?= Router::url("/admin/package_details/view_package_product?product_id={$item['Product']['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Lihat Data Paket"><i class="icon-cube"></i></button></a>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                            ?>
                                <tr>
                                    <td colspan="4"></td>
                                    <td class="text-center"><?php echo $total . " MC"; ?></td>
                                    <td></td>
                                </tr>    
                            <?php    
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->element(_TEMPLATE_DIR . "/{$template}/pagination") ?>
</div>
<!-- Default modal -->
<div id="default-view" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">LIHAT DATA STOK PRODUK SIAP JUAL
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user"></i> Data Produk</a></li>
                            </ul>
                            <div class="tab-content pill-content">
                                <div class="tab-pane fade in active" id="justified-pill1">
                                    <table width="100%" class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="11" style="width:200px">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("Dummy.product_id", __("Nama Produk"), array("class" => "col-sm-2 control-label"));
                                                        echo $this->Form->input("Dummy.product_id", array("div" => array("class" => "col-sm-10"), "type" => "text", "label" => false, "class" => "form-control", "disabled"));
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="table-responsive stn-table">
                                            <div class="panel-heading" style="background:#2179cc">
                                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Detail Data Konversi / Nota Timbang") ?></h6>
                                            </div>
                                            <table width="100%" class="table table-hover table-bordered">                        
                                                <thead>
                                                    <tr>
                                                        <th width="50">No</th>
                                                        <th><?= __("Nomor Paket") ?></th>
                                                        <th><?= __("Berat Bersih") ?></th>
                                                        <th><?= __("Berat Kotor") ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="target-installment">
                                                    <tr id="init">
                                                        <td class = "text-center" colspan = 4>Tidak Ada Data</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.viewData').click(function () {
            var productId = $(this).data("product-id");
            $.ajax({
                url: BASE_URL + "admin/package_details/get_package_detail/" + productId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    $('input#DummyProductId').val(data[0].Product.Parent.name + " " + data[0].Product.name);
                    var i = 1;
                    var template = $("#tmpl-package").html();
                    Mustache.parse(template);
                    $("table tr#init").remove();
                    $.each(data, function (index, item) {
                        var options = {
                            i: i,
                            no_package: item.PackageDetail.package_no,
                            nett_weight: item.PackageDetail.nett_weight,
                            brut_weight: item.PackageDetail.brut_weight,
                        };
                        var rendered = Mustache.render(template, options);
                        $('#target-installment').append(rendered);
                        i++;
                    });
                }
            });
        });
    });
</script>
<script type="x-tmpl-mustache" id="tmpl-package">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input type="text" class="form-control" value="{{no_package}}" readonly>
    </td>
    <td>
    <div class="input-group">
    <input type="text" class="form-control text-center" value="{{nett_weight}}" readonly>
    <span class="input-group-addon"> Kg</span>
    </td>
    <td>
    <div class="input-group">
    <input class="form-control text-center" type="text" value = "{{brut_weight}}" readonly>                                    
    <span class="input-group-addon"> Kg</span>
    </div>
    </td>
    </tr>
</script>