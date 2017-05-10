$(function () {
	var viewer = new Viewer(document.getElementById('images'));
	
	$('.delete').click(function(){
		var id = $(this).attr('rel');
		var parent = $(this).parent();
		$.post(
				$('#delete-pic-url').text(),
				{id:id},
				function(data){
					if (data.c == 0)
					{
						parent.remove();
					}
					else
					{
						newAlert('danger',$('#danger-title').text(),data.msg);
					}
				},
				'json'
			);
	});
	
	$('.showbig').click(function(e){
		e.stopPropagation();
		$(this).parent().find('img').trigger('click');
	});
});