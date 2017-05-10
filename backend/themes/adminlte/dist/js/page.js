$(function () {
	var originHeight = 38;
	var heightAdd = 100;
	$(".timeline-content").focus(function(){
		$(this).parent().prev().find('.column-line').css('height',heightAdd+"px");
		$(this).animate({height:originHeight+heightAdd+"px"});
	});
	$(".timeline-content").blur(function(){
		$(this).parent().prev().find('.column-line').css('height',originHeight+"px");
		$(this).animate({height:originHeight+"px"});
	});
	
	$('.save-timeline').click(function(){
		var parent = $(this).parent();
		var id = $(this).attr('timeline_id');
		var about_id = $('#about_id').text();
		var content = parent.find('.timeline-content').val();
		var date = parent.find('.timeline-date').val();
		
		saveTimeline(id,about_id,content,date);
	});
	
	$('.delete-timeline').click(function(){
		if (confirm($('#delete-confirm-text').text()))
		{
			var id = $(this).attr('timeline_id');
			var that = $(this);
			$.post(
					$('#delete-timeline-url').text(),
					{
						id:id,
					},
					function(data){
						if (data.c == 0)
						{
							that.parent().remove();
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
	
	function saveTimeline(id,about_id,content,date)
	{
		if (content == '')
		{
			newAlert('danger',$('#danger-title').text(),$('#new-timeline-error1').text());
			return false;
		}
		if (date == '')
		{
			newAlert('danger',$('#danger-title').text(),$('#new-timeline-error2').text());
			return false;
		}
		$.post(
				$('#save-timeline-url').text(),
				{
					id:id,
					about_id:about_id,
					content:content,
					date:date
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
});