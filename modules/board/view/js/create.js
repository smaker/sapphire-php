$(function(){
	$(document).on('change keypress', '#instanceId', function(e){
		if(e.type == 'change')
		{
			/**
			 * @todo AJAX로 해당 id를 사용중인 지 확인
			 */
		}

		$('#boardID_live').text($(this).val());
	});
});