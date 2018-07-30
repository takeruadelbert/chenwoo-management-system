<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        DATA MUTASI / KENAIKAN JABATAN PEGAWAI VALIDASI
    </div>
    <div style="font-size:11px;font-style: italic; font-family:Tahoma, Geneva, sans-serif;">Periode : <?= $this->Echo->laporanPeriodeBulan(@$periodeLaporanStartDate, @$periodeLaporanEndDate) ?></div>
</div>
<br>
<table width="100%" class="table-data">
    <thead>
        <tr>
            <th width="50">No</th>
            <th><?= __("Nama Pegawai") ?></th>
            <th><?= __("NIP") ?></th>
            <th><?= __("Jabatan Asal") ?></th>
            <th><?= __("Department Asal") ?></th>
            <th><?= __("Cabang Asal") ?></th>
            <th><?= __("Jabatan Tujuan") ?></th>
            <th><?= __("Department Tujuan") ?></th>
            <th><?= __("Cabang Tujuan") ?></th>
            <th><?= __("Tanggal Mutasi") ?></th>
            <th><?= __("Keterangan") ?> </th>
            <th><?= __("Status Verifikasi") ?></th>
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
                <td class = "text-center" colspan = "12">Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows'] as $item) {
                ?>
                <tr>
                    <td class="text-center"><?= $i ?></td>
                    <td><?= $item['Employee']['Account']['Biodata']['full_name'] ?></td>
                    <td class="text-center"><?= $item['Employee']['nip'] ?></td>
                    <td class="text-center">
                        <?= empty($item['OriginOffice']['name']) ? $item["Employee"]["Office"]["name"] : $item['OriginOffice']['name'] ?> 
                    </td>
                    <td class="text-center">
                        <?= empty($item['OriginDepartment']['name']) ? $item["Employee"]["Department"]["name"] : $item['OriginDepartment']['name'] ?> 
                    </td>
                    <td class="text-center">
                        <?= empty($item['OriginBranchOffice']['name']) ? $item["Employee"]["BranchOffice"]["name"] : $item['OriginBranchOffice']['name'] ?> 
                    </td>
                    <td class="text-center">
                        <?= $item['Department']['name'] ?>
                    </td>
                    <td class="text-center">
                        <?= $item['Office']['name'] ?>
                    </td>
                    <td class="text-center">
                        <?= $item['BranchOffice']['name'] ?>
                    </td>
                    <td class="text-center"><?= $this->Html->cvtHariTanggal($item['TransferEmployee']['tanggal_sk_mutasi']) ?> </td>
                    <td class="text-center"><?= $item['TransferEmployeeType']['name'] ?></td>

                    <td class="text-center"  id = "target-change-status<?= $i ?>">
                        <?php
                        echo $item['VerifyStatus']['name'];
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