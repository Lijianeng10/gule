<div class="navMenubox">
    <div id="slimtest1">
        <ul class="navMenu">
            <?php
            $str="";
            foreach ($menus as $val){
                $str.='<li> <a href="javascript:;" class="afinve">  <span class="menu-t1 fa"><span class="fa-sitemap" ></span>'.$val["auth_name"].'</span> <span class="arrow"></span> </a>';
                if(!empty($val["childrens"])){
                    foreach ($val["childrens"] as $v ){
                        $str.='<ul class="sub-menu clearfix">';
                        if(!empty($v["childrens"])){
                            $str.='<li> <a href="javascript:;"><span>'.$v["auth_name"].'</span><span class="arrow"></span></a><ul class="sub-menu clearfix">';
                            foreach ($v["childrens"] as $item){
                                $str.='<li data-url='.$item["auth_url"].' class="afinve"><a><span>'.$item["auth_name"].'</span></a></li>';
                            }
                            $str.='</ul></li>';
                        }else{
                            $str.='<li data-url='.$v["auth_url"].' class="afinve"><a><span>'.$v["auth_name"].'</span></a></li>';
                        }
                        $str.='</ul>';
                    }

                }
                $str.='</li>';
            }
            echo $str;
            ?>
        </ul>
    </div>
</div>
<script>
        $(function(){
            // nav收缩展开
            $('.navMenu li a').on('click',function(){
                $('.sub-menu li a').removeClass("active");
                var parent = $(this).parent().parent();//获取当前页签的父级的父级
                var labeul =$(this).parent("li").find(">ul")
                if ($(this).parent().hasClass('open') == false) {
                    //展开未展开
                    parent.find('ul').slideUp(300);
                    parent.find("li").removeClass("open")
                    parent.find('li a').removeClass("active").find(".arrow").removeClass("open")
                    $(this).parent("li").addClass("open").find(labeul).slideDown(300);
                    $(this).addClass("active").find(".arrow").addClass("open")
                }else{
                    $(this).parent("li").removeClass("open").find(labeul).slideUp(300);
                    if($(this).parent().find("ul").length>0){
                        $(this).removeClass("active").find(".arrow").removeClass("open")
                    }else{
                        $(this).addClass("active")
                    }
                }

            });
        });
    </script>