<div class="modal fade" id="multipledelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<div id="default-modalpenilaian" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>

<div id="modalgantipp" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-4">
        <div class="modal-content">
            <?php echo $this->Form->create("Account", array("type" => "file", "action" => "ganti_pp", "id" => "formSubmit", "inputDefaults" => array("error" => array("attributes" => array("wrap" => "label", "class" => "error"))))) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= __("Ganti Foto") ?></h4>
            </div>
            <div class="modal-body">
                <br/>
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class=" col-md-4 control-label">
                                <label>Foto</label>
                            </div>
                            <div class="col-md-8">
                                <?= $this->Form->input("profile_picture", ["type" => "file", "accept" => "image/*", "label" => false, "div" => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Batal") ?></button>
                <button type="submot" class="btn btn-success"><?= __("Ganti") ?></button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div id="default-modalkehadiran" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-coop-supplier" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-coop-stock" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-coop-transaction" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-ajax-modal" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-payment-debt" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-payment-debt-material-additional" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-sale-product-additional" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-treatment" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-product-history" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-cash-disbursement" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-salary-allowance" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="default-view-depreciation-asset" class="modal fade modal-ajax" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div id="ajax-loading" class="modal fade" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content" style="width:50px;height:50px;border-radius:25px;text-align: center">
                <img src="<?= Router::url("/img/chenwoofish.png", true) ?>" style="width:15px;position:absolute;left: 18px;top: 12px;">
                <img src="<?= Router::url("/img/loading-ring.svg", true) ?>" style="display:inline-block"/>
            </div>
        </div>
    </div>
</div>
<div class="hidden" id="modalloading">
    <div class="text-center">
        <img src="<?= Router::url("/img/loading-ring.svg", true) ?>" width="100px"/>
    </div>
</div>
<style>
    #multipledelete .modal-dialog {
        top:200px;
        width:350px;
    }

    #add .modal-dialog{
        top:200px;
        width:350px;
    }

    #edit .modal-dialog{
        top:200px;
        width:350px;
    }

    #send .modal-dialog{
        top:200px;
        width:350px;
    }
    #ajax-loading .vertical-alignment-helper {
        display:table;
        height: 100%;
        width: 100%;
        pointer-events:none; /* This makes sure that we can still click outside of the modal to close it */
    }
    #ajax-loading .vertical-align-center {
        /* To center vertically */
        display: table-cell;
        vertical-align: middle;
        pointer-events:none;
    }
    #ajax-loading .modal-content {
        /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
        width:inherit;
        height:inherit;
        /* To center horizontally */
        margin: 0 auto;
        pointer-events: all;
    }
</style>