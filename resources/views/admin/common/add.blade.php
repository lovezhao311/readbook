<div class="headbar">
	<include file="Public/ur_here" />
</div>
<div class="content_box">
	<div class="content form_content">
		<form method="post">
			<table class="form_table" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>				
				<tr>
					<th>分类名称：</th>
					<td>
						<input class="normal" name="cate_name" type="text" value="{$category.cate_name}" pattern="required" alt="分类名称不能为空" /><label>* 必选项</label>
						<input name="id" value="{$category.id}" type="hidden" />
					</td>
				</tr>
				<tr>
					<th>分类url：</th>
					<td>
						<input class="normal" name="cate_url" type="text" value="{$category.cate_url}" pattern="required" alt="分类url不能为空" /><label>* 必选项</label>				
					</td>
				</tr>
				<tr>
					<th>分类域名：</th>
					<td>
						<input class="normal" name="cate_domain" type="text" value="{$category.cate_domain|default='www'}" pattern="required" alt="分类域名不能为空" /><label>* 必选项</label>						
					</td>
				</tr>
				<tr>
					<th>上级分类：</th>
					<td>
						<select class="normal" name="parent_id" onchange='update_model();'>
						<option value="0">顶级分类</option>
						<volist name="categorys" id="el">
							<if condition="$el['id'] eq $category['parent_id']">
							<option value="{$el.id}" selected="true">			
								｜{:str_repeat("－",$el['Count'])}
								{$el.cate_name}
							</option>
							<else />
							<option value="{$el.id}">			
								｜{:str_repeat("－",$el['Count'])}
								{$el.cate_name}
							</option>
							</if>
						</volist>		
					</td>
				</tr>
				<tr>
					<th>商品模型：</th>
					<td>
					<select class="normal" name="model_id" pattern='required' alt='必需选择商品模型'>
						<option value=''>选择商品模型</option>
						<volist name="models" id="el">							
							<if condition="$el['id'] eq $category['model_id'] ">
							<option value='{$el.id}' selected='selected'>{$el.model_name}</option>
							<else />
							<option value='{$el.id}'>{$el.model_name}</option>
							</if>
						</volist>				
					</select>
					<label>* 必选项</label>
					</td>
				</tr>
				<tr>
					<th>首页是否显示：</th>
					<td>
						<eq name="category['show_index']" value='1'>
						<label class='attr'><input name="show_index" type="radio" value="1" checked='checked' /> 是 </label>
						<label class='attr'><input name="show_index" type="radio" value="0"  /> 否 </label>
						<else />
						<label class='attr'><input name="show_index" type="radio" value="1" /> 是 </label>
						<label class='attr'><input name="show_index" type="radio" value="0" checked='checked' /> 否 </label>
						</eq>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input class="normal" name="sort_order" pattern='int' empty alt='排序必须是一个数字' type="text" value="{$category.sort_order|default='255'}"/></td>
				</tr>
				<tr>
					<th>分类描述：</th><td><textarea name="cate_desc" cols="" rows="">{$category.cate_desc}</textarea></td>
				</tr>
				<tr>
					<th>SEO标题：</th><td><input class="normal" name="meta_title" type="text" value="{$category.meta_title}" /></td>
				</tr>
				<tr>
					<th>SEO关键词：</th><td><input class="normal" name="meta_keywords" type="text" value="{$category.meta_keywords}" /></td>
				</tr>
				<tr>
					<th>SEO描述：</th><td><textarea name="meta_description" cols="" rows="">{$category.meta_description}</textarea></td>
				</tr>
				<tr>
					<td></td><td><button class="submit" type="submit"><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type='text/javascript'>
	//修改分类同步模型
	function update_model()
	{
		var selectedOption = $('[name="parent_id"] option:selected');
		$('[name="model_id"]').val(selectedOption.attr('model_id'));
	}
</script>

