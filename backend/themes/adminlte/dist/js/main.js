var params = getUrlVars(); 
var sidesearch = decodeURI(params['sidesearch']);
if (sidesearch != '' && sidesearch != 'undefined')
{
	$('#sidebar-search-val').val(sidesearch);
}


$('#sidebar-search-val').bind('keyup', function (e) {
	e.preventDefault();
	sideBarSearch();
});

$('.form-nav-item.sel').click(function(){
	if (!$(this).hasClass('disabled'))
	{
		showTab($(this));
	}
});

function getUrlVars(){ 
	var vars = [], hash; 
	var hashes = window.location.href.slice(window.location.href.indexOf('?')+1).split('&'); 
	for(var i = 0; i < hashes.length; i++) { 
	hash = hashes[i].split('='); 
	vars.push(hash[0]); 
	vars[hash[0]] = hash[1]; 
	} 
	return vars; 
} 

function newAlert(type,title,text)
{
	var icon = '';
	var alertClass = '';
	
	switch (type)
	{
		case 'danger':
			icon = 'fa-ban';
			alertClass = 'alert-danger';
			break;
		case 'info':
			icon = 'fa-info';
			alertClass = 'alert-info';
			break;
		case 'warning':
			icon = 'fa-warning';
			alertClass = 'alert-warning';
			break;
		case 'success':
			icon = 'fa-check';
			alertClass = 'alert-success';
			break;
	}
	
	var str = '<div class="alert-box"><div class="alert '+alertClass+' alert-dismissible">';
	str += '<button type="button" class="close">×</button>';
	str += '<h4><i class="icon fa '+icon+'"></i> '+title+'</h4>';
	str += text;
	str += '</div></div>';
	
	var alert = $(str);
	alert.find('.close').click(function(){
		closeAlert();
	});
	
	$('#mask-layout').removeClass('hide');
	$('body').append(alert);
}

function newCallout(type,title,text)
{
	var callOutClass = '';
	
	switch (type)
	{
		case 'danger':
			callOutClass = 'callout-danger';
			break;
		case 'info':
			callOutClass = 'callout-info';
			break;
		case 'warning':
			callOutClass = 'callout-warning';
			break;
		case 'success':
			callOutClass = 'callout-success';
			break;
	}
	
	var str ='<div class="alert-box"><div class="callout '+callOutClass+'">';
    str += '<h4>'+title+'</h4>';
    str += '<p>'+text+'</p>';
    str += '</div></div>';
	
	var callOut = $(str);
	
	$('#mask-layout').removeClass('hide');
	$('body').append(callOut);
}

function closeAlert()
{
	$('#mask-layout').addClass('hide');
	$('.alert-box').remove();
}

function setSideBarActive(rel)
{
	$('.sidebar-menu').find('li').each(function(){
		if ($(this).attr('rel') == rel)
		{
			$(this).addClass('active');
		}
	});
}

function showBigImg(imgSrc)
{
	if (imgSrc!='')
	{
		$('body').append('<img id="tmpimg" src="'+imgSrc+'" />');
		var imgWidth = $('#tmpimg').width();
		var imgHeight = $('#tmpimg').height();
		$('#tmpimg').remove();

		var windowWidth = $(window).width();
		var maxWidth = windowWidth - 400;
		if (imgWidth >= maxWidth)
		{
			imgWidth = maxWidth;
		}

		var windowHeight = $(window).height();
		var maxHeight = windowHeight - 200;
		if (imgHeight >= maxHeight)
		{
			imgHeight = maxHeight;
		}
		
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  skin: 'layui-layer-nobg', //没有背景色
			  area: [imgWidth, imgHeight],
			  shadeClose: true,
			  scrollbar: true,
			  closeBtn: 1,
			  content: '<div style="width:'+imgWidth+'px;height:'+imgHeight+'px;overflow:auto;"><img src="'+imgSrc+'" /></div>'
			});
	}
}

function sideBarSearch()
{
	var keywords = $('#sidebar-search-val').val();
	if (keywords != '')
	{
		$('.side-search-item').each(function(){
			if ($(this).find('.treeview-menu').length > 0)
			{
				var showParent = false;
				$(this).find('.treeview-menu').find('li').each(function(){
					var name = $(this).find('a').find('span').text();
					if (name.indexOf(keywords) != -1)
					{
						showParent = true;
						$(this).removeClass('hide');
					}
					else
					{
						$(this).addClass('hide');
					}
				});
				if (showParent)
				{
					$(this).removeClass('hide');
				}
				else
				{
					$(this).addClass('hide');
				}
			}
			else
			{
				var name = $(this).find('a').find('span').text();
				if (name.indexOf(keywords) != -1)
				{
					$(this).removeClass('hide');
				}
				else
				{
					$(this).addClass('hide');
				}
			}
		});
	}
	else
	{
		$('.side-search-item').removeClass('hide');
		$('.treeview-menu').find('li').removeClass('hide');
	}
}

var timer;
var time;
function timerRefresh()
{
	var timeStr = $('.timer').text();
	if (timeStr != '' && timeStr != 'undefined')
	{
		time = parseInt(timeStr);
		timer = setInterval("minusTime()", 1000);
	}
}
function minusTime()
{
	if (time > 1)
	{
		time--;
		$('.timer').text(time);
	}
	else
	{
		window.clearInterval(timer);
		window.location.reload();
	}
}

function isValidURL(url){
    var urlRegExp=/^((https|http|ftp|rtsp|mms)?:\/\/)+[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
    if(urlRegExp.test(url)){
        return true;
    }else{
        return false;
    }
}

function showTab(obj)
{
	var rel = obj.attr('rel');
	$('.form-nav-item ').removeClass('active');
	obj.addClass('active');
	$('.form-tab').addClass('hide');
	$('.'+rel).removeClass('hide');
}

function switchChangeFunc(checkbox,url,state)
{
	var stateVal = state?1:0;
	checkbox.attr('disabled',true);
	$.post(
		url,
		{state:stateVal},
		function(data) {
			if (data.c == 0)
			{
				if (state == true)
                {
                	$('.gridview-box').find('.mask-layout').addClass('hide');
               		$('.create-btn').removeAttr('disabled');
               	}
               	else
               	{
               		$('.gridview-box').find('.mask-layout').removeClass('hide');
                	$('.create-btn').attr('disabled',true);
               	}
				checkbox.removeAttr('disabled');
			}
			else
			{
				newAlert('danger',$('#danger-title').text(),data.msg);
			}
		},
		'json'
	);
}


$('.index-config li').next().hide();
$('.index-config li:eq(0)').next().show();
$('.index-config li').on('click',function(){
	$('.index-config li').removeClass('ht_choice_on');
	$(this).addClass('ht_choice_on');
	$('.index-config li').next().hide();	
	$(this).next().toggle();
	
});
$('.index-config li:eq(0)').addClass('ht_choice_on');


$('.info-block').eq($('.info-block').length-1).css('border-bottom','none');



function setHomeConfig(obj,url){
		$.post(
	            url,
	            {
	            	feature:obj.getAttribute('rel'),
	            	config_id:obj.getAttribute('config'),
	                value:obj.value,
	                type:'post',
	            },
	            function (data){
	                console.log(data);
	            	/*if(data.c==0){
						window.location.href="<?php echo Url::toRoute(['site/index','sname'=>$_SESSION['serial_id']])?>"
	                	}*/
	            },
	            'json'
	   	);
	
}
