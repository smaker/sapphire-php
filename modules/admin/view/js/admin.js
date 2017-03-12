$(function() {
	$('.ui.sidebar').sidebar({
		context : $('.bottom.segment'),
		dimPage : false,
		closable : false,
		onVisible : function() {
			Cookies.set('ST_ADMIN_OPEN', 'Y');
		},
		onHide : function() {
			Cookies.set('ST_ADMIN_OPEN', 'N');
		}
	}).sidebar('attach events', '#sidebarToggler');
	
	$('#language').dropdown();

	$('.ui .form .dropdown').dropdown();
	$('.ui-popup').popup();
	
	$('.ui.sidebar .item.hasChild > a').click(function(){
		$(this).parent().toggleClass('open');
		return false;
	});
});