<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="block-inner text-danger">
                <h6 class="heading-hr">KORESPONDENSI SURAT MASUK 
                    <div class="pull-right">
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?php echo Router::url("korespondensi/{$result[0]["IncomingMail"]['id']}/print?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class="icon-print2"></i> Print</button>
                        &nbsp;
                        <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?php echo Router::url("korespondensi/{$result[0]["IncomingMail"]['id']}/excel?" . $_SERVER['QUERY_STRING'], true) ?>')"><i class="icon-file-excel"></i> Excel</button>
                    </div>
                    <small class="display-block">Dinas Pemuda Olahraga dan Pariwisata Provinsi Sulawesi Barat</small>
                </h6>
            </div>
            <div class="table-responsive">
                <table width="100%" class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="15%">Nomor Agenda</td>
                            <td width="1%" align="center" valign="middle">:</td>
                            <td width="34%"><?= $result[0]['IncomingMail']['nomor_agenda'] ?></td>
                            <td width="1%" rowspan="2">&nbsp;</td>
                            <td width="15%">Pengirim</td>
                            <td width="1%" align="center">:</td>
                            <td width="34%"><?= $result[0]['IncomingMail']['pengirim'] ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Surat</td>
                            <td align="center" valign="middle">:</td>
                            <td><?= $result[0]['IncomingMail']['nomor_surat'] ?></td>
                            <td>Perihal</td>
                            <td align="center">:</td>
                            <td><?= $result[0]['IncomingMail']['perihal'] ?></td>
                        </tr>
                    </tbody></table>
            </div>
            <br>
            <div class="table-responsive">
                <table width="100%" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10%" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">Jenis Surat</th>
                            <th width="15%" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">Nomor Agenda</th>
                            <th width="15%" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">Nomor Surat</th>
                            <th align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">Perihal</th>
                            <th width="5%" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">Lihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $item) {
                            if (substr($item['uniq'], 0, 1) == 'm') {
                                ?>
                                <tr>
                                    <td align="center" valign="middle" style=" text-align:center">Surat Masuk</td>
                                    <td valign="middle" style=" text-align:center"><?= $item['IncomingMail']['nomor_agenda'] ?></td>
                                    <td width="173" valign="middle" style=" text-align:center"><?= $item['IncomingMail']['nomor_surat'] ?></td>
                                    <td width="173" valign="middle" style=" text-align:center"><?= $item['IncomingMail']['perihal'] ?></td>
                                    <td width="5%" valign="middle" style=" text-align:center"><a href="<?= Router::url("/admin/incoming_mails/view/" . $item['IncomingMail']['id']) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="" data-original-title="Lihat Surat"><i class="icon-eye7"></i></button></a></td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td align="center" valign="middle" style=" text-align:center">Surat Keluar</td>
                                    <td valign="middle" style=" text-align:center"><?= $item['OutgoingMail']['nomor_agenda'] ?></td>
                                    <td width="173" valign="middle" style=" text-align:center"><?= $item['OutgoingMail']['nomor_surat'] ?></td>
                                    <td width="173" valign="middle" style=" text-align:center"><?= $item['OutgoingMail']['perihal'] ?></td>
                                    <td width="5%" valign="middle" style=" text-align:center"><a href="<?= Router::url("/admin/outgoing_mails/view/" . $item['OutgoingMail']['id']) ?>"><button type="button" class="btn btn-default btn-xs btn-icon tip" title="" data-original-title="Lihat Surat"><i class="icon-eye7"></i></button></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="form-actions text-center">
                <input name="Button" type="button" onclick="history.go(-1);
                        return true;" class="btn btn-success" value="Kembali">
                <input type="reset" value="Reset" class="btn btn-info">
                <input type="submit" value="Simpan" class="btn btn-danger">
            </div>
        </div>
        <!-- /shipping method -->
    </div>
</div>