<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/customer");
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr"><?= __("DATA PELANGGAN") ?>
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
                            <th><?= __("Nama Lengkap") ?></th>
                            <th><?= __("Jenis Kelamin") ?></th>
                            <th><?= __("Alamat") ?></th>
                            <th><?= __("Kota") ?></th>
                            <th><?= __("Provinsi") ?></th>
                            <th><?= __("Negara") ?></th>
                            <th><?= __("Phone/Handphone") ?></th>
                            <th><?= __("Email") ?></th>
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
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($data['rows'] as $item) {
                                ?>
                                <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                                    <td class="text-center"><input type="checkbox" name="data[<?php echo Inflector::classify($this->params['controller']) ?>][checkbox][]" value="<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>"  id="checkBoxRow" class="styled checkboxDeleteRow" /></td>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $item['Customer']['full_name'] ?></td>
                                    <td class="text-center"><?= $item['Gender']['name'] ?></td>
                                    <td class="text-center"><?= $item['Customer']['address'] ?></td>
                                    <td class="text-center"><?= $item['Customer']['city'] ?></td>
                                    <td class="text-center"><?= $item['Customer']['state'] ?></td>
                                    <td class="text-center"><?= $item['Customer']['country'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        $phone = "";
                                        $handphone = "";
                                        if(!empty($item['Customer']['phone'])) {
                                            $phone = $item['Customer']['phone'] . " / ";
                                        }
                                        if(!empty($item["Customer"]['handphone'])) {
                                            $handphone = $item['Customer']['handphone'];
                                        }
                                        if(empty($item['Customer']['phone']) && empty($item['Customer']['handphone'])) {
                                            echo "-";
                                        }
                                        echo $phone . $handphone;
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $this->Echo->empty_strip($item['Customer']['email']) ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-customer-id="<?= $item[Inflector::classify($this->params['controller'])]['id'] ?>" role="button" href="#default-lihatdata" class="btn btn-default btn-xs btn-icon btn-icon tip viewData" title="Lihat Data"><i class="icon-eye7"></i></a>
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
                        <h6 class="heading-hr">DATA PELANGGAN
                            <small class="display-block">PT. CHENWOOFISHERY - Fisheries Processing Plant -</small>
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
                                                <?php
                                                echo $this->Form->label("Customer.first_name", __("Nama Depan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.first_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.last_name", __("Nama Belakang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.last_name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.gelar_depan", __("Gelar Depan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.gelar_depan", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.gelar_belakang", __("Gelar Belakang"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.gelar_belakang", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.gender", __("Jenis Kelamin"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.gender", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>                                        
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.country_id", __("Negara"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.country_id", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.state_id", __("Provinsi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.state_id", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.city_id", __("Kota"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.city_id", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.address", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.postal_code", __("Kode Pos"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.postal_code", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.phone", __("Nomor Telepon"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.phone", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("Customer.handphone", __("Nomor Handphone"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.handphone", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
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
                                                echo $this->Form->label("Customer.email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                echo $this->Form->input("Customer.email", array("type" => "email", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                ?>
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
    $(document).ready(function() {
        $(".viewData").click(function() {
           var customerId = $(this).data("customer-id");
           $.ajax({
               url: BASE_URL + "customers/view_data_customer/" + customerId,
               type: "GET",
               dataType: "JSON",
               data: {},
               success: function(data) {
                   $("#CustomerFirstName").val(data.Customer.first_name);
                   $("#CustomerLastName").val(empty_strip(data.Customer.last_name));
                   $("#CustomerGelarDepan").val(empty_strip(data.Customer.gelar_depan));
                   $("#CustomerGelarBelakang").val(empty_strip(data.Customer.gelar_belakang));
                   $("#CustomerGender").val(data.Gender.name);
                   $("#CustomerCountryId").val(data.Customer.country_id);
                   $("#CustomerStateId").val(data.Customer.state_id);
                   $("#CustomerCityId").val(data.Customer.city_id);
                   $("#CustomerAddress").val(data.Customer.address);
                   $("#CustomerPostalCode").val(empty_strip(data.Customer.postal_code));
                   $("#CustomerPhone").val(empty_strip(data.Customer.phone));
                   $("#CustomerHandphone").val(empty_strip(data.Customer.handphone));
                   $("#CustomerEmail").val(empty_strip(data.Customer.email));
               }
           })
        });
    });
</script>