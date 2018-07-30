<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Gaji Pegawai Harian
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?= $this->Echo->laporanPeriodeBulan($this->data["EmployeeSalaryPeriod"]["start_dt"], $this->data["EmployeeSalaryPeriod"]["end_dt"]) ?>
    </div>
</div>
<br>
<table width="100%" class="small-font table-data">
    <thead>
        <tr bordercolor="#000000">
            <th width="1%" align="center" valign="middle">No</th>
            <th align="center" valign="middle">Nama Karyawan</th>
            <th align="center" valign="middle">Lembur (Jam)</th>
            <th align="center" valign="middle">Lembur (Rp)</th>
            <th align="center" valign="middle">Lembur (Hari)</th>
            <th align="center" valign="middle">Hari Kerja</th>
            <th align="center" valign="middle">Jumlah Hari Kerja</th>
            <th align="center" valign="middle">Gaji Pokok (Rp)</th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["IWP"] ?></th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKI"] ?></th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["PKS"] ?></th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPH"] ?></th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["LPJ"] ?></th>
            <th align="center" valign="middle">Total Gaji Lembur</th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["GPK"] ?></th>
            <th align="center" valign="middle">Total Gaji</th>
            <th align="center" valign="middle"><?= $mapLabelParameterSalary["PJS"] ?></th>
            <th align="center" valign="middle">Total Diterima</th>
            <th align="center" valign="middle">Tgl Masuk</th>
        </tr>
        <tr style="white-space:nowrap">
            <td class="text-center" style="padding:0 1px"><small>a</small></td>
            <td class="text-center" style="padding:0 1px"><small>b</small></td>
            <td class="text-center"style="padding:0 1px"><small>c</small></td>
            <td class="text-center"style="padding:0 1px"><small>d</small></td>
            <td class="text-center"style="padding:0 1px"><small>e</small></td>
            <td class="text-center"style="padding:0 1px"><small>f</small></td>
            <td class="text-center"style="padding:0 1px"><small>g = (2 x e) + f</small></td>
            <td class="text-center"style="padding:0 1px"><small>h</small></td>
            <td class="text-center"style="padding:0 1px"><small>l</small></td>
            <td class="text-center"style="padding:0 1px"><small>m</small></td>
            <td class="text-center"style="padding:0 1px"><small>n</small></td>
            <td class="text-center"style="padding:0 1px"><small>o = e x (h x 2)</small></td>
            <td class="text-center"style="padding:0 1px"><small>p</small></td>
            <td class="text-center"style="padding:0 1px"><small>q</small></td>
            <td class="text-center"style="padding:0 1px"><small>r</small></td>
            <td class="text-center"style="padding:0 1px"><small>s</small></td>
            <td class="text-center"style="padding:0 1px"><small>t</small></td>
            <td class="text-center"style="padding:0 1px"><small>u</small></td>
            <td class="text-center"style="padding:0 1px"><small>v</small></td>
        </tr>
    </thead>
    <tbody style="white-space:nowrap">
        <?php
        $n = 1;
        $grandTotal = [];
        $grandTotalGajiLembur = 0;
        $grandTotalGaji = 0;
        $grandTotalDiterima = 0;
        foreach ($this->data["EmployeeSalary"] as $employeeSalary) {
            $build = [];
            foreach ($employeeSalary["ParameterEmployeeSalary"] as $parameterEmployeeSalary) {
                $build[$parameterEmployeeSalary["ParameterSalary"]["code"]] = abs($parameterEmployeeSalary["nominal"]);
                if (!isset($grandTotal[$parameterEmployeeSalary["ParameterSalary"]["code"]])) {
                    $grandTotal[$parameterEmployeeSalary["ParameterSalary"]["code"]] = abs($parameterEmployeeSalary["nominal"]);
                } else {
                    $grandTotal[$parameterEmployeeSalary["ParameterSalary"]["code"]]+=abs($parameterEmployeeSalary["nominal"]);
                }
            }
            $totalgaji = $build["LPJ"] + $build["LPH"] + $build["GPK"];
            $grandTotalGajiLembur+=ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_gaji_lembur"]);
            $grandTotalGaji+=ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_gaji"]);
            $grandTotalDiterima+=ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_diterima"]);
            ?>
            <tr>
                <td class="text-center"><?= $n ?></td>
                <td class="text-left"><?= $employeeSalary["Employee"]["Account"]["Biodata"]["full_name"] ?></td>
                <td class="text-center"><?= $employeeSalary["EmployeeSalaryInfo"]["lembur_jam"] ?></td>
                <td class="text-right"><?= ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["lembur_rp"]) ?></td>
                <td class="text-center"><?= $employeeSalary["EmployeeSalaryInfo"]["lembur_hari"] ?></td>
                <td class="text-center"><?= $employeeSalary["EmployeeSalaryInfo"]["hari_kerja"] ?></td>
                <td class="text-center"><?= $employeeSalary["EmployeeSalaryInfo"]["jumlah_hari_kerja"] ?></td>
                <td class="text-right"><?= ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["gaji_pokok"]) ?></td>
                <td class="text-right"><?= $build["IWP"] ?></td>
                <td class="text-right"><?= $build["PKI"] ?></td>
                <td class="text-right"><?= $build["PKS"] ?></td>
                <td class="text-right"><?= $build["LPH"] ?></td>
                <td class="text-right"><?= $build["LPJ"] ?></td>
                <td class="text-right"><?= ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_gaji_lembur"]) ?></td>
                <td class="text-right"><?= $build["GPK"] ?></td>
                <td class="text-right"><?= ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_gaji"]) ?></td>
                <td class="text-right"><?= $build["PJS"] ?></td>
                <td class="text-right"><?= ic_number_reverse($employeeSalary["EmployeeSalaryInfo"]["total_diterima"]) ?></td>
                <td class="text-center"><?= $this->Html->cvtTanggal($employeeSalary["Employee"]["tmt"], false) ?></td>
            </tr>
            <?php
            $n++;
        }
        ?>
    </tbody>  
    <tfoot>
        <tr>
            <td colspan="8" class="text-right">Total</td>
            <td class="text-right"><?= $grandTotal["IWP"] ?></td>
            <td class="text-right"><?= $grandTotal["PKI"] ?></td>
            <td class="text-right"><?= $grandTotal["PKS"] ?></td>
            <td class="text-right"><?= $grandTotal["LPH"] ?></td>
            <td class="text-right"><?= $grandTotal["LPJ"] ?></td>
            <td class="text-right"><?= $grandTotalGajiLembur ?></td>
            <td class="text-right"><?= $grandTotal["GPK"] ?></td>
            <td class="text-right"><?= $grandTotalGaji ?></td>
            <td class="text-right"><?= $grandTotal["PJS"] ?></td>
            <td class="text-right"><?= $grandTotalDiterima ?></td>
        </tr>
    </tfoot>
</table>