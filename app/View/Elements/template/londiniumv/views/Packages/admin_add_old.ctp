<?php echo $this->Form->create("Package", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Paket") ?>
                    <small class="display-block">Input data <i>Multiple</i> paket! Mohon Isikan Dengan Sesuai dan Benar</small>
                </h6>
            </div>
            <div class="well block">
                <div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->label("Package.sale_id", __("Penjualan"), array("class" => "col-md-3 control-label"));
                        echo $this->Form->input("Package.sale_id", array("div" => array("class" => "col-md-3"), "empty" => "- Pilih Penjualan -", "label" => false, "class" => "select-full","onChange"=>"getDetailPurchase(this)"));
                        ?>
                    </div>
                </div>    
                <div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive stn-table">
                                <div class="panel-heading" style="background:#2179cc">
                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Produk yang dipaketkan") ?></h6>
                                </div>
                                <br>
                                <div id="detailPurchases" class="col-md-12">

                                </div>
                                <table width="100%" class="table table-hover table-bordered">
                                    <thead>
                                        <th width="1%" style="text-align: center;">No</th>
                                        <th width="20%" style="text-align: center;">Nama Produk</th>
                                        <th width="10%" style="text-align: center;">Berat Maksimal Produk</th>
                                        <th width="10%" style="text-align: center;">Jumlah Paket</th>
                                        <th width="10%" style="text-align: center;">Berat Produk yang Diolah</th>
                                        <th width="10%" style="text-align: center;">Berat Produk yang Tersedia</th>
                                        <th width="5%" style="text-align: center;">Aksi</th>
                                    </thead>
                                    <tbody id="target-product-data">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <tr>
                                            <td colspan="8">
                                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this,'product-data','')" data-n="1" id="clickFunction"><i class="icon-plus-circle"></i></a>
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
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger submitButton" data-toggle="modal" data-target="#add" type="button" disabled href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<?php
$listProduct=[];
$listTreatmentProduct=[];
foreach($dataProduct as $product){
    $childs=[];
    foreach($product["Child"] as $child){
        $childs[]=[
            "id"=>$child["id"],
            "label"=>$child["name"],
            "price"=>$child["price"],
        ];
    }
    $listProduct[]=[
        "id"=>$product["Product"]["id"],
        "label"=>$product["Product"]["name"],
        "child"=>$childs,
    ];
}
foreach($dataTreatmentProduct as $treatmentProduct){
    $listTreatmentProduct[]=[
        "id"=>$treatmentProduct["TreatmentDetail"]["id"],
        "label"=>$treatmentProduct["Product"]["name"]." ".$treatmentProduct["Product"]["name"]." - ".date("d/m/Y", strtotime($treatmentProduct['TreatmentDetail']['created'])),
        "price"=>$treatmentProduct["Product"]["price"],
    ];
}
?>
<script>
    var count=1;
    var data_product= <?= json_encode($listTreatmentProduct)?>;
    $(document).ready(function () {
//        $.ajax({
//            url: BASE_URL + "admin/treatment_products/get_all_product",
//            type: "GET",
//            dataType: "JSON",
//            success: function (data) {
//                for(i=0;i<data.length;i++){
//                    data_product.push({no:data[i]['TreatmentProduct']['id'],label:data[i]['TreatmentProduct']['name']});
//                    //data_product_nama.push(data[i]['ProductData']['serial_number']);
//                }
//            }
//        });
        addThisRow(".firstrunclick", 'product-data', '');
    });    
    function getDetailPurchase(purchase){
        var data_purchase = "";
        var buyer = "";
        $.ajax({
            url: BASE_URL + "admin/purchases/get_purchase_list/"+purchase.value,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                buyer = data[0]['Buyer']['company_name'];
                for(i=0;i<data[0]['PurchaseDetail'].length;i++){
                    //alert(data[0]['PurchaseDetail'].length);
                    //data_purchase.push({name:data[0]['PurchaseDetail'][i]['id']});
                    data_purchase+= "<p>"+(i+1)+". "+data[0]['PurchaseDetail'][i]['ProductSize']['Product']['name']+" - "+data[0]['PurchaseDetail'][i]['ProductSize']['name']+" sebanyak "+data[0]['PurchaseDetail'][i]['quantity']+" "+data[0]['PurchaseDetail'][i]['ProductSize']['ProductUnit']['name']+"</p>"   
                    //alert(data_purchase);
                    //$("#detailPurchases").append("<h3 style='margin-top:20px'>Nama Pembeli: "+buyer+"</h3>"+data_purchase);
                };
                $("#detailPurchases").append("<h3 style='margin-top:20px'>Nama Pembeli: "+buyer+"</h3>"+data_purchase);
            }
        });
    }
        
    function addProduct(){
        var list_products = "<select name='data[PackageDetail]["+count+"][product_data_id]' class='form-control' id='PackageData1ProductId'>";
        list_products += "<option value='0'>-Pilih Data Produk-</option>";
        for(i=0;i<data_product_no.length;i++){
            list_products += "<option value='"+data_product_no[i]+"'>"+data_product_nama[i]+"</option>";
        }
        list_products+= "</select>";
        $("#productList").append("<div class='form-group'><label for='PackageDetail[" + count + "]id' class='col-md-2 control-label'>Nama Data Produk "+count+"</label><div class='col-md-4'>"+list_products+"</div></div>");
        count++;
    }
    
    function listenerProduk(e, n) {
    }

    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };

    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        count--;
        //$("input.ParameterEmployeeSalaryNominalDebt").trigger("change");
        fixNumber(tbody);
    }
    
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            //$(this).find(".product_size_id").attr("id","PurchaseDetail"+i+"Price");
            i++;
        })
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-'+t).html();
        Mustache.parse(template);
//        var list_produk = products;
//        var list_produk_size = productSizes;
        var options = {i: 2, n: n, data_product: data_product};
//        if (typeof (optFunc) !== 'undefined') {
//            $.extend(options, window[optFunc]());
//        }
        var rendered = Mustache.render(template, options);
        $('#target-'+t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-'+t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-'+t).find("tr").last(), n);
        count++;
    }
    
    function showDetails(n) {
        document.getElementById("detailPackages"+ n).innerHTML = "";
        var count = parseInt($("input#PackageDetail"+ n+"Qtq").val());
        var productId = parseInt($("input.product_id_package_detail"+n).val());
        var treatmentDetailId = parseInt($("input.treatment_detail_id_package_detail"+n).val());
        var weightPerPackage = parseFloat($("input#Product"+n+"Weight").val());
        $("#detailPackages" + n).append("<div class='panel-heading' style='background:#ff0000'><h6 class='panel-title' style=' color:#fff'><i class='icon-menu2'></i>Rincian Berat Ikan per Paket:</h6></div>");
        for (i = 0; i < count; i++) {
            $("#detailPackages"+n).append("<div class='col-md-2' style='margin:6px auto 6px auto'><div class='input-group'><input type='text' placeholder ='Paket "+(i + 1)+"' class='form-control isDecimal beratTimbangan"+ n + i + "' name='data[PackageDetail]["+n+""+i+"][weight]' id='PackageDetail" + i + "Weight' value='"+weightPerPackage+"' onkeyup='calcTotalWeightPerProduct("+n+")'><span class='input-group-addon'>Kg</span></div><input type='hidden' name='data[PackageDetail]["+n+""+i+"][product_id]' value='"+productId+"'/><input type='hidden' name='data[PackageDetail]["+n+""+i+"][treatment_detail_id]' value='"+treatmentDetailId+"'/></div>");
        }
        $("input#PackageDetail"+n+"WeightProcess").val(count*weightPerPackage);
    }
    
    function getDetailProduk(produk,n){
        $.ajax({
            url: BASE_URL + "admin/products/get_detail_product/"+produk.value,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("input#Product"+n+"Weight").val(data.Product.weight);
                $("input#PackageDetail"+n+"WeightRemaining").val(data.Product.total_weight_stock);
            }
        });
    }
    
    function getDetailTreatmentProduk(detailTreatmentProduct,n){
        $.ajax({
            url: BASE_URL + "admin/treatments/get_detail_treatment_product/"+detailTreatmentProduct.value,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("input#Product"+n+"Weight").val(data.Product.weight);
                $("input#PackageDetail"+n+"WeightRemaining").val(data.TreatmentDetail.remaining_weight);
                $("input.product_id_package_detail"+n).val(data.Product.id)
                $("input.treatment_detail_id_package_detail"+n).val(data.TreatmentDetail.id)
            }
        });
    }
    
    function calcTotalWeightPerProduct(n){
        var count = $("input#PackageDetail"+n+"Qtq").val();
        var maxWeight = $("input#PackageDetail"+n+"WeightRemaining").val();
        var totalWeight = 0;
        for(i=0;i<count;i++){
            if($("input.beratTimbangan"+n+i).val()!=""){
                totalWeight+= parseFloat($("input.beratTimbangan"+n+i).val()); 
            }
        }
        $("input#PackageDetail"+n+"WeightProcess").val(totalWeight);
        if(totalWeight<=maxWeight){
            $(".submitButton").removeAttr("disabled");
            $("#PackageDetail"+n+"WeightProcess").tooltip('hide');
        }else{
             $(".submitButton").attr("disabled", "disabled");
             $("#PackageDetail"+n+"WeightProcess").attr("data-original-title", "Berat Melebihi Persediaan!").tooltip('fixTitle').tooltip('show');
        }
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-product-data">
    <tr class="dynamic-row">
        <td class="text-center nomorIdx">{{n}}</td>
        <td class="text-center">
<!--        <select name='data[PackageDetailTemp][{{n}}][product_id]' class='select-full product_id_package_detail{{n}}' onchange="getDetailProduk(this,{{n}})">
        <option value='0'>-Pilih Produk-</option>
        {{#data_product}}
        <optgroup label="{{label}}">
        {{#child}}
        <option value="{{id}}" data-price="{{price}}" data-id="{{n}}">{{label}}</option>
        {{/child}}
        </optgroup>
        {{/data_product}}
        </select>-->
        <select name='data[PackageDetailTemp][{{n}}][treatment_detail_id]' class='select-full' onchange="getDetailTreatmentProduk(this,{{n}})">
        <option value='0'>-Pilih Produk-</option>
        {{#data_product}}
        <option value="{{id}}">{{label}}</option>
        {{/data_product}}
        </select>  
        <input type="hidden" name='data[PackageDetailTemp][{{n}}][product_id]' class='product_id_package_detail{{n}}' value="0" id="PackageDetailTemp{{n}}ProductId"/>
        <input type="hidden" name='data[PackageDetailTemp][{{n}}][treatment_detail_id]' class='treatment_detail_id_package_detail{{n}}' value="0" id="PackageDetailTemp{{n}}TratmentDetailId"/>
        </td>          
        <td>
            <span class="input-group" style="">
            <input type='text' id='Product{{n}}Weight' name='data[ProductTemp][{{n}}][weight]' class='form-control' readonly/>          
            <span class="input-group-addon">Kg</span>
            </span>
        </td> 
        <td>
            <span class="input-group" style="">
            <input type='text' id='PackageDetail{{n}}Qtq' name='data[PackageDetailTemp][{{n}}][qty]' class='form-control' onkeyup="showDetails({{n}})"/>          
            <span class="input-group-addon">Pcs</span>
            </span>
        </td> 
        <td>
            <span class="input-group" style="">
            <input type='text' id='PackageDetail{{n}}WeightProcess' name='data[PackageDetailTemp][{{n}}][weight_process]'  data-toggle = "tooltip" class='form-control' readonly/>
            <span class="input-group-addon">Kg</span>
            </span>            
        </td>    
        <td>
            <span class="input-group" style="">
            <input type='text' id='PackageDetail{{n}}WeightRemaining' name='data[PackageDetailTemp][{{n}}][weight_remaining]' class='form-control' readonly/>
            <span class="input-group-addon">Kg</span>
            </span>            
        </td>                    
        <td align="center">
        <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
        <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
        <i class="icon-remove3"></i>
        </button>
        </a>
        </td>    
    </tr>
    <tr>
        <td class="material-detail-data-input" id="detailPackages{{n}}" colspan="7"></td>
    </tr>
</script>