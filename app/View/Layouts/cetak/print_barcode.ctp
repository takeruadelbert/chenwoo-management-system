<?php
$context = stream_context_create(['ssl' => [
        'verify_peer' => true,
        'allow_self_signed' => true,
        'CN_match' => 'app-server.chenwoofishery.com',
]]);
$path = Router::url("/img/logoqrcode.png", true);
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path, 'rt', $context);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script src="<?= Router::url("/js/jquery.min.js") ?>"></script>
<script src="<?= Router::url("/js/plugin/jquery.qrcode-0.12.0.min.js") ?>"></script>
<img id="qrcodelogo" src="<?= $base64 ?>" style="display:none"/>
<style>
    .isQRcode img{
        max-width:75px;
    }
    @page {
        margin:5px 1px;
    }
</style>
<script>
    $(document).ready(function () {
        toQRcode();
        window.print();
    })
    function toQRcode() {
        $(".isQRcode").each(function () {
            var text = $(this).html();
            var options = {
                render: 'image',
                ecLevel: 'H',
                minVersion: 5,
                maxVersion: 10,
                fill: '#000',
                background: '#fff',
                text: text,
                size: 450,
                radius: 0,
                quiet: 1,
                mode: 4,
                mSize: 0.3,
                mPosX: 0.5,
                mPosY: 0.5,
                image: $("#qrcodelogo")[0],
            };
            $(this).html("");
            $(this).qrcode(options);
        })
    }
</script>
<div class="print">
    <?php
    echo $this->fetch("content");
    ?>
</div>