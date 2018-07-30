<div style="border:1px solid black;padding:0 10px">
    <div class="text-center" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
        <strong><?= $data['title'] ?></strong>
    </div>
    <br/>
    <table width="100%" class="no-border" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
        <tr>
            <td style="width:170"> Nama </td>
            <td style="width:10"> : </td>
            <td style="width:200"><?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
        </tr>
        <tr>
            <td> NIK </td>
            <td> : </td>
            <td colspan="3"><?= $data['rows']['Employee']['nip'] ?></td>
        </tr>
        <tr>
            <td> Jabatan/Bagian </td>
            <td> : </td>
            <td colspan="3"><?= $data['rows']['Employee']['Department']['name'] ?></td>
        </tr>
        <tr>
            <td> Jenis Izin </td>
            <td> : </td>
            <td colspan="3"><?= $data['rows']['PermitType']['name'] ?></td>
        </tr>
        <tr>
            <td> Izin </td>
            <td> : </td>
            <td> Hari </td>
            <td> : </td>
            <td> <?= $this->Html->cvtHari($data['rows']['Employee']['Department']['name']) ?> </td>
        </tr>
        <tr>
            <td> &nbsp </td>
            <td> &nbsp </td>
            <td> Tanggal </td>
            <td>:</td>
            <td> <?= $this->Html->cvtTanggal($data['rows']['Permit']['start_date']) ?> </td>
        </tr>
        <tr>
            <td> &nbsp </td>
            <td> &nbsp </td>
            <td> Alasan </td>
            <td> : </td>
            <td> <?= $data['rows']['Permit']['keterangan'] ?> </td>
        </tr>
        <tr>
            <td> Catatan Personalia </td>
            <td> : </td>
            <td colspan="3"> <?= $data['rows']['Permit']['personalia_note'] ?> </td>
        </tr>
        <tr>
            <td> Catatan General Manager </td>
            <td> : </td>
            <td colspan="3"> <?= $data['rows']['Permit']['general_manager_note'] ?> </td>
        </tr>
    </table>
    <br/>
    <table width="100%" class="no-border" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
        <tr>
            <td style="border-top: none; border-bottom: none">
                <table width="100%" class="table table-hover table1">
                    <tr>
                        <td style="padding:0 0 0 0;">
                            <table width="100%" class="table1" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                                <tr>
                                    <td class="text-center" width = "10%">Mengetahui</td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%">Dicatat</td>
                                    <td width="5%" style=""></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%">Yang bersangkutan</td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black">General Manager</td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black">Personalia</td>
                                    <td width="5%" style=""></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style = "padding-top:35px; font-family:Tahoma, Geneva, sans-serif; font-size:9px">Ket : Arsip</td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<br>
<hr style="border-top: dashed 1px;">
<div style="page-break-inside: void;">
    <table width="50%" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
        <tr>
            <td class="text-center" style="border-bottom: 1px solid black; line-height:20px; text-decoration:none;"><strong><?= $data['title2'] ?></strong></td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none">
                <table width="100%" class="table table-hover table1" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                    <tr>
                        <td><br></td>
                    </tr>
                    <tr>
                        <td width = "30%" class="text-left"> Hari/Tanggal </td>
                        <td width = "5%"> : </td>
                        <td width = "65%"> <?= $this->Html->cvtHari($data['rows']['Employee']['Department']['name']) ?> / <?= $this->Html->cvtTanggal($data['rows']['Permit']['start_date']) ?> </td>
                    </tr>
                    <tr>
                        <td class="text-left"> Nama </td>
                        <td> : </td>
                        <td><?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-left"> Jabatan/Bagian </td>
                        <td> : </td>
                        <td><?= $data['rows']['Employee']['Department']['name'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-left"> Jam Keluar </td>
                        <td> : </td>
                        <td> <?= $this->Html->cvtJam($data['rows']['Permit']['jam_keluar'], false) ?> </td>
                    </tr>
                    <tr>
                        <td class="text-left"> Keterangan Izin </td>
                        <td>:</td>
                        <td> <?= $data['rows']['Permit']['keterangan'] ?> </td>
                    </tr>
                    <tr>
                        <td class="text-left"> Jenis Izin </td>
                        <td> : </td>
                        <td> <?= $data['rows']['PermitType']['name'] ?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none"><br></td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none">
                <table width="100%" class="table table-hover table1" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                    <tr>
                        <td style="padding:0 0 0 0;">
                            <table width="100%" class="table1" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px;">
                                <tr>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%">Diketahui : </td>
                                    <td width="5%" style=""></td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black; font-size:9px;">Quality Control</td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black; font-size:9px;">Processing Manager</td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%"><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black; font-size:9px;">Production Dept Head</td>
                                    <td width="5%" style=""></td>
                                    <td class="text-center" width = "10%" style = "border-top: 1px solid black; font-size:9px;">HRD Group Head</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td style = "padding-top:10px; font-size:8px">
                            - Keterangan izin dapat diberikan apabila diketahui 2 bagian dan laporkan ke security <br>
                            - Keterangan izin di file di bagian HRD
                        </td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>