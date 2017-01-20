function show(target){target.style.display="";return true;}
function showBlock(target){target.style.display="block";return true;}
function hide(target){target.style.display="none";return true;}
function getNodeClass(obj){var result=false;if(obj.getAttributeNode("class")){result=obj.attributes.getNamedItem("class").value;}return result;}
function createCookie(name,value,days){
    if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toGMTString();}
    else expires="";var domainName="";if(DOMAIN_PATH!=""){domainName="domain="+DOMAIN_PATH;}
    document.cookie=name+"="+value+expires+"; path="+SITE_PATH+"; "+domainName;
}
function readCookie(name){
    var nameEQ=name+"=";
    var ca=document.cookie.split(';');
    for(var i=0;i<ca.length;i++){
        var c=ca[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);
        if(c.indexOf(nameEQ)==0)return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function expandCollapse(){
    for(var i=0;i<expandCollapse.arguments.length;i++){
        var element=document.getElementById(expandCollapse.arguments[i]);element.style.display=(element.style.display=="none")?"block":"none";
    }
}
var timerID;
function ShowLayer(id){document.getElementById().style.display="block";}
function HideTimedLayer(id){clearTimeout(timerID);document.getElementById(id).style.display="none";}
function timedLayer(id){setTimeout("HideTimedLayer(\""+id+"\")",5000);}
function popup_ask(mess){
	return confirm(mess);
}
function selectedText(input){
    var startPos = input.selectionStart;
    var endPos = input.selectionEnd;
    var doc = document.selection;
    if(doc && doc.createRange().text.length != 0){
        return doc.createRange().text;
    }else if (!doc && input.value.substring(startPos,endPos).length != 0){
        return input.value.substring(startPos,endPos);
    }
}
function insertAtCursor(myField, myValue) {
  //IE support
  if (document.selection) {
    myField.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
  }
  //MOZILLA/NETSCAPE support
  else if (myField.selectionStart || myField.selectionStart == '0') {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    myField.value = myField.value.substring(0, startPos)
                  + myValue 
                  + myField.value.substring(endPos, myField.value.length);
  } else {
    myField.value += myValue;
  }
}

