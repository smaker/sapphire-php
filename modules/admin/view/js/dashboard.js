$(function() {
	$('.flushCache').click(function() {
		ST.ajax('admin/flushCache.do', {
			method : 'GET',
			dataType : 'json',
			complete: function(res) {
				var data = res.responseJSON;
				alert(data.message);
			}
		});
		return false;
	});
});