Zepto(function($){
	show_processes();
});

function show_processes(){
	send_post({showProcesses:''}, function(res){
		if(res!='error'){
			$('#processes').html(res);
			sorttable.k($('#psTable').get(0));
			ps_bind();
		}
	});
}

function ps_bind(){
	$('.kill').off('click');
	$('.kill').on('click', function(e){
		kill_pid(ps_get_pid($(this)));
	});


	cbox_bind('psTable','ps_update_status');
}

function ps_get_pid(el){
	return el.parent().parent().attr('data-pid');
}

function ps_update_status(){
	totalSelected = $('#psTable').find('.cBoxSelected').not('.cBoxAll').length;
	if(totalSelected==0) $('.psSelected').html('');
	else $('.psSelected').html(' ( '+totalSelected+' item(s) selected )');
}

function kill_selected(){
	buffer = get_all_cbox_selected('psTable', 'ps_get_pid');

	allPid = '';
	$.each(buffer,function(i,v){
		allPid += v + ' ';
	});
	allPid = $.trim(allPid);
	kill_pid(allPid);
}

function kill_pid(allPid){
	title = 'Kill';
	content = "<table class='boxtbl'><tr><td colspan='2'><textarea class='allPid' style='height:120px;min-height:120px;' disabled>"+allPid+"</textarea></td></tr><tr><td colspan='2'><span class='button' onclick=\"kill_pid_go();\">kill</span></td></tr></table>";
	show_box(title, content);
}

function kill_pid_go(){
	allPid = $('.allPid').val();
	if($.trim(allPid)!=''){
		send_post({allPid:allPid}, function(res){
			if(res!='error'){
				$('.boxresult').html(res + ' process(es) killed');
			}
			else $('.boxresult').html('Unable to kill process(es)');
			show_processes();
		});
	}
}