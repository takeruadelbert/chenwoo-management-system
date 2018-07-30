<?php echo $this->Form->create("Product", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Tambah Produk") ?>
                </h6>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->label("Product.name", __("Nama"), array("class" => "col-md-3 control-label"));
                echo $this->Form->input("Product.name", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "form-control"));
                ?>
                <?php
                echo $this->Form->label("Product.product_category_id", __("Kategori"), array("class" => "col-md-3 control-label"));
                echo $this->Form->input("Product.product_category_id", array("div" => array("class" => "col-md-3"), "label" => false, "class" => "select-full","empty"=>"- Pilih Produk Category -"));
                ?>
            </div>
            <div id="productDetailList"> 
                <div class="form-group">
                    <?php
                    //echo $this->Form->label("ProductDetail.1.name", __("Nama Produk Detail 1"), array("class" => "col-md-2 control-label"));
                    //echo $this->Form->input("ProductDetail.1.name", array("div" => array("class" => "col-md-2"), "empty" => "- Pilih Produk -", "label" => false, "class" => "form-control"));
                    ?>
                    <?php
                    //echo $this->Form->label("ProductDetail.1.product_unit_id", __("Satuan Produk Detail 1"), array("class" => "col-md-2 control-label"));
                    //echo $this->Form->input("ProductDetail.1.product_unit_id", array("div" => array("class" => "col-md-2"), "label" => false, "class" => "form-control","empty" => "-Pilih Satuan Detail Produk-"));
                    ?>
                    <?php
                    //echo $this->Form->label("ProductDetail.1.price", __("Harga Produk Detail 1"), array("class" => "col-md-2 control-label"));
                    //echo $this->Form->input("ProductDetail.1.price", array("div" => array("class" => "col-md-2"), "label" => false, "class" => "form-control","empty" => "-Pilih Satuan Detail Produk-"));
                    ?>
                </div>
            </div>
            <div>
                <table width="100%" class="table table-hover">
                    <thead>
                        <tr>
                            <td align="center" valign="middle" width="1%">No</td>
                            <td align="center" valign="middle" width="30%">Nama Produk Detail</td>
                            <td align="center" valign="middle" width="20%">Satuan Produk Detail</td>
                            <td align="center" valign="middle" width="20%">Harga Produk Detail</td>
                            <td align="center" valign="middle" width="5%">Aksi</td>
                        </tr>
                    </thead>
                    <tbody id="target-material-data">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this,'material-data','')" data-n="0"><i class="icon-plus-circle"></i></a>
                            </td>
                        </tr>
                </table>
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
                <input type="submit" value="<?= __("Simpan") ?>" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    var count=2;
    var data_produk_unit = [];
    //var data_produk_unit_nama = [];
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + "admin/product_units/get_unit",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for(i=0;i<data.length;i++){
                    data_produk_unit.push({no:data[i]['ProductUnit']['id'],label:data[i]['ProductUnit']['name']});
                    if(i==data.length-1){
                        addThisRow(".firstrunclick",'material-data','')
                    }
                }
            }
        });
    });
//    function addProductDetail(){
//        var list_units = "<select name='data[ProductDetail]["+count+"][product_unit_id]' class='form-control' id='ProductDetail1ProductUnitId'>";
//        list_units += "<option value='0'>-Pilih Satuan Detail Produk-</option>";
//        for(i=0;i<data_produk_unit_no.length;i++){
//            list_units += "<option value='"+data_produk_unit_no[i]+"'>"+data_produk_unit_nama[i]+"</option>";
//        }
//        list_units+= "</select>";
//        $("#productDetailList").append("<div class='form-group'><label for='ProductDetail[" + count + "]id' class='col-md-2 control-label'>Nama Produk Detail "+count+"</label><div class='col-md-2'><input type='text' id='ProductDetailName' name='data[ProductDetail]["+count+"][name]' class='form-control'/></div><label for='ProductDetail[" + count + "]id' class='col-md-2 control-label'>Satuan Detail Produk "+count+"</label><div class='col-md-2'>"+list_units+"</div><label for='ProductDetail[" + count + "]id' class='col-md-2 control-label'>Harga Produk Detail "+count+"</label><div class='col-md-2'><input type='text' id='ProductDetailPrice' name='data[ProductDetail]["+count+"][price]' class='form-control'/></div></div>");
//        count++;
//    }
    
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
        fixNumber(tbody);
    }
    
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-'+t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n, data_produk_unit: data_produk_unit};
        var rendered = Mustache.render(template, options);
        $('#target-'+t).append(rendered);
        $(e).data("n", n + 1);
        fixNumber($('#target-'+t));
        reloadisdecimal();
        reloadSelect2();
        listenerProduk($('#target-'+t).find("tr").last(), n);
        count++;
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row">
        <td class="text-center nomorIdx">{{n}}</td>
        <td><input type='text' id='ProductDetailName' name='data[ProductSize][{{n}}][name]' class='form-control'/></td>    
        <td class="text-center">
        <select name='data[ProductSize][{{n}}][product_unit_id]' class='select-full' id='ProductSizeProductUnitId'>
        <option value='0'>-Pilih Satuan Produk-</option>
        {{#data_produk_unit}}
        <option value="{{no}}">{{label}}</option>
        {{/data_produk_unit}}
        </select>
        </td>
        <td class="text-center"><input type='input' name="data[ProductSize][{{n}}][price]" class='form-control qtyPrice' id="ProductSize{{n}}Price"/></td>      
        <td align="center">
        <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
        <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
        <i class="icon-remove3"></i>
        </button>
        </a>
        </td>    
    </tr>
</script>
