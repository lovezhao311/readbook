<script type="text/javascript" charset="utf-8" src="__PUBLIC__/admin/js/editor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/admin/js/editor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="__PUBLIC__/admin/js/editor/lang/zh-cn/zh-cn.js"></script>
<div class="headbar">
	<include file="Public/ur_here" />
	<ul class="tab" name="menu1">
		<li><a href="#tab-1" hidefocus="true" class="selected">基本信息</a></li>
		<li><a href="#tab-2" hidefocus="true">描述</a></li>
		<li><a href="#tab-3" hidefocus="true">SEO</a></li>
	</ul>

</div>

<div class="content_box">
	<div class="content form_content">
		<form action="" name="goodsForm" method="post">
			<table id="tab-1" class="form_table" name="table">
				<col width="150px" />
				<col />
			<tr>
				<th>商品名称：</th>
				<td>
					<input class="normal" name="goods_name" type="text" value="{$goods_info.goods_name}" pattern="required" alt="商品名称不能为空" /><label>* 商品名称（必填）</label>
				</td>
			</tr>					
			<tr >
				<th>所属分类：</th>
				<td>
					<ul class="select">
						<volist name="categorys" id="el">
						<li style="padding-left:{$el.Count}0px">
							<if condition="in_array($el['id'] , $goods_info['Categorys'])">
							<label><input type="checkbox" value="{$el.id}" name="category[]" checked="checked" />{$el.cate_name}</label>
							<else />
							<label><input type="checkbox" value="{$el.id}" name="category[]" />{$el.cate_name}</label>
							</if>
						</li>					
						</volist>
					</ul>
				</td>
			</tr>
			<tr>
				<th>商品模型：</th>
				<td>
					<if condition="$goods_info['model_id']" >
					<volist name="model_list" id="el">
						<if condition="$el['id'] eq $goods_info['model_id']">
						<span>{$el.model_name}</span>	
						<input type="hidden" name="model_id" value="{$el.id}" >						
						</if>
					</volist>					
					<else />
					<select class="auto" pattern="required" name="model_id" pattern="int" onchange="$.create_attr(this.value)">							
						<option>请选择商品模型</option>
						<volist name="model_list" id="el">
							<if condition="$el['id'] eq $goods_info['model_id']">
							<option value="{$el.id}" selected="selected">{$el.model_name}</option>
							<else />
							<option value="{$el.id}">{$el.model_name}</option>
							</if>
						</volist>
					</select>
					<label>* 商品模型（必填）</label>
					</if>
				</td>
			</tr>
			<tr>
				<th>是否上架：</th>
				<td>
					<if condition="$goods_info['shelves']">
					<label class='attr'><input type="radio" name="shelves" value="0"> 否</label>
					<label class='attr'><input type="radio" name="shelves" value="1" checked> 是</label>
						<else />
					<label class='attr'><input type="radio" name="shelves" value="0" checked> 否</label>
					<label class='attr'><input type="radio" name="shelves" value="1"> 是</label>
					</if>
				</td>
			</tr>					
			<tr>
				<th>附加数据：</th>
				<td>
					<div class="con">
						<table class="border_table">
							<thead>
								<tr>
									<th>购买成功增加积分</th>
									<th>排序</th>
									<th>计量单位显示</th>
									<th>购买成功增加经验值</th>
								
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input class="small" name="point" type="text" pattern="int" value="{$goods_info.point|default="0"}">
									</td>
									<td>
										<input class="small" name="sort_order" type="text" pattern="int" value="{$goods_info.sort_order|default="99"}">
									</td>
									<td>
										<select class="auto" name="unit">
											<volist name="unit" id="el">
											<if condition="$goods_info['unit'] eq $el['id']">
											<option value="{$el.id}" selected='selected'>{$el.name}</option>
											<else />
											<option value="{$el.id}">{$el.name}</option>
											</if>
											</volist>											
										</select>
									</td>
									<td>
										<input class="small" name="exp" type="text" pattern="int" value="{$goods_info.exp|default="0"}">
									</td>									
								</tr>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<th>基本数据：</th>
				<td>
					<div class="con">
						<table class="border_table">
							<thead id="goodsBaseHead">
								<!--商品标题模板-->
									<script id="goodsHeadTemplate" type='text/html'>
									<tr>
										<th>商品货号</th>
										<%var isProduct = false;%>
										<%for(var item in templateData){%>
										<%isProduct = true;%>
										<th><%=templateData[item]['spec_name']%></th>
										<%}%>
										<th>库存</th>
										<th>市场价格</th>
										<th>销售价格</th>			
										<th>重量</th>
										<%if(isProduct == true){%>
										<th>操作</th>
										<%}%>
									</tr>
									</script>

							</thead>
							<tbody id="goodsBaseBody">
																
							</tbody>	
							<!--商品内容模板-->
							<script id="goodsRowTemplate" type="text/html">
							<%var i=0;%>
							<%for(var item in templateData){%>
							<%item = templateData[item]%>
							<tr class='td_c'>
								<td><input class="small" name="_goods_no[<%=i%>]" pattern="required" type="text" value="<%=item['goods_no']?item['goods_no']:item['products_no']%>" /></td>								
								<%var isProduct = false;%>							
								<%for(var result in item['spec_array']){%>
								<%result = item['spec_array'][result]%>
								<input type='hidden' name="_spec_array[<%=i%>][]" value='<%=result['id']%>' />
								<%isProduct = true;%>
								<td>								
									<%=result['spec_value']%>	
								</td>
								<%}%>
								<td><input class="tiny" name="_stock[<%=i%>]" type="text" pattern="int" value="<%=item['stock']?item['stock']:100%>" /></td>
								<td><input class="tiny" name="_market_price[<%=i%>]" type="text" pattern="float" value="<%=item['market_price']?item['market_price']:0.00%>" /></td>
								<td>									
									<input class="tiny" name="_shop_price[<%=i%>]" type="text" pattern="float" value="<%=item['shop_price']?item['shop_price']:0%>" />							
								</td>								
								<td><input class="tiny" name="_weight[<%=i%>]" type="text" pattern="float" empty value="<%=item['weight']?item['weight']:0%>" /></td>
								<%if(isProduct == true){%>
								<td><a href="javascript:void(0)" onclick="delProduct(this);"><img class="operator" src="__PUBLIC__/admin/images/icon_del.gif" alt="删除" /></a></td>
								<%}%>
							</tr>
							<%i++;%>
							<%}%>
							</script>		
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<th>规格：</th>
				<td>
					<button class="btn" type="button" onclick="$.selSpec()">
						<span class="add">添加规格</span>
					</button>
				</td>
			</tr>					
			<tr id="properties" style="display:none">
				<th>扩展属性：</th>
				<td>					
					<table class="border_table1" id="propert_table"></table>
					<script type='text/html' id='propertiesTemplate'>
					<%for(var item in templateData){%>
						<%item = templateData[item]%>
						<%var valueItems = item['attr_value'].split(',');%>
						<tr>
							<th><%=item.attr_name%></th>
							<%if(item['wirte_way'] == 1){%>
							<td>							
							<%for(var tempVal in valueItems){%>
								<%tempVal = valueItems[tempVal]%>
								<label class="attr">
								<%if(item.value && item.value == tempVal){%>
									<input type="radio" name="attr_id[<%=item.id%>]" checked="checked" value="<%=tempVal%>"><%=tempVal%>
									<%}else{%>
									<input type="radio" name="attr_id[<%=item.id%>]" value="<%=tempVal%>"><%=tempVal%>
								<%}%>
									
								</label>							
							<%}%>
							</td>
							<%}else if(item['wirte_way'] == 2){%>
							<td>
							<%for(var tempVal in valueItems){%>
								<%tempVal = valueItems[tempVal]%>
								<%if(item.value && item.value == tempVal){%>
								<label class="attr"><input type="checkbox" name="attr_id[<%=item.id%>][]" value="<%=tempVal%>" checked="checked" /><%=tempVal%></label>
								<%}else{%>
								<label class="attr"><input type="checkbox" name="attr_id[<%=item.id%>][]" value="<%=tempVal%>" /><%=tempVal%></label>
								<%}%>
								<%}%>
							</td>
							<%}else if(item['wirte_way'] == 3){%>
							<td>
							<select class="auto" name="attr_id[<%=item['id']%>]">
							<option>请选择</option>
							<%for(var tempVal in valueItems){%>
							<%tempVal = valueItems[tempVal]%>
							<%if(item.value && item.value == tempVal){%>
							<option value="<%=tempVal%>" selected="selected"><%=tempVal%></option>
							<%}else{%>
							<option value="<%=tempVal%>"><%=tempVal%></option>
							<%}%>
							<%}%>
							</select>
							</td>
							<%}else if(item['wirte_way'] == 4){%>
							<td>
							<input type="text" name="attr_id[<%=item['id']%>]" value="<%=item['value']%>" class="normal" />
							</td>								
							<%}%>
						</tr>
					<%}%>
					</script>					
				</td>
			</tr>
			<tr>
				<th>商品推荐类型：</th>
				<td>
					<volist name="types" id="el">
					<if condition="in_array($el['id'] , $goods_info['Types'])">
					<label class="attr"><input name="goods_type[]" type="checkbox" value="{$el.id}" checked="checked"/>{$el.type_name}</label>	
					<else />
					<label class="attr"><input name="goods_type[]" type="checkbox" value="{$el.id}" />{$el.type_name}</label>
					</if>
					</volist>				
				</td>
			</tr>				
			<tr>
				<th>商品主图</th>
				<td id="thumbnail"></td>
				<!--图片模板-->
				<script type='text/html' id='picTemplate'>
				<span class='pic fileInputContainer'>
					<input class="fileInput upload_image"  type="file" data-oldimg="<%=picRoot.id%>" data-type="thumbnail" data-loading="__PUBLIC__/admin/css/skins/icons/loading.gif" />
					<img style="margin:5px; opacity:1;width:100px;border:none;" src="<%=picRoot.filename?picRoot.filename:'/Public/admin/images/iconfont-jiazaizhong.png'%>" alt="<%=picRoot.filename%>" />			
        			<input type="hidden" name="goods_image" value="<%=picRoot.id?picRoot.id:0%>"/>
				</span>
				</script>
			</tr>
			<tr>
				<th>商品相册</th>
				<td id="thumbnails"></td>
				<!--图片模板-->
				<script type='text/html' id='picsTemplate'>
				<%for(var item in picsRoot){%>
					<%picRoot=picsRoot[item]%>
					<span class='pic fileInputContainer'>
						<input class="fileInput upload_image" type="file" data-oldimg="<%=picRoot.id%>" data-type="goods_album" data-loading="__PUBLIC__/admin/css/skins/icons/loading.gif" />
						<img style="margin:5px; opacity:1;width:100px;border:none;" src="<%=picRoot.filename%>" alt="<%=picRoot.filename%>" />			
	        			<input type="hidden" name="album[]" value="<%=picRoot.id%>"/>
					</span>
				<%}%>
				</script>
				
			</tr>
			</table>
			<table id="tab-2" class="form_table" name="table">
				<col width="150px" />
				<col />
				<tr>
					<th>产品描述：</th>
					<td>
						<textarea id="content7" name="description" style="width:960px;">{$goods_info.description}</textarea>
					</td>
				</tr>
			</table>
			<table id="tab-3" class="form_table" name="table">
				<col width="150px" />
				<col />				
				<tr>
					<th>mate关键词：</th>
					<td>
						<input class="normal" name="mate_keywords" type="text" value="{$goods_info.mate_keywords}">
					</td>
				</tr>
				<tr>
					<th>mate描述：</th>
					<td>
						<textarea name="mate_description">{$goods_info.mate_description}</textarea>
					</td>
				</tr>
			</table>

			<table class="form_table">
				<colgroup><col width="150px">
				<col>
				</colgroup><tbody><tr>
					<td></td>
					<td>
						<input type="hidden" name="id" value="{$goods_info.id}" />
						<button class="submit" type="submit" onclick="return checkForm()"><span>发布商品</span></button>
					</td>
				</tr>
			</tbody></table>
		</form>
	</div>
</div>
<script type="text/javascript">
var model_data;
var defaultProductNo	=	"{:create_goods_sn()}";
$(function(){
	//初始化
	initProductTable();
	//图片上传
	$.upload_image();
	//存在商品信息
	$('[name="_goods_no[0]"]').val(defaultProductNo);

});

var thumbnail =	{:json_encode($thumbnail)};
var picHtml = template.render('picTemplate',{'picRoot':thumbnail});
$('#thumbnail').append(picHtml);

var thumbnails =	{:json_encode($album)};
var picsHtml = template.render('picsTemplate',{'picsRoot':thumbnails});
$('#thumbnails').append(picsHtml);

//初始化货品表格
function initProductTable()
{
	//默认产生一条商品标题空挡
	var default_goodsHead	=	{:json_encode($model_info_head)};
	var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':default_goodsHead});
	$('#goodsBaseHead').html(goodsHeadHtml);	
	//默认产生一条商品空挡
	var defaule_goodsRow	=	{:json_encode($goods_info['Products'])};
	var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':defaule_goodsRow == null ? [[]] : defaule_goodsRow});
	$('#goodsBaseBody').html(goodsRowHtml);

}


//编辑器
var ue = window.UE.getEditor('content7');
//选择模型
$.create_attr	=	function (model_id) {
	$.post(
		'{:U('Goods/attribute_init')}' ,
		{id:model_id} ,
		function(data){			
			//propertiesTemplate
			if(data){
			 	model_data	=	data;
				var templateHtml = template.render('propertiesTemplate',{'templateData':data.attr});
				$('#propert_table').html(templateHtml);
				$('#properties').show();
			}	

		},'json');
}
//
$.selSpec	=	function () {
	var model_id	=	"";
	//货品是否已经存在
	if($('input:hidden[name^="_spec_array"]').length > 0)
	{
		alert("当前货品已经存在，无法进行规格设置。\n如果需要重新设置规格请您手动删除当前货品");
		return;
	}

	if(model_data){
		model_id	=	model_data.id;
	}else{
		alert('请先选择商品模型。');
		return;
	}

	art.dialog.open('{:U('Goods/search_spec')}?id='+model_id, {
		    title: '设置商品的规格',
		    okVal:'保存',
		    ok:function(iframeWin, topWin){
				var addSpecObject = iframeWin.document.forms['search_specForm'];
				//开始遍历规格
				var temp = [];
				var specData      = [];
				var specTitle		=	{};
				var i = 0;
				$(addSpecObject).find('input:hidden[name="specJson"]').each(function()
				{

					var json = $.parseJSON(this.value);					
					if(!temp[json.spec_id] && temp[json.spec_id] != 0){
						temp[json.spec_id]	=	i;
						i++;
						specData[temp[json.spec_id]]	=	[];
						specTitle[temp[json.spec_id]]      = {'id':json.id,'spec_name':json.spec_name};
					}
					specData[temp[json.spec_id]].push({'id':json.id,'spec_name':json.spec_name,'spec_value':json.spec_value});
				});
				
				//生成货品的笛卡尔积
				var specMaxData = cartProd(specData);
				// console.log(specData);
				//从表单中获取默认商品数据
				var productJson = {};
				$('#goodsBaseBody tr:first').find('input[type="text"]').each(function(){
					productJson[this.name.replace(/^_(\w+)\[\d+\]/g,"$1")] = this.value;
				});
			
				//生成最终的货品数据
				var productList = [];

				for(var i = 0;i < specMaxData.length;i++)
				{
					var productItem = {};
					for(var index in productJson)
					{
						//自动组建货品号
						if(index == 'goods_no')
						{
							//值为空时设置默认货号
							if(productJson[index] == '')
							{
								productJson[index] = defaultProductNo;
							}

							if(productJson[index].match(/(?:\-\d*)$/) == null)
							{
								//正常货号生成
								productItem['goods_no'] = productJson[index]+'-'+(i+1);
							}
							else
							{
								//货号已经存在则替换
								productItem['goods_no'] = productJson[index].replace(/(?:\-\d*)$/,'-'+(i+1));
							}
						}
						else
						{
							productItem[index] = productJson[index];
						}
					}
					
					productItem['spec_array'] = specMaxData[i];
					productList.push(productItem);
				}
				// console.log(specTitle);
				//创建规格标题
				var goodsHeadHtml = template.render('goodsHeadTemplate',{'templateData':specTitle});
				$('#goodsBaseHead').html(goodsHeadHtml);
				//创建货品数据表格
				var goodsRowHtml = template.render('goodsRowTemplate',{'templateData':productList});
				$('#goodsBaseBody').html(goodsRowHtml);


		    }
		});
	
}

//删除货品
function delProduct(_self)
{
	$(_self).parent().parent().remove();
	if($('#goodsBaseBody tr').length == 0)
	{
		initProductTable();
	}
}


//笛卡儿积组合
function cartProd(paramArray) {

 	function addTo(curr, args) {

		var i, copy, 
		rest = args.slice(1),
		last = !rest.length,
		result = [];		
		for(i in args[0]){
			copy = curr.slice();
			copy.push(args[0][i]);

			if (last) {
				result.push(copy);
			} else {
				result = result.concat(addTo(copy, rest));
			}
		}
	 	return result;
 	}
 	return addTo([], paramArray);
}




</script>
<if condition="isset($goods_info) && !empty($goods_info)">
<script type="text/javascript">
var model_info	=	{:json_encode($model_info)};
var templateHtml = template.render('propertiesTemplate',{'templateData':model_info.attr});
$('#propert_table').html(templateHtml);
$('#properties').show();
</script>
</if>