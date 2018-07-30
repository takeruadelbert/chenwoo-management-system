<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/cooperative-loan-interest");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA SETUP BUNGA PINJAMAN") ?>
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
                    <a href="<?= Router::url("/admin/{$this->params['controller']}/add", true) ?>">
                        <button class="btn btn-xs btn-success" type="button">
                            <i class="icon-file-plus"></i>
                            <?= __("Tambah Data") ?>
                        </button>
                    </a>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="50"><input type="checkbox" class="styled checkall"/></th>
                            <th width="50">No</th>
                            <th><?= __("Tipe Pinjaman") ?></th>
                            <th width="150"><?= __("Bunga") ?></th>
                            <th width="350"><?= __("Range Pinjaman") ?></th>
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
                                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['CooperativeLoanType']['name'] ?></td>
                                    <td class="text-right"><?= $item['CooperativeLoanInterest']['interest'] ?>%</td>
                                    <td class="text-left"><?= $this->Html->IDR($item['CooperativeLoanInterest']['bottom_limit']) . " s/d " . $this->Html->IDR($item['CooperativeLoanInterest']['upper_limit']) ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-type-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
                                        <a href="<?= Router::url("/admin/{$this->params['controller']}/edit/{$item[Inflector::classify($this->params['controller'])]['id']}") ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="Ubah"><i class="icon-pencil"></i></button></a>
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

<div id="default-lihatdata" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM</h4>
            </div>
            <!-- New invoice template -->
            <div class="panel form-horizontal">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr">DATA SETUP BUNGA PINJAMAN
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <!-- Justified pills -->
                    <div class="well block">                        
                        <table width="100%" class="table table-hover">
                            <tr>
                                <td colspan="3" style="width:200px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-md-4 control-label">
                                                    <label>Tipe Pinjaman</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control text-left" name="data[CooperativeLoanType][name]" id="tipe" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-3 col-md-4 control-label">
                                                    <label>Bunga</label>
                                                </div>                                            
                                                <div class="col-sm-9 col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right" name="data[CooperativeLoanInterest][interest]" id="interest" disabled>
                                                        <span class="input-group-addon"><strong>%</strong></span>
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
                                                <div class="col-md-4 control-label">
                                                    <label>Minimal Pinjaman</label>
                                                </div>                                            
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>Rp.</strong></span>
                                                        <input type="text" class="form-control text-right" name="data[CooperativeLoanInterest][bottom_limit]" id="bottomLimit" disabled>
                                                        <span class="input-group-addon"><strong>,00.</strong></span>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-md-4 control-label">
                                                    <label>Maksimal Pinjaman</label>
                                                </div>                                            
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>Rp.</strong></span>
                                                        <input type="text" class="form-control text-right" name="data[CooperativeLoanInterest][upper_limit]" id="upperLimit" disabled>
                                                        <span class="input-group-addon"><strong>,00.</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
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
        $(".viewData").click(function () {
            var typeId = $(this).data("type-id");
            $.ajax({
                url: BASE_URL + "cooperative_loan_interests/view_loan_interest/" + typeId,
                type: "GET",
                dataType: "JSON",
                data: {},
                success: function (data) {
                    $("#bottomLimit").val(IDR(data.CooperativeLoanInterest.bottom_limit));
                    $("#interest").val(data.CooperativeLoanInterest.interest);
                    $("#upperLimit").val(IDR(data.CooperativeLoanInterest.upper_limit));
                    $("#tipe").val(IDR(data.CooperativeLoanType.name));
                }
            })
        });
    });
</script>