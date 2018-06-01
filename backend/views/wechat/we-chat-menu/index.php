<?php
use yii\helpers\Html;
use kartik\widgets\Select2;
use kartik\dialog\Dialog;

//use yii\web\JsExpression;

echo Dialog::widget();

if (class_exists('backend\assets\GritterAsset')) {
    backend\assets\GritterAsset::register($this);
}
?>
<?=Html::jsFile('@web/js/jquery.min.js')?>
<?=Html::cssFile('@web/css/weChatMenu.css')?>

	<div class="bg">
		<div class="mobile-content">
			<footer class="mobile-footer">
				<ul class="we-chat-mobile-menu">
                    <li>
                        <i class="fa fa-fw fa-keyboard-o"></i>
                    </li>
					<li>菜单一</li>
					<li>菜单二</li>
					<li>菜单三</li>
				</ul>
			</footer>
			<nav class="but-hide mobile-nav">
				<a href="###">1</a>
				<a href="###">1a</a>
				<a href="###">1b</a>
				<a href="###">1c</a>
				<a href="###">1d</a>
			</nav>
			<nav class="but-hide mobile-nav">
				<a href="###">2</a>
				<a href="###">2a</a>
				<a href="###">2b</a>
				<a href="###">2c</a>
				<a href="###">2d</a>
			</nav>
			<nav class="but-hide mobile-nav">
				<a href="###">3</a>
				<a href="###">3a</a>
				<a href="###">3b</a>
				<a href="###">3c</a>
				<a href="###">3d</a>
			</nav>
            <div class="but-hide menu-input">
                <div class="col-xs-12 mobile-select-box" style="margin-top:4px">
                <?php
                    echo Select2::widget([
                        'name' => '请选择自定义菜单类型',
                        'data' => $model::$menuTypeMap,
                        'options' => [
                            'placeholder' => '请选择自定义菜单类型 ...',
                            'class' => 'menu_type',
                            'options' => [
                                3 => ['disabled' => true],
                                4 => ['disabled' => true],
                            ],
                        ],
                    ]);
                ?>
                </div>
                <div class="col-xs-12" style="margin-top:4px">
                    <input type="text" class="form-control menu_name" placeholder="请输入菜单名称">
                </div>
                <div class="col-xs-12" style="margin-top:4px">
                    <input type="text" class="form-control menu_key" placeholder="请输入菜单key或url">
                </div>
                <div class="col-xs-4" style="margin-top:4px">
                    <button type="button" class="btn btn-block btn-info saveSubmenu">保存</button>
                </div>
                <div class="col-xs-4" style="margin-top:4px">
                    <button type="button" class="btn btn-block btn-warning delSubmenu">删除</button>
                </div>
                <div class="col-xs-4" style="margin-top:4px">
                    <button type="button" class="btn btn-block btn-warning submitSubmenu">上传</button>
                </div>
            </div>
		</div>
	</div>

<?php $this->beginBlock('count_js') ?>
    var data = <?php echo json_encode($menuData); ?>;
    var submenuIndex;
    var parmenuIndex;

	for (var i = 1; i < $('.we-chat-mobile-menu>li').length; i++) {
		(function(int){
			$('.we-chat-mobile-menu>li')[i].onclick = function(){
				$('.mobile-nav').slideUp('fast');
                if($('.mobile-nav').eq(int-1).css('display')=='none'){
                    $('.mobile-nav').eq(int-1).slideDown('fast');
                }else{
					$('.mobile-nav').eq(int-1).slideUp('fast');
                }
			}
		})(i)
	}

    $('.mobile-nav>a').on('click', function(){
        submenuIndex = $(this).index() + 1;
        parmenuIndex = $(this).parent().index();
        initData();
        $('.menu-input').show();
        $('.mobile-select-box').show();
        $('.menu_key').show();
    })

    $(".we-chat-mobile-menu>li").on("contextmenu", function(){
        return false;
    }).mousedown(function(e) {
        if (3 == e.which) {
            $('.menu-input').show();
            submenuIndex = 0;
            parmenuIndex = $(this).index();
            initData();
            var len = 0;
            for(var i = 1,l = data['menu' + parmenuIndex].length;i < l;i++) {
                if(data['menu' + parmenuIndex][i] != "" && typeof(data['menu' + parmenuIndex][i]) != "undefined") {
                    len ++;
                }
            }
            if (len > 0) {
                $('.mobile-select-box').hide();
                $('.menu_key').hide();
            } else {
                $('.mobile-select-box').show();
                $('.menu_key').show();
            }
        }
    })

    $('.saveSubmenu').click(function(){
        var menuType = $('.menu_type').val();
        var menuName = $('.menu_name').val();
        var menuKey = $('.menu_key').val();
        data['menu' + parmenuIndex][submenuIndex] = {menuType:menuType,menuName:menuName,menuKey:menuKey};
    })

    $('.delSubmenu').on("click", function() {
        krajeeDialog.confirm("确定删除菜单吗?", function (result) {
            if (result) {
                data['menu' + parmenuIndex].splice($.inArray(submenuIndex, 1));
            }
        });
    });

    var initData = function () {

        var defval = data['menu' + parmenuIndex][submenuIndex];
        if (defval == undefined) {
            defval = {};
        }
        if (defval.menuType == undefined) {
            defval.menuType = 0;

            defval.menuTypeName = '请选择自定义菜单类型 ...';
        } else {
            defval.menuTypeName = $('.menu_type option').eq(defval.menuType).html();
        }
        if (defval.menuName == undefined) {
            defval.menuName = '';
        }
        if (defval.menuKey == undefined) {
            defval.menuKey = '';
        }
        $('.menu_type').val(defval.menuType);
        $('.select2-selection__rendered').html(defval.menuTypeName);
        $('.menu_name').val(defval.menuName);
        $('.menu_key').val(defval.menuKey);
    }

    $('.submitSubmenu').click(function(){
        var url = 'save-we-chat-menu';
        $.ajax({
            url : url,
            data : {data:data},
            type : 'POST',
            dataType : 'json',
            success : function (msg) {
                if (0 == msg.errcode) {
                    $.gritter.add({
                        title: '提示',
                        text: '创建成功',
                        class_name: 'gritter-success gritter-center',
                        time: 2000
                    });
                } else {
                    $.gritter.add({
                        title: '提示',
                        text: '创建失败',
                        class_name: 'gritter-error',
                        time: 3000
                    });
                }

                return false;
            }
        });
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['count_js'], \yii\web\View::POS_END); ?>
