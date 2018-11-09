<style>
    #qrcode {
        width: 200px;
        height:200px;
    }
</style>
<div class="super-theme-example">
    <table>
        <tbody>
            <tr>
                <td>
                    <div id="qrcode"></div>
                    <span style="font-size: 18px;font-weight: bold;width:200px;text-align: center;display: inline-block">终端号：<?php echo $num;?></span>
                </td>
                <div id="can"></div>
<!--                <td style="padding-left: 57px;">-->
<!--                    <span style="font-size: 18px;color:blue">终端号：--><?php //echo $num;?><!--</span>-->
<!--                </td>-->
                <td style="padding-left: 10px;">
                    <div><a href="#" class="easyui-linkbutton primary" onclick="dwn();">下载保存</a></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("#qrcode").qrcode({
            render : "canvas",    //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
            text : '<?php echo $url;?>',    //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接
            width : "200",               //二维码的宽度
            height : "200",              //二维码的高度
            background : "#ffffff",       //二维码的后景色
            foreground : "#000000",        //二维码的前景色
            src: '/images/logo.jpg'             //二维码中间的图片
        });
        // setTimeout(function() {
        //     var canvas= $('#qrcode canvas')[0]
        //     var src = canvas.toDataURL("image/png")
        //     var oImg = new Image();
        //     oImg.src = src;
        //
        //     canvas.width = canvas.width + 40;
        //     canvas.height = canvas.height + 40;
        //     var ctx = canvas.getContext("2d")
        //     ctx.beginPath();
        //     ctx.fillStyle = "blue";
        //     ctx.fillRect(0,0,240,240);
        //     ctx.stroke();
        //
        //     ctx.drawImage(oImg, 20, 10);
        //
        //     // var src = canvas.toDataURL("image/png")
        //     console.log(src)
        // },0)

    });
    // function createQRcode() {
        //var qrcode = new QRCode(document.getElementById("qrcode"), {
        //    width: $('#qrcode').width(),
        //    height: $('#qrcode').height()
        //});
        //    var elText ='<?php //echo $url;?>//';
        //qrcode.makeCode(elText)
    // }
    // createQRcode();

    /*下载二维码*/
    function dwn(){
        var oldcanvas= $('#qrcode canvas')[0]
        var src = oldcanvas.toDataURL("image/png")
        var oImg = new Image();
        oImg.src = src;
        oImg.onload = function (){
            var canvas = document.createElement("canvas");
            canvas.width = oldcanvas.width + 40;
            canvas.height = oldcanvas.height + 40;
            var ctx = canvas.getContext("2d");
            ctx.beginPath();
            ctx.fillStyle = "#fff";
            ctx.fillRect(0,0,240,240);
            ctx.stroke();
            //添加终端号重新绘图
            ctx.drawImage(oImg, 20, 10);
            // $("#can").append(canvas);
            ctx.font="bold 18px Arial";
            ctx.fillStyle = '#333';
            var text ='终端号：'+'<?php echo $num;?>';
            ctx.fillText(text,40,230);

            var donwloadSrc = canvas.toDataURL("image/png");

            //下载
            var type = 'png';
            var dataurl = donwloadSrc//$("canvas").get(0).toDataURL('image/png').replace("image/png", "image/octet-stream");
            var filename = '<?php echo $num;?>' + '.' + type;
            saveFile(dataurl,filename);
        }
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