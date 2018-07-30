<?php
echo $this->element(_TEMPLATE_DIR . "/{$template}/filter/laporan-surat");

if (isset($inMail)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr">HASIL PENCARIAN DATA SURAT MASUK <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("laporan/print?" . $_SERVER['QUERY_STRING'], true) ?>')">
                            <i class="icon-print2"></i> 
                            <?= __("Cetak") ?>
                        </button>&nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("laporan/excel?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class="icon-file-excel"></i> Excel</button>
                    </div>
                    <small class="display-block">Dinas Pemuda Olahraga dan Pariwisata Provinsi Sulawesi Barat</small></h6>
            </div>
            <div class="table-responsive">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style=" text-align:center" width="5px" bgcolor="#FFFFCC">No</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tanggal</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">No. Agenda</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">No. Surat</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tanggal Surat</th>
                            <th style=" text-align:center" width="20px" bgcolor="#FFFFCC">Perihal</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Pengirim</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tujuan</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Asal Surat</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Klasifikasi Surat</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Jenis Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (empty($inMail)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($inMail as $item) {
                                ?>
                                <tr>
                                    <td style=" text-align:center"><?= $i ?></td>
                                    <td style=" text-align:left">Senin</td>
                                    <td style=" text-align:left"><?= $item['IncomingMail']['nomor_agenda'] ?></td>
                                    <td style=" text-align:center"><?= $item['IncomingMail']['nomor_surat'] ?></td>
                                    <td style=" text-align:center"><?= $this->Html->cvtTanggal($item['IncomingMail']['created']) ?></td>
                                    <td style=" text-align:center"><?= $item['IncomingMail']['perihal'] ?></td>
                                    <td style=" text-align:center"><?= $item['IncomingMail']['pengirim'] ?></td>
                                    <td style=" text-align:center"><?= $item['IncomingMail']['tujuan'] ?></td>
                                    <td style=" text-align:center"><?= $item['MailOrigin']['name'] ?></td>
                                    <td style=" text-align:center"><?= $item['MailClassification']['name'] ?></td>
                                    <td style=" text-align:center"><?= $item['MailType']['name'] ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} else if (isset($outMail)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr">HASIL PENCARIAN DATA SURAT KELUAR <div class="pull-right"><button class="btn btn-xs btn-default" type="button"><i class="icon-print2"></i> Print</button>&nbsp;<button class="btn btn-xs btn-default" type="button"><i class="icon-file-excel"></i> Excel</button>&nbsp;<button class="btn btn-xs btn-default" type="button"><i class="icon-file-pdf"></i> PDF</button></div><small class="display-block">Dinas Pemuda Olahraga dan Pariwisata Provinsi Sulawesi Barat</small></h6>
            </div>
            <div class="table-responsive">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style=" text-align:center" width="5px" bgcolor="#FFFFCC">No</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tanggal</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">No. Agenda</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">No. Surat</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tanggal Surat</th>
                            <th style=" text-align:center" width="20px" bgcolor="#FFFFCC">Perihal</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Pengirim</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Tujuan</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Lampiran</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Klasifikasi Surat</th>
                            <th style=" text-align:center" width="50px" bgcolor="#FFFFCC">Jenis Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (empty($outMail)) {
                            ?>
                            <tr>
                                <td class = "text-center" colspan = 11>Tidak Ada Data</td>
                            </tr>
                            <?php
                        } else {
                            foreach ($outMail as $item) {
                                ?>
                                <tr>
                                    <td style=" text-align:center"><?= $i ?></td>
                                    <td style=" text-align:left">Senin</td>
                                    <td style=" text-align:left"><?= $item['OutgoingMail']['nomor_agenda'] ?></td>
                                    <td style=" text-align:center"><?= $item['OutgoingMail']['nomor_surat'] ?></td>
                                    <td style=" text-align:center"><?= $this->Html->cvtTanggal($item['OutgoingMail']['created']) ?></td>
                                    <td style=" text-align:center"><?= $item['OutgoingMail']['perihal'] ?></td>
                                    <td style=" text-align:center"><?= $item['OutgoingMail']['pengirim'] ?></td>
                                    <td style=" text-align:center"><?= $item['OutgoingMail']['tujuan'] ?></td>
                                    <td style=" text-align:center"><?= $item['MailClassification']['name'] ?></td>
                                    <td style=" text-align:center"><?= $item['MailType']['name'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php }
?>

