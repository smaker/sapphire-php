$(function(){
  $('#memberJoin').submit(function() {
    var form = $(this);

    var agree = form.find('input[name=agree]');
    if(!agree.is(':checked')) {
      alert('이용약관에 동의하셔야 합니다.');
      agree.focus();
      return false;
    }
    var userId = form.find('input[name=userId]');
    if(!userId.val()) {
      alert('아이디를 입력해주세요.');
      userId.focus();
      return false;
    }

    var password = form.find('input[name=password]');
    if(!password.val()) {
      alert('비밀번호를 입력해주세요.');
      password.focus();
      return false;
    }

    var password2 = form.find('input[name=password2]');
    if(!password2.val()) {
      alert('비밀번호 확인을 입력해주세요.');
      password2.focus();
      return false;
    }

    if(password.val() != password2.val())
    {
      alert('입력하신 비밀번호가 서로 다릅니다. 다시 확인해주세요.');
      password2.focus();
      return false;
    }

    var userName = form.find('input[name=userName]');
    if(!userName.val())
    {
      alert('이름을 입력해주세요.');
      userName.focus();
      return false;
    }

    // 닉네임
    var nickName = form.find('input[name=nickName]');
    if(!nickName.val())
    {
      alert('닉네임을 입력해주세요.');
      nickName.focus();
      return false;
    }

    var emailAddress = form.find('input[name=emailAddress]');
    if(!emailAddress.val()) {
      alert('이메일 주소를 입력해주세요.');
      emailAddress.focus();
      return false;
    }
  });
});