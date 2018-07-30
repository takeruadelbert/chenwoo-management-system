<div class="panel panel-default">
    <div class="panel-body">
        <div class="block-inner text-danger">
            <h6 class="heading-hr">EKSPEDISI SURAT MASUK <div class="pull-right" >
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('print', '<?= Router::url("/admin/{$this->params['controller']}/ekspedisi/{$result['IncomingMail']['id']}/print", true) ?>')"><i class="icon-print2"></i> Print</button>
                    &nbsp;
                    <button class="btn btn-xs btn-default" type="button" onclick="exp('excel', '<?= Router::url("/admin/{$this->params['controller']}/ekspedisi/{$result['IncomingMail']['id']}/excel", true) ?>')"><i class="icon-file-excel"></i> Excel</button>
                    &nbsp;
                </div>
                <small class="display-block">Dinas Pemuda Olahraga dan Pariwisata Provinsi Sulawesi Barat</small>
            </h6>
        </div>
        <div class="table-responsive">
            <table width="100%" class="table table-bordered">
                <tr>
                    <td width="15%">Nomor Agenda</td>
                    <td width="1%" align="center" valign="middle">:</td>
                    <td width="34%"><?= $result['IncomingMail']['nomor_agenda'] ?></td>
                    <td width="1%" rowspan="2">&nbsp;</td>
                    <td width="15%">Pengirim</td>
                    <td width="1%" align="center">:</td>
                    <td width="34%"><?= $result['IncomingMail']['pengirim'] ?></td>
                </tr>
                <tr>
                    <td>Nomor Surat</td>
                    <td align="center" valign="middle">:</td>
                    <td><?= $result['IncomingMail']['nomor_surat'] ?></td>
                    <td>Perihal</td>
                    <td align="center">:</td>
                    <td><?= $result['IncomingMail']['perihal'] ?></td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="table-responsive">
            <table width="100%" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="238" rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">TANGGAL</th>
                        <th colspan="3" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">PENERIMA</th>
                        <th colspan="2" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">PENGIRIM</th>
                    </tr>
                    <tr>
                        <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NIP</th>
                        <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NAMA</th>
                        <th width="182" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">STATUS</th>
                        <th width="173" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NIP</th>
                        <th width="149" align="center" valign="middle" bgcolor="#FFFFCC" style=" text-align:center">NAMA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result['MailRecipient'] as $mailRecipient) {
                        ?>
                        <tr>
                            <td valign="middle" style=" text-align:center"><?= $this->Html->cvtTanggal($mailRecipient['created'], false) ?></td>
                            <td valign="middle" style=" text-align:center"><?= $mailRecipient['Employee']['nip_baru'] ?></td>
                            <td valign="middle" style=" text-align:center"><?= $mailRecipient['Employee']['Account']['Biodata']['full_name'] ?></td>
                            <td valign="middle" style=" text-align:center">
                                <?php
                                if ($mailRecipient['seen']) {
                                    ?>
                                    <i class="icon-bubble-check" style="color:green"></i>&nbsp;Sudah Dibaca
                                    <?php
                                } else {
                                    ?>
                                    <i class="icon-bubble-blocked" style="color:red"></i>&nbsp;Belum Dibaca  
                                    <?php
                                }
                                ?>
                            </td>
                            <td valign="middle" style=" text-align:center"><?= !empty($mailRecipient['Dispositor']['nip_baru']) ? $mailRecipient['Dispositor']['nip_baru'] : "[mailroom]" ?></td>
                            <td valign="middle" style=" text-align:center"><?= !empty($mailRecipient['Dispositor']['Account']["Biodata"]["full_name"]) ? $mailRecipient['Dispositor']['Account']["Biodata"]["full_name"] : "[mailroom]" ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br/>
        <div class="form-actions text-center">
            <input name="Button" type="button" onclick="history.go(-1);
                    return true;" class="btn btn-success" value="<?= __("Kembali") ?>">
        </div>
    </div>
</div>
