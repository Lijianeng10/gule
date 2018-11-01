<div class="super-theme-example">
    <form id="myform">
        <div class="form-item">
            <label for="" class="label-top">预生成数量：</label>
            <input type="text" class="easyui-numberbox" name="nums" id="nums" data-options="required:true">
        </div>
    </form>
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
        var elText = 'http://114.115.148.102:8011/store/store/to-jump-page?terminalNum=PS100001'
        qrcode.makeCode(elText)
    }
    createQRcode()
</script>