<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Simpanan Koperasi
    </div>
    <br>
    <table width="100%" class="table table-bordered" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
        <tbody><tr>

                <td width="15%"><?= __("Nama Pegawai") ?></td>
                <td width="1%" align="center" valign="middle">:</td>
                <td width="34%"><?= $this->Session->read("credential.admin.Biodata.full_name"); ?></td>
                <td width="15%"><?= __("NIP") ?></td>
                <td width="1%" align="center">:</td>
                <td width="34%"><?= $this->Session->read("credential.admin.Employee.nip"); ?></td>
            </tr>
            <tr>
                <td><?= __("Jabatan") ?></td>
                <td align="center" valign="middle">:</td>
                <td><?= $this->Session->read("credential.admin.Employee.Office.name"); ?></td>
                <td><?= __("Department") ?></td>
                <td align="center">:</td>
                <td>
                    <?= $this->Session->read("credential.admin.Employee.Department.name"); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%" class="table-data">
        <thead>
            <tr height="50px">
                <th class="text-center" width="1%" align="center" valign="middle" bgcolor="#FFFFCC">No</th>
                <th class="text-center" width="45%" bgcolor="#FFFFCC" colspan = "2"><?= __("Jumlah Simpanan") ?></th>
                <th class="text-center" width="45%" bgcolor="#FFFFCC"><?= __("Tanggal Simpanan") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
            $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
            $i = ($limit * $page) - ($limit - 1);
            if (empty($dataDeposit)) {
                ?>
                <tr>
                    <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                </tr>
                <?php
            } else {
                ?>
                <tr id="row-<?= $i ?>" class="removeRow<?php echo $dataDeposit[Inflector::classify($this->params['controller'])]['id']; ?>">
                    <td class="text-center" width="1%" align="center" valign="middle"><?= $i ?></td>
                    <td class="text-center" width="1%" align="center" valign="middle" style = "border-right-style:none !important" >Rp. </td>
                    <td class="text-center" width="3%" align="center" valign="middle" style = "border-left-style:none !important" ><?= $this->Html->Rp($dataDeposit['EmployeeDataDeposit']['balance']) ?></td>
                    <td class="text-center" width="3%" align="center" valign="middle"><?= $this->Html->cvtWaktu($dataDeposit['EmployeeDataDeposit']['transaction_date']) ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>