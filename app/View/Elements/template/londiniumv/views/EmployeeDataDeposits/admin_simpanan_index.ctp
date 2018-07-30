<?php
//echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/simpanan-index");
?>
<div class="row">
    <div class="col-md-12">
        <!-- /separated form outside panel -->
        <!-- Shipping method -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("DATA SIMPANAN PEGAWAI") ?> 
                        <div class="pull-right">
                            <button class="btn btn-xs btn-default" title="Print Data" type="button" onclick="exp('print', '<?php echo Router::url("simpanan_index/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                                <i class="icon-print2"></i>
                                Print
                            </button>&nbsp;
                            <button class="btn btn-xs btn-default" title="Ekspor Ke Excel" type="button" onclick="exp('excel', '<?php echo Router::url("simpanan_index/excel?" . $_SERVER['QUERY_STRING'], true) ?>')">
                                <i class="icon-file-excel"></i>
                                Excel
                            </button>&nbsp;
                        </div>
                        <small class="display-block">Periode Tahun : <strong><?= date('Y', strtotime(date("Y-m-01"))); ?></strong></small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered">
                        <tbody><tr>
                                <td width="2%" rowspan="2"><a href="<?= Router::url($this->Session->read("credential.admin.User.profile_picture"), true) ?>" class="lightbox" title="<?= $this->Session->read("credential.admin.Biodata.full_name") ?>"><img src="<?= Router::url($this->Session->read("credential.admin.User.profile_picture"), true) ?>" width="40px" alt="" class="img-media"></a></td>
                                <td width="15%"><?= __("Nama Pegawai") ?></td>
                                <td width="1%" align="center" valign="middle">:</td>
                                <td width="34%"><?= $this->Session->read("credential.admin.Biodata.full_name"); ?></td>
                                <td width="15%"><?= __("NIP") ?></td>
                                <td width="1%" align="center">:</td>
                                <td width="34%"><?= $this->Session->read("credential.admin.Employee.nip"); ?></td>
                            </tr>
                            <tr>
                                <td><?= __("Jabatan") ?></td>
                                <td align="center" valign="middle">:</td>
                                <td><?= $this->Session->read("credential.admin.Employee.Office.name"); ?></td>
                                <td><?= __("Department") ?></td>
                                <td align="center">:</td>
                                <td>
                                    <?= $this->Session->read("credential.admin.Employee.Department.name"); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="table-responsive pre-scrollable">
                        <table width="100%" class="table table-hover table-bordered">
                            <thead>
                                <tr height="50px">
                                    <th class="text-center" width="1%" align="center" valign="middle" bgcolor="#FFFFCC">No</th>
                                    <th class="text-center" width="45%" bgcolor="#FFFFCC" colspan = "2"><?= __("Jumlah Simpanan") ?></th>
                                    <th class="text-center" width="45%" bgcolor="#FFFFCC"><?= __("Tanggal Simpanan") ?></th>
                                    <!--<th class="text-center" width="5%" bgcolor="#FFFFCC"><?= __("Aksi") ?></th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $limit = intval(isset($this->params['named']['limit']) ? $this->params['named']['limit'] : 10);
                                $page = intval(isset($this->params['named']['page']) ? $this->params['named']['page'] : 1);
                                $i = ($limit * $page) - ($limit - 1);
                                if (empty($dataDeposit)) {
                                    ?>
                                    <tr>
                                        <td class = "text-center" colspan = 13>Tidak Ada Data</td>
                                    </tr>
                                    <?php
                                } else {
                                        ?>
                                        <tr id="row-<?= $i ?>" class="removeRow<?php echo $dataDeposit[Inflector::classify($this->params['controller'])]['id']; ?>">
                                            <td class="text-center" width="1%" align="center" valign="middle"><?= $i ?></td>
                                            <td class="text-center" width="1%" align="center" valign="middle" style = "border-right-style:none !important" >Rp. </td>
                                            <td class="text-center" width="3%" align="center" valign="middle" style = "border-left-style:none !important" ><?= $this->Html->Rp($dataDeposit['EmployeeDataDeposit']['balance']) ?></td>
                                            <td class="text-center" width="3%" align="center" valign="middle"><?= $this->Html->cvtWaktu($dataDeposit['EmployeeDataDeposit']['transaction_date']) ?></td>
                                            <!--<td width="2%" class="text-center"><a data-toggle="modal" role="button" href="#default-modal" class="btn btn-default btn-xs btn-icon tip" title="" data-original-title="Lihat Data"><i class="icon-eye7"></i></a></td>-->
                                        </tr>
                                        <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /shipping method -->

                </div>
                <!-- Shipping method -->

            </div>
            <!-- /page content -->
        </div>
        <!-- Default modal -->
        <div id="default-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Data Penghasilan</h4>
                    </div>
                    <!-- New invoice template -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="block-inner text-danger">
                                <h6 class="heading-hr">DATA PENGHASILAN <div class="pull-right"><button class="btn btn-xs btn-default" type="button"><i class="icon-print2"></i> Print</button>&nbsp;<button class="btn btn-xs btn-default" type="button"><i class="icon-file-excel"></i> Excel</button>&nbsp;<button class="btn btn-xs btn-default" type="button"><i class="icon-file-pdf"></i> PDF</button></div><small class="display-block">Periode : <strong>Januari 2016</strong></small></h6>
                            </div>
                            <div class="table-responsive">
                                <table width="100%" class="table table-bordered">
                                    <tbody><tr>
                                            <td width="5%" rowspan="2" align="center" valign="middle"><a href="images/demo/users/face3.png" class="lightbox" title="Eugene A. Kopyov"><img src="images/demo/users/face3.png" alt="" class="img-media"></a></td>
                                            <td width="15%">Nama Pegawai</td>
                                            <td width="1%" align="center" valign="middle">:</td>
                                            <td width="34%">Muhammad Nasrullah, S.Kom</td>
                                            <td width="1%" rowspan="2">&nbsp;</td>
                                            <td width="15%">Department</td>
                                            <td width="1%" align="center">:</td>
                                            <td width="34%">Direksi</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td align="center" valign="middle">:</td>
                                            <td>Direktur Utama</td>
                                            <td>Periode Laporan</td>
                                            <td align="center">:</td>
                                            <td>01 Januari 2016  s/d  31 Januari 2016</td>
                                        </tr>
                                    </tbody></table>
                                <br>
                                <!-- Form bordered -->
                                <form class="form-horizontal" action="#" role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i>PENDAPATAN</h6></div><table width="100%" class="table">

                                                    <tbody><tr>
                                                            <td colspan="3" style="width:200px">
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label">Gaji Pokok</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari setup parameter gaji">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">Tunjangan Jabatan</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari setup parameter gaji">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px">
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label">Tunjangan Konsumsi</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari setup parameter gaji">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">Tunjangan Komunikasi</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari setup parameter gaji">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px">
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label">Lembur Harian</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="dihitung dari absensi dan biaya lembur per jam">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">TOTAL PENDAPATAN</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="Auto Kalkulasi" style="background:#ff0000; color:#fff">
                                                                    </div></div></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i>POTONGAN</h6>
                                                </div><table width="100%" class="table">

                                                    <tbody><tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">Keterlambatan</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari data denda keterlambatan">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">Kehadiran</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari data denda kehadiran">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">Kasbon</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="diambil dari data kasbon karyawan">
                                                                    </div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">TOTAL POTONGAN</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="Auto Kalkulasi" style="background:#ff0000; color:#fff">
                                                                    </div></div></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div>&nbsp;</div>
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <div class="panel-heading" style="background:#2179cc">
                                                    <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i>KETERANGAN</h6>
                                                </div><table width="100%" class="table">

                                                    <tbody><tr>
                                                            <td colspan="3" style="width:200px"><div class="form-group">
                                                                    <label class="col-sm-4 control-label">TOTAL GAJI DITERIMA</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" readonly="" value="Auto Kalkulasi (Pendapatan - Potongan)" style="background:#ff0000; color:#fff">
                                                                    </div></div></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /new invoice template -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form></div>
                        </div>
                    </div>
                    <!-- /default modal -->
                    <!-- /page container -->

                </div></div></div></div></div>