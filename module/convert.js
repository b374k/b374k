Zepto(function($){
	$('#decodeStr').on('keydown', function(e){
		if(e.ctrlKey && (e.keyCode == 10 || e.keyCode == 13)){
			decode_go();
		}
		fix_tabchar(this, e);
	});
});

function decode_go(){
	decodeStr = $('#decodeStr').val();
	send_post({decodeStr:decodeStr}, function(res){
		if(res!='error'){
			$('#decodeResult').html('');
			$('#decodeResult').html(res);
		}
	});
}
