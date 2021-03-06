<?php if (!defined('THINK_PATH')) exit();?>	<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>网站后台系统管理</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/yoga/Public/assets/css/bootstrap.css" />
		<link rel="stylesheet" href="/yoga/Public/assets/css/font-awesome.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/yoga/Public/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/yoga/Public/assets/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/yoga/Public/assets/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
        <link rel="stylesheet" href="/yoga/Public/assets/css/slackck.css" />
		<!-- ace settings handler -->
		<script src="/yoga/Public/assets/js/ace-extra.js"></script>
		<script src="/yoga/Public/assets/js/jquery.min.js"></script>
		<script src="/yoga/Public/assets/js/jquery.form.js"></script>
		<script src="/yoga/Public/layer/layer.js"></script>
		<!--<script src="/yoga/Public/assets/js/jquery.leanModal.min.js"></script>-->

		<!--[if lte IE 8]>
		<script src="/yoga/Public/assets/js/html5shiv.js"></script>
		<script src="/yoga/Public/assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default    navbar-collapse">
			<div class="navbar-container" id="navbar-container">
				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="<?php echo U('Index/index');?>" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							生活的艺术-瑜伽后台管理系统
						</small>
					</a>

				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">
					<li class="transparent"></li>
					<li class="transparent">
						<a style="cursor:pointer;" id="cache" class="dropdown-toggle">清除缓存</a>
					</li>

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/yoga/Public/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo ($_SESSION['admin_username']); ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										个人设置
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										会员中心
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="javascript:;"  id="logout">
										<i class="ace-icon fa fa-power-off"></i>
										注销
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>


<script type="text/javascript">
$(document).ready(function(){
	$("#logout").click(function(){
		layer.confirm('你确定要退出吗？', {icon: 3}, function(index){
	    layer.close(index);
	    window.location.href="<?php echo U('Login/logout');?>";
	});
	});
});



$(function(){
$('#cache').click(function(){
if(confirm("确认要清除缓存？")){
var $type=$('#type').val();
var $mess=$('#mess');
$.post('/yoga/Admin/News/clear',{type:$type},function(data){
alert("缓存清理成功");
});
}else{
return false;
}
});
});
</script>



		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">

			<!-- #section:basics/sidebar -->

				<div id="sidebar" class="sidebar responsive">



				<ul class="nav nav-list">
<?php use Common\Controller\AuthController; use Think\Auth; $m = M('auth_rule'); $field = 'id,name,title,css'; $data = $m->field($field)->where('pid=0 AND status=1')->order('sort')->select(); $auth = new Auth(); foreach ($data as $k=>$v){ if(!$auth->check($v['name'], $_SESSION['aid']) && $_SESSION['aid'] != 1){ unset($data[$k]); } } ?>

<?php if(is_array($data)): foreach($data as $key=>$v): ?><li class="<?php if(CONTROLLER_NAME == $v['name']): ?>active open<?php endif; ?>"><!--open代表打开状态-->
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa <?php echo ($v["css"]); ?>"></i>
							<span class="menu-text">
								<?php echo ($v["title"]); ?>
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
    <?php $m = M('auth_rule'); $dataa = $m->where(array('pid'=>$v['id'],'status'=>1))->select(); foreach ($dataa as $kk=>$vv){ if(!$auth->check($vv['name'], $_SESSION['aid']) && $_SESSION['aid'] != 1){ unset($dataa[$kk]); } } ?>
    <?php if(is_array($dataa)): foreach($dataa as $key=>$j): ?><li class="<?php if(($_SESSION['se'] == $j['id'])): ?>active<?php endif; ?>">
								<a href="<?php echo U($j['name'],array('se'=>$j['id']));?>">
									<i class="menu-icon fa fa-caret-right"></i>
									<?php echo ($j["title"]); ?>
								</a>
								<b class="arrow"></b>
							</li><?php endforeach; endif; ?>
						</ul>
					</li><?php endforeach; endif; ?>

				</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>




			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">



                        <!--主题-->
						<div class="page-header">
							<h1>
								您当前操作
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									添加课程文案
								</small>
							</h1>
						</div>

<script type="text/javascript" src="/yoga/Public/assets/js/region.js"></script>
						<div class="row">
							<div class="col-xs-12">
								<form class="form-horizontal" name="form0" id="form0"  method="post" action="<?php echo U('class_runadd');?>"  enctype="multipart/form-data">

                                  <?php $arr=session('classcopy');?>
									<div class="space-4"></div>

                                	<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程名称：  </label>
										<div class="col-sm-10">
											<input type="text" name="title" id="title"  placeholder="必填：课程标题"  class="col-xs-10 col-sm-6" value="<?php echo ($arr["mc_title"]); ?>"/>

                                            <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle" id="resone"></span>
											</span>
										</div>
									</div>
                                    <div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程文案归属：  </label>
										<div class="col-sm-10">
											 <select name="member_list_province" id="class_diyflag" onChange="loadClass('class_diyflag','class_type','<?php echo U('Ajax/getClass');?>');">
												<option value="0" selected>未选择</option>
												<?php if(is_array($diyflag_two)): foreach($diyflag_two as $key=>$dt): ?><option value="<?php echo ($dt["dt_value"]); ?>" <?php if($dt['dt_value'] == $arr['ct_type_one']): ?>selected<?php endif; ?> ><?php echo ($dt["dt_name"]); ?></option><?php endforeach; endif; ?>
											 </select>
											 <select name="member_list_type" id="class_type" >
											   <option value="0">未选择</option>
											 </select>

	 									</div>
									</div>
									<script type="text/javascript">
									function loadClass(sel,selName,url,idnum){

										jQuery("#"+selName+" option").each(function(){
											jQuery(this).remove();
										});
										jQuery("<option value=0>请选择</option>").appendTo(jQuery("#"+selName));
										if(jQuery("#"+sel).val()==0){
											return;
										}
										jQuery.getJSON(url,{pid:jQuery("#"+sel).val()},
											function(data){

												if(data){
													jQuery.each(data,function(idx,item){

														if(item.ct_id==idnum){
															jQuery("<option value="+item.ct_id+" selected>"+item.ct_name+"("+item.ct_dm+")</option>").appendTo(jQuery("#"+selName));
														}else{
															jQuery("<option value="+item.ct_id+" >"+item.ct_name+"("+item.ct_dm+")</option>").appendTo(jQuery("#"+selName));
														}

													});
												}else{
													jQuery("<option value='0'>请选择</option>").appendTo(jQuery("#"+selName));
												}
											}
										);
									}
									$(function() {
										loadClass('class_diyflag','class_type','<?php echo U('Ajax/getClass');?>',"<?php echo ($arr['ct_id']); ?>");

									})

									</script>
                                    <div class="space-4"></div>


									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程指导教师：  </label>
                                        <div class="col-sm-5">
												<input type="text" name="news_flag" id="news_flag"  placeholder="必填：课程老师"  class="col-xs-10 col-sm-6"/>
                                             <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle" id="resone"></span>
											 </span>
											 </div>

									</div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程义工：  </label>
                                                  <div class="col-sm-5">
												<input type="text" name="work_flag" id="work_flag"  placeholder="必填：课程义工"  class="col-xs-10 col-sm-6"/>
                                             <span class="help-inline col-xs-12 col-sm-7">
												<span class="middle" id="resone"></span>
											 </span>
											 </div>
									</div>
                                    <div class="space-4"></div>



									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程发布人姓名：  </label>
										<div class="col-sm-10">
											<input type="text" name="ad_name" id="person" placeholder="输入真实姓名" class="col-xs-10 col-sm-6" />
										</div>
									</div>
                                    <div class="space-4"></div>

                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程发布人联系方式：  </label>
										<div class="col-sm-10">
											<input type="text" name="tel" id="tel" placeholder="输入手机号或者电话" class="col-xs-10 col-sm-6" />
										</div>
									</div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 地址类型 ： </label>
												<div class="checkbox">

													<label id="">
														<input class="ace ace-radio-2" name="sea" type="radio"  value="0" checked="checked"/>
														<span class="lbl"> 境内</span>
													</label>
													<label id="">
														<input class="ace ace-radio-2" name="sea" type="radio"  value="1" />
														<span class="lbl"> 境外</span>
													</label>

												</div>
									</div>
									<div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 隶属城市：  </label>
										<div class="col-sm-10">
											<input type="text" name="city" id="city" placeholder="上海" class="col-xs-3 col-sm-2" />
											<span class="lbl">&nbsp;&nbsp;注意：关系到课程编号的生成</span>
										</div>
									</div>

                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程详细地址：  </label>
										<div class="col-sm-10">
											<input type="text" name="adress" id="adress" placeholder="例：中国上海市浦东新区xxx路xxx号等" class="col-xs-10 col-sm-6" />
										</div>
									</div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程开始至结束日期：  </label>
										<div class="col-sm-10">
											<input type="text" name="starttime" id="starttime" placeholder="请按正确格式填写" class="col-xs-2 col-sm-2" />
											<div class="col-xs-1" style="text-align:center;line-height:30px;font-size:30px;">-</div>
											<input type="text" name="stoptime" id="stoptime" placeholder="请按正确格式填写" class="col-xs-2 col-sm-2" />
											<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 例：2016-05-06 24:00:00 </label>

										</div>
									</div>

                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程截止报名日期：  </label>
										<div class="col-sm-10">
											<input type="text" name="closingtime" id="closingtime" placeholder="例：2016-01-02 20:00:00" class="col-xs-2 col-sm-2" />


										</div>
									</div>

                                    <div class="space-4"></div>

                                    <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程最大报名数限制：  </label>
										<div class="col-sm-10">
											<input type="text" name="maxnum" id="max" placeholder="填写0则无限制" class="col-xs-3 col-sm-1" />
											<label class=" control-label no-padding-left"> &nbsp;人  </label>
										</div>
									</div>
                                    <div class="space-4"></div>





									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 封面图片上传： </label>
										<div class="col-sm-10">
										<a href="javascript:;" class="file">
                                          <input type="file" name="pic_one[]" id="file0" />
											选择上传文件
										</a>
											<span class="lbl">&nbsp;&nbsp;<img src="/yoga/Public/img/no_img.jpg" width="100" height="70" id="img0" ></span>&nbsp;&nbsp;<a href="javascript:;" onClick="return backpic('/yoga/Public/img/no_img.jpg');" title="还原修改前的图片" class="file">
                                            撤销上传
										</a>
											<span class="lbl">&nbsp;&nbsp;上传前先用PS处理成等比例图片后上传，请保证上传后预览以防失真<br />
</span>
										</div>
									</div>
                                    <div class="space-4"></div>








    <link href="/yoga/Public/ppy/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="/yoga/Public/ppy/js/fileinput.js" type="text/javascript"></script>
    <script src="/yoga/Public/ppy/js/fileinput_locale_zh.js" type="text/javascript"></script>








                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否开启： </label>
										<div class="col-sm-10" style="padding-top:5px;">
                                            <input name="open" id="open" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" <?php if($arr["mc_open"] == 1): ?>checked="checked"<?php endif; ?>/>
											<span class="lbl">&nbsp;&nbsp;注意：课程需要开启用户才能看到发布信息</span>
										</div>
									</div>

                                    <div class="space-4"></div>
                                    <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 是否置顶： </label>
										<div class="col-sm-10" style="padding-top:5px;">
                                            <input name="top" id="top" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
											<span class="lbl">&nbsp;&nbsp;默认不置顶</span>
										</div>
									</div>
                                    <div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程简介： </label>
										<div class="col-sm-9">
											<input type="text" name="say" id="news_scontent" class="col-xs-10 col-sm-10"  maxlength="50"  value="<?php echo ($arr["mc_say"]); ?>"/>
											<label class="input_last">已限制在50个字以内</label>
										</div>
									</div>
                                    <div class="space-4"></div>


									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 课程主内容 </label>
										<div class="col-sm-10">
											<script src="/yoga/Public/ueditor/ueditor.config.js" type="text/javascript"></script>
                                            <script src="/yoga/Public/ueditor/ueditor.all.js" type="text/javascript"></script>
											<textarea name="content" rows="100%" style="width:100%" id="myEditor"><?php echo ($arr["news_content_body"]); ?></textarea>
											<script type="text/javascript">
                                                var editor = new UE.ui.Editor();
                                                editor.render("myEditor");
                                            </script>
										</div>
									</div>
                                    <div class="space-4"></div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												保存
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												重置
											</button>
											&nbsp; &nbsp; &nbsp;
											<a class="btn" href="#" onClick="javascript:history.go(-1);"><i class="ace-icon fa fa-undo bigger-110"></i>取消</a>
										</div>
									</div>
								</form>
                        	</div>
                        </div>
									<div class="hr hr-24"></div>

<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
	<div class="row">
		<div class="col-xs-12">
			<div class="">
				<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse collapse_btn">
					<ul class="nav nav-list header-nav" id="header-nav">
                                        
    <?php $m = M('auth_rule'); $dataaa = $m->where(array('pid'=>$_SESSION['se'],'menustatus'=>1))->order('sort')->select(); foreach ($dataaa as $kkk=>$vvv){ if(!$auth->check($vvv['name'], $_SESSION['aid']) && $_SESSION['aid']!= 1){ unset($dataaa[$kkk]); } } ?>
    <?php if(is_array($dataaa)): foreach($dataaa as $key=>$k): ?><li>
												<a href="<?php echo U(''.$k['name'].'');?>">
													<o class="font12 <?php if((CONTROLLER_NAME.'/'.ACTION_NAME == $k['name'])): ?>rigbg<?php endif; ?>"><?php echo ($k["title"]); ?></o>
												</a>

								<b class="arrow"></b>
							</li><?php endforeach; endif; ?>
					</ul><!-- /.nav-list -->
				</div><!-- .sidebar -->
			</div>
		</div><!-- /.col -->
	</div><!-- /.row -->
	
</div>

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

				<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">生活的艺术-瑜伽</span>
							后台管理系统 &copy; 2015-2016
						</span>
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>


		<!-- basic scripts -->


<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script src="/yoga/Public/assets/js/bootstrap.js"></script>
		<script src="/yoga/Public/assets/js/maxlength.js"></script>
		<script src="/yoga/Public/assets/js/ace/ace.js"></script>
		<script src="/yoga/Public/assets/js/ace/ace.sidebar.js"></script>


		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			   $('#sidebar2').insertBefore('.page-content');

			   $('.navbar-toggle[data-target="#sidebar2"]').insertAfter('#menu-toggler');


			   $(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
				 if(event_name == 'sidebar_fixed') {
					 if( $('#sidebar').hasClass('sidebar-fixed') ) {
						$('#sidebar2').addClass('sidebar-fixed');
						$('#navbar').addClass('h-navbar');
					 }
					 else {
						$('#sidebar2').removeClass('sidebar-fixed')
						$('#navbar').removeClass('h-navbar');
					 }
				 }
			   }).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);
			})
		</script>


		</div><!-- /.main-container -->

	</body>
</html>
<script>
function backpic(picurl){
	$("#img0").attr("src",picurl);//还原修改前的图片
	$("input[name='file0']").val("");//清空文本框的值
}

$(document).ready(function(){

//多图设置
  $("#pic_list").hide();
  $("#news_pic_list").click(function(){
  	$("#pic_list").hide();
  });
  $("#news_pic_qqlist").click(function(){
  	$("#pic_list").show();
  });

  $("#pptaddress").hide();
  $("#news_flag_vaj").click(function(){
    $("#pptaddress").toggle(500);
  });
});


$(function(){
	$('#form0').ajaxForm({
		beforeSubmit: checkForm, // 此方法主要是提交前执行的方法，根据需要设置
		success: complete, // 这是提交后的方法
		dataType: 'json'
	});

	function checkForm(){


		if( '' == $.trim($('#title').val())){
			layer.alert('课程标题不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#title').focus();
			});
			return false;
		}

		if('' == $.trim($('#news_flag').val())){
			layer.alert('课程老师不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#news_flag').focus();
			});
			return false;
		}
		if('' == $.trim($('#work_flag').val())){
			layer.alert('课程义工不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#work_flag').focus();
			});
			return false;
		}


		if( '' == $.trim($('#person').val())){
			layer.alert('课程发布人不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#person').focus();
			});
			return false;
		}
		if( '' == $.trim($('#tel').val())){
			layer.alert('发布联系人不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#tel').focus();
			});
			return false;
		}
		if( '' == $.trim($('#city').val())){
			layer.alert('隶属城市不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#city').focus();
			});
			return false;
		}
		if( '' == $.trim($('#adress').val())){
			layer.alert('课程地址不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#adress').focus();
			});
			return false;
		}
		if( '' == $.trim($('#starttime').val())){
			layer.alert('课程开始时间不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#starttime').focus();
			});
			return false;
		}
		if( '' == $.trim($('#stoptime ').val())){
			layer.alert('课程结束时间不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#stoptime').focus();
			});
			return false;
		}

		if( '' == $.trim($('#closingtime').val())){
			layer.alert('课程截止报名时间不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#closingtime').focus();
			});
			return false;
		}
		if( '' == $.trim($('#max').val())){
			layer.alert('课程最大报名数不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#max').focus();
			});
			return false;
		}
		if( '' == $.trim($('#file0').val())){
			layer.alert('你必须上传一个课程封面', {icon: 6}, function(index){
 			layer.close(index);
			$('#file0').focus();
			});
			return false;
		}

		if( '' == $.trim($('#news_scontent').val())){
			layer.alert('课程简介不能为空', {icon: 6}, function(index){
 			layer.close(index);
			$('#news_scontent').focus();
			});
			return false;
		}






 }
	function complete(data){
		if(data.status==1){
			layer.alert(data.info, {icon: 6}, function(index){
 			layer.close(index);
			window.location.href=data.url;
			});
		}else{
			layer.alert(data.info, {icon: 6}, function(index){
 			layer.close(index);

			});
		}
	}

});

$("#file0").change(function(){
	var objUrl = getObjectURL(this.files[0]) ;
	console.log("objUrl = "+objUrl) ;
	if (objUrl) {
		$("#img0").attr("src", objUrl) ;
	}
}) ;
//建立一個可存取到該file的url
function getObjectURL(file) {
	var url = null ;
	if (window.createObjectURL!=undefined) { // basic
	$("#news_flag_vap").attr("checked", true);
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
	$("#news_flag_vap").attr("checked", true);
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		$("#news_flag_vap").attr("checked", true);
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}


</script>