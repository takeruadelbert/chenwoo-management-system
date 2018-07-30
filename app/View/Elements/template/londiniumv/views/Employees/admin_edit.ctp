<?php echo $this->Form->create("Employee", array("class" => "form-horizontal form-separate", "action" => "edit", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#data-utama" data-toggle="tab"><i class="icon-user3"></i> <?= __("Data Utama") ?></a></li>
        <li><a href="#posisi-jabatan" data-toggle="tab"> <?= __("Posisi & Jabatan") ?></a></li>
        <li><a href="#data-login" data-toggle="tab"><?= __("Login") ?></a></li>
        <li><a href="#riwayat-pendidikan" data-toggle="tab"> <?= __("Riwayat Pendidikan") ?></a></li>
        <li><a href="#riwayat-jabatan" data-toggle="tab"> <?= __("Riwayat Jabatan") ?></a></li>
        <li><a href="#data-keluarga" data-toggle="tab"> <?= __("Data Keluarga") ?></a></li>
        <li><a href="#riwayat-diklat" data-toggle="tab"> <?= __("Kursus/Diklat") ?></a></li>
        <li><a href="#penghargaan" data-toggle="tab"> <?= __("Penghargaan") ?></a></li>
        <li><a href="#catatan" data-toggle="tab"> <?= __("Catatan") ?></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active fade in" id="data-utama">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Utama") ?>
                        </h6>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.nip", __("NIK"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.nip", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                    <?php
                                    echo $this->Form->input("Employee.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Account.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Account.Biodata.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Account.User.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Family.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Couple.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("EducationHistory.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("EmployeeParent.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("EmployeeParent.1.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Honor.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("PositionHistory.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("Training.0.id", array("type" => "hidden", "class" => "form-control"));
                                    echo $this->Form->input("EmployeeSignature.id", array("type" => "hidden", "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.first_name", __("Nama Depan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.first_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.last_name", __("Nama Belakang"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.last_name", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.gelar_depan", __("Gelar Depan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.gelar_depan", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.gelar_belakang", __("Gelar Belakang"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.gelar_belakang", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.tempat_lahir_kota", __("Kota Kelahiran"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.tempat_lahir_kota", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.tanggal_lahir", __("Tanggal Lahir"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.tanggal_lahir", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker", "type" => "text"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.religion_id", __("Agama"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.religion_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Agama -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.gender_id", __("Jenis Kelamin"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.gender_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Kelamin -"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.marital_status_id", __("Status Perkawinan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.marital_status_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Status Perkawinan -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.User.email", __("Email"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.User.email", array("type" => "email", "div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.address", __("Alamat"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.address", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.state_id", __("Provinsi"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.state_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full city-state", "data-city-state-target" => "#AccountBiodataCityId", "empty" => "- Pilih Provinsi -"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.city_id", __("Kota"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.city_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full city-state-target", "empty" => "- Pilih Kota -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.postal_code", __("Kode Pos"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.postal_code", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.handphone", __("No. HP"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.handphone", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "empty" => "- Pilih Provinsi -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.Biodata.phone", __("No. Telp"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.Biodata.phone", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("EmployeeSignature.file", __("Tanda Tangan"), array("class" => "col-md-4 control-label", "style" => "padding-top: 15px"));
                                    ?>
                                    <?php
                                    $link_image = "";
                                    if (!empty($this->data['EmployeeSignature']['AssetFile']['id'])) {
                                        $link_image = Router::url("/admin/AssetFiles/getfile/{$this->data['EmployeeSignature']['AssetFile']['id']}/{$this->data['EmployeeSignature']['AssetFile']['token']}?dl=0");
                                    }
                                    ?>
                                    <img src = "<?= $link_image ?>" style = "width:150px;padding-top: 15px" class = "col-md-8" >
                                    <?php
                                    echo "<div class='form-group'></div>";
                                    echo $this->Form->input("EmployeeSignature.file", array("div" => array("class" => "col-md-8 col-md-offset-4"), "label" => false, "class" => "styled form-control", "type" => "file"));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Foto.file", __("Foto Pegawai"), array("class" => "col-md-4 control-label", "style" => "padding-top: 15px"));
                                    echo $this->Html->image(Router::url($this->data['Account']['User']['profile_picture'], true), array("class" => "col-md-8 col-sm-11 col-md-10", "style" => "width:150px;padding-top: 15px"));
                                    echo "<div class='form-group'></div>";
                                    echo $this->Form->input("Foto.file", array("div" => array("class" => "col-md-8 col-md-offset-4"), "label" => false, "class" => "styled form-control", "type" => "file", "after" => "<span class='help-block'>Format File Hanya Bisa: <strong>jpg, jpeg, png, gif.</strong> Dengan Ukuran File Maksimal 10Mb</span>"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="posisi-jabatan">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Posisi & Jabatan") ?>
                        </h6>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.department_id", __("Department"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.department_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Department -"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.office_id", __("Nama Jabatan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.office_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jabatan Struktural -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.employee_type_id", __("Tipe Pegawai"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.employee_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Pegawai -"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.tmt", __("Tanggal Mulai Kerja"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.tmt", array("type" => "text", "div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control datepicker"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.branch_office_id", __("Cabang Perusahaan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.branch_office_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Cabang Perusahaan -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="riwayat-pendidikan">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Riwayat Pendidikan") ?>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sekolah /<br/>Perguruan Tinggi</th>
                                    <th width="120">Tingkat Pendidikan</th>
                                    <th>Fakultas / Prodi / Jurusan /<br/>Konsentrasi / Minat</th>
                                    <th>No.Ijazah</th>
                                    <th width="120">Tanggal Lulus</th>
                                    <th>Nama Kepsek / Ketua / Direktur /<br/>Dekan / Rektor</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-riwayat-pendidikan">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["EducationHistory"]);
                                foreach ($this->data["EducationHistory"] as $i => $value) {
                                    ?>
                                    <tr class="dynamic-row">
                                        <td class="text-center nomorIdx"><?= $no; ?></td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("EducationHistory.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("EducationHistory.$i.nama_sekolah", array("div" => false, "label" => false, "class" => "form-control"));
                                            ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("EducationHistory.$i.tingkat_pendidikan", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("EducationHistory.$i.jurusan", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("EducationHistory.$i.no_ijazah", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("EducationHistory.$i.tgl_lulus", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("EducationHistory.$i.nama_kepala", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
                                                    <i class="icon-remove3"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="8">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'riwayat-pendidikan')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="riwayat-jabatan">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Riwayat Jabatan") ?>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jabatan</th>
                                    <th>Instansi</th>
                                    <th>Unit Kerja</th>
                                    <th>Nomor SK</th>
                                    <th>Tanggal SK</th>
                                    <th width="120">TMT</th>
                                    <th>Eselon</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-riwayat-jabatan">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["PositionHistory"]);
                                foreach ($this->data["PositionHistory"] as $i => $value) {
                                    ?>
                                    <tr class="dynamic-row">
                                        <td class="text-center nomorIdx"><?= $no; ?></td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("PositionHistory.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("PositionHistory.$i.nama_jabatan", array("div" => false, "label" => false, "class" => "form-control"));
                                            ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.instansi", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.unit_kerja", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.no_sk", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.tanggal_sk", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.tmt", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("PositionHistory.$i.eselon", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
                                                    <i class="icon-remove3"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="9">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'riwayat-jabatan')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
        <div class="tab-pane fade in" id="data-login">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Login") ?>
                        </h6>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.User.username", __("Username"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.User.username", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control"));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Employee.working_hour_type_id", __("Jam Kerja"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Employee.working_hour_type_id", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Jenis Jam Kerja -"));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="data-keluarga">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Data Keluarga") ?>
                        </h6>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="40">No</th>
                                        <th>Nama</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pendidikan</th>
                                        <th>Pekerjaan</th>
                                        <th>Agama</th>
                                        <th>Status Perkawinan</th>
                                        <th>Status Hidup</th>
                                        <th>Status Anak</th>
                                        <th>Alamat</th>
                                        <th>No. HP / Telp</th>
                                        <th width="40">Aksi</th>
                                    </tr>
                                <thead>
                                <tbody id="target-anak">
                                    <?php
                                    $no = 1;
                                    $dataN = count($this->data["Family"]);
                                    foreach ($this->data["Family"] as $i => $value) {
                                        ?>
                                        <tr class="dynamic-row">
                                            <td class="text-center nomorIdx"><?= $no; ?></td>
                                            <td>
                                                <?php
                                                echo $this->Form->input("Family.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                                echo $this->Form->input("Family.$i.name", array("div" => false, "label" => false, "class" => "form-control"));
                                                ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.tempat_lahir", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.tanggal_lahir", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.gender_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.education_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.job", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.religion_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.marital_status_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.life_status_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.family_relation_id", array("div" => false, "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih -")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.address", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input("Family.$i.handphone", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                            </td>
                                            <td align="center">
                                                <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                    <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
                                                        <i class="icon-remove3"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="14">
                                            <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'anak', 'anakOptions')" data-n="1"><i class="icon-plus-circle"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="riwayat-diklat">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Riwayat Kursus/Diklat") ?>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>Nama Kursus / Diklat</th>
                                    <th>Lama Kursus / Jumlah Jam</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Tanggal Sertifikat</th>
                                    <th>Penyelenggara</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-riwayat-diklat">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["Training"]);
                                foreach ($this->data["Training"] as $i => $value) {
                                    ?>
                                    <tr class="dynamic-row">
                                        <td class="text-center nomorIdx"><?= $no; ?></td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("Training.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("Training.$i.name", array("div" => false, "label" => false, "class" => "form-control"));
                                            ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Training.$i.duration", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Training.$i.nomor_sertifikat", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Training.$i.tanggal_sertifikat", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Training.$i.penyelenggara", array("div" => false, "label" => false, "class" => "form-control", "type" => "text")) ?>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
                                                    <i class="icon-remove3"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="6">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'riwayat-diklat')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="penghargaan">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Penghargaan") ?>
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered stn-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>Nama Penghargaan</th>
                                    <th>Nomor Surat Keputusan</th>
                                    <th>Tanggal Keputusan</th>
                                    <th>Nama Pemberi Penghargaan</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-penghargaan">
                                <?php
                                $no = 1;
                                $dataN = count($this->data["Honor"]);
                                foreach ($this->data["Honor"] as $i => $value) {
                                    ?>
                                    <tr class="dynamic-row">
                                        <td class="text-center nomorIdx"><?= $no; ?></td>
                                        <td>
                                            <?php
                                            echo $this->Form->input("Honor.$i.id", array("div" => false, "label" => false, "type" => "hidden", "class" => false));
                                            echo $this->Form->input("Honor.$i.name", array("div" => false, "label" => false, "class" => "form-control"));
                                            ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Honor.$i.nomor_surat_keputusan", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Honor.$i.tanggal_keputusan", array("div" => false, "label" => false, "class" => "form-control datepicker", "type" => "text")) ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->input("Honor.$i.nama_pemberi", array("div" => false, "label" => false, "class" => "form-control")) ?>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:void(false)" onclick="deleteThisRow($(this))">
                                                <button type="button" class="btn btn-default btn-xs btn-icon tip" title="Hapus">
                                                    <i class="icon-remove3"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                                <tr>
                                    <td colspan="6">
                                        <a class="text-success" href="javascript:void(false)" onclick="addThisRow($(this), 'penghargaan')" data-n="1"><i class="icon-plus-circle"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="catatan">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="block-inner text-danger">
                        <h6 class="heading-hr"><?= __("Catatan") ?>
                        </h6>
                    </div>
                    <div>
                        <?= $this->Form->input("Employee.note", array("div" => false, "label" => false, "class" => "form-control")) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                <input type="reset" value="Reset" class="btn btn-info">
                <button class="btn btn-danger" data-toggle="modal" data-target="#edit" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_edit', true); ?>">
                    <?= __("Simpan") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    var genders =<?= $this->Engine->toJSONoptions($genders) ?>;
    var education_levels =<?= $this->Engine->toJSONoptions($educations) ?>;
    var religions =<?= $this->Engine->toJSONoptions($religions) ?>;
    var marital_statuses =<?= $this->Engine->toJSONoptions($maritalStatuses, "- Pilih -") ?>;
    var life_statuses =<?= $this->Engine->toJSONoptions($lifeStatuses, "- Pilih -") ?>;
    var family_relations =<?= $this->Engine->toJSONoptions($familyRelations, "- Pilih -") ?>;
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        e.parents("tr").remove();
        fixNumber(tbody);
    }
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $('#target-' + t + " tr:last").before(rendered);
        $(e).data("n", n + 1);
        reloadDatePicker();
        reloadSelect2();
        fixNumber($(e).parents("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function anakOptions() {
        return {genders: genders, education_levels: education_levels, religions: religions, marital_statuses: marital_statuses, life_statuses: life_statuses, family_relations: family_relations};
    }

    reloadStyled();
</script>
<script type="x-tmpl-mustache" id="tmpl-riwayat-pendidikan">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][nama_sekolah]" class="form-control" maxlength="255" type="text" id="EducationHistory{{n}}NamaSekolah">                                    
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][tingkat_pendidikan]" class="form-control" maxlength="45" type="text" id="EducationHistory{{n}}TingkatPendidikan">                                    
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][jurusan]" class="form-control" maxlength="255" type="text" id="EducationHistory{{n}}Jurusan">                                    
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][no_ijazah]" class="form-control" maxlength="255" type="text" id="EducationHistory{{n}}NoIjazah">                                    
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][tgl_lulus]" class="form-control datepicker" type="text" id="EducationHistory{{n}}TglLulus">                                    
    </td>
    <td>
    <input name="data[EducationHistory][{{n}}][nama_kepala]" class="form-control" maxlength="255" type="text" id="EducationHistory{{n}}NamaKepala">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-riwayat-jabatan">
    <tr>
    <td class="text-center nomorIdx">
    {{i}}
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][nama_jabatan]" class="form-control" type="text" id="PositionHistory{{n}}NamaJabatan">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][instansi]" class="form-control" type="text" id="PositionHistory{{n}}Instansi">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][unit_kerja]" class="form-control" type="text" id="PositionHistory{{n}}UnitKerja">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][no_sk]" class="form-control" type="text" id="PositionHistory{{n}}NoSk">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][tanggal_sk]" class="form-control datepicker" type="text" id="PositionHistory{{n}}TanggalSk">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][tmt]" class="form-control datepicker" type="text" id="PositionHistory{{n}}Tmt">                                    
    </td>
    <td>
    <input name="data[PositionHistory][{{n}}][eselon]" class="form-control" type="text" id="PositionHistory{{n}}Eselon">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-anak">
    <tr>
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    <input name="data[Family][{{n}}][name]" class="form-control" maxlength="255" type="text" id="Family{{n}}Name">                                    
    </td>
    <td>
    <input name="data[Family][{{n}}][tempat_lahir]" class="form-control" maxlength="255" type="text" id="Family{{n}}TempatLahir">                                    
    </td>
    <td>
    <input name="data[Family][{{n}}][tanggal_lahir]" class="form-control datepicker" type="text" id="Family{{n}}TanggalLahir">                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][gender_id]" class="select-full" id="Family{{n}}GenderId" placeholder="- Pilih -">
    {{#genders}}
    <option value="{{value}}">{{label}}</option>
    {{/genders}}
    </select>                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][education_level_id]" class="select-full" id="Family{{n}}EducationLevelId" placeholder="- Pilih -">
    {{#education_levels}}
    <option value="{{value}}">{{label}}</option>
    {{/education_levels}}
    </select>                                    
    </td>
    <td>
    <input name="data[Family][{{n}}][job]" class="form-control" maxlength="255" type="text" id="Family{{n}}Job">                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][religion_id]" class="select-full" id="Family{{n}}ReligionId" placeholder="- Pilih -">
    {{#religions}}
    <option value="{{value}}">{{label}}</option>
    {{/religions}}
    </select>                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][marital_status_id]" class="select-full" id="Family{{n}}MaritalStatusId" placeholder="- Pilih -">
    {{#marital_statuses}}
    <option value="{{value}}">{{label}}</option>
    {{/marital_statuses}}
    </select>                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][life_status_id]" class="select-full" id="Family{{n}}LifeStatusId" placeholder="- Pilih -">
    {{#life_statuses}}
    <option value="{{value}}">{{label}}</option>
    {{/life_statuses}}
    </select>                                    
    </td>
    <td>
    <select name="data[Family][{{n}}][family_relation_id]" class="select-full" id="Family{{n}}FamilyRelationId" placeholder="- Pilih -">
    {{#family_relations}}
    <option value="{{value}}">{{label}}</option>
    {{/family_relations}}
    </select>                                    
    </td>
    <td>
    <input name="data[Family][{{n}}][address]" class="form-control" maxlength="255" type="text" id="Family{{n}}Address">                                    
    </td>
    <td>
    <input name="data[Family][{{n}}][handphone]" class="form-control" maxlength="45" type="text" id="Family{{n}}Handphone">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-riwayat-diklat">
    <tr>
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    <input name="data[Training][{{n}}][name]" class="form-control" type="text" id="Training{{n}}Name">                                   
    </td>
    <td>
    <input name="data[Training][{{n}}][duration]" class="form-control" type="text" id="Training{{n}}Duration">                                    
    </td>
    <td>
    <input name="data[Training][{{n}}][nomor_sertifikat]" class="form-control" type="text" id="Training{{n}}NomorSertifikat">                                    
    </td>
    <td>
    <input name="data[Training][{{n}}][tanggal_sertifikat]" class="form-control datepicker" type="text" id="Training{{n}}TanggalSertifikat">                                    
    </td>
    <td>
    <input name="data[Training][{{n}}][penyelenggara]" class="form-control" type="text" id="Training{{n}}Penyelenggara">                                    
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
<script type="x-tmpl-mustache" id="tmpl-penghargaan">
    <tr>
    <td class="text-center nomorIdx">{{i}}</td>
    <td>
    <input name="data[Honor][{{n}}][name]" class="form-control" maxlength="255" type="text" id="Honor{{n}}Name">
    </td>
    <td>
    <input name="data[Honor][{{n}}][nomor_surat_keputusan]" class="form-control" maxlength="255" type="text" id="Honor{{n}}NomorSuratKeputusan">
    </td>
    <td>
    <input name="data[Honor][{{n}}][tanggal_keputusan]" class="form-control datepicker" type="text" id="Honor{{n}}TanggalKeputusan">
    </td>
    <td>
    <input name="data[Honor][{{n}}][nama_pemberi]" class="form-control" maxlength="255" type="text" id="Honor{{n}}NamaPemberi"> 
    </td>
    <td class="text-center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>
