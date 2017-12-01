<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*/*">
	<title>美酷直播后台管理---<?php echo ($title); ?></title>
    <link href="/newadmin/Application/Admin/Static/css/toast.css" rel="stylesheet" type="text/css"/>
    <link href="/newadmin/Application/Admin/Static/css/animate.css" rel="stylesheet" type="text/css"/>
	<link href="/newadmin/Application/Admin/Static/css/amazeui.min.css" rel="stylesheet" type="text/css"/>
	<link href="/newadmin/Application/Admin/Static/css/amazeui.reset.css" rel="stylesheet" type="text/css"/>
	<link href="/newadmin/Application/Admin/Static/css/app.css" rel="stylesheet" type="text/css"/>
    <script src="/newadmin/Application/Admin/Static/js/jquery.min.js" type="text/javascript" ></script>
    <script src="/newadmin/Application/Admin/Static/js/jquery.form.min.js" type="text/javascript" ></script>
    <script src="/newadmin/Application/Admin/Static/js/webuploader.js" type="text/javascript" ></script>
    <script src="/newadmin/Application/Admin/Static/js/amazeui.min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="/newadmin/Public/plugs/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/newadmin/Public/plugs/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/newadmin/Public/plugs/ueditor/zh-cn.js"></script>
</head>
<body>
    <?php $account = $_SESSION['account']; $level = $_SESSION['level']; ?>
	<div class="am-g">
		<!--头部-->
        <div style="height: 57px;width: 100%;"></div>
		<div class="header-box">
            <header>
                <div class="am-fl tpl-header-logo">
                    <a href="<?php echo U('Admin/admin');?>"><img src="/newadmin/Application/Admin/Static/img/logo.png" alt=""></a>
                </div>
                <div class="tpl-header-fluid">
                    <div class="am-fl tpl-header-switch-button am-icon-list">
                        <span></span>
                        </div>
                        <div class="am-fl tpl-header-navbar tpl-header-navbar-admin">
                        <?php if(($level) == "-100000000"): ?><ul >
                                <li class="am-text-sm am-dropdown tpl-dropdown" data-am-dropdown>
                                    <a href="javascript:void(0);" class="am-dropdown-toggle tpl-dropdown-toggle" data-am-dropdown-toggle>后台配置 <i class="am-icon-chevron-down"></i></a>
                                    <div class="am-dropdown-content tpl-dropdown-content am-g admin">
                                        <ul class="am-u-sm-4">
                                            <li>
                                                <a href="JavaScript:void(0)">后台设置</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('Admin/index');?>">菜单目录</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo U('Admin/account');?>">管理权限</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul><?php endif; ?>
                    </div>

                    <div class="am-fr tpl-header-navbar">
                        <ul>
                            <li class="am-text-sm tpl-header-navbar-welcome">

                                <a href="javascript:void(0);">欢迎你, <span><?php echo ($account); ?></span> </a>
                            </li>
                            <li class="am-text-sm"  onclick="exitlogin()" >
                                <a href="javascript:void(0);">
                                    <span class="am-icon-sign-out"></span> 退出
                                </a>
                            </li>
                        </ul>
                        <script type="text/javascript">
                            function exitlogin(){
                                $.ajax({
                                    type:"POST",
                                    url:"<?php echo U('Index/exitlogin');?>",
                                    success:function(){
                                        window.location.href ="<?php echo U('Admin/Index/index');?>";
                                    }
                                })
                            }
                        </script>
                    </div>
                </div>
            </header>
        </div>
		<!--左侧-->
		<div class="left-sidebar">
            <?php
 $pid = $_SESSION['pid']; $cid = $_SESSION['cid']; ?>
			<ul class="sidebar-nav" >
				<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menuItem): $mod = ($i % 2 );++$i; $active = $menuItem['id'] == $pid?"active":""; $style = $menuItem['id'] == $pid?"display:block":""; $icon = $menuItem['id'] == $pid?"sidebar-nav-sub-ico-rotate":""; ?>
                    <li class="sidebar-nav-link " id="menu-<?php echo ($menuItem["id"]); ?>">
                        <a href="javascript:void(0);" class="sidebar-nav-sub-title <?php echo ($active); ?>">
                            <i class="am-icon-table sidebar-nav-link-logo"></i>
                            <?php echo ($menuItem["title"]); ?>
                            <span class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico <?php echo ($icon); ?>"></span>
                        </a>
                        <ul class="sidebar-nav sidebar-nav-sub" style="<?php echo ($style); ?>">
                            <?php if(is_array($menuChildrens)): $i = 0; $__LIST__ = $menuChildrens;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menuChildren): $mod = ($i % 2 );++$i; if($menuChildren['p_id'] == $menuItem['id']): $cActive = $menuChildren['id'] == $cid?"active":""; ?>
                                    <li class="sidebar-nav-link" id="menu-children-<?php echo ($menuChildren["id"]); ?>">
                                        <a href="###" class="<?php echo ($cActive); ?>" onclick='thisMenuIndex(<?php echo ($menuItem["id"]); ?>,<?php echo ($menuChildren["id"]); ?>,"<?php echo ($adminlUrl); echo ($menuChildren['url']); ?>")'>
                                            <span class="am-icon-angle-right sidebar-nav-link-logo"></span> <?php echo ($menuChildren["title"]); ?>
                                        </a>
                                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<!--内容区域-->
		<div class="tpl-content-wrapper clearfix">
			
    <style>
        .power-one{
            line-height: 40px;
            padding-left: 100px;
            background: #f2f6f9;
        }
        .power-two{
            font-size: 14px;
            padding-left: 150px;
            margin: 10px 0;
        }
        label{
            font-weight:100!important;
            margin-bottom: 0px;
        }
        .power-three{
            padding-left: 200px;
        }
        .am-form-group-box{
            position: relative;
        }
        .icon{
            position: absolute;
            font-size: 18px;
            top:5px;
            left: 30px;
            display: block;
            width:50px;
            text-align: center;
            cursor:pointer;
        }
        .power{
            display: none;
        }
        .am-icon-remove{
            display: none;
        }
    </style>
    <div class="tpl-content-wrapper-body row-content">
        <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                <div class="widget am-cf">
                    <div class="widget-head am-cf">
                        <?php $data = M("account")->where(array('id'=>I('get.id')))->find(); $onepower = M("power")->where(array('account_id'=>I('get.id'),"level"=>1))->select(); $twopower = M("power")->where(array('account_id'=>I('get.id'),"level"=>2))->select(); ?>
                        <div class="widget-title  am-cf"><?php echo ($data['account']); ?> 账号权限设置
                            <span style="display: inline-block;padding-left: 20px;font-size: 12px">查看 为  增加, 删除 ,审核, 导出excel 权限的前提</span>
                        </div>
                    </div>
                    <div class="widget-body am-fr">
                        <form class="am-form tpl-form-border-form tpl-form-border-br tpl-form-line-form" method="post" action="<?php echo U('Admin/setPower');?>" enctype="application/x-www-form-urlencoded">
                            <input type="hidden" name="account_id" value="<?php echo ($data['id']); ?>">
                            <?php if(is_array($otherdata)): $i = 0; $__LIST__ = $otherdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="am-form-group am-form-group-box">
                                    <i class="am-icon-plus icon"></i>
                                    <i class="am-icon-remove icon"></i>
                                    <div class="power-one">
                                        <?php $select = ''; foreach($onepower as $key => $one){ if($one['menu_id'] == $item['id']){ unset($onepower[$key]); $select = "checked='checked'"; break; } } ?>
                                        <label>
                                            <input  type="checkbox" value="<?php echo ($item['id']); ?>" name="one[]" <?php echo ($select); ?>> <?php echo ($item['title']); ?>
                                        </label>
                                    </div>
                                    <?php $twomenu = $item['twoMenu']; ?>
                                    <?php if(is_array($twomenu)): $i = 0; $__LIST__ = $twomenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$twoitem): $mod = ($i % 2 );++$i; $select = $add = $remove = $edit = $query = $export = $verify = ""; foreach($twopower as $key=>$two){ if($twoitem['id'] == $two['menu_id']){ $select = "checked='checked'"; $add = $two['add'] == 1?"checked='checked'":""; $remove = $two['remove'] ==1 ?"checked='checked'":""; $edit = $two['edit'] == 1?"checked='checked'":""; $query = $two['query'] ==1 ?"checked='checked'":""; $export = $two['export'] == 1?"checked='checked'":""; $verify = $two['verify'] == 1?"checked='checked'":""; break; } } ?>
                                        <div class="power">
                                        <div class="power-two">
                                            <label>
                                                <input  type="checkbox" value="<?php echo ($twoitem['id']); ?>" name="two[]" <?php echo ($select); ?>>
                                                <?php echo ($twoitem['title']); ?>
                                            </label>
                                        </div>
                                        <div class="power-three">
                                            <div class="am-form-group">
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][query][]" <?php echo ($query); ?>> 查看
                                                </label>
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][add][]" <?php echo ($add); ?>> 增加
                                                </label>
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][remove][]" <?php echo ($remove); ?>> 删除
                                                </label>
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][edit][]" <?php echo ($edit); ?>> 修改
                                                </label>
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][excel][]" <?php echo ($export); ?>> 导出excel
                                                </label>
                                                <label class="am-checkbox-inline">
                                                    <input type="checkbox" value="1" name="three[<?php echo ($twoitem['id']); ?>][verify][]"  <?php echo ($verify); ?>> 审核
                                                </label>
                                            </div>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            <div class="am-form-group">
                                <div class="am-u-sm-7 am-u-sm-push-3">
                                    <button class="am-btn am-btn-primary tpl-btn-bg-color-success" id="submit" type="submit">确定</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".power-one label input").change(function(){
                 var val = $(this).is(':checked');
                 var p_dom = $(this).parents(".am-form-group");
                 if(val){
                    $(p_dom).find("input:checkbox").each(function () {
                        $(this).prop('checked', true);
                    })
                 }else{
                     $(p_dom).find("input:checkbox").each(function () {
                         $(this).prop('checked', false);
                     })
                 }
            })
            $(".power-three input").change(function(){
                var val = $(this).is(':checked');
                if(val){
                    $(this).parents(".power").find(".power-two label input").prop("checked",true);
                    $(this).parents(".am-form-group").find(".power-one label input").prop("checked",true);
                }else{
                    var thisDom =  $(this).parents(".power").find(".power-three label input");
                    console.log(thisDom);
                    var thisStatus = false;
                    for(var i = 0;i<thisDom.length;i++){
                        if($(thisDom[i]).is(':checked')){
                            thisStatus = true;
                            return;
                        }
                    }
                    if(!thisStatus){
                        $(this).parents(".power").find(".power-two label input").prop("checked",false);
                        var twoDom = $(this).parents(".am-form-group").find(".power-two label input");
                        var twoStatus = false;
                        for(var i = 0;i<twoDom.length;i++){
                            if($(twoDom[i]).is(':checked')){
                                twoStatus = true;
                                return;
                            }
                        }
                        if(!twoStatus){
                            $(this).parents(".power").find(".power-two label input").prop("checked",false);
                        }
                    }
                }
            })
            $(".power-two input").change(function(){
                var val = $(this).is(':checked');
                if(val){
                    $(this).parents(".am-form-group").find(".power-one label input").prop("checked",true);
                    $(this).parents(".power").find(".power-three label input").prop("checked",true);
                }else{
                    $(this).parents(".power").find(".power-three label input").prop("checked",false);
                    var twoDom = $(this).parents(".am-form-group").find(".power-two label input");
                    var twoStatus = false;
                    for(var i = 0;i<twoDom.length;i++){
                        if($(twoDom[i]).is(':checked')){
                            twoStatus = true;
                            return;
                        }
                    }
                    if(!twoStatus){
                        $(this).parents(".power").find(".power-two label input").prop("checked",false);
                    }
                }
            })


            $(".am-icon-plus").click(function () {
                $(this).parents(".am-form-group").find(".am-icon-plus").hide();
                $(this).parents(".am-form-group").find(".power").show();
                $(this).parents(".am-form-group").find(".am-icon-remove").show();
            });
            $(".am-icon-remove").click(function () {
                $(this).parents(".am-form-group").find(".am-icon-plus").show();
                $(this).parents(".am-form-group").find(".power").hide();
                $(this).parents(".am-form-group").find(".am-icon-remove").hide();
            });
        });
    </script>

		</div>
	</div>
    <script src="/newadmin/Application/Admin/Static/js/toast.js" type="text/javascript" ></script>
    <script src="/newadmin/Application/Admin/Static/js/toast.class.js" type="text/javascript" ></script>
    <script src="/newadmin/Application/Admin/Static/js/app.js" type="text/javascript" ></script>
    <script>
        function  thisMenuIndex(pid,cid,url) {
                console.log(cid);
            $.ajax({
                type:"post",
                data:{"pid":pid,"cid":cid},
                url:"<?php echo U('Admin/Index/menuIndex');?>",
                success:function(){
                    window.location.href = url;
                },
                error:function(){
                    window.location.href = url;
                }
            })
        }
//        console.log("%c四溢满孤舟",'font-size:12px;color:red');
//        console.log("%c点点坠穷楼",'font-size:12px;color:red');
//        console.log("%c化雨踏空去",'font-size:12px;color:red');
//        console.log("%c虚空步神州",'font-size:12px;color:red');
//        console.log("%c祥云桥上望",'font-size:12px;color:red');
//        console.log("%c青伞伫桥头",'font-size:12px;color:red;');
    </script>
</body>
</html>