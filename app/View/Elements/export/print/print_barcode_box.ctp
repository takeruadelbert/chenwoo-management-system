<div style="display:inline-block">
    <div class="isQRcode"><?= $data['Box']['box_no'] ?></div><br/>
    <div style="text-align: center;font-size:24px;font-weight: bold;"><?php echo $data['Box']['box_no']; ?></div>
</div>
<img id="logo-ilu" src="<?= Router::url("/asset/logo/logo.png", true) ?>" style="display:none"/>
<img id="img-buffer" src="<?= Router::url("/asset/logo/logo.png", true) ?>" style="display:none"/>
<canvas id="myCanvas" style="display:none"/>
<script>
    function toQRcode() {
        $(".isQRcode").each(function () {
            var text = $(this).html();
            var options = {
                render: 'image',
                ecLevel: 'Q',
                minVersion: 1,
                maxVersion: 40,
                fill: '#000',
                background: '#fff',
                text: text,
                size: 250,
                radius: 0,
                quiet: 1,
                mode: 4,
                mSize: 0.2,
                mPosX: 0.5,
                mPosY: 0.5,
                image: $("#img-buffer")[0]
            };
            $(this).html("");
            $(this).qrcode(options);
        })
    }
    function getBase64Image() {
        var file = new File([""], $("#logo-ilu").attr("src"));
        var reader = new FileReader();
        reader.onload = function (event) {
            $('#img-buffer').attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }
    $(document).ready(function () {
        getBase64Image();
        toQRcode();
    })
</script>