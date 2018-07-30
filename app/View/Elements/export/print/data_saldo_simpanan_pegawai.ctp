<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Data Saldo Simpanan Pegawai
    </div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("No Rekening") ?></th>
            <th colspan = "2"><?= __("Jumlah Simpanan") ?></th>
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
                <td class = "text-center" colspan = "5">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            $total = 0;
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['EmployeeBalance']['account_number'] ?></td>
                    <td class="text-center" width ="50" style = "border-right: none !important">Rp.</td>
                    <td class="text-right" style = "border-left: none !important"><?= $item['EmployeeBalance']['amount__ic'] ?></td>
                </tr>
                <?php
                $total += $item['EmployeeBalance']['amount'];
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right" style="font-weight: bold"> Total </td>
            <td class="text-center" width ="50" style = "border-right: none !important">Rp.</td>
            <td class="text-right" style = "border-left: none !important"><?= ic_rupiah($total) ?></td>
        </tr>
    </tfoot>
</table>