$(function () {
	setSideBarActive('nav');
	
	$('#nav-list').find('li.nav-li').find('.click-layout').click(function(e){
		showEditBox($(this).parent().parent());
		e.stopPropagation();
	});
	
	$('#add-nav').find('li').click(function(){
		if ($(this).attr('type') == '4001')
		{
			$('#customer-link-box-title').text($('#update-customerlink-lang').text());
			$('#customer_link_form').find('.inputID').val($(this).attr('rel'));
			$('#customer_link_form').find('.inputName').val($(this).attr('name'));
			$('#customer_link_form').find('.inputUrl').val($(this).attr('url'));
			$('#delete-customerlink-btn').removeClass('hide');
		}
		else
		{
			$('#customer-link-box-title').text($('#new-customerlink-lang').text());
			$('#customer_link_form').find('.inputID').val('');
			$('#customer_link_form').find('.inputName').val('');
			$('#customer_link_form').find('.inputUrl').val('');
			$('#delete-customerlink-btn').addClass('hide');
		}
		return false;
	});
	
	$('#add-nav').find('li').find('.fa-plus').click(function(e){
		addNav($(this).parent().parent().parent());
		e.stopPropagation();
	});
	
	$('#save-navs-btn').click(function(){
		saveNavs();
	});
	
	$('#save-customerlink-btn').click(function(){
		saveCustomerLink();
	});
	
	$('#delete-customerlink-btn').click(function(){
		deleteCustomerLink();
	});
	
	var newNavIndex = 0;
	var deleteNavIds = [];
	
	function showEditBox(obj)
	{
		var type = obj.attr('type');
		var id = obj.attr('rel');
		var a =  obj.find('a:eq(0)');
		var upDownIcon = a.find('.up-down-icon');
		
		if (id == '')
		{
			newNavIndex++;
			id = '_new'+newNavIndex;
			obj.attr('rel',id);
		}
		
		if (type != 3001)
		{
			var editBoxId = 'nav_cms_box'+id;
		}
		else
		{
			var editBoxId = 'nav_customer_box'+id;
		}
		
		if ($('#'+editBoxId).length == 0)
		{
			if (type != 3001)
			{
				var cloneEditBox = $('#nav_cms_box').clone();
				cloneEditBox.find('.inputName').val(obj.attr('name'));
			}
			else
			{
				var cloneEditBox = $('#nav_customer_box').clone();
				cloneEditBox.find('.inputName').val(obj.attr('name'));
				cloneEditBox.find('.inputUrl').val(obj.attr('url'));
			}
			cloneEditBox.attr('id',editBoxId);
			a.after(cloneEditBox);
			editBoxBtnFunc(cloneEditBox);
		}
		showBtn($('#'+editBoxId));
		
		if ($('#'+editBoxId).hasClass('hide'))
		{
			$('#nav-list').find('li.nav-li').removeClass('bg-color-1');
			obj.addClass('bg-color-1');
			$('.nav-edit-box').addClass('hide');
			$('.up-down-icon').removeClass('fa-chevron-up');
			$('.up-down-icon').addClass('fa-chevron-down');
			
			$('#'+editBoxId).removeClass('hide');
			upDownIcon.removeClass('fa-chevron-down');
			upDownIcon.addClass('fa-chevron-up');
		}
		else
		{
			obj.removeClass('bg-color-1');
			$('#'+editBoxId).addClass('hide');
			upDownIcon.removeClass('fa-chevron-up');
			upDownIcon.addClass('fa-chevron-down');
		}
	}
	
	function showBtn(editBox)
	{
		var prev = editBox.parent().prev().not('.sub-category');
		if (prev.length > 0)
		{
			editBox.find('.upBtn').removeClass('hide');
			editBox.find('.rightBtn').removeClass('hide');
		}
		else
		{
			editBox.find('.upBtn').addClass('hide');
			editBox.find('.rightBtn').addClass('hide');
		}
		var next = editBox.parent().next();
		if (next.length > 0)
		{
			editBox.find('.downBtn').removeClass('hide');
		}
		else
		{
			editBox.find('.downBtn').addClass('hide');
		}
		var box = editBox.parent().parent().parent();
		if (box.hasClass('nav-sub-list'))
		{
			editBox.find('.leftBtn').removeClass('hide');
		}
		else
		{
			editBox.find('.leftBtn').addClass('hide');
		}
	}
	
	function editBoxBtnFunc(editBox)
	{
		editBox.find('input').change(function(e){
			if ($(this).hasClass('inputName'))
			{
				if (validateName($(this)))
				{
					$('#save-navs-btn').removeAttr('disabled');
					editBox.parent().attr('name',$(this).val());
					editBox.parent().find('span.name').first().text($(this).val());
				}
				else
				{
					$('#save-navs-btn').attr('disabled',true);
				}
			}
			if ($(this).hasClass('inputUrl'))
			{
				if (validateUrl($(this)))
				{
					$('#save-navs-btn').removeAttr('disabled');
					editBox.parent().attr('url',$(this).val());
				}
				else
				{
					$('#save-navs-btn').attr('disabled',true);
				}
			}
		});
		
		editBox.find('.removeBtn').click(function(e){
			deleteNavIds.push(editBox.parent().attr('rel'));
			editBox.parent().remove();
			//e.stopPropagation();
		});
		
		editBox.find('.upBtn').click(function(e){
			var prev = editBox.parent().prev().not('.sub-category');
			if (prev.length > 0)
			{
				prev.before(editBox.parent());
				showBtn(editBox);
			}
			//e.stopPropagation();
		});
		
		editBox.find('.downBtn').click(function(e){
			var next = editBox.parent().next();
			if (next.length > 0)
			{
				next.after(editBox.parent());
				showBtn(editBox);
			}
			//e.stopPropagation();
		});
		
		editBox.find('.rightBtn').click(function(e){
			var prev = editBox.parent().prev().not('.sub-category');
			if (prev.length > 0)
			{
				var navSubList = prev.find('.nav-sub-list').first();
				navSubList.find('ul').first().append(editBox.parent());
				showBtn(editBox);
			}
			//e.stopPropagation();
		});
		
		editBox.find('.leftBtn').click(function(e){
			var box = editBox.parent().parent().parent();
			if (box.hasClass('nav-sub-list'))
			{
				box.parent().after(editBox.parent());
				showBtn(editBox);
			}
			//e.stopPropagation();
		});
	}
	
	function addNav(obj)
	{
		var type = obj.attr('type');
		if (type != '3001')
		{
			if (type == '1001')
			{
				var subs = '';
				if (obj.find('.sub-item').length > 0){
					subs = '<li class="nav-li sub-category" type="1002" rel="" name="sub" ext_id="'+obj.attr('rel')+'" url="">';
					var subCategoryLang = $("#sub-category-lang").text();
					obj.find('.sub-item').each(function(){
						subs += '<a href="javascript:;"><span class="name">'+$(this).attr('name')+'</span><span class="text-gray">-'+subCategoryLang+'</span></a>';
					});
					subs += '</li>';
				}
				
				var nav = $('<li class="nav-li" type="'+obj.attr('type')+'" rel="" ext_id="'+obj.attr('rel')+'" name="'+obj.attr('name')+'"><a href="#"><div class="click-layout">&nbsp;</div><span class="name">'+obj.attr('name')+'</span><span class="text-gray">'+obj.find('.text-gray').text()+'</span><i class="up-down-icon pull-right fa fa-chevron-down"></i></a><div class="box box-solid nav-sub-list"><ul class="nav nav-stacked">'+subs+'</ul></div></li>');
			}
			else if (type == '8001')
			{
				var subs = '';
				if (obj.find('.sub-item').length > 0){
					subs = '<li class="nav-li sub-category" type="8002" rel="" name="sub" ext_id="'+obj.attr('rel')+'" url="">';
					var subCategoryLang = $("#product-category-lang").text();
					obj.find('.sub-item').each(function(){
						subs += '<a href="javascript:;"><span class="name">'+$(this).attr('name')+'</span><span class="text-gray">-'+subCategoryLang+'</span></a>';
					});
					subs += '</li>';
				}
				
				var nav = $('<li class="nav-li" type="'+obj.attr('type')+'" rel="" ext_id="'+obj.attr('rel')+'" name="'+obj.attr('name')+'"><a href="#"><div class="click-layout">&nbsp;</div><span class="name">'+obj.attr('name')+'</span><span class="text-gray">'+obj.find('.text-gray').text()+'</span><i class="up-down-icon pull-right fa fa-chevron-down"></i></a><div class="box box-solid nav-sub-list"><ul class="nav nav-stacked">'+subs+'</ul></div></li>');
			}
			else
			{
				var nav = $('<li class="nav-li" type="'+obj.attr('type')+'" rel="" ext_id="'+obj.attr('rel')+'" name="'+obj.attr('name')+'"><a href="#"><div class="click-layout">&nbsp;</div><span class="name">'+obj.attr('name')+'</span><span class="text-gray">'+obj.find('.text-gray').text()+'</span><i class="up-down-icon pull-right fa fa-chevron-down"></i></a><div class="box box-solid nav-sub-list"><ul class="nav nav-stacked"></ul></div></li>');
			}
		}
		else
		{
			var nav = $('<li class="nav-li" type="'+obj.attr('type')+'" rel="" ext_id="'+obj.attr('rel')+'" url="'+obj.attr('url')+'" name="'+obj.attr('name')+'"><a href="#"><div class="click-layout">&nbsp;</div><span class="name">'+obj.attr('name')+'</span><span class="text-gray">'+obj.find('.text-gray').text()+'</span><i class="up-down-icon pull-right fa fa-chevron-down"></i></a><div class="box box-solid nav-sub-list"><ul class="nav nav-stacked"></ul></div></li>');
		}
		
		nav.find('.click-layout').click(function(e){
			showEditBox($(this).parent().parent());
			return false;
		});
		
		$('#nav-list').find('.nav:eq(0)').append(nav);
	}
	
	function saveNavs()
	{
		var navs = getNavs($('#nav-list').find('ul').first().children('li'));
		
		newCallout('info',$('#info-title').text(),$('#saving-text').text());
		$.post(
			$('#save-navs-url').text(),
			{navs:navs,deleteNavIds:deleteNavIds},
			function(data){
				if (data.c == 0)
				{
					newCallout('success',$('#success-title').text(),data.msg);
					timerRefresh();
				}
				else
				{
					newAlert('danger',$('#danger-title').text(),data.msg);
				}
			},
			'json'
		);
	}
	
	function getNavs(liList)
	{
		var navs = [];
		liList.each(function(){
			var a = {
				'type':$(this).attr('type'),
				'rel':$(this).attr('rel'),
				'name':$(this).attr('name'),
				'ext_id':$(this).attr('ext_id'),
				'url':$(this).attr('url'),
				'sub':'',
			};
			if ($(this).find('ul').first().children('li').length > 0)
			{
				a.sub = getNavs($(this).find('ul').first().children('li'));
			}
			navs.push(a);
		});
		
		return navs;
	}
	
	function saveCustomerLink()
	{
		var id = $('#customer_link_form').find('.inputID');
		var inputName = $('#customer_link_form').find('.inputName');
		var inputUrl = $('#customer_link_form').find('.inputUrl');
		
		if (validateName(inputName) && validateUrl(inputUrl))
		{
			$.post(
					$('#save-customerlink-url').text(),
					{
						id:id.val(),
						name:inputName.val(),
						url:inputUrl.val()
					},
					function(data){
						if (data.c == 0)
						{
							window.location.reload();
						}
						else
						{
							newAlert('danger',$('#danger-title').text(),data.msg);
						}
					},
					'json'
				);
		}
	}
	
	function deleteCustomerLink()
	{
		var id = $('#customer_link_form').find('.inputID');
		
		if (id.val() == '')
		{
			return false;
		}
		else
		{
			$.post(
					$('#delete-customerlink-url').text(),
					{
						id:id.val()
					},
					function(data){
						if (data.c == 0)
						{
							window.location.reload();
						}
						else
						{
							newAlert('danger',$('#danger-title').text(),data.msg);
						}
					},
					'json'
				);
		}
	}
	
	function validateName(input)
	{
		input.parent().removeClass('has-error');
		input.parent().find('.help-block').remove();
		
		if (input.val() == '')
		{
			input.parent().addClass('has-error');
			input.after('<div class="help-block">'+$('#name-blank-error-lang').text()+'</div>');
			return false;
		}
		else
		{
			input.parent().removeClass('has-error');
			input.parent().addClass('has-success');
			input.parent().find('.help-block').remove();
			return true;
		}
	}
	
	function validateUrl(input)
	{
		input.parent().removeClass('has-error');
		input.parent().find('.help-block').remove();
		
		if (input.val() == '')
		{
			input.parent().addClass('has-error');
			input.after('<div class="help-block">'+$('#url-blank-error-lang').text()+'</div>');
			return false;
		}
		else if (isValidURL(input.val()) == false)
		{
			input.parent().addClass('has-error');
			input.after('<div class="help-block">'+$('#url-valid-error-lang').text()+'</div>');
			return false;
		}
		else
		{
			input.parent().removeClass('has-error');
			input.parent().addClass('has-success');
			input.parent().find('.help-block').remove();
			return true;
		}
	}
});