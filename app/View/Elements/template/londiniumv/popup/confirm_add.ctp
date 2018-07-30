<script type="text/javascript">
    function showModalAdd(e) {
        $("#formSubmit").submit();
    }
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?= __("Konfirmasi Penyimpanan Data") ?></h4>

</div>
<div class="modal-body">
    <div class="te">
        <div class="popup-confirmation">
            <span class="alert_big_ico">&nbsp;</span>
            <div class="text-center">
                <b>Apakah Anda yakin ingin menyimpan data ini?</b>
                <div class="clear"></div>
                <smal class="text-danger">Note : Jika Anda memilih Ya, aksi ini tidak dapat di batalkan.</small>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?= __("Batal") ?></button>
    <button type="button" class="btn btn-primary" id = "ok" onclick="showModalAdd($(this))" data-dismiss="modal"><?= __("Ok") ?></button>
</div>