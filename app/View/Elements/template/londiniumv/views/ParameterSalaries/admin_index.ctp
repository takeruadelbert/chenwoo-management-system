<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/parameter-salary");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PARAMETER GAJI") ?>
                <div class="pull-right">
                    <button class="btn btn-xs btn-default" title="Print Data" type="button" onclick="exp('print', '<?php echo Router::url("index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-print2"></i>
                        Cetak
                    </button>&nbsp;
                    <button class="btn btn-xs btn-default" title="Ekspor Ke Excel" type="button" onclick="exp('excel', '<?php echo Router::url("index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                        <i class="icon-file-excel"></i>
                        Excel
                    </button>&nbsp;
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/delete") ?>
                    <?= $this->element(_TEMPLATE_DIR . "/{$template}/roleaccess/add") ?>
                </div>
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="table-responsive pre-scrollable stn-table stn-table-nowrap" style="max-height: 550px;">
            <form id="checkboxForm" method="post" name="checkboxForm" action="<?php echo Router::url('/' . $this->params['prefix'] . '/' . $this->params['controller'] . '/multiple_delete', true); ?>">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;"><input type="checkbox" class="styled checkall"/></th>
                            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
                            <th class="text-center" bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Kode") ?></th>
                            <th class="text-center" width="8%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Jenis") ?></th>
                            <th class="text-center" bgcolor="#FFFFCC" style="color: #000;"><?= __("Keterangan") ?></th>
                            <th class="text-center" width="2%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Aksi") ?></th>
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
                                <td class = "text-center" colspan ="7">Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-left"><?= $item['ParameterSalary']['name'] ?></td>
                                    <td class="text-left"><?= $item['ParameterSalary']['code'] ?></td>
                                    <td class="text-left"><?= $item['ParameterSalaryType']['name'] ?></td>
                                    <td class="text-left"><?= emptyToStrip($item['ParameterSalary']['note']) ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-parameter-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-view" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title=""><i class="icon-eye7"></i></a>&nbsp;
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
                        <h6 class="heading-hr">LIHAT DATA PARAMETER GAJI
                            <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-hover">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ParameterSalary.name", __("Nama"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ParameterSalary.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                            <?php
                                            echo $this->Form->label("ParameterSalary.ParameterSalaryType.name", __("Jenis Parameter Gaji"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ParameterSalary.ParameterSalaryType.name", array("div" => array("class" => "col-sm-4"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:200px">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("ParameterSalary.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                            echo $this->Form->input("ParameterSalary.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "form-control", "readonly"));
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
<!-- /default modal -->

<script>
    $(document).ready(function () {
        $('.viewData').click(function () {
            var paramId = $(this).data("parameter-id");
            $.ajax({
                url: BASE_URL + "/parameter_salaries/view_data_parameter/" + paramId,
                dataType: "JSON",
                type: "GET",
                data: {},
                success: function (data) {
                    // Data Parameter Gaji
                    $('input#ParameterSalaryName').val(data.ParameterSalary.name);
                    $('input#ParameterSalaryParameterSalaryTypeName').val(data.ParameterSalaryType.name);
                    $('input#ParameterSalaryUniqName').val(data.ParameterSalary.uniq_name);
                    $('textarea#ParameterSalaryNote').val(data.ParameterSalary.note);
                }
            });
        });
    });
</script>

