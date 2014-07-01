var loading_count = 0;
var running = false;
var defaultTab = 'explorer';
var currentTab = $('#'+defaultTab);
var tabScroll = new Object;
var onDrag = false;
var onScroll = false;
var scrollDelta = 1;
var scrollCounter = 0;
var scrollSpeed = 60;
var scrollTimer = '';
var dragX = '';
var dragY = '';
var dragDeltaX = '';
var dragDeltaY = '';
var editSuccess = '';
var terminalHistory = new Array();
var terminalHistoryPos = 0;
var evalSupported = "";
var evalReady = false;
var resizeTimer = '';
var portableWidth = 700;
var portableMode = null;

Zepto(function($){
	if(init_shell){
		var now = new Date();
		output("started @ "+ now.toGMTString());
		output("cwd : "+get_cwd());
		output("module : "+module_to_load);

		show_tab();
		xpl_bind();
		eval_init();
		
		window_resize();
		
		xpl_update_status();
		
		$(window).on('resize', function(e){
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout("window_resize()", 1000);
		});

		$('.menuitem').on('click', function(e){
			selectedTab = $(this).attr('href').substr(2);
			show_tab(selectedTab);
		});

		$('#logout').on('click', function(e){
			var cookie = document.cookie.split(';');
			for(var i=0; i<cookie.length; i++){
				var entries = cookie[i], entry = entries.split("="), name = entry[0];
				document.cookie = name + "=''; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
			}
			localStorage.clear();
			location.href = targeturl;
		});

		$('#totop').on('click', function(e){
			$(window).scrollTop(0);
		});
		$('#totop').on('mouseover', function(e){
			onScroll = true;
			clearTimeout(scrollTimer);
			start_scroll('top');
		});
		$('#totop').on('mouseout', function(e){
			onScroll = false;
			scrollCounter = 0;
		});
		$('#tobottom').on('click', function(e){
			$(window).scrollTop($(document).height()-$(window).height());
		});
		$('#tobottom').on('mouseover', function(e){
			onScroll = true;
			clearTimeout(scrollTimer);
			start_scroll('bottom');
		});
		$('#tobottom').on('mouseout', function(e){
			onScroll = false;
			scrollCounter = 0;
		});
		$('#basicInfo').on('mouseenter', function(e){
			$('#toggleBasicInfo').show();
		});
		$('#basicInfo').on('mouseleave', function(e){
			$('#toggleBasicInfo').hide();
		});
		$('#toggleBasicInfo').on('click', function(e){
			$('#basicInfo').hide();
			$('#showinfo').show();
			$('#toggleBasicInfo').hide();
			localStorage.setItem('infoBarShown', 'hidden');
		});
		$('#showinfo').on('click', function(e){
			$('#basicInfo').show();
			$('#showinfo').hide();
			localStorage.setItem('infoBarShown', 'shown');
		});
		
		if((infoBarShown = localStorage.getItem('infoBarShown'))){
			if(infoBarShown=='shown'){
				$('#basicInfo').show();
				$('#showinfo').hide();
			}
			else{
				$('#basicInfo').hide();
				$('#showinfo').show();
				$('#toggleBasicInfo').hide();
			}
		}
		else{
			info_refresh();
		}

		if(history.pushState){
			window.onpopstate = function(event) { refresh_tab(); };
		}
		else{
			window.historyEvent = function(event) {	refresh_tab(); };
		}
	}
});

function output(str){
	console.log('b374k> '+str);
}

function window_resize(){
	bodyWidth = $('body').width();
	if(bodyWidth<=portableWidth){
		layout_portable();
	}
	else{
		layout_normal();
	}
}

function layout_portable(){
	nav = $('#nav');
	menu = $('#menu');
	headerNav = $('#headerNav');
	content = $('#content');

	//nav.hide();
	nav.prependTo('#content');
	nav.css('padding','5px 8px');
	nav.css('margin-top', '8px');
	nav.css('display','block');
	nav.addClass('border');
	
	menu.children().css('width', '100%');
	menu.hide();
	$('#menuButton').remove();	
	headerNav.prepend("<div id='menuButton' class='boxtitle' onclick=\"$('#menu').toggle();\" style='float-left;display:inline;padding:4px 8px;margin-right:8px;'>menu</div>");
	menu.attr('onclick', "\$('#menu').hide();");
	
	$('#xplTable tr>:nth-child(4)').hide();
	$('#xplTable tr>:nth-child(5)').hide();
	if(!win){
		$('#xplTable tr>:nth-child(6)').hide();
	}
	
	tblfoot = $('#xplTable tfoot td:last-child');
	if(tblfoot[0]) tblfoot[0].colSpan = 1;
	if(tblfoot[1]) tblfoot[1].colSpan = 2;
	
	
	$('.box').css('width', '100%');
	$('.box').css('height', '100%');
	$('.box').css('left', '0px');
	$('.box').css('top', '0px');
		
	paddingTop = $('#header').height();
	content.css('padding-top', paddingTop+'px');
	
	portableMode = true;
}

function layout_normal(){	
	nav = $('#nav');
	menu = $('#menu');	
	content = $('#content');

	nav.insertAfter('#b374k');
	nav.css('padding','0');
	nav.css('margin-top', '0');
	nav.css('display','inline');
	nav.removeClass('border');
	
	menu.children().css('width', 'auto');
	menu.show();
	$('#menuButton').remove();
	menu.attr('onclick', "");
	
	$('#xplTable tr>:nth-child(4)').show();
	$('#xplTable tr>:nth-child(5)').show();
	if(!win){
		$('#xplTable tr>:nth-child(6)').show();
		colspan = 4;
	}
	else colspan = 3;
	
	tblfoot = $('#xplTable tfoot td:last-child');
	if(tblfoot[0]) tblfoot[0].colSpan = colspan;
	if(tblfoot[1]) tblfoot[1].colSpan = colspan+1;

	paddingTop = $('#header').height();
	content.css('padding-top', paddingTop+'px');
	
	portableMode = false;
}

function start_scroll(str){
	if(str=='top'){
		to = $(window).scrollTop() - scrollCounter;
		scrollCounter = scrollDelta + scrollCounter;
		if(to<=0){
			to = 0;
			onScroll = false;
		}
		else if(onScroll){
			scrollTimer = setTimeout("start_scroll('top')", scrollSpeed);
			$(window).scrollTop(to);
		}
	}
	else if(str=='bottom'){
		to = $(window).scrollTop() + scrollCounter;
		scrollCounter = scrollDelta + scrollCounter;
		bottom = $(document).height()-$(window).height();
		if(to>=bottom){
			to = bottom;
			onScroll = false;
		}
		else if(onScroll){
			scrollTimer = setTimeout("start_scroll('bottom')", scrollSpeed);
			$(window).scrollTop(to);
		}
	}
}

function get_cwd(){
	return decodeURIComponent(get_cookie('cwd'));
}

function fix_tabchar(el, e){
	if(e.keyCode==9){
		e.preventDefault();
		var s = el.selectionStart;
		el.value = el.value.substring(0,el.selectionStart) + "\t" + el.value.substring(el.selectionEnd);
		el.selectionEnd = s+1;
	}
}

function get_cookie(key){
	var res;
	return (res = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? (res[1]) : null;
}

function set_cookie(key, value){
	document.cookie = key + '=' + encodeURIComponent(value);
}

function html_safe(str){
	if(typeof(str) == "string"){
		str = str.replace(/&/g, "&amp;");
		str = str.replace(/"/g, "&quot;");
		str = str.replace(/'/g, "&#039;");
		str = str.replace(/</g, "&lt;");
		str = str.replace(/>/g, "&gt;");
	}
	return str;
}

function ucfirst(str){
	return str.charAt(0).toUpperCase() + str.slice(1);
}

function time(){
	var d = new Date();
	return d.getTime();
}

function send_post(targetdata, callback, loading){
	if(loading==null) loading_start();
	$.ajax({
		url: targeturl,
		type: 'POST',
		data: targetdata,
		success: function(res){
			callback(res);
			if(loading==null) loading_stop();
		},
		error: function(){ if(loading==null) loading_stop(); }
	});
}

function loading_start(){
	if(!running){
		$('#overlay').show();
		running = true;
		loading_loop();
	}
}

function loading_loop(){
	if(running){
		img = $('#loading');
		img.css('transform', 'rotate('+loading_count+'deg)');
		img.css('-ms-transform', 'rotate('+loading_count+'deg)');
		img.css('-webkit-transform', 'rotate('+loading_count+'deg)');

		loading_count+=7;
		if(loading_count>360) loading_count = 0;
		if(running) setTimeout("loading_loop()",20);
	}
}

function loading_stop(){
	if(running){
		img = $('#loading');
		img.css('transform', 'rotate(0deg)');
		img.css('-ms-transform', 'rotate(0deg)');
		img.css('-webkit-transform', 'rotate(0deg)');

		$('#overlay').hide();
		running = false;
	}
}

function show_tab(id){
	if(!id){
		if(location.hash!='') id = location.hash.substr(2);
		else id = defaultTab;
	}
	refresh_tab(id);
}

function refresh_tab(id){
	if(!id){
		if(location.hash!='') id = location.hash.substr(2);
		else id = defaultTab;
	}
	$('.menuitemSelected').removeClass("menuitemSelected");
	$('#menu'+id).addClass("menuitemSelected");

	tabScroll[currentTab.attr('id')] = $(window).scrollTop();
	currentTab.hide();
	currentTab = $('#'+id);
	currentTab.show();
	window[id]();
	if(tabScroll[id]){
		$(window).scrollTop(tabScroll[id]);
	}
	hide_box();
}

function trap_enter(e, callback){
	if(e.keyCode==13){
		if(callback!=null) window[callback]();
	}
}

function show_box(title, content){
	onDrag = false;
	hide_box();
	box = "<div class='box'><p class='boxtitle'>"+title+"<span class='boxclose floatRight'>x</span></p><div class='boxcontent'>"+content+"</div><div class='boxresult'></div></div>";
	$('#content').append(box);

	box_width = $('.box').width();
	body_width = $('body').width();

	box_height = $('.box').height();
	body_height = $('body').height();

	x = (body_width - box_width)/2;
	y = (body_height - box_height)/2;
	if(x<0 || portableMode) x = 0;
	if(y<0 || portableMode) y = 0;
	if(portableMode){
		$('.box').css('width', '100%');
		$('.box').css('height', '100%');	
	}

	$('.box').css('left', x+'px');
	$('.box').css('top', y+'px');

	$('.boxclose').on('click', function(e){
		hide_box();
	});
	
	if(!portableMode){
		$('.boxtitle').on('click', function(e){
			if(!onDrag){
				dragDeltaX = e.pageX - parseInt($('.box').css('left'));
				dragDeltaY = e.pageY - parseInt($('.box').css('top'));
				drag_start();
			}
			else drag_stop();
		});
	}

	$(document).off('keyup');
	$(document).on('keyup', function(e){
		if(e.keyCode == 27) hide_box();
	});

	if($('.box input')[0]) $('.box input')[0].focus();
}

function hide_box(){
	$(document).off('keyup');
	$('.box').remove();
}

function drag_start(){
	if(!onDrag){
		onDrag = true;
		$('body').off('mousemove');
		$('body').on('mousemove', function(e){
			dragX = e.pageX;
			dragY = e.pageY;
		});
		setTimeout('drag_loop()',50);
	}
}

function drag_loop(){
	if(onDrag){
		x = dragX - dragDeltaX;
		y = dragY - dragDeltaY;
		if(y<0)y=0;
		$('.box').css('left', x+'px');
		$('.box').css('top', y+'px');
		setTimeout('drag_loop()',50);
	}
}

function drag_stop(){
	onDrag = false;
	$('body').off('mousemove');
}

function get_all_cbox_selected(id, callback){
	var buffer = new Array();
	$('#'+id).find('.cBoxSelected').not('.cBoxAll').each(function(i){
		if((href = window[callback]($(this)))){
			buffer[i] = href;
		}
	});
	return buffer;
}


function cbox_bind(id, callback){
	$('#'+id).find('.cBox').off('click');
	$('#'+id).find('.cBoxAll').off('click');

	$('#'+id).find('.cBox').on('click', function(e){
		if($(this).hasClass('cBoxSelected')){
			$(this).removeClass('cBoxSelected');
		}
		else $(this).addClass('cBoxSelected');
		if(callback!=null) window[callback]();
	});
	$('#'+id).find('.cBoxAll').on('click', function(e){
		if($(this).hasClass('cBoxSelected')){
			$('#'+id).find('.cBox').removeClass('cBoxSelected');
			$('#'+id).find('.cBoxAll').removeClass('cBoxSelected');
		}
		else{
			$('#'+id).find('.cBox').not('.cBoxException').addClass('cBoxSelected');
			$('#'+id).find('.cBoxAll').not('.cBoxException').addClass('cBoxSelected');
		}
		if(callback!=null) window[callback]();
	});
}