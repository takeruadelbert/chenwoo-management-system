<table width="100%" class="table table-hover table1" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif; line-height:1.5; border: 1px solid #000;">
                <tr style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
                  <td colspan="5" align="center" style="font-family:Tahoma, Geneva, sans-serif; font-size:11px; border: 1px solid #000; "><?= $data['title'] ?></strong><br/><?= $data["rows"]["EmployeeDataLoan"]["receipt_loan_number"] ?></td>
                </tr>
                <tr style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr style="font-size:11px;font-weight: bold; font-family:Tahoma, Geneva, sans-serif;">
                    <td width="2%" rowspan="9" align="right" valign="top">I</td>
                  <td width="1%" align="right">&nbsp;</td>
                    <td width="28%">IDENTITAS PEGAWAI</td>
                    <td colspan="2"></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Nama Pegawai</td>
                    <td width="2%" align="center" valign="middle" style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">:</td>
                    <td width="67%" style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $data['rows']['Employee']['Account']['Biodata']['full_name'] ?></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Department / Jabatan</td>
                    <td align="center" valign="middle" style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $data['rows']['Employee']['Office']['name'] ?></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Tempat Lahir</td>
                    <td align="center" valign="middle" style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $data['rows']['Employee']['Account']['Biodata']['tempat_lahir_kota'] . ", " . $data['rows']['Employee']['Account']['Biodata']['tempat_lahir_provinsi'] ?></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Tanggal Lahir</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;" align="center" valign="middle">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $this->Html->cvtTanggal($data['rows']['Employee']['Account']['Biodata']['tanggal_lahir']) ?></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Alamat Sekarang</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;" align="center" valign="middle">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $data['rows']['Employee']['Account']['Biodata']['postal_code'] . " " . $data['rows']['Employee']['Account']['Biodata']['address'] ?></td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Alamat sesuai KTP</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;" align="center" valign="middle">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">-</td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">Nomor KTP / Identitas</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;" align="center" valign="middle">:</td>
                    <td>-</td>
                </tr>
                <tr style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">
                    <td></td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;">No. Telp / Hp</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;" align="center" valign="middle">:</td>
                    <td style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><?= $this->Html->getContact($data['rows']['Employee']['Account']['Biodata']['handphone'], $data['rows']['Employee']['Account']['Biodata']['phone']) ?></td>
                </tr>
				<br>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                    <td align="right">II</td>
                  <td align="right">&nbsp;</td>
                    <td>BESARNYA PINJAMAN YANG DIINGINKAN</td>
                    <td align="center">:</td>
                    <td><?= $this->Html->IDR($data['rows']['EmployeeDataLoan']['amount_loan']) ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>(<?= angka2kalimat($data['rows']['EmployeeDataLoan']['amount_loan']) ?> rupiah)</td>
                </tr>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                    <td align="right">III</td>
                  <td align="right">&nbsp;</td>
                    <td>JANGKA WAKTU PENGEMBALIAN</td>
                    <td align="center" valign="middle">:</td>
                    <td><?= $data['rows']['EmployeeDataLoan']['installment_number'] ?> Bulan</td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                    <td align="right" valign="top">IV</td>
                  <td align="right" valign="top">&nbsp;</td>
                  <td>ALASAN PENGAJUAN PINJAMAN <br> (Digunakan untuk apa)</td>
                  <td align="center" valign="top">:</td>
                    <td valign="top"><?= $data['rows']['EmployeeDataLoan']['note'] ?></td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                    <td align="right" valign="top">V</td>
                  <td align="right" valign="top">&nbsp;</td>
                  <td>NAMA ANGGOTA KELUARGA/REFERENSI <br> DI PT. CHEN WOO FISHERY</td>
                  <td align="center" valign="top">:</td>
                    <td valign="top"><?= $data['rows']['EmployeeDataLoan']['acquaintance'] ?></td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                    <td align="right">VI</td>
                  <td align="right">&nbsp;</td>
                    <td>JAMINAN YANG DIBERIKAN</td>
                    <td align="center" valign="middle">:</td>
                    <td><?= $data['rows']['EmployeeDataLoan']['assurance'] ?></td>
                </tr>
                <tr style="font-size:11px;font-family:Tahoma, Geneva, sans-serif;">
                  <td colspan="5">&nbsp;</td>
                </tr>
</table>
<table width="100%" class="table table-hover table1" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif; border: 1px solid #000; line-height:15px;">
  <tr>
    <td width="48" align="center" valign="middle" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">VII</td>
    <td colspan="6" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">DIISI OLEH ATASAN MASING-MASING</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">1.</td>
    <td width="750">Perilaku / Sikap</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="816">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">2.</td>
    <td width="750">Kerja Sama</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td>&nbsp;</td>
    <td width="816">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">3.</td>
    <td width="750">Catatan dari Atasan</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td>&nbsp;</td>
    <td width="816">Tanda Tangan</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" class="table table-hover table1" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif; border: 1px solid #000; line-height:15px;">
  <tr>
    <td width="48" align="center" valign="middle" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">VIII</td>
    <td colspan="6" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">DIISI OLEH PERSONALIA PT. CHEN WOO FISHERY</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">1.</td>
    <td width="750">Lama Bekerja</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="814">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">2.</td>
    <td width="750">Kehadiran</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="814">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="32">3.</td>
    <td width="750">Sanksi yang pernah diberikan</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="814">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td>4.</td>
    <td width="750">Gaji / Hari</td>
    <td align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="814">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td>5.</td>
    <td width="750">Catatan dari Personalia</td>
    <td align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="51">&nbsp;</td>
    <td width="814">Tanda Tangan</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" class="table table-hover table1" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif; border: 1px solid #000; line-height:15px;">
  <tr>
    <td width="39" align="center" valign="middle" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">IX</td>
    <td colspan="6" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">DISPOSISI GM / DIREKTUR</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="39" align="center" valign="middle">&nbsp;</td>
    <td width="39"><div style="border:1px solid black;width:20px;height:20px;display:inline-block;vertical-align: middle;font-size:24px;text-align: center"></div></td>
    <td width="721">Pinjaman Disetujui</td>
    <td width="33" align="center" valign="middle">:</td>
    <td width="585">________________________________________</td>
    <td width="48">&nbsp;</td>
    <td width="786">&nbsp;</td>
  </tr>
  <tr>
    <td width="39" align="center" valign="middle">&nbsp;</td>
    <td width="39"><div style="border:1px solid black;width:20px;height:20px;display:inline-block;vertical-align: middle;font-size:24px;text-align: center"></div></td>
    <td width="721">Pinjaman Ditolak</td>
    <td width="33" align="center" valign="middle">:</td>
    <td width="585">________________________________________</td>
    <td>&nbsp;</td>
    <td width="786">Tanda Tangan</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<table width="100%" class="table table-hover table1" style="font-size:11px;font-family:Tahoma, Geneva, sans-serif; border: 1px solid #000; line-height:15px;">
  <tr>
    <td width="48" align="center" valign="middle" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">X</td>
    <td colspan="6" style="border-bottom:1px solid #000; font-size:11px;font-family:Tahoma, Geneva, sans-serif;">DISPOSISI KETUA</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">BERIKAN ALASAN ( HARUS DIISI )</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="33"><div style="border:1px solid black;width:20px;height:20px;display:inline-block;vertical-align: middle;font-size:24px;text-align: center"></div></td>
    <td width="750">Pinjaman Disetujui</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td width="52">&nbsp;</td>
    <td width="813">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="33"><div style="border:1px solid black;width:20px;height:20px;display:inline-block;vertical-align: middle;font-size:24px;text-align: center"></div></td>
    <td width="750">Pinjaman Dipending</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td>&nbsp;</td>
    <td width="813">&nbsp;</td>
  </tr>
  <tr>
    <td width="48" align="center" valign="middle">&nbsp;</td>
    <td width="33"><div style="border:1px solid black;width:20px;height:20px;display:inline-block;vertical-align: middle;font-size:24px;text-align: center"></div></td>
    <td width="750">Pinjaman Ditolak</td>
    <td width="35" align="center" valign="middle">:</td>
    <td width="600">________________________________________</td>
    <td>&nbsp;</td>
    <td width="813">Tanda Tangan</td>
  </tr>
  <tr>
    <td colspan="7" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center">
  <tr>
    <td align="center" style="font-size:10px;font-family:Tahoma, Geneva, sans-serif;"><br>.............., .......................
                <br><br><br>
                Yang Bermohon
                <br><br><br><br><br>
                ................................<br><br></td>
  </tr>
</table>