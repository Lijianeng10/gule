<style>
    #qrcode {
        width: 150px;
        height:150px;
    }
</style>
<div class="super-theme-example">
    <table>
        <tbody>
            <tr>
                <td>
                    <div id="qrcode"></div>
                </td>
                <td style="padding-left: 20px;">
                    <span style="font-size: 18px;color:blue">终端号：<?php echo $num;?></span>
                </td>
                <td style="padding-left: 50px;">
                    <div><a href="#" class="easyui-linkbutton info" onclick="dwn();">下载保存</a></div>
                </td>
            </tr>
        </tbody>
    </table>



    <div>


        <div style="float: right;margin-right: 200px;">

        </div>
    </div>

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
    createQRcode();

    /*下载二维码*/
    function dwn(){
        var type = 'png';
        var dataurl =$("canvas").get(0).toDataURL('image/png').replace("image/png", "image/octet-stream");
        var filename = '<?php echo $num;?>' + '.' + type;
        saveFile(dataurl,filename);
    }
    /**
         * 在本地进行文件保存
         * @param  {String} data     要保存到本地的图片数据
         * @param  {String} filename 文件名
         */
    function saveFile(data, filename){
        var save_link = document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
        save_link.href = data;
        save_link.download = filename;

        var event = document.createEvent('MouseEvents');
        event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        save_link.dispatchEvent(event);
    };
</script>