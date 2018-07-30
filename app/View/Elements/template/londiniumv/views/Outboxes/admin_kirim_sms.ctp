<?php echo $this->Form->create("Outbox", array("class" => "form-horizontal form-separate", "action" => "kirim_sms", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Kirim SMS") ?>
                    </h6>
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Outbox.tujuan", __("Tujuan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Outbox.tujuan", array("div" => array("class" => "col-sm-9 col-md-8"),"options"=>$tujuan, "label" => false, "class" => "select-full"));
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Outbox.nomor", __("Nomor"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Outbox.nomor", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            echo $this->Form->label("Outbox.pesan", __("Pesan"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("Outbox.pesan", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control","type"=>"textarea"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-actions text-center">
                                    <input name="Button" type="button" onclick="history.go(-1);" class="btn btn-success" value="<?= __("Kembali") ?>">
                                    <input type="reset" value="Reset" class="btn btn-info">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#send" type="button" href="<?php echo Router::url('/admin/popups/content?content=confirm_send', true); ?>">
                                        <?= __("Kirim") ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end() ?>
<script>
    $(document).ready(function(){
        $("#OutboxTujuan").on("change",function(){
            if ($(this).val()==0){
                $("#OutboxNomor").removeAttr("disabled");
            }else{
                $("#OutboxNomor").val("");
                $("#OutboxNomor").attr("disabled","disabled");
            }
        })
    })
</script>