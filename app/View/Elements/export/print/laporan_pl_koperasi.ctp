<div style="text-align: center">
    <div style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
        Laporan Laba/Rugi Koperasi
    </div>
    <div style="font-size:10px;font-weight: 400; font-style: italic; font-family:Tahoma, Geneva, sans-serif;">
        <?= $this->Echo->laporanPeriodeBulan($start_date, $end_date) ?>
    </div>
</div>
<br>
<table width="100%" class="table-data small-font">
    <thead>
        <tr>
            <th style="max-width: 25px;width:25px;">No</th>
            <th><?= __("Uraian") ?></th>
            <th><?= __("Nominal") ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = [
            "income" => 0,
            "outcome" => 0,
        ];
        $totaloutcome = 0;
        foreach ($result as $typeName => $dataPL) {
            $i = 1;
            if ($typeName == "netral") {
                continue;
            }
            ?>
            <tr>
                <th class="text-left" colspan="3">
                    <b>
                        <?= mapNamePL($typeName) ?>
                    </b>
                </th>
            </tr>
            <?php
            foreach ($dataPL as $code => $pl) {
                ?>
                <tr >
                    <td class="text-center"><?= $i ?></td>
                    <td class="text-left"><?= $mapNameCooperativeEntryType[$code] ?></td>
                    <td class="text-right"><?= ic_rupiah($pl["amount"]) ?></td>
                </tr>
                <?php
                $total[$typeName]+=$pl["amount"];
                $i++;
            }
            ?>
            <tr>
                <th colspan="2" class="text-left">
                    <b>Total <?= mapNamePL($typeName) ?></b>
                </th>
                <th class="text-right">
                    <b>
                        <?= ic_rupiah($total[$typeName]) ?>
                    </b>
                </th>
            </tr>
            <?php
        }
        $grandTotal = $total["income"] - $total["outcome"];
        ?>
        <tr>
            <th colspan="2" class="text-left">
                <b>Total <?= determineNamePL($grandTotal) ?></b>
            </th>
            <th class="text-right">
                <b>
                    <?= ic_rupiah($grandTotal) ?>
                </b>
            </th>
        </tr>
    </tbody>
</table>