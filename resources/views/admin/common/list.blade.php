<html>
<head>
	<title>列表页面</title>
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_style.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_right.css" />
	<script src="/static/admin/js/artTemplate/artTemplate.js" type="text/javascript"></script>
	<script src="/static/admin/js/artTemplate/artTemplate-plugin.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/static/admin/js/artdialog/skins/chrome.css" type="text/css" />
	<script src="/static/admin/js/jquery.idTabs.min.js" type="text/javascript"></script>
	<script src="/static/admin/js/artdialog/artDialog.js" type="text/javascript"></script>
	<script src="/static/admin/js/artdialog/plugins/iframeTools.js" type="text/javascript"></script>
	<script src="/static/admin/js/validate.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/static/admin/js/validate/style.css">
	<script src="/static/admin/js/jquery-1.4.4.min.js"></script>
	<script src="/static/admin/js/jquery.stonecms.js" type="text/javascript"></script>
	<script src="/static/admin/js/main.js"></script>
</head>
<body>
<div class="right_body">
	<div class="headbar">
	<div class="top_subnav">CMS内容管理平台 ＞ 首页 ＞ 商品列表</div>
	<div class="operating">
		<div class="search f_r">
			<form method="post" name="searchModForm">
				<select name="search[name]" class="auto">
					<option value="mobile">手机号码</option>								
					<option value="email">邮件地址</option>								
					<option value="username">会员昵称</option>					
				</select>
				<input type="text" value="" name="search[keywords]" class="small">
				<button type="submit" class="btn"><span class="sch">搜 索</span></button>
			</form>
		</div>

		<a href="/index.php/Admin/member/member_add.html">
			<button type="button" class="operating_btn">
				<span class="addition">添加会员</span>
			</button>
		</a>
		<a class="all_checkbox" href="javascript:void(0);">
			<button class="operating_btn">
				<span class="sel_all">全选</span>
			</button>
		</a>
		<a href="javascript:void(0);">
			<button class="operating_btn">
				<span class="delete">批量删除</span>
			</button>
		</a>
		<a href="/index.php/Admin/member/group_list.html"><button type="button" class="operating_btn"><span class="grade">会员等级</span></button></a>
	</div>
	<div class="searchbar">
		<form name="searchListForm" method="post">	
			<select name="search[rank_id]" class="auto">
				<option value="">会员等级</option>
									<option value="2">注册会员</option>					<option value="3">铁牌会员</option>						
			</select>
			会员积分大于
			<input type="text" value="" name="search[gtexp]" class="small">
			会员积分小于
			<input type="text" value="" name="search[ltexp]" class="small">
			搜索字段
			<select name="search[name]" class="auto">
								<option value="mobile">手机号码</option>								<option value="email">邮件地址</option>								<option value="username">会员昵称</option>				
			</select>
			关键词<input type="text" value="" name="search[keywords]" class="small">
			<button type="submit" class="btn"><span class="sel">筛 选</span></button>
		</form>
	</div>

	<div class="field">
		<table class="list_table">
			<colgroup>
				<col width="40px">
				<col>
				<col>
				<col>
				<col width="180px">
				<col width="180px">
				<col width="180px">
				<col width="100px">
			</colgroup>

			<thead>
				<tr class="">
					<th>选择</th>
					<th>会员名称</th>
					<th>邮件地址</th>
					<th>手机号码</th>
					<th>资金</th>
					<th>会员等级</th>
					<th>会员积分</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>

</div>

<div class="content" style="height: 326px;">		
	<form name="groupFrom" method="post">
		<table class="list_table">
			<colgroup>
				<col width="40px">
				<col>
				<col>
				<col>
				<col width="180px">
				<col width="180px">
				<col width="180px">
				<col width="100px">
			</colgroup>
			<tbody>	
				<tr class="">
					<td><input type="checkbox" value="2" class="item_checkbox" name="id[]"></td>
					<td>root_dad</td>
					<td>zft55052623@126.cn</td>
					<td>18695633623</td>
					<td>0.00</td>
					<td>注册会员</td>
					<td>0</td>
					<td>
						<a title="删除会员" href="/index.php/Admin/Member/member_del/id/2.html">
							<img alt="删除会员" src="/Public/admin/images/icon_del.gif" class="operator">
						</a>
                        <a title="编辑会员资料" href="/index.php/Admin/Member/member_edit/id/2.html">
							<img alt="编辑" src="/Public/admin/images/icon_edit.gif" class="operator">
						</a>
					</td>
				</tr>			</tbody>

		</table>
	</form>
</div>
</div>
</body>
</html>