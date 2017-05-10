$(function () {
	var viewer = new Viewer(document.getElementById('images'));
	
	$('.showbig').click(function(e){
		e.stopPropagation();
		$(this).parent().find('img').trigger('click');
	});
});