<?php
if (!empty($data['rows'])) {
    ?>
    <table width="100%" border="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
        <tr>
            <td width="25%">&nbsp;</td>
            <td width="50%" style="text-align:center; font-size:12px"><strong>NOTA TIMBANG</strong></td>
            <td width="25%">&nbsp;</td>
        </tr>
        <tr>
            <td width="25%">&nbsp;</td>
            <td width="50%" style="text-align:center; font-size:12px; border-bottom: 1px solid #000"><strong>PT. CHENWOOFISHERY</strong></td>
            <td width="25%">&nbsp;</td>
        </tr>
        <tr>
            <td width="25%">&nbsp;</td>
            <td width="50%" style="text-align:center; font-style:italic; font-size:10px"><?= $data['rows']['MaterialEntry']['material_entry_number'] ?></td>
            <td width="25%">&nbsp;</td>
        </tr>
    </table>
    <div>&nbsp;</div>
    <table width="50%" border="0" cellpadding="1" cellspacing="1" style="font-family:Tahoma, Geneva, sans-serif; font-size:11px;">
        <tr style="border-bottom: 1px #000 solid;">
            <td width="35%">Nama Supplier</td>
            <td width="1%" style="text-align: center">:</td>
            <td width="72%"><?= $data['rows']['Supplier']['name']; ?></td>
        </tr>
        <tr>
            <td width="35%">Waktu Proses Timbang</td>
            <td width="1%" style="text-align: center">:</td>
            <td width="72%"><?= $this->Html->cvtHari($data['rows']['MaterialEntry']['created']); ?>, <?= $this->Html->cvtTanggalWaktu($data['rows']['MaterialEntry']['created']); ?></td>
        </tr>
        <tr>
            <td width="35%">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>

    <table style="margin-top:10px; font-family:Tahoma, Geneva, sans-serif; font-size:11px;width:100%;white-space: nowrap" class="table-data"> 
        <tr style="font-weight:bold">
            <td width="1%" class = "text-center" style="border: 1px solid">NO</td>
            <td width="25%" class = "text-center" style="border: 1px solid">JENIS IKAN</td>
            <td width="15%" class = "text-center" style="border: 1px solid">GRADE</td>
            <td width="15%" class = "text-center" style="border: 1px solid">BRUTO</td>
            <td width="15%" class = "text-center" style="border: 1px solid">NETTO</td>
            <td width="30%" class = "text-center" style="border: 1px solid">KETERANGAN</td>
        </tr>
        <?php
        $number = 1;
        $fishList = array();
        $totalBerat = 0;
        foreach ($data['rows']['MaterialEntryGrade'] as $transaction) {
            $jenisIkan = $transaction['MaterialDetail']['name'];
            foreach ($transaction['MaterialEntryGradeDetail'] as $detail) {
                $totalBerat+=$detail["weight"];
                ?>
                <tr>
                    <td width="1%" class = "text-center" style="border: 1px solid"><?= $number ?></td>
                    <td width="30%" class = "text-left" style="border: 1px solid"><?= $jenisIkan ?></td>
                    <td width="5%" class = "text-left" style="border: 1px solid"><?= $transaction["MaterialSize"]["name"] ?></td>
                    <td width="15%" class = "text-center" style="border: 1px solid"></td>
                    <td width="15%" class = "text-right" style="border: 1px solid"><?= ic_kg($detail['weight']) . " " . $transaction['MaterialDetail']['Unit']['uniq'] ?></td>
                    <td width="30%" class = "text-center" style="border: 1px solid"></td>
                </tr>
                <?php
                $number++;
            }
        }
        ?> 
        <tfoot>
            <tr>
                <td colspan="3" style="border: 1px solid #000; text-align: right !important;"><strong>TOTAL</strong></td>
                <td width="15%" class = "text-center" style="border: 1px solid"></td>
                <td width="15%" class = "text-right" style="border: 1px solid"><strong><?= ic_kg($totalBerat) ?> Kg</strong></td>
                <td width="30%" class = "text-center"></td>
            </tr>
        </tfoot>
    </table>
    <br/>
    <table width="100%" class="table1" style="font-family:Tahoma, Geneva, sans-serif; font-size:11px;">
        <tr>
            <td class="text-center" width = "10%">Pembuat</td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%">Penimbang</td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%">Disetujui</td>
        </tr>
        <tr>
            <td class="text-center" width = "10%"><br><br><br><br><br></td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%"><br><br><br><br><br></td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%"><br><br><br><br><br></td>
        </tr>
        <tr>
            <td class="text-center" width = "10%" style = "border-top: 1px solid black"><?= @$data['rows']['Employee']['Account']['Biodata']['full_name']; ?></td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%" style = "border-top: 1px solid black"><?= $data['rows']['Operator']['Account']['Biodata']['full_name']; ?></td>
            <td width="5%" style=""></td>
            <td class="text-center" width = "10%" style = "border-top: 1px solid black"></td>
        </tr>
    </table>

    <?php
} else {
    echo "<div class='text-center'><h2>Tidak Ada Data</h2></div>";
}
?>