<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/box");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("Pengepakan") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i> 
                        <?= __("Cetak") ?>
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Nomor Pengepakan") ?></th>
                            <th><?= __("Berat Kotak") ?></th>
                            <th><?= __("Tanggal") ?></th>
                            <th width="100"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item['Box']['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item["Box"]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><span class="isQRcode"><?php echo $item['Box']['box_no']; ?></span></td>
                                    <td class="text-center"><span><?php echo $item['Box']['total_weight']; ?> Kg</span></td>
                                    <td class="text-center"><?php echo $this->Html->cvtTanggalWaktu($item["Box"]['created']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/print_qr_code/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Print QRCode"><i class="icon-print2"></i></button></a>
                                        <a data-toggle="modal" data-box-id="<?= $item["Box"]['id'] ?>" role="button" href="#default-lihatpackage" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <?php //$this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/view", ["editUrl" => Router::url("/admin/{$this->params['controller']}/view/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
                                        <?php //$this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete", ["editUrl" => Router::url("/admin/{$this->params['controller']}/delete/{$item[Inflector::classify($this->params['controller'])]['id']}")]) ?>
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

<div id="default-lihatpackage" class="modal fade" tabindex="-1" role="dialog">
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
                        <h6 class="heading-hr">LIHAT DATA PENGEPAKAN
                            <small class="display-block">PT. iLugroup Multimedia Indonesia</small>
                        </h6>
                    </div>                               
                    <div class="well block">
                        <div class="form-group">
                            <?php
                            echo $this->Form->label("Sale.sale_no", __("Nomor Penjualan"), array("class" => "col-md-2 control-label", "style" => "padding-top:10px !important;"));
                            echo $this->Form->input("Sale.sale_no", array("div" => array("class" => "col-md-4"), "label" => false, "class" => "form-control", "id" => "saleId", "readonly"));
                            ?>
                        </div>
                        <br/>
                        <br/>
                        <div class="table-responsive stn-table">
                            <div class="panel-heading" style="background:#2179cc">
                                <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Produk yang dipaketkan") ?></h6>
                            </div>
                            <br>
                            <table width="100%" class="table table-hover table-bordered">
                                <thead>
                                <th width="1%" style="text-align: center;">No</th>
                                <th width="30%" style="text-align: center;">Nama Paket</th>
                                <th width="30%" style="text-align: center;">Berat Paket</th>
                                </thead>
                                <tbody id="target-income">
                                    <tr class="dynamic-row-pendapatan hidden" data-n="0">
                                    </tr>
                                </tbody>
<!--                                <tfoot>
                                    <tr>
                                    <tr align="right">
                                        <td colspan="2">Total</td>
                                        <td>
                                            <span class="input-group" style="">
                                                <input type="text" class="form-control text-right auto-calculate-grand-total-produk-data" name="data[Box][total_weight]"readonly>
                                                <span class="input-group-addon">KG</span>
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function () {
        $('.viewData').click(function () {
            $("tr.dynamic-row-pendapatan").html("");
            var boxId = $(this).data("box-id");
            var e = $("tr.dynamic-row-pendapatan");
            fixNumberPendapatan(e.parents("tbody"));
            var totalPendapatan = 0;
            var totalPotongan = 0;
            $.ajax({
                url: BASE_URL + "/boxes/view_data_boxes/" + boxId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    // Data Gaji Pegawai
                    $('#saleId').val(data.Sale.sale_no);

                    // Data Pendapatan dan Pemotongan
                    var emp = data.BoxDetail;
                    var i = 1;
                    var j = 1;
                    $.each(emp, function (index, value) {
                        var parameter = value.PackageDetail.package_no;
                        var weight = value.PackageDetail.weight;
                        var n = e.data("n");
                        var template = $('#tmpl-income').html();
                        Mustache.parse(template);
                        var options = {
                            i: i,
                            n: n,
                            parameter: parameter,
                            weight: weight,
                        };
                        i++;
                        var rendered = Mustache.render(template, options);
                        $('#target-income tr.dynamic-row-pendapatan:last').after(rendered);
                        e.data("n", n + 1);
                    });
                }
            });
        });
    });

    function fixNumberPendapatan(e) {
        var i = 1;
        $.each(e.find("tr.dynamic-row-pendapatan").not(".hidden"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-income">
    <tr class="dynamic-row-pendapatan">
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    <input name="data[ParameterEmployeeSalary][{{n}}][ParameterSalary][name]" class="form-control" value="{{parameter}}" readonly>                                
    </td>
    <td>
    <div class="input-group">
    <input name="data[ParameterEmployeeSalary][{{n}}][nominal]" class="form-control text-right Nominal" value="{{weight}}" readonly>
    <span class="input-group-addon">Kg</span>
    </div>
    </td>
    </tr>
</script>
