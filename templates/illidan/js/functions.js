
function hideMenu(menuNum){
  document.getElementById("menuContainer"+menuNum).style.display="none";
}
function showMenu(menuNum){
  document.getElementById("menuContainer"+menuNum).style.display="block";

}
    function newsCollapse(newsPost) {
    var obj;
    obj = document.getElementById(newsPost);
    if (obj.style.display != "block")
        obj.style.display = "block";
    else
        obj.style.display = "none";
    }

function getexpirydate(nodays){
  var UTCstring;
  Today = new Date();
  nomilli=Date.parse(Today);
  Today.setTime(nomilli+nodays*24*60*60*1000);
  UTCstring = Today.toUTCString();
  return UTCstring;
}

function getcookie(cookiename) {
   var cookiestring=""+document.cookie;
   var index1=cookiestring.indexOf(cookiename);
   if (index1==-1 || cookiename=="") return ""; 
   var index2=cookiestring.indexOf(';',index1);
   if (index2==-1) index2=cookiestring.length; 
   return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}
function setcookie(name,value){
  cookiestring=name+"="+escape(value)+";EXPIRES="+ getexpirydate(365)+";PATH="+SITE_PATH;
  document.cookie=cookiestring;
}

function createCookie(name,value,days) {

  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path="+SITE_PATH;
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function initTheme(e) {

  var cookie = readCookie("style");
  var title = cookie ? cookie : getPreferredStyleSheet();
  setActiveStyleSheet(title);
}

function setCookie (name, value, expires, path, domain, secure) {
    var curCookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") + ((path) ? "; path=" + path : "/") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
    document.cookie = curCookie;
}

function getCookie (name) {
    var prefix = name + '=';
    var c = document.cookie;
    var nullstring = '';
    var cookieStartIndex = c.indexOf(prefix);
    if (cookieStartIndex == -1)
        return nullstring;
    var cookieEndIndex = c.indexOf(";", cookieStartIndex + prefix.length);
    if (cookieEndIndex == -1)
        cookieEndIndex = c.length;
    return unescape(c.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}

function deleteCookie (name, path, domain) {
    if (getCookie(name))
        document.cookie = name + "=" + ((path) ? "; path=" + path : "/") + ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
}

function fixDate (date) {
    var base = new Date(0);
    var skew = base.getTime();
    if (skew > 0)
        date.setTime(date.getTime() - skew);
}

function rememberMe (f) {
    var now = new Date();
    fixDate(now);
    now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
    setCookie('mtcmtauth', f.author.value, now, '', HOST, '');
    setCookie('mtcmtmail', f.email.value, now, '', HOST, '');
    setCookie('mtcmthome', f.url.value, now, '', HOST, '');
}

function forgetMe (f) {
    deleteCookie('mtcmtmail', '', HOST);
    deleteCookie('mtcmthome', '', HOST);
    deleteCookie('mtcmtauth', '', HOST);
    f.email.value = '';
    f.author.value = '';
    f.url.value = '';
}

var menuCookie;
var tempString;
if(!(tempString = getcookie("menuCookie"))){
  setcookie('menuCookie', '1 1 0 0 0 1 0 0');
  menuCookie = [1, 1, 0, 0, 0, 1, 0, 0];
} else {
  menuCookie = tempString.split(" ");
}
var menuNames = ["menunews", "menuaccount", "menugameguide", "menuinteractive", "menumedia", "menuforums", "menucommunity", "menusupport"];

function toggleNewMenu(menuID) {
  var menuNum = parseInt(menuID)+1;
  
  var toggleState = menuCookie[menuID];
  var menuName = menuNames[menuID]+ "-inner";
    var collapseLink = menuNames[menuID]+ "-collapse";
    var menuVisual = menuNames[menuID]+ "-icon";
    var menuHeader = menuNames[menuID]+ "-header";
    var menuButton = menuNames[menuID]+ "-button";
  
  if (toggleState == 0) {
    try{showMenu(menuNum);}catch(err){}
    document.getElementById(menuName).style.visibility = "visible";
    document.getElementById(menuName).style.display = "block";    
        document.getElementById(menuButton).className = "menu-button-on";
        document.getElementById(collapseLink).className = "leftmenu-minuslink";
        document.getElementById(menuVisual).className = menuNames[menuID]+ "-icon-on";
        document.getElementById(menuHeader).className = menuNames[menuID]+ "-header-on";
    menuCookie[menuID] = 1;
  } else {
    try{hidewMenu(menuNum);}catch(err){}
    document.getElementById(menuName).style.visibility = "hidden";
    document.getElementById(menuName).style.display = "none";   
        document.getElementById(menuButton).className = "menu-button-off";
        document.getElementById(collapseLink).className = "leftmenu-pluslink";
        document.getElementById(menuVisual).className = menuNames[menuID]+ "-icon-off";
        document.getElementById(menuHeader).className = menuNames[menuID]+ "-header-off";
    menuCookie[menuID] = 0;
  }
    var theString = menuCookie[0] + " " +menuCookie[1]+ " " +menuCookie[2]+ " " +menuCookie[3]+ " " +menuCookie[4]+ " " +menuCookie[5] + " " +menuCookie[6] + " " +menuCookie[7];
    setcookie('menuCookie', theString); 
}

function dummyFunction(){}

function toggleEntry(newsID,alt) {

  var newsEntry = "news"+newsID;
    var collapseLink = "plus"+newsID;

  if (document.getElementById(newsEntry).className == 'news-expand') {
    document.getElementById(newsEntry).className = "news-collapse"+alt; 
    setcookie(newsEntry, "0");  
  } else {
    document.getElementById(newsEntry).className = "news-expand"; 
    setcookie(newsEntry, "1");  
  }


}
function clearFiller(menuNum) {
  document.getElementById("menuFiller" + menuNum).style.visibility="hidden";
}

bgTimeout = null;
function changeNavBgPos() {

    var n, e;
    e = n = document.getElementById("nav");
    y = 0;
    x = 0;
 if (e.offsetParent) {
  while (e.offsetParent) {
   y += e.offsetTop;
   x += e.offsetLeft;
   e = e.offsetParent;
        }
    } else if (e.x && e.y) {
  y += e.y;
  x += e.x;
    }
    n.style.backgroundPosition = (x*-1) + "px " + (y*-1) + "px";

}

function addEvent(obj, evType, fn) {
  
    if (obj.addEventListener) {

        obj.addEventListener(evType, fn, false);
        return true;
    } else if (obj.attachEvent) {

        var r = obj.attachEvent("on"+evType, fn);
        return r;
    } else {

        return false;
    }
}
  
