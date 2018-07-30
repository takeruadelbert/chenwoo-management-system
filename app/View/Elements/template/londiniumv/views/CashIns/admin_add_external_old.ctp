<?php echo $this->Form->create("CashIn", array("class" => "form-horizontal form-separate", "action" => "add_external", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Tambah Kas Masuk Eksternal") ?>
                        <small class="display-block">Mohon Isikan Dengan Sesuai dan Benar</small>
                    </h6>
                </div>

                <div class="well block">
                    <div class="tabbable">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#justified-pill1" data-toggle="tab"><i class="icon-user4"></i>Data Pegawai</a></li>
                            <li><a href="#justified-pill3" data-toggle="tab"><i class="icon-user"></i>Data Partner</a></li>
                            <li><a href="#justified-pill4" data-toggle="tab"><i class="icon-phone2"></i>Data Kontak Person Partner</a></li>
                            <li><a href="#justified-pill2" data-toggle="tab"><i class="icon-file"></i>Data Kas Masuk</a></li>
                        </ul>
                        <div class="tab-content pill-content">
                            <div class="tab-pane fade in active" id="justified-pill1">
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php
                                                            echo $this->Form->label("Creator.Account.Biodata.full_name", __("Nama Pegawai"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Account.Biodata.full_name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Biodata.full_name")));
                                                            echo $this->Form->input("CashIn.creator_id", array("type" => "hidden", "value" => $this->Session->read("credential.admin.Employee.id")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.nip", __("NIP"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.nip", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.nip")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.Department.name", __("Departemen"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Department.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Department.name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Creator.Office.name", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Creator.Office.name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => $this->Session->read("credential.admin.Employee.Office.name")));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill3">
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="col-sm-3 col-md-4 control-label">
                                                                <label>Nama Partner</label>
                                                            </div>
                                                            <div class="has-feedback">
                                                                <div class="col-sm-9 col-md-8">                                                
                                                                    <input type="text" class="form-control typeahead-ajax-partner" placeholder="Cari Partner ...">
                                                                    <i class="icon-search3 form-control-feedback"></i>
                                                                    <input type="hidden" name="data[CashIn][partner_id]" id="partnerId">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                              
                                                            <?php
                                                            echo $this->Form->label("Partner.email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.email", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>     
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Partner.address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.address", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                
                                                            <?php
                                                            echo $this->Form->label("Partner.phone", __("Telepon"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.phone", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?> 
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                 
                                                            <?php
                                                            echo $this->Form->label("Partner.postal_code", __("Kode Pos"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.postal_code", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>         
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                            
                                                            <?php
                                                            echo $this->Form->label("Partner.city", __("Kota"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.city", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>     
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Partner.state", __("Provinsi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.state", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>   
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                             
                                                            <?php
                                                            echo $this->Form->label("Partner.country", __("Negara"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.country", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>            
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                           
                                                            <?php
                                                            echo $this->Form->label("Partner.website", __("Website"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.website", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>       
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill4">
                                <div class="table-responsive">
                                    <table width="100%" class="table">
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                          
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_name", __("Nama"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_name", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>     
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                           
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_position", __("Jabatan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_position", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>        
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                           
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_email", __("Email"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_email", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                   
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_address", __("Alamat"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_address", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>  
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                              
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_phone", __("Telepon"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_phone", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>             
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                     
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_city", __("Kota"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_city", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>           
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="width:200px">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_state", __("Provinsi"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_state", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>             
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                              
                                                            <?php
                                                            echo $this->Form->label("Partner.cp_country", __("Negara"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                            echo $this->Form->input("Partner.cp_country", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled"));
                                                            ?>        
                                                        </div>
                                                    </div>
                                                </div>                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="justified-pill2">
                                <table width="100%" class="table">
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CashIn.cash_in_number", __("Nomor Kas Masuk"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.cash_in_number", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control", "disabled", "value" => "Akan Digenerate Setelah Disimpan"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-md-4 control-label label-required">
                                                            <label>Nominal</label>
                                                        </div>
                                                        <div class="col-sm-9 col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><strong>Rp.</strong></span>
                                                                <input type="text" class="form-control text-right isdecimal" name="data[CashIn][amount]" required="required">
                                                                <span class="input-group-addon"><strong>,00.</strong></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CashIn.initial_balance_id", __("Tipe Kas Yang Digunakan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.initial_balance_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Tipe Kas -"));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php
                                                        echo $this->Form->label("CashIn.created_datetime", __("Tanggal"), array("class" => "col-sm-3 col-md-4 control-label"));
                                                        echo $this->Form->input("CashIn.created_datetime", array("type" => "text", "div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control datetime", "value" => date("Y-m-d H:i:s")));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="width:200px">
                                            <div class="form-group">
                                                <?php
                                                echo $this->Form->label("CashIn.note", __("Keterangan"), array("class" => "col-sm-2 control-label"));
                                                echo $this->Form->input("CashIn.note", array("div" => array("class" => "col-sm-10"), "label" => false, "class" => "ckeditor fix"));
                                                ?>
                                            </div>                           
                                        </td>
                                    </tr>
                                </table>
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
    </div>
</div>
<?php echo $this->Form->end() ?>

<script>
    $(document).ready(function () {
        /* Cari Nama Partner */
        var partner = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= Router::url("/admin/partners/list", true) ?>',
            remote: {
                url: '<?= Router::url("/admin/partners/list", true) ?>' + '?q=%QUERY',
                wildcard: '%QUERY',
            }
        });
        partner.clearPrefetchCache();
        partner.initialize(true);
        $('input.typeahead-ajax-partner').typeahead({
            hint: false,
            highlight: true
        }, {
            name: 'partner',
            display: 'name',
            source: partner.ttAdapter(),
            templates: {
                header: '<center><h5>Data Partner</h5></center><hr>',
                suggestion: function (data) {
                    return '<p> Nama : ' + data.name + '<br/> Alamat : ' + data.address + '<br/> Lokasi : ' + data.location + '<br/> Telepon : ' + data.phone + '<br>Handphone : ' + data.handphone + '<br>Email : ' + data.email + '</p>';
                },
                empty: [
                    '<center><h5>Data Partner</h5></center><hr> <center><p> Hasil Pencarian Anda Tidak Dapat Ditemukan. </p></center>',
                ]
            }
        });
        $('input.typeahead-ajax-partner').bind('typeahead:select', function (ev, suggestion) {
            $("#partnerId").val(suggestion.id);
            $("#PartnerCity").val(suggestion.city);
            $("#PartnerState").val(suggestion.state);
            $("#PartnerCountry").val(suggestion.country);
            $("#PartnerAddress").val(suggestion.address);
            $("#PartnerPostalCode").val(suggestion.postal_code);
            $("#PartnerPhone").val(suggestion.phone);
            $("#PartnerHandphone").val(suggestion.handphone);
            $("#PartnerEmail").val(suggestion.email);
            $("#PartnerWebsite").val(suggestion.website);


            $("#PartnerCpCity").val(suggestion.cp_city);
            $("#PartnerCpState").val(suggestion.cp_state);
            $("#PartnerCpCountry").val(suggestion.cp_country);
            $("#PartnerCpAddress").val(suggestion.cp_address);
            $("#PartnerCpPosition").val(suggestion.cp_position);
            $("#PartnerCpPhone").val(suggestion.cp_phone);
            $("#PartnerCpEmail").val(suggestion.cp_email);
            $("#PartnerCpName").val(suggestion.cp_name);
        });
    });
</script>