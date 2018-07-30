<?php
if (!empty($data['rows'])) {
    ?>
    <style>
        table.tab, .tab td, .tab th {border:none;}
        table.dat{width:100%;text-align: center;}
        table.wrap{ border-collapse: collapse;border: 0px solid black;width:100%;}
        div.note{margin: 0 auto;}
    </style>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            I. DATA UTAMA
        </h3>
    </div>
    <table class="tab" style="float:left;">
        <tr>
            <td width="10" align="right">1.</td>
            <td width="200">NIK</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Employee']['nip']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">2.</td>
            <td width="200">NAMA</td>
            <td>:</td>
            <td><?= $data['rows']['Account']['Biodata']['first_name'] . " " . $data['rows']['Account']['Biodata']['last_name'] ?></td>
        </tr>
        <tr>
            <td width="10" align="right">3.</td>
            <td width="200">GELAR DEPAN</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['gelar_depan']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right"></td>
            <td width="200">GELAR BELAKANG</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['gelar_belakang']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">4.</td>
            <td width="200">TEMPAT, TANGGAL LAHIR</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['tempat_lahir_kota']) ?>, <?= $this->Html->cvtTanggal($data['rows']['Account']['Biodata']['tanggal_lahir'], false) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">5.</td>
            <td width="200">AGAMA</td>
            <td>:</td>
            <?php
            if ($data['rows']['Account']['Biodata']['religion_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Account']['Biodata']['Religion']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">6.</td>
            <td width="200">JENIS KELAMIN</td>
            <td>:</td>
            <?php
            if ($data['rows']['Account']['Biodata']['gender_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Account']['Biodata']['Gender']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">7.</td>
            <td width="200">STATUS PERKAWINAN</td>
            <td>:</td>
            <?php
            if ($data['rows']['Account']['Biodata']['marital_status_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Account']['Biodata']['MaritalStatus']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">8.</td>
            <td width="200">EMAIL</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['User']['email']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">9.</td>
            <td width="200">ALAMAT</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['address']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right"></td>
            <td width="200">KODE POS</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['postal_code']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">10.</td>
            <td width="200">PROVINSI TEMPAT TINGGAL</td>
            <td>:</td>
            <?php
            if ($data['rows']['Account']['Biodata']['state_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Account']['Biodata']['State']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">11.</td>
            <td width="200">KOTA TEMPAT TINGGAL</td>
            <td>:</td>
            <?php
            if ($data['rows']['Account']['Biodata']['city_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Account']['Biodata']['City']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">12.</td>
            <td width="200">NO TELP/HP</td>
            <td>:</td>
            <td><?= emptyToStrip($data['rows']['Account']['Biodata']['phone']) . " / " . emptyToStrip($data['rows']['Account']['Biodata']['handphone']) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">13.</td>
            <td width="200">STATUS PEGAWAI</td>
            <td>:</td>
            <?php
            if ($data['rows']['Employee']['employee_work_status_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['EmployeeWorkStatus']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
    </table>
    <!--Photo Profile-->
    <div style="float:right;position:relative;">
        <img src="<?= Router::url($this->data["Account"]["User"]['profile_picture'], true) ?>" height="100px" style="position:relative;top:-26px;padding:25px 15px 0 0"/>
    </div>
    <div style="clear:both;"></div>

    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            II. POSISI &amp; JABATAN
        </h3>
    </div>
    <table class="tab">
        <tr>
            <td width="10" align="right">1.</td>
            <td width="200">DEPARTEMEN</td>
            <td>:</td>
            <?php
            if ($data['rows']['Employee']['department_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Department']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">2.</td>
            <td width="200">NAMA JABATAN</td>
            <td>:</td>
            <?php
            if ($data['rows']['Employee']['office_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['Office']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">3.</td>
            <td width="200">TIPE PEGAWAI</td>
            <td>:</td>
            <?php
            if ($data['rows']['Employee']['employee_type_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['EmployeeType']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td width="10" align="right">4.</td>
            <td width="200">TANGGAL MULAI KERJA</td>
            <td>:</td>
            <td><?= emptyToStrip(@$this->Html->cvtTanggal($data['rows']['Employee']['tmt'], false)) ?></td>
        </tr>
        <tr>
            <td width="10" align="right">5.</td>
            <td width="200">CABANG PERUSAHAAN</td>
            <td>:</td>
            <?php
            if ($data['rows']['Employee']['branch_office_id'] != null) {
                ?>
                <td><?= emptyToStrip($data['rows']['BranchOffice']['name']) ?></td>
                <?php
            } else {
                ?>
                <td>-</td>
                <?php
            }
            ?>
        </tr>
    </table>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            III. RIWAYAT PENDIDIKAN
        </h3>
    </div>
    <table class="dat">
        <tr>
            <th>No</th>
            <th>Nama Sekolah/Perguruan Tinggi</th>
            <th>Tingkat Pendidikan</th>
            <th>Fakulitas/Prodi/Jurusan/Konsentrasi/Minat</th>
            <th>No. Ijazah </th>
            <th>Tanggal Lulus</th>
            <th>Nama Kepsek/Ketua/Direktur/Dekan/Rektor</th>
        </tr>
        <?php
        $i = 1;
        if (empty($data['rows']['EducationHistory'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows']['EducationHistory'] as $item) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= emptyToStrip($item['nama_sekolah']) ?></td>
                    <td><?= emptyToStrip($item['tingkat_pendidikan']) ?></td>
                    <td><?= emptyToStrip($item['jurusan']) ?></td>
                    <td><?= emptyToStrip($item['no_ijazah']) ?></td>
                    <td><?= emptyToStrip($this->Html->cvtTanggal($item['tgl_lulus'], false)) ?></td>
                    <td><?= emptyToStrip($item['nama_kepala']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

    </table>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            IV. RIWAYAT JABATAN
        </h3>
    </div>
    <table class="dat">
        <tr>
            <th>No</th>
            <th>Nama Jabatan</th>
            <th>Instansi</th>
            <th>Unit Kerja</th>
            <th>No. SK & Tanggal</th>
            <th>Sejak</th>
        </tr>

        <?php
        $i = 1;
        if (empty($data['rows']['PositionHistory'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 6>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows']['PositionHistory'] as $item) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= emptyToStrip($item['nama_jabatan']) ?></td>
                    <td><?= emptyToStrip($item['instansi']) ?></td>
                    <td><?= emptyToStrip($item['unit_kerja']) ?></td>
                    <td><?= emptyToStrip($item['no_sk']) . " " . emptyToStrip(@$this->Html->cvtTanggal($item['tanggal_sk'], false)) ?></td>
                    <td><?= $this->Html->cvtTanggal($item['tmt'],false) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

    </table>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            V. DATA KELUARGA
        </h3>
    </div>
    <table class="dat">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tempat & Tgl Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th>Agama</th>
            <th>Status Perkawinan</th>
            <th>Status Hidup</th>
            <th>Status Dalam Keluarga</th>
            <th>Alamat</th>
            <th>No. HP / Telp</th>
        </tr>

        <?php
        $i = 1;
        if (empty($data['rows']['Family'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 12>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows']['Family'] as $item) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= emptyToStrip($item['name']) ?></td>
                    <td><?= emptyToStrip($item['tempat_lahir']) . " / " . emptyToStrip($this->Html->cvtTanggal($item['tanggal_lahir'], false)) ?></td>
                    <?php
                    if ($item['gender_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['Gender']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <?php
                    if ($item['education_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['Education']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <td><?= emptyToStrip($item['job']) ?></td>
                    <?php
                    if ($item['religion_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['Religion']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <?php
                    if ($item['marital_status_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['MaritalStatus']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <?php
                    if ($item['life_status_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['LifeStatus']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <?php
                    if ($item['family_relation_id'] != null) {
                        ?>
                        <td><?= emptyToStrip($item['FamilyRelation']['name']) ?></td>
                        <?php
                    } else {
                        ?>
                        <td>-</td>
                        <?php
                    }
                    ?>
                    <td><?= emptyToStrip($item['address']) ?></td>
                    <td><?= emptyToStrip($item['handphone']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

    </table>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            VI. KURSUS / DIKLAT
        </h3>
    </div>

    <table class="dat">
        <tr>
            <th>No</th>
            <th>Nama Kursus/Diklat</th>
            <th>Lama Kursus/Jumlah Jam</th>
            <th>No. Sertifikat</th>
            <th>Tanggal Sertifikat</th>
            <th>Penyelenggara</th>
        </tr>

        <?php
        $i = 1;
        if (empty($data['rows']['Training'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 7>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows']['Training'] as $item) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= emptyToStrip($item['name']) ?></td>
                    <td><?= emptyToStrip($item['duration']) ?></td>
                    <td><?= emptyToStrip($item['nomor_sertifikat']) ?></td>
                    <td><?= emptyToStrip($this->Html->cvtTanggal($item['tanggal_sertifikat'], false)) ?></td>
                    <td><?= emptyToStrip($item['penyelenggara']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

    </table>
    <div width="100%" border="0">
        <h3 style="text-align: left; border-bottom:1px solid #000; font-family:Tahoma, Geneva, sans-serif; font-size:10px; font-weight:700; line-height: 20px;">
            VII. PENGHARGAAN
        </h3>
    </div>

    <table class="dat">
        <tr>
            <th>No</th>
            <th>Nama Penghargaan</th>
            <th>Nomor Surat Keputusan</th>
            <th>Tanggal Keputusan</th>
            <th>Instansi Pemberi Penghargaan</th>
        </tr>

        <?php
        $i = 1;
        if (empty($data['rows']['Honor'])) {
            ?>
            <tr>
                <td class = "text-center" colspan = 5>Tidak Ada Data</td>
            </tr>
            <?php
        } else {
            foreach ($data['rows']['Honor'] as $item) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= emptyToStrip($item['name']) ?></td>
                    <td><?= emptyToStrip($item['nomor_surat_keputusan']) ?></td>
                    <td><?= emptyToStrip($this->Html->cvtTanggal($item['tanggal_keputusan'], false)) ?></td>
                    <td><?= emptyToStrip($item['nama_pemberi']) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </table>


    <?php
}
?>