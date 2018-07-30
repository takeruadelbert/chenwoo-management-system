<div style="position: absolute; top:27px; right:50px;">Tanggal : <?= $this->Html->cvtTanggal($data['rows']['EmployeeDataDeposit']['transaction_date']) ?></div>
<table width="100%" class="">
    <tr>
        <td class="text-center"><strong><?= $data['title'] ?></strong></td>
    </tr>
    <tr>
        <td>
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td width="20%">Diterima dari : </td>
                    <td><?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 0 0 0;">
            <table width="100%" class="table2">
                <thead>
                    <tr>
                        <th class="text-center" width="30%" style="border-left: none;">No. Rekening</th>
                        <th class="text-center" width="60%">Keterangan</th>
                        <th class="text-center" colspan="2" width="10%" style="border-right: none;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-left: none;"><?= emptyToStrip(@$data['rows']['EmployeeBalance']['account_number']) ?></td>
                        <td style="border-left: none;"><?= $data['rows']['EmployeeDataDeposit']['note'] ?></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $data['rows']['EmployeeDataDeposit']['amount__ic'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right" style="border-left: none;"><strong>Jumlah / Total : </strong></td>
                        <td class="text-center" style = "border-right-style:none !important" width = "50">Rp. </td>
                        <td class="text-right" style = "border-left-style:none !important" width = "150"><?= $data['rows']['EmployeeDataDeposit']['amount__ic'] ?></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td width="15%">Terbilang :</td>
                    <td><strong><?= angka2kalimat($data['rows']['EmployeeDataDeposit']['amount']) . " rupiah." ?></strong></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td style="padding:0 0 0 0;">
            <table width="100%" class="table table-hover table1">
                <tr>
                    <td style="padding:0 0 0 0;">
                        <table width="100%" class="table1">
                            <tr>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black;">Dibuat/Prepared</td>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black;">Diperiksa/Checked</td>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black;">Disetujui/Approved</td>
                                <td width="5%" style=""></td>
                                <td class="text-center" style="border-left:1px solid black; border-bottom: 1px solid black;">Dibayar/Payer</td>
                            </tr>
                            <tr>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td></td>
                                <td style="border-left:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><br></td>
                </tr>
                <tr>
                    <td colspan="5">Untuk Akuntansi & Pemeriksa / For Accounting and Audit use only</td>
                </tr>
                <tr>
                    <td style="padding:0 0 0 0;">
                        <table width="100%" class="table1">
                            <tr>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;">Dibukukan/Recorded</td>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;">Disetujui/Approved</td>
                                <td class="text-center" style="border-right:1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;">Diperiksa/Audit</td>
                                <td colspan="2" width="120"></td>
                            </tr>
                            <tr>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td style="border-right:1px solid black; border-bottom: 1px solid black;"><br><br><br><br>Tgl/Date :</td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<hr style="border-top: dashed 1px;">
<table width="100%" class="">
    <tr>
        <td class="text-center"><strong><?= $data['title2'] ?></strong><br><br></td>
    </tr>
    <tr>
        <td>
            <table width="100%" class="table1">
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td style="width:175px">Tanggal</td>
                    <td style="width:25px">:</td>
                    <td><?= $this->Html->cvtTanggal($data['rows']['EmployeeDataDeposit']['transaction_date']) ?></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" class="table1">
                <tr>
                    <td style="width:175px">Nomor Rekening</td>
                    <td style="width:25px">:</td>
                    <td><?= emptyToStrip(@$data['rows']['EmployeeBalance']['account_number']) ?></td>
                </tr>
                <tr>
                    <td>Nama Pemilik Rekening</td>
                    <td>:</td>
                    <td><?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
                </tr>
                <tr>
                    <td>Jumlah Setoran</td>
                    <td>:</td>
                    <td>Rp <?= $data['rows']['EmployeeDataDeposit']['amount__ic'] ?></td>
                </tr>
                <tr>
                    <td>Terbilang</td>
                    <td>:</td>
                    <td><?= angka2kalimat($data['rows']['EmployeeDataDeposit']['amount']) . " rupiah." ?></td>
                </tr>
                <tr>
                    <td><br><br><br></td>
                </tr>
                <tr>
                    <td class="text-center">Tanda Tangan Penerima</td>
                    <td></td>
                    <td class="text-center">Tanda Tangan Penyetor</td>
                </tr>
            </table>
        </td>
    </tr>
</table>