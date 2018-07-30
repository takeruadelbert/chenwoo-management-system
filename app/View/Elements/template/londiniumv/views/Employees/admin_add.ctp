<?php echo $this->Form->create("Employee", array("class" => "form-horizontal form-separate", "action" => "add", "type" => "file", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<style>
    .table td {
        white-space: nowrap;
    }
</style>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#data-utama" data-toggle="tab"><i class="fa fa-address-card-o"></i> <?= __("Data Utama") ?></a></li>
        <li><a href="#posisi-jabatan" data-toggle="tab"><i class="icon-tree3"></i> <?= __("Posisi & Jabatan") ?></a></li>
        <li><a href="#data-login" data-toggle="tab"><i class="icon-enter3"></i><?= __("Login") ?></a></li>
        <li><a href="#riwayat-pendidikan" data-toggle="tab"><i class="icon-office"></i> <?= __("Data Pendidikan") ?></a></li>
        <li><a href="#riwayat-jabatan" data-toggle="tab"><i class="fa fa-id-card-o"></i> <?= __("Riwayat Jabatan") ?></a></li>
        <li><a href="#data-keluarga" data-toggle="tab"><i class="fa fa-users"></i> <?= __("Data Keluarga") ?></a></li>
        <li><a href="#riwayat-diklat" data-toggle="tab"><i class="icon-clipboard"></i> <?= __("Kursus/Diklat") ?></a></li>
        <li><a href="#penghargaan" data-toggle="tab"><i class="icon-certificate"></i> <?= __("Penghargaan") ?></a></li>
        <li><a href="#catatan" data-toggle="tab"><i class="icon-file4"></i> <?= __("Catatan") ?></a></li>
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
                                    echo $this->Form->label("Account.User.email", __("Email"), array("class" => "col-md-4 control-label label-required"));
                                    echo $this->Form->input("Account.User.email", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "required" => true));
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
                                    echo $this->Form->label("EmployeeSignature.file", __("Tanda Tangan"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("EmployeeSignature.file", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "styled form-control", "type" => "file"));
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Foto.file", __("Foto Pegawai"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Foto.file", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "styled form-control", "type" => "file", "after" => "<span class='help-block'>Format File Hanya Bisa: <strong>jpg, jpeg, png, gif.</strong> Dengan Ukuran File Maksimal 10Mb</span>"));
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label("Account.User.password", __("Password"), array("class" => "col-md-4 control-label"));
                                    echo $this->Form->input("Account.User.password", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "value" => "chenwoo123", "type" => "text", "readonly" => true));
                                    echo $this->Form->hidden("Account.User.repeat_password", array("div" => array("class" => "col-md-8"), "label" => false, "class" => "form-control", "value" => "chenwoo123", "type" => "text"));
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
                        <div class="table-responsive pre-scrollable">
                            <table class="table table-hover table-bordered stn-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="40">No</th>
                                        <th width="200">Nama</th>
                                        <th width="200">Tempat Lahir</th>
                                        <th width="200">Tanggal Lahir</th>
                                        <th width="200">Jenis Kelamin</th>
                                        <th width="200">Pendidikan</th>
                                        <th width="200">Pekerjaan</th>
                                        <th width="200">Agama</th>
                                        <th width="200">Status Perkawinan</th>
                                        <th width="200">Status Hidup</th>
                                        <th width="200">Status Dalam Keluarga</th>
                                        <th width="200">Alamat</th>
                                        <th width="200">No. HP / Telp</th>
                                        <th width="40">Aksi</th>
                                    </tr>
                                <thead>
                                <tbody id="target-anak">
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
                                    <th>Lama Kursus /Jumlah Jam</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Tanggal Sertifikat</th>
                                    <th>Penyelenggara</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-riwayat-diklat">
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
                                    <th>Instansi Pemberi Penghargaan</th>
                                    <th width="40">Aksi</th>
                                </tr>
                            <thead>
                            <tbody id="target-penghargaan">
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
                        <?= $this->Form->input("Employee.note", array("div" => false, "label" => false, "class" => "form-control editor")) ?>
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
                <button class="btn btn-danger" data-toggle="modal" data-target="#add" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_add', true); ?>">
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

    $('#tppBebanPrestasiKerja').change(function () {
        if ($('#bebanKerja').is(':checked')) {
            $('#bebanKerjaHidden').attr('disabled', 'true');
        } else {
            $('#bebanKerjaHidden').removeAttr('disabled');
        }

        if ($('#prestasiKerja').is(':checked')) {
            $('#prestasiKerjaHidden').attr('disabled', 'true');
        } else {
            $('#prestasiKerjaHidden').removeAttr('disabled');
        }
    });

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