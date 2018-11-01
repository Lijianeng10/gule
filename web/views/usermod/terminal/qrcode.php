<div class="super-theme-example">
    <style>
        #qrcode {
            width: 150px;
            height:150px;
        }
    </style>
    <div id="qrcode"></div>
</div>
<script>

    function createQRcode() {
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: $('#qrcode').width(),
            height: $('#qrcode').height()
        });
        var elText ='<?php echo $url;?>';
        qrcode.makeCode(elText)
    }
    createQRcode()
</script>