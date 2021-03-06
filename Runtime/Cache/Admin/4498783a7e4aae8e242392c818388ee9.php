<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*/*">
	<title>美酷直播后台管理---<?php echo ($title); ?></title>
    <link href="/Application/Admin/Static/css/toast.css" rel="stylesheet" type="text/css"/>
    <link href="/Application/Admin/Static/css/animate.css" rel="stylesheet" type="text/css"/>
	<link href="/Application/Admin/Static/css/amazeui.min.css" rel="stylesheet" type="text/css"/>
	<link href="/Application/Admin/Static/css/amazeui.reset.css" rel="stylesheet" type="text/css"/>
	<link href="/Application/Admin/Static/css/app.css" rel="stylesheet" type="text/css"/>
    <script src="/Application/Admin/Static/js/jquery.min.js" type="text/javascript" ></script>
    <script src="/Application/Admin/Static/js/jquery.form.min.js" type="text/javascript" ></script>
    <script src="/Application/Admin/Static/js/webuploader.js" type="text/javascript" ></script>
    <script src="/Application/Admin/Static/js/amazeui.min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="/Public/plugs/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" src="/Public/plugs/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" src="/Public/plugs/ueditor/zh-cn.js"></script>
</head>
<body>
    <?php $account = $_SESSION['account']; $level = $_SESSION['level']; ?>
	<div class="am-g">
		<!--头部-->
        <div style="height: 57px;width: 100%;"></div>
		<div class="header-box">
            <header>
                <div class="am-fl tpl-header-logo">
                    <a href="<?php echo U('Admin/admin');?>"><img src="/Application/Admin/Static/img/logo.png" alt=""></a>
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
			
	<div class="tpl-content-wrapper-body row-content">
		<div class="row">
			<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
				<div class="widget am-cf">
					<div class="widget-head am-cf">
						<div class="widget-title  am-cf"><?php echo ($title); ?></div>
					</div>
					<div class="widget-body  am-fr">
						<form action="<?php echo ($savePostUrl); ?>" class="am-form tpl-form-border-form tpl-form-border-br tpl-form-line-form" method="post" enctype="application/x-www-form-urlencoded">
							<?php if(!empty($formtitle)): ?><legend><?php echo ($formtitle); ?></legend><?php endif; ?>
							<?php if(is_array($keyList)): $i = 0; $__LIST__ = $keyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; switch($field["type"]): case "hidden": ?><div class="am-form-group" style="display: none!important;">
			<?php $value = $field['value'] != '' ? $field['value'] : $field['opt']['value']; ?>
		    <input type="hidden" name="<?php echo ($field["name"]); ?>" class="tpl-form-input"  placeholder="<?php echo ($field["opt"]["placeholder"]); ?>" value="<?php echo ($value); ?>">
		</div><?php break;?>
	<?php case "textDisabled": ?><div class="am-form-group">
			<label  class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<?php $value = $field['value'] != '' ? $field['value'] : $field['opt']['value']; ?>
			<div class="am-u-sm-4">
		        <input type="text" name="<?php echo ($field["name"]); ?>" class="tpl-form-input" placeholder="<?php echo ($field["opt"]["placeholder"]); ?>"
		        value="<?php echo ($value); ?>"  disabled="disabled">
		        <small><?php echo ($field["opt"]["error"]); ?></small>
		    </div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
		</div><?php break;?>
	<?php case "textnumber": ?><div class="am-form-group">
			<label class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<?php $value = $field['value'] != ''? $field['value'] : $field['opt']['value']; ?>
			<div class="am-u-sm-4">
		        <input type="number" name="<?php echo ($field["name"]); ?>" class="tpl-form-input"  placeholder="<?php echo ($field["opt"]["placeholder"]); ?>" value="<?php echo ($value); ?>">
		        <small><?php echo ($field["opt"]["error"]); ?></small>
		    </div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
		</div><?php break;?>
	<?php case "radio": ?><div class="am-form-group">
			<label class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<?php $select = $field['opt']['checked']; ?>
			<div class="am-u-sm-4">
				<?php if(is_array($select)): $i = 0; $__LIST__ = $select;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$key): $mod = ($i % 2 );++$i;?><div class="am-radio">
						<label>
							<input type="radio" name="<?php echo ($field["name"]); ?>"  value="<?php echo ($key); ?>"  checked>
							<?php echo ($select["$key"]); ?>
						</label>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<small><?php echo ($field["opt"]["error"]); ?></small>
			</div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
		</div><?php break;?>
	<?php case "text": ?><div class="am-form-group">
			<label class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<?php $value = $field['value'] != '' ? $field['value'] : $field['opt']['value']; ?>
			<div class="am-u-sm-4">
		        <input type="text" name="<?php echo ($field["name"]); ?>" class="tpl-form-input"  placeholder="<?php echo ($field["opt"]["placeholder"]); ?>" value="<?php echo ($value); ?>">
		        <small><?php echo ($field["opt"]["error"]); ?></small>
		    </div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
		</div><?php break;?>
	<?php case "time": ?><div class="am-form-group">
			<label class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<?php $value = $field['value'] != '' ? $field['value'] : $field['opt']['value']; ?>
			<div class="am-u-sm-4">
				<input type="text" name="<?php echo ($field["name"]); ?>" class="tpl-form-input"  data-am-datepicker  value="<?php echo ($value); ?>" readonly>
				<small><?php echo ($field["opt"]["error"]); ?></small>
			</div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
		</div><?php break;?>
	<?php case "textarea": ?><div class="am-form-group">
            <label for="user-intro" class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?> </label>
            <div class="am-u-sm-4">
                <textarea rows="10"   name="<?php echo ($field["name"]); ?>" id="user-intro" placeholder="<?php echo ($field["opt"]["placeholder"]); ?>"><?php echo ($field["value"]); ?></textarea>
            </div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
        </div><?php break;?>
	<?php case "select": ?><div class="am-form-group">
            <label  class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?> <span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span></label>
            <div class="am-u-sm-4">
                <select data-am-selected="{searchBox: 1,maxHeight: 200}" name="<?php echo ($field["name"]); ?>">
				  	 <?php if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $selected = $field['value']==$key ? 'selected="selected" ' : ''; ?>
		                <option value="<?php echo ($key); ?>"  <?php echo ($selected); ?> ><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
            </div>
			<div class="am-u-sm-6"></div>
        </div><?php break;?>
	<?php case "DisabledStatus": ?><div class="am-form-group">

            <label class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?> <span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span></label>
            <div class="am-u-sm-4">
                <select data-am-selected="{searchBox: 1}" name="<?php echo ($field["name"]); ?>" disabled="disabled">
				  	 <?php if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $selected = $field['value']==$key ? 'selected="selected" ' : ''; ?>
		                <option value="<?php echo ($key); ?>"  <?php echo ($selected); ?>><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
            </div>
			<div class="am-u-sm-6"></div>
        </div><?php break;?>
	<?php case "showimg": ?><div class="am-form-group">
            <label class="am-u-sm-2 am-form-label">
            	<?php echo ($field["title"]); ?> 
            	<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
            </label>
            <div class="am-u-sm-4">
                <div class="am-form-group am-form-file" >
                   	<?php if(empty($$field["value"])): ?><div class="tpl-form-file-img">
                        	<img src="<?php echo ($field["value"]); ?>" id="showimg_<?php echo ($field["name"]); ?>" style='max-width:150px;max-height:150px'>
                    	</div><?php endif; ?>
                	<input type="hidden" id="showimg_field_hidden_<?php echo ($field["name"]); ?>" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>">
                </div>
            </div>
			<div class="am-u-sm-6"><?php echo ($field["opt"]["prompt"]); ?></div>
        </div><?php break;?>
	<?php case "uploadimg": ?><div class="am-form-group">
            <label class="am-u-sm-2 am-form-label">
            	<?php echo ($field["title"]); ?> 
            	<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
            </label>
            <div class="am-u-sm-4">
                <div class="am-form-group am-form-file" >
                   	<?php if(empty($$field["value"])): ?><div class="tpl-form-file-img">
                        	<img src="<?php echo ($field["value"]); ?>" id="img_<?php echo ($field["name"]); ?>" style='max-width:150px;max-height:150px'>
                    	</div><?php endif; ?>
                	<input type="hidden" id="img_field_hidden_<?php echo ($field["name"]); ?>" name="<?php echo ($field["name"]); ?>"  value="<?php echo ($field["value"]); ?>">
                	<div id="fileImg_<?php echo ($field["name"]); ?>">
                		<button type="button"  class="am-btn am-btn-danger am-btn-sm">
							<i class="am-icon-cloud-upload"></i> <?php echo ($field["opt"]["btntitle"]); ?>
						</button>
	                    <input id="doc-form-file_<?php echo ($field["name"]); ?>"  type="file">
                	</div>
                </div>
            </div>
			<div class="am-u-sm-6"></div>
        </div>
        <script type="text/javascript">
    		$(function(){
    			function initWebuploader(){
    				var uploader_<?php echo ($field["name"]); ?> = WebUploader.create({
		        		 auto: true,
		        		 swf: "/Application/Admin/Static/js/Uploader.swf",
		        		 server:"<?php echo U('Upload/UploadImg');?>",
		        		 pick:"#fileImg_<?php echo ($field["name"]); ?>",
		        		 duplicate:true,
		        		 accept: {
						    title: 'Images',
						    extensions: 'gif,jpg,jpeg,bmp,png',
						    mimeTypes: 'image/*'
					     }
		        	});
		        	uploader_<?php echo ($field["name"]); ?>.on("uploadSuccess",function(file,data){

		        		if(data.ret == 1){
		        			var data = data.data;
		        			$("#img_<?php echo ($field["name"]); ?>").attr("src",data.root_path);
		        			$("#img_field_hidden_<?php echo ($field["name"]); ?>").val(data.path);
		        		}
		        	});
		        	uploader_<?php echo ($field["name"]); ?>.on("uploadFinished", function () {
				        uploader_<?php echo ($field["name"]); ?>.destroy();
				        initWebuploader();
				    });
    			}
    			initWebuploader();
    		})
        </script><?php break;?>
	<?php case "uploadfalsh": ?><div class="am-form-group">
            <label class="am-u-sm-2 am-form-label">
            	<?php echo ($field["title"]); ?> 
            	<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
            </label>
            <div class="am-u-sm-4">
                <div class="am-form-group am-form-file" >
               		<div id="tpl-form-file-swf_<?php echo ($field["name"]); ?>">
               		 	<?php if(empty($$field["value"])): ?><embed src="<?php echo ($field["value"]); ?>" id="swf_<?php echo ($field["name"]); ?>"></embed><?php endif; ?>
                	</div>
                	<input type="hidden" id="swf_field_hidden_<?php echo ($field["name"]); ?>" name="<?php echo ($field["name"]); ?>" value="<?php echo ($field["value"]); ?>">
                	<div id="fileSwf_<?php echo ($field["name"]); ?>">
                		<button type="button"  class="am-btn am-btn-danger am-btn-sm">
							<i class="am-icon-cloud-upload"></i> <?php echo ($field["opt"]["btntitle"]); ?>
						</button>
	                    <input id="swf-form-file_<?php echo ($field["name"]); ?>" type="file">
                	</div>
                </div>
            </div>
			<div class="am-u-sm-6">
				<?php echo ($field["opt"]["prompt"]); ?>
			</div>
        </div>
        <script type="text/javascript">
    		$(function(){
    			function initWebuploader(){
    				var uploader_<?php echo ($field["name"]); ?> = WebUploader.create({
		        		 auto: true,
		        		 swf: "/Application/Admin/Static/js/Uploader.swf",
		        		 server:"<?php echo U('Upload/UploadImg');?>",
		        		 pick:"#fileSwf_<?php echo ($field["name"]); ?>",
		        		 formData:{"exts":"swf"},
		        		 duplicate:true,
		        		 accept: {
						    title: 'Images',
						    extensions: 'swf',
						    mimeTypes: 'swf'
					     }
		        	});
		        	uploader_<?php echo ($field["name"]); ?>.on("uploadSuccess",function(file,data){
                        console.log(file);
                        console.log(data);
		        		if(data.ret == 1){
		        			var data = data.data;
		        			$("#swf_<?php echo ($field["name"]); ?>").remove()
		        			var html = "<embed src='"+data.root_path+"' id='swf_<?php echo ($field["name"]); ?>'></embed>";
		        			$("#tpl-form-file-swf_<?php echo ($field["name"]); ?>").append(html);
		        			$("#swf_field_hidden_<?php echo ($field["name"]); ?>").val(data.path);
		        		}
		        	});
		        	uploader_<?php echo ($field["name"]); ?>.on("uploadFinished", function () {
				        uploader_<?php echo ($field["name"]); ?>.destroy();
				        initWebuploader();
				    });
    			}
    			initWebuploader();
    		})
        </script><?php break;?>
	<?php case "editor": ?><div class="am-form-group">
			<label class="am-u-sm-2 am-form-label">
				<?php echo ($field["title"]); ?>
				<span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span>
			</label>
			<div class="am-u-sm-8">
					<textarea id="editor_<?php echo ($field["name"]); ?>" name="<?php echo ($field["name"]); ?>" type="text/plain" style="<?php echo ($field["opt"]["style"]); ?>"></textarea>
					<?php $value = html_entity_decode($field['value']); ?>
					<script>
                        UE.getEditor('editor_<?php echo ($field["name"]); ?>').addListener("ready", function () {
                            UE.getEditor('editor_<?php echo ($field["name"]); ?>').setContent('<?php echo ($value); ?>');
                        });
					</script>
			</div>
			<div class="am-u-sm-2">
				<?php echo ($field["opt"]["prompt"]); ?>
			</div>
		</div><?php break;?>
	<?php case "noselect": ?><div class="am-form-group">
			<label  class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?> <span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span></label>
			<div class="am-u-sm-4">
				<select data-am-selected="{searchBox: 1,maxHeight: 200}" name="<?php echo ($field["name"]); ?>" onchange="selectDataList(this)" id="noselect">
					<?php if(is_array($field["opt"])): $i = 0; $__LIST__ = $field["opt"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i; $selected = $field['value']==$key ? 'selected="selected" ' : ''; ?>
						<option value="<?php echo ($key); ?>"  <?php echo ($selected); ?> ><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="am-u-sm-6"></div>
		</div><?php break;?>
	<?php case "selectdata": $frist = $field['opt'][0]; ?>
		<div class="am-form-group">
			<label  class="am-u-sm-2 am-form-label"><?php echo ($field["title"]); ?> <span class="tpl-form-line-small-title"><?php echo ($field["subtitle"]); ?></span></label>
			<div class="am-u-sm-4">
				<select data-am-selected="{searchBox: 1,maxHeight: 200}" name="<?php echo ($field["name"]); ?>" id="onchangeselect">
					<?php if(is_array($frist)): $i = 0; $__LIST__ = $frist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"  <?php echo ($selected); ?> ><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="am-u-sm-6"></div>
		</div>
		<?php $newarr = json_encode($field['opt']); ?>
		<script>
			var arr = <?php echo ($newarr); ?>;
			var old_val =("<?php echo ($field['value']); ?>");
			function selectDataList(dom){
				var selectVal = $(dom).val();
				if(selectVal == "user_car"){
                    selectRes(arr[1]);
				}else if (selectVal == "user_noble"){
                    selectRes(arr[2]);
				}else if (selectVal == "recommend"){
                    selectRes(arr[3]);
				}else if(selectVal == "announce"){
                    selectRes(arr[4]);
				}else if(selectVal == "medal"){
                    selectRes(arr[5]);
                }else{
                    selectRes();
				}
			}
            selectDataList($("#noselect"));
            var p_val = "<?php echo ($val); ?>";
			function  selectRes(arr) {
				$("#onchangeselect").children().remove();
				if(arr){
                    var len = arr.length;
                    for(var i = 0;i<len;i++){
                        var select = "";
                        if(old_val == arr[i].id){
                            select  = "selected='selected'";
						}
                        var html = "<option value="+arr[i].id+" "+select+">"+arr[i].name+"</option>";
                        $("#onchangeselect").append(html);
                    }
				}else{
                    var html = "<option value='0'> 请选择奖励类型</option>";
                    $("#onchangeselect").append(html);
				}

            }
		</script><?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
							<div class="am-form-group">
                                <div class="am-u-sm-7 am-u-sm-push-3">
                                <?php if(is_array($buttonList)): $i = 0; $__LIST__ = $buttonList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$button): $mod = ($i % 2 );++$i;?><button <?php echo ($button["attr"]); ?>><?php echo ($button["title"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

		</div>
	</div>
    <script src="/Application/Admin/Static/js/toast.js" type="text/javascript" ></script>
    <script src="/Application/Admin/Static/js/toast.class.js" type="text/javascript" ></script>
    <script src="/Application/Admin/Static/js/app.js" type="text/javascript" ></script>
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