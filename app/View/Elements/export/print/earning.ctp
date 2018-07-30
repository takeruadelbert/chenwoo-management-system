<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Slip Gaji
    </div>
    <br>
    <table width="100%" class="table table-bordered" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
        <tbody>
            <tr>

                <td width="15%"><?= __("Nama Pegawai") ?></td>
                <td width="1%" align="center" valign="middle">:</td>
                <td width="34%"><?= $this->Session->read("credential.admin.Biodata.full_name"); ?></td>
                <td width="15%"><?= __("Department") ?></td>
                <td width="1%" align="center">:</td>
                <td width="34%"><?= $this->Session->read("credential.admin.Employee.Department.name"); ?></td>
            </tr>
            <tr>
                <td><?= __("Jabatan") ?></td>
                <td align="center" valign="middle">:</td>
                <td><?= $this->Session->read("credential.admin.Employee.Office.name"); ?></td>
                <td><?= __("Periode Laporan") ?></td>
                <td align="center">:</td>
                <td>
                    <?php
                    if (isset($this->request->query["awalint_EmployeeSalary_month_period"]) && isset($this->request->query["akhirint_EmployeeSalary_month_period"]) && isset($this->request->query["awalint_EmployeeSalary_year_period"]) && isset($this->request->query["akhirint_EmployeeSalary_year_period"])) {
                        echo date('F Y', strtotime($this->request->query["awalint_EmployeeSalary_year_period"] . "-" . $this->request->query["awalint_EmployeeSalary_month_period"] . "-01")) . " s/d " . date('F Y', strtotime($this->request->query["akhirint_EmployeeSalary_year_period"] . "-" . $this->request->query["akhirint_EmployeeSalary_month_period"] . "-01"));
                    } else {
                        echo date('F Y', strtotime(date("Y-m-01")));
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%" class="table-data">
        <thead>
            <tr height="50px">
                <th class="text-center" width="1%" align="center" valign="middle" bgcolor="#FFFFCC">No</th>
                <th class="text-center" width="3%" bgcolor="#FFFFCC"><?= __("Bulan") ?></th>
                <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Jumlah Pendapatan") ?></th>
                <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Jumlah Potongan") ?></th>
                <th class="text-center" colspan="2" bgcolor="#FFFFCC"><?= __("Gaji Diterima") ?></th>
                <th class="text-center" bgcolor="#FFFFCC"><?= __("Divalidasi") ?></th>
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
                    <td class = "text-center" colspan = 7>Tidak Ada Data</td>
                </tr>
                <?php
            } else {
                foreach ($data['rows'] as $item) {
                    ?>
                    <tr id="row-<?= $i ?>" class="removeRow<?php echo $item[Inflector::classify($this->params['controller'])]['id']; ?>">
                        <td class="text-center" width="1%" align="center" valign="middle"><?= $i ?></td>
                        <td class="text-center"><?= $this->Html->cvtTanggal($item['EmployeeSalary']['start_date_period'], false) ?> - <?= $this->Html->cvtTanggal($item['EmployeeSalary']['end_date_period'], false) ?></td>
                        <?php
                        $totalIncome = 0;
                        $totalDebt = 0;
                        foreach ($item['ParameterEmployeeSalary'] as $value) {
                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '1') {
                                $totalIncome += $value['nominal'];
                            }
                            if ($value['ParameterSalary']['parameter_salary_type_id'] === '2') {
                                $totalDebt += $value['nominal'];
                            }
                        }
                        ?>
                        <td class="text-center" width="1%" align="center" valign="middle" width = "50">Rp.</td>
                        <td class="text-center" width="3%" align="center" valign="middle" width = "150"><?= $this->Html->IDR($totalIncome); ?></td>
                        <td class="text-center" width="1%" align="center" valign="middle" width = "50">Rp.</td>
                        <td class="text-center" width="3%" align="center" valign="middle" width = "150"><?= $this->Html->IDR($totalDebt * -1); ?></td>
                        <td class="text-center" width="1%" align="center" valign="middle" width = "50"><strong>Rp.</strong></td>
                        <td class="text-center" width="3%" align="center" valign="middle" width = "150"><strong><?= $this->Html->IDR(($totalIncome + $totalDebt)); ?></strong></td>
                        <td width="10%" align="center" valign="middle">
                            <?php
                            if ($item['ValidateBy']['id'] === null) {
                                ?>
                                <strong>-</strong>
                                <?php
                            } else {
                                ?>
                                <strong>di Validasi Oleh <?= $item['ValidateBy']['Account']['Biodata']['full_name']; ?><br><?= $this->Html->cvtTanggalWaktu($item['EmployeeSalary']['validate_datetime']); ?></strong>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>