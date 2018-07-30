<script src="<?= Router::url("/js/jquery.min.js")?>"></script>
<script src="<?= Router::url("/js/plugin/jquery.qrcode-0.12.0.min.js")?>"></script>
<script>
    $(document).ready(function() {
        window.print();
    })
</script>
<div class="print">
    <?php
    echo $this->fetch("content");
    ?>
</div>