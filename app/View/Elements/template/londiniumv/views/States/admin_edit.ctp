<?php echo $this->Form->create("State", array("class" => "form-horizontal form-separate", "action" => "edit", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="block-inner text-danger">
                    <h6 class="heading-hr"><?= __("Ubah State") ?>

                        <small class="display-block">Form State</small>
                    </h6>
                </div>
                <div class="table-responsive">
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data State") ?></h6>
                    </div>
                    <table width="100%" class="table">
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("State.name", __("Nama State"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("State.name", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "form-control"));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label("State.country_id", __("Negara"), array("class" => "col-sm-3 col-md-4 control-label"));
                                            echo $this->Form->input("State.country_id", array("div" => array("class" => "col-sm-9 col-md-8"), "label" => false, "class" => "select-full", "empty" => "", "placeholder" => "- Pilih Negara -"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="panel-heading" style="background:#2179cc">
                        <h6 class="panel-title" style=" color:#fff"><i class="icon-menu2"></i><?= __("Data Kota") ?></h6>
                    </div>
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr bordercolor="#000000">
                                <td width="1%" align="center" valign="middle" bgcolor="#feffc2">No</td>
                                <td width="20%" align="center" valign="middle" bgcolor="#feffc2">Nama Kota</td>
                                <td width="20%" align="center" valign="middle" bgcolor="#feffc2">Kode Pos</td>
                                <td width="5%" align="center" valign="middle" bgcolor="#feffc2">Aksi</td>
                            </tr>
                        </thead>
                        <tbody id="target-modullink"><?php
                            foreach ($this->data["City"] as $k => $item) {
                                ?>
                                <tr>
                                    <?= $this->Form->hidden("City.$k.id") ?>
                                    <td align="center" class="nomorIdx"><?= $k + 1 ?></td>
                                    <td>
                                        <div class="false">
                                            <?= $this->Form->input("City.$k.name", [ "div" => false, "class" => "form-control", "label" => false]) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="false">
                                            <?= $this->Form->input("City.$k.postal_code", [ "div" => false, "class" => "form-control", "label" => false]) ?>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>  
                        <tfoot>
                            <tr class="addrowborder">
                                <td colspan="4" align="left"><a href="javascript:void(false)" onclick="addThisRow($(this), 'modullink', 'anakOptions')" data-n="<?= count($this->data["City"]) ?>"><i class="icon-plus-circle"></i></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="text-center">
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
<?php echo $this->Form->end() ?>

<script>
    function addThisRow(e, t, optFunc) {
        var n = $(e).data("n");
        var template = $('#tmpl-' + t).html();
        Mustache.parse(template);
        var options = {i: 2, n: n};
        if (typeof (optFunc) !== 'undefined') {
            $.extend(options, window[optFunc]());
        }
        var rendered = Mustache.render(template, options);
        $("#target-" + t).append(rendered);
        $(e).data("n", n + 1);
        reloadSelect2();
        fixNumber($(e).parents("table").find("tbody"));
    }
    function fixNumber(e) {
        var i = 1;
        $.each(e.find("tr"), function () {
            $(this).find(".nomorIdx").html(i);
            i++;
        })
    }
    function deleteThisRow(e) {
        var tbody = $(e).parents("tbody");
        var tr = e.parents("tr");
        tr.remove();
        fixNumber(tbody);
    }
    function anakOptions() {
    }
</script>

<script type="x-tmpl-mustache" id="tmpl-modullink">
    <tr>
    <td align="center" class="nomorIdx">1</td>
    <td>
    <div class="false">
    <input name="data[City][{{n}}][name]" class="form-control" maxlength="255" type="text" id="City{{n}}Name">  
    </div>
    </td>
    <td>
    <div class="false">
    <input name="data[City][{{n}}][postal_code]" class="form-control" maxlength="255" type="text" id="City{{n}}PostalCode">     
    </div>
    </td>
    <td align="center">
    <a href="javascript:void(false)" onclick="deleteThisRow($(this))"><i class="icon-remove3"></i></a>
    </td>
    </tr>
</script>