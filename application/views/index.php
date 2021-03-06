<?php
    $this->load->view('common/header');
?>
<!-- 页头 end -->
<div class="center">
    <div class="navigation_module" dd_name="面包屑路径"></div>
    <div class="main classification_list">
        <div class="left" id="nav_left" dd_name="左侧导航">
            <div class="classification_left_nav">
                <div class="first_level publication publisher selected"><h3 data-category="">全部</h3></div>
                <?php if($category):?>
                <?php foreach ($category as $k=>$v):?>
                    <div class="first_level publication publisher  original_blank">
                        <h3 data-category="<?=$v['id']?>"><?=$v['name']?><i class="icon"> </i></h3>
                        <ul class="second_level">
                            <?php foreach ($v['child'] as $kk=>$vv):?>
                                <li data-category="<?=$vv['id']?>"><?=$vv['name']?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endforeach;?>
                <?php endif;?>
<!--                <div class="first_level publication publisher  original_blank">-->
<!--                    <h3>文艺 <i class="icon"> </i></h3>-->
<!--                    <ul class="second_level">-->
<!--                        <li>文学</li>-->
<!--                        <li>青春文学</li>-->
<!--                        <li>动漫幽默</li>-->
<!--                        <li>艺术</li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="first_level publication publisher original_blank">-->
<!--                    <h3>原创女生 <i class="icon"> </i></h3>-->
<!--                    <ul class="second_level">-->
<!--                        <li>小说</li>-->
<!--                        <li>文学</li>-->
<!--                        <li>青春文学</li>-->
<!--                        <li>动漫幽默</li>-->
<!--                        <li>艺术</li>-->
<!--                    </ul>-->
<!--                </div>-->

            </div>
        </div>
        <div class="right" dd_name="书籍分类列表">
            <div class="classification_content">
                <div class="index_subnav_module">
                    <ul class="nav clearfix for_publish">
                        <li class="on" data-type="create_time">
                            <a data-type="create_time" href="javascript:;" dd_name="上架时间">上架时间
                                <i class="icon"> </i></a>
                        </li>
                        <li data-type="publish_time"><a data-type="publish_time" href="javascript:;" dd_name="出版时间">出版时间<i
                                        class="icon"> </i></a>
                        </li>
                    </ul>
                    <div class="bar" style="width: 83px;"></div>
                </div>
                <div class="book book_list clearfix" id="book_list">

<!--                    <a href="./product/1900364619.html" target="_blank" title="白鹿原" dd_name="陈忠实">-->
<!--	                 <span class="bookcover">-->
<!--	                <img src="http://img62.ddimg.cn/digital/product/46/19/1900364619_ii_cover.jpg?version=9c76fba6-b737-49d8-ade6-9653907610f4"-->
<!--                 alt="白鹿原"></span>-->
<!--                        <div class="bookinfo">-->
<!--                            <div class="title">白鹿原</div>-->
<!--                            <div class="author">陈忠实</div>-->
<!--                            <div class="startie"></div>-->
<!--                            <div class="price">-->
<!---->
<!--	            	<span class="now">-->
<!---->
<!--		            	￥5.99-->
<!--		            	</span>-->
<!--                            </div>-->
<!--                            <div class="des">-->
<!--                                　　《白鹿原》是一部渭河平原五十年变迁的雄奇史诗，一轴中国农村班斓多彩、触目惊心的长幅画卷。主人公六娶六丧，神秘的序曲预示着不祥。一个家族两代子孙，为争夺白鹿原的统治代代争斗不已，上演了一幕幕惊心动魄的活剧：巧取风水地，恶施美人计，孝子为匪，亲翁杀媳，兄弟相煎，情人反目……大革命、日寇入侵、三年内战，白鹿原翻云覆雨，王旗变幻，家仇国恨交错缠结，冤冤相报代代不已……古老的土地在新生的阵痛中颤粟。厚重深邃的思想内容，复杂多变的人物性格，跌宕曲折的故事情节，绚丽多彩的风土人情，形成作品鲜明的艺术特色和令人震撼的真实感。-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </a>-->

                </div>
            </div>
            <div class="clickMore_wrap">
                 <div class="loading" style="display: none;"></div>
                <!-- <span class="clickMore">点击加载更多</span> -->
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/footer');?>
<script>

    $(function () {
        $(".classification_left_nav .publisher h3").on("click", function () {
            var b = $(this).parent();
            //发送请求
            if(!b.is('.selected')){
                init();
                category = $(this).data('category');
                getData(pageStart,pageSize);
            }
            b.addClass("selected").siblings().removeClass("selected");
            b.children("ul").slideToggle().end().siblings().children("ul").slideUp();
        });
        $(".original_blank .second_level li").on("click", function () {
            $(".classification_left_nav li").removeClass("current");
            $(this).addClass("current");
            init();
            category = $(this).data('category');
            getData(pageStart,pageSize);
        });
        $('.index_subnav_module li').click(function (e) {
            if (!$(this).is('.on')) {
                $(this).siblings('li').removeClass('on').end().addClass('on');
                var type = $(this).data('type');
                var move = function (b) {
                    var c = $("li[data-type=" + b + "]");
                    c.addClass("on").siblings("li").removeClass("on");
                    var d = c.parent().find("li").eq(0).outerWidth(),
                        e = c.offset().left - c.parent().offset().left + (c.outerWidth() - d) / 2;
                    $(".index_subnav_module .bar").width(d).animate({left: e + "px"}, 100);
                };
                move(type)
                init();
                order = type;
                getData(pageStart,pageSize);
            }
        });
        /*初始化*/
        var counter = 0;
        /*计数器*/
        var pageStart = 0;
        /*offset*/
        var pageSize = 12;
        /*size*/
        var isEnd = false;
        var category = null;
        var order = 'create_time';
        /*结束标志*/

        var init = function () {
            pageStart = 0;
            $('#book_list').empty();
        };

        var getData = function(pageStart, pageSize) {
            $(".loading").show();
            isEnd = true;
            var query = {
                start: pageStart,
                pageSize: pageSize,
                category: category,
                order:order
            };

            $.ajax({
                url: "<?=site_url('welcome/book')?>",
                type: 'post',
                dataType: 'json',
                data: query,
                complete:function () {
                    $(".loading").hide();
                }
            }).done(function (res) {
                var data = res.data.data;
                if(!data || !data.length){
                    $('#book_list').append("<div class='go_for_more' style='clear:both'><a href='javascript:void(0)'>亲，没有更多内容了</a></div>");
                }else{
                    var template = _.template($('#classification_book_list').html());
                    var html = template({data:data});
                    $('#book_list').append(html);
                    isEnd = false;
                }
            })
        }

        /*首次加载*/
        getData(pageStart, pageSize);

        /*监听加载更多*/
        $(window).scroll(function () {
            if (isEnd == true) {
                return;
            }
            // 当滚动到最底部以上100像素时， 加载新内容
            // 核心代码
            if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) {
                $('.returntop').show();
                counter++;
                pageStart = counter * pageSize;
                getData(pageStart, pageSize);
            }
        });

        $('.searchbtn').click(function () {
            var q = $('.searchtext').val();
            location.href = "<?=site_url('welcome/search')?>/" + q;
        });
        $('.searchtext').bind('keypress',function(event){
            if(event.keyCode == "13") {
                var q = $('.searchtext').val();
                location.href = "<?=site_url('welcome/search')?>/" + q;
            }
        });
    });
</script>
<script type="text/template" id="classification_book_list">
    <%if (data && data !=undefined){%>
    <%for(var i=0;i<data.length;i++){%>
    <%var item = data[i]%>
    <a href="<?=site_url('welcome/detail')?>/<%=item.id%>" target="_blank" title="<%=item.name%>" dd_name="<%=item.name%>">
	                 <span class="bookcover">
	                <img src="<%=item.cover%>"
                         alt="<%=item.name%>"></span>
        <div class="bookinfo">
            <div class="title"><%=item.name%></div>
            <div class="author"><%=item.publisher%></div>
            <div class="startie"></div>
            <div class="price">
                <span class="now">ISBN <%=item.isbn%></span>
            </div>
            <div class="des">出版时间 <%=item.publish_time%>
            </div>
        </div>
    </a>
    <%}%>
    <%}else{%>
    <div>亲，没有更多内容了</div>
    <%}%>
</script>

</html>
