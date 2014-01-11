Zepto(function($){
	info_init();

});

function info_init(){
	if((infoResult = localStorage.getItem('infoResult'))){
		$('.infoResult').html(infoResult);
	}
	else{
		info_refresh();
	}
}

function info_toggle(id){
	$('#'+id).toggle();
}

function info_refresh(){
	send_post({infoRefresh:'infoRefresh'}, function(res){
		$('.infoResult').html(res);
		localStorage.setItem('infoResult', res);
	});
}