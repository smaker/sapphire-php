/**
 * SensitiveCMS에서 사용되는 전역 변수
 */
window.ST = {
	ajax : function(url, setting) {
		return $.ajax(this.defaultUrl + url, setting);
	}
};
