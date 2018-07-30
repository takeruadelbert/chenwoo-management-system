<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Tunjangan Gaji Pegawai
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th class="text-center" width="1%" bgcolor="#FFFFCC" style="color: #000;">No</th>
            <th class="text-center" width="20%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Nama Pegawai") ?></th>
            <th class="text-center" width="20%" bgcolor="#FFFFCC" style="color: #000;"><?= __("Detail Tunjangan") ?></th>
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
                <td class = "text-center" colspan = 3>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-center"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td>
                        <ul>
                            <?php
                            foreach ($item['SalaryAllowanceDetail'] as $details) {
                                ?>
                                <li><?= $details['ParameterSalary']['name'] ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>