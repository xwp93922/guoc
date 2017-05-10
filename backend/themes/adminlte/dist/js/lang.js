$(function () {
	$('.sel-lang-item').click(function(){
		setDefaultLang($(this).attr('url'),$(this).attr('cms_lang_id'));
	});
	
	$('.set-check').click(function(e){
		if($(this).hasClass('btn-success'))
		{
			$(this).removeClass('btn-success');
			$(this).addClass('btn-default');
			$(this).text($('#unused-lang').text());
		}
		else
		{
			$(this).addClass('btn-success');
			$(this).removeClass('btn-default');
			$(this).text($('#used-lang').text());
		}
	});
	$('.fa-arrow-up').click(function(e){
		var item = $(this).parent().parent();
		var prev = item.prev();
		if (prev.length > 0)
		{
			prev.before(item);
		}
	});
	$('.fa-arrow-down').click(function(e){
		var item = $(this).parent().parent();
		var next = item.next();
		if (next.length > 0)
		{
			next.after(item);
		}
	});
	
	$('.fa-edit').click(function(){
		var lang = $(this).parent().parent();
		var lang_id = lang.attr('lang_id');
		var name = lang.attr('name');
		var flag = $('#web-url').text() + lang.attr('flag');
		var cms_lang_id = lang.attr('cms_lang_id');
		
		$('.inputID').val(cms_lang_id);
		$('.inputName').val(name);
		$('.set-lang-box').removeClass('hide');
		$('.inputFlag').removeClass('hide').attr('src',flag);
	});
	
	$('#save-langlist-btn').click(function(){
		var itemList = [];
		$('.lang-item').each(function(){
			if ($(this).find('.set-check').hasClass('btn-success'))
			{
				itemList.push({
					cms_lang_id:$(this).attr('cms_lang_id'),
					lang_id:$(this).attr('lang_id'),
					name:$(this).attr('name'),
					flag:$(this).attr('flag'),
				});
			}
		});
		if (itemList.length == 0)
		{
			newAlert('danger',$('#danger-title').text(),$('#save-lang-error3').text());
			return false;
		}
		
		newCallout('info',$('#info-title').text(),$('#saving-text').text());
		$.post(
			$('#save-langlist-url').text(),
			{itemList:itemList},
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
	});
	
	$('#save-cmslang-btn').click(function(){
		if ($('.inputID').val() == '' || $('.inputID').val() == 'undefined')
		{
			newAlert('danger',$('#danger-title').text(),$('#save-lang-error1').text());
			return false;
		}
		if ($('.inputName').val() == '' || $('.inputName').val() == 'undefined')
		{
			newAlert('danger',$('#danger-title').text(),$('#save-lang-error2').text());
			return false;
		}
		$.post(
				$('#save-langitem-url').text(),
				{
					id:$('.inputID').val(),
					name:$('.inputName').val(),
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
	});
	
	function setDefaultLang(url,id)
	{
		$.post(
				url,
				{id:id},
				function(data){
					if (data.c == 0)
					{
						window.location.href = data.rturl;
					}
					else
					{
						newAlert('danger',$('#danger-title').text(),data.msg);
					}
				},
				'json'
			);
	}
});