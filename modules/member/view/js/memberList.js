$(function() {
	$('#deleteMembers').click(function() {
		var memberIds = [];

		$('#memberList input[name=cart]:checked').each(function() {
			memberIds.push($(this).val());
		});

		if(memberIds.length < 1) {
			alert('삭제할 회원을 선택해 주세요.');
			return false;
		}
		$('.ui.modal.deleteConfirm').modal({
			closable  : false,
			onDeny    : function(){
				return false;
			},
			onApprove : function() {
				var $loading = $('<div class="ui text loader">삭제중입니다...</div>');
				$('#body').dimmer('toggle').dimmer('set variation', 'inverted').dimmer('add content', $loading);
				
				ST.ajax('admin/member/deleteMember.do', {
					method: 'POST',
					data: { memberId : memberIds },
					dataType: 'json',
				}).done(function(response) {
					if(!response.success) {
						alert(response.message);
					}

					$('#body').dimmer('toggle');

					for(var i = 0, c= memberIds.length; i < c; i++) {
						$('#member_' + memberIds[i]).fadeOut(300, function(){
							$(this).remove();
						});
					}
				});
			}
  		}).modal('show');
		
		
		return false;


		


	});	
});
