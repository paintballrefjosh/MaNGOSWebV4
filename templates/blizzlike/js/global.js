var uagent    = navigator.userAgent.toLowerCase();
var is_safari = ( (uagent.indexOf('safari') != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var is_opera  = (uagent.indexOf('opera') != -1);
var is_webtv  = (uagent.indexOf('webtv') != -1);
var is_ie     = ( (uagent.indexOf('msie') != -1) && (!is_opera) && (!is_safari) && (!is_webtv) );
var is_ie4    = ( (is_ie) && (uagent.indexOf("msie 4.") != -1) );
var is_moz    = ( (navigator.product == 'Gecko')  && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns     = ( (uagent.indexOf('compatible') == -1) && (uagent.indexOf('mozilla') != -1) && (!is_opera) && (!is_webtv) && (!is_safari) );
var is_ns4    = ( (is_ns) && (parseInt(navigator.appVersion) == 4) );
var is_kon    = (uagent.indexOf('konqueror') != -1);

var is_win    =  ( (uagent.indexOf("win") != -1) || (uagent.indexOf("16bit") !=- 1) );
var is_mac    = ( (uagent.indexOf("mac") != -1) || (navigator.vendor == "Apple Computer, Inc.") );
var ua_vers   = parseInt(navigator.appVersion);

// IE bug fix
var ie_range_cache = '';
var imgres;

function myshow(el)
{
	obj = document.getElementById(el);
	obj.style.visibility='visible';
	obj.style.display = '';
}
function myhide(el)
{
	obj = document.getElementById(el);
	obj.style.visibility='hidden';
	obj.style.display = 'none';
	
}
function myhide_timed(el){
    setTimeout("myhide(\""+el+"\")",1000)
}
function mytoggleview(el)
{
	obj = document.getElementById(el);
	if (obj.style.visibility == 'hidden')
	{
		obj.style.visibility = 'visible';
		obj.style.display = '';
	}
	else
	{
		obj.style.visibility = 'hidden';
		obj.style.display = 'none';
	}
}

function popup_ask(mess){
	return confirm(mess);
}
function clear_innerHTML(el)
{
	document.getElementById(el).innerHTML = '';
}
function addlink(el)
{
	url = prompt('Insert link:', 'http://');
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		sel = document.selection;
		rng = ie_range_cache ? ie_range_cache : sel.createRange();
		rng.colapse;
		if(rng.text.length < 1){
		name = prompt('Enter link name:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}else{
		if(document.getElementById(el).selectionEnd-document.getElementById(el).selectionStart<1){
		name = prompt('Insert link name:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}
	if(url){
	wrap_tags('[url='+url+']'+name+'','[/url]',el);
	}
}
function addemail(el)
{
	url = prompt('Insert email', '');
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		sel = document.selection;
		rng = ie_range_cache ? ie_range_cache : sel.createRange();
		rng.colapse;
		if(rng.text.length < 1){
		name = prompt('Insert addressee:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}else{
		if(document.getElementById(el).selectionEnd-document.getElementById(el).selectionStart<1){
		name = prompt('Insert addressee:', '');
		  if(!name){name = url;}
		}else{
		name = '';
		}
	}
	if(url){
	wrap_tags('[url=mailto:'+url+']'+name+'','[/url]',el);
	}
}
function addimage(el)
{
	url = prompt('Insert image url:', 'http://');
	wrap_tags('[img]'+url,'[/img]',el);
}

function wrap_tags(opentext, closetext, tofield, issingle)
{
	postfieldobj = document.getElementById(tofield);
	var has_closed = false;
	
	if ( ! issingle )
	{
		issingle = false;
	}
	
	//----------------------------------------
	// It's IE!
	//----------------------------------------
	
	if ( (ua_vers >= 4) && is_ie && is_win )
	{
		if ( postfieldobj.isTextEdit )
		{
			//postfieldobj.focus();
			
			var sel = document.selection;
			
			var rng = ie_range_cache ? ie_range_cache : sel.createRange();
			rng.colapse;
			
			if ( (sel.type == "Text" || sel.type == "None") && rng != null && rng.text )
			{
				if (closetext != "" && rng.text.length > 0)
				{ 
					opentext += rng.text + closetext;
				}
				else if ( issingle )
				{
					has_closed = true;
				}
				rng.text = opentext;
			}
			else
			{
				postfieldobj.value += opentext + closetext;
				has_closed = true;
			}
		}
		else
		{
			postfieldobj.value += opentext + closetext;
			has_closed = true;
		}

		ie_range_cache = null;
		rng.select();

	}
	
	//----------------------------------------
	// It's MOZZY!
	//----------------------------------------
	
	else if ( postfieldobj.selectionEnd )
	{
		var ss = postfieldobj.selectionStart;
		var st = postfieldobj.scrollTop;
		var es = postfieldobj.selectionEnd;
		
		if (es <= 0)
		{
			es = postfieldobj.textLength;
		}
		
		var start  = (postfieldobj.value).substring(0, ss);
		var middle = (postfieldobj.value).substring(ss, es);
		var end    = (postfieldobj.value).substring(es, postfieldobj.textLength);
		
		//-----------------------------------
		// text range?
		//-----------------------------------
		
		if ( postfieldobj.selectionEnd - postfieldobj.selectionStart > 0 )
		{
			middle = opentext + middle + closetext;
		}
		else
		{
			middle = ' ' + opentext + middle + closetext + ' ';
			
			if ( issingle )
			{
				has_closed = true;
			}
		}
		
		postfieldobj.value = start + middle + end;
		
		var cpos = ss + (middle.length);
		
		postfieldobj.selectionStart = cpos;
		postfieldobj.selectionEnd   = cpos;
		postfieldobj.scrollTop      = st;
	}
	
	//----------------------------------------
	// It's CRAPPY!
	//----------------------------------------
	
	else
	{ 
		if ( issingle )
		{
			has_closed = false;
		}
			
		postfieldobj.value += opentext + ' ' + closetext;
	}
	
	postfieldobj.focus();

	return has_closed;
}

function setColor(color,tofield)
{
	var parentCommand = parent.command;
	
	if ( parentCommand == "hilitecolor" )
	{
		if ( wrap_tags("[background=" +color+ "]", "[/background]", 'textarea', true ) )
		{
			//toggle_button( "background" );
			//pushstack(bbtags, "background");
		}
	}
	else
	{
		if ( wrap_tags("[color=" +color+ "]", "[/color]", tofield, true ) )
		{
			//toggle_button( "color" );
			//pushstack(bbtags, "color");
		}
	}

	document.getElementById('cp').style.visibility = "hidden";
	document.getElementById('cp').style.display    = "none";
}