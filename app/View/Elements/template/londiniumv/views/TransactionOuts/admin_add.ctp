<?php echo $this->Form->create("TransactionOut", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tab-pane active fade in" id="data-utama">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr"><?= __("Transaksi Barang Keluar") ?>
                </h6>
            </div>
            <div id="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-sm-3 col-md-4 control-label">
                                <label>Nomor Pemesanan</label>
                            </div>
                            <div class="has-feedback">
                                <div class="col-sm-9 col-md-8">                                                
                                    <input type="text" class="form-control typeahead-ajax-purchase" placeholder="Cari Nomor Pemesanan ...">
                                    <i class="icon-search3 form-control-feedback"></i>
                                    <input type="hidden" name="data[TransactionOut][purchase_id]" id="purchase">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div id="">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("TransactionOut.shipment_id", __("Data Pengiriman"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("TransactionOut.shipment_id", array("div" => array("class" => "col-md-2"), "empty" => "- Pilih Data Pengiriman -", "label" => false, "class" => "select-full"));
                    ?>
                    <?php
                    echo $this->Form->label("TransactionOut.shipment_agent_id", __("Agen Pengiriman"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("TransactionOut.shipment_agent_id", array("div" => array("class" => "col-md-2"), "empty" => "- Pilih Agen -", "label" => false, "class" => "select-full"));
                    ?>
                    <?php
                    echo $this->Form->label("TransactionOut.container_id", __("Kontainer Pengiriman"), array("class" => "col-md-2 control-label"));
                    echo $this->Form->input("TransactionOut.container_id", array("div" => array("class" => "col-md-2"), "empty" => "- Pilih Container -", "label" => false, "class" => "select-full"));
                    ?>
                </div>    
            </div>
            <div>
                <table width="100%" class="table table-hover">
                    <thead>
                        <tr>
                            <td align="center" valign="middle" width="5%">No</td>
                            <td align="center" valign="middle" width="40%">Nomor Paket</td>
                            <td align="center" valign="middle" width="40%">Harga </td>
                            <td align="center" valign="middle" width="10%">Aksi</td>
                        </tr>
                    </thead>
                    <tbody id="target-material-data">

                    </tbody>
                    <tfoot>
                        <tr>
                        <tr>
                            <td colspan="8">
                                <a class="text-success firstrunclick"  href="javascript:void(false)" onclick="addThisRow(this,'material-data','')" data-n="0"><i class="icon-plus-circle"></i></a>
                            </td>
                        </tr>
                    <td colspan="2" align="right">
                        <strong>Grand Total</strong>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" id="grandtotal" name="data[TransactionOut][total]"readonly >
                            <span class="input-group-addon">,00.</span>
                        </div>
                    </td>
                    </tfoot>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    var count=0;
    var data_package = [];
    var data_package_total = [];
    var temp_total=0;
    $(document).ready(function () {
        $.ajax({
            url: BASE_URL + "admin/packages/get_all_package",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for(i=0;i<data.length;i++){
                    for(j=0;j<data[i]['PackageDetail'].length;j++){
                        //alert(data[i]['PackageDetail'][j]['ProductData']['ProductSize']['price']);
                        temp_total+= parseInt(data[i]['PackageDetail'][j]['ProductData']['ProductSize']['price']);
                        if(j==data[i]['PackageDetail'].length-1){
                            data_package.push({no:data[i]['Package']['id'],label:data[i]['Package']['package_no'],total:temp_total});
                        }
                        //data_package_total.push();
                    }
                    if(i==data.length-1){
                        addThisRow(".firstrunclick", 'material-data', '');
                    }
                    temp_total=0;
                }
            }
        });
        
        /* Cari No Pemesanan */
        var purchase = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('no'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/purchases/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/purchases/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        purchase.clearPrefetchCache();
        purchase.initialize(true);
        $('input.typeahead-ajax-purchase').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'purchase',
            display: 'no',
            source: purchase.ttAdapter(),
            templates: {
                header: '<center><h5>Data Pembelian</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> No Pembelian : ' + data.no + '<br/> Pembeli : ' + data.buyer +'</p>';
                },
                empty: [
                    '<center><h5>Data Pembelian</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-purchase').bind('typeahead:select', function (ev, suggestion) {
            $("#purchase").val(suggestion.id);
        });
    });
    function addPackage(){
        var list_packages = "<select name='data[TransactionMaterialOut]["+count+"][package_id]' class='form-control' id='TransactionOut"+count+"ProductSizeId' onchange='getPrice(this)'>";
        list_packages += "<option value='0'>-Pilih Paket -</option>";
        for(i=0;i<data_package_no.length;i++){
            list_packages += "<option value='"+data_package_no[i]+"'>"+data_package_nama[i]+"</option>";
        }
        list_packages+= "</select>";
        $("#packageList").append("<div class='form-group'><label for='TransactionOutMaterial[" + count + "]id' class='col-md-2 control-label'>Nomor Paket "+count+"</label><div class='col-md-2'>"+list_packages+"</div><label for='TransactionOutMaterial[" + count + "]id' class='col-md-2 control-label'>Harga Produk "+count+"</label><div class='col-md-2'><input type='input' name='data[TransactionMaterialOut][" + count + "][price]' class='form-control' id='TransactionMaterialOut" + count + "Price'/></div></div>");
        count++;
    }
    
    function getPrice(index){
        var id = index.id;
        //var count = id.charAt(14);
        var price = data_package[index.value]['total'];
        $("#TransactionMaterialOut"+(count-1)+"Price").val(price);
        updateTotal();
        //alert(index);
    }
    
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        count--;
        fixNumber(tbody);
        updateTotal();
    }
    
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            $(this).find(".qtyPrice").attr("id","TransactionMaterialOuts"+i+"Price");
            i++;
        })
    }

    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-'+t).html();
        Mustache.parse(template);
//        var list_produk = products;
//        var list_produk_size = productSizes;
        var options = {i: 2, n: n, data_package: data_package};
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
    
    function listenerProduk(e, n) {
    }
    
    String.prototype.replaceAll = function (find, replace) {
        var str = this;
        return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
    };
    
    function updateTotal(){
        var total = 0;
        $('input.TotalPrice').each(function () {
            $thisGrandTotalDebt = String($(this).val());
            total += parseInt($thisGrandTotalDebt.replaceAll('.', ''));
        });
        $("input.auto-calculate-grand-total-produk-data").val(total);
    }
</script>
<script type="x-tmpl-mustache" id="tmpl-material-data">
    <tr class="dynamic-row">
        <td class="text-center nomorIdx">{{n}}</td>
        <td class="text-center">{{list_materials}}
        <select name='data[TransactionMaterialOut][{{n}}][package_id]' onchange='getPrice(this)' class='select-full' id='TransactionOut1PackageId'>
        <option value='0'>-Pilih Paket-</option>
        {{#data_package}}
        <option value="{{no}}">{{label}}</option>
        {{/data_package}}
        </select>
        </td>
        <td class="text-center"><input type='input' name='data[TransactionMaterialOut][{{n}}][price]' class='form-control TotalPrice' id='TransactionMaterialOut{{n}}Price' readonly/></td>    
        <td align="center">
        <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
        <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
        <i class="icon-remove3"></i>
        </button>
        </a>
        </td>    
    </tr>
</script>
<?php echo $this->Form->end() ?>
