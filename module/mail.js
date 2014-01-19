Zepto(function($){

});

function mail_send(){
	mailFrom = $.trim($('#mailFrom').val());
	mailTo = $.trim($('#mailTo').val());
	mailSubject = $.trim($('#mailSubject').val());
	mailContent = $('#mailContent').val();
	mailAttachment = '';
	if($('.mailAttachment')){
		mailAttachment = $('.mailAttachment').map(function(){ return this.value; }).get().join('{[|b374k|]}');
	}

	send_post({mailFrom:mailFrom, mailTo:mailTo, mailSubject:mailSubject, mailContent:mailContent, mailAttachment:mailAttachment}, function(res){
		$('#mailResult').html(res);
	});
}

function mail_attach(){
	content = "<tr><td>Local file <a onclick=\"$(this).parent().parent().remove();\">(-)</a></td><td colspan='2'><input type='text' class='mailAttachment' value=''></td></tr>";
	$('#mailTBody').append(content);
}