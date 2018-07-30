<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">LIHAT DATA TUNJANGAN PEGAWAI</h4>
</div>
<!-- New invoice template -->
<div class="panel form-horizontal">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">LIHAT DATA TUNJANGAN PEGAWAI
                <small class="display-block"><?= _APP_CORPORATE_FULL ?></small>
            </h6>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php
                    echo $this->Form->label("SalaryAllowance.employee_name", __("Nama Pegawai"), array("class" => "col-sm-4 control-label"));
                    echo $this->Form->input("SalaryAllowance.employee_name", array("div" => array("class" => "col-sm-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->data['Employee']['Account']['Biodata']['full_name']));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel-heading" style="background:#2179cc">
            <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Tunjangan") ?></h6>
        </div>
        <table width="100%" class="table table-bordered table-hover">
            <thead>
                <tr bordercolor="#000000">
                    <th width="1%" align="center" valign="middle" class="text-center" bgcolor="#feffc2">No</th>
                    <th align="center" valign="middle" class="text-center" bgcolor="#feffc2"><?= __("Jenis Tunjangan") ?></th>
                    <th class="text-center" width="30%" align="center" valign="middle" bgcolor="#feffc2"><?= __("Nilai Tunjangan") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($this->data['SalaryAllowanceDetail'] as $details) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td><?= $details['ParameterSalary']['name'] ?></td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input class="form-control text-right" type="text" disabled value="<?= ic_rupiah($details['amount']) ?>">
                                <span class="input-group-addon">,00.</span>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>                        
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Form</button>
</div>