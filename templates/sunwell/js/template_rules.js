var myrules = {
    '#form_tool li' : function(element){
        element.onclick = function(){
            var comment = document.getElementById('input_comment')
            var a_text = element.childNodes[0].childNodes[0].childNodes[0];
            var code = element.id.substring(element.id.lastIndexOf('_') + 1);
            var code_child = code.substring(code.lastIndexOf('-') + 1);
            var selected_text = '';
            var spacer = '';
            var tag = '';
            if(code_child != code) {
                code = code.substring(0, code.lastIndexOf('-')); }
            if(comment && code) {
                // get selected text, if any
                selected_text = selectedText(comment);
                if(!selected_text)selected_text = '';
                // Fix Mozilla extra spacing behind the text when double-click a word
                if(selected_text.charAt(selected_text.length - 1) == ' ' )
                {
                    spacer = ' ';
                    selected_text = selected_text.substring(0, selected_text.length - 1);
                }
                if(code == 'url') {
                    tag = prompt("Enter url: ","http://");
                    if (tag == null) { return false; }
                    tag = '=' + tag;
                }
                if(code == 'img') {
                    tag1 = prompt("Enter image url: ","http://");
                    if (tag1 == null) { return false; }
                    selected_text = tag1;
                }
                if(code == 'attach') {
                    window.open(SITE_HREF+'index.php?n=forum&sub=attach&nobody=1','attach','toolbar=no, location=no, directories=no, status=no, resize=yes, menubar=no, scrollbars=yes, width=500, height=600,left=160,top=80');
                    return false; 
                }
                if(code == 'style') {
                    tag = prompt("Please enter a valid CSS attributes (e.g. font-weight: bold;): ","");
                    if (tag == "" || tag == null) { return false; }
                    tag = '=' + tag;
                }
                if(code == 'class') {
                    tag = prompt("Please enter a class name: ","");
                    if (tag == "" || tag == null) { return false; }
                    tag = '=' + tag;
                }
                if(code == 'size' || code == 'color' || code == 'align') {
                    if(code_child != code) {
                        if(code_child == 'custom') {
                            code_child = prompt("Please enter a HTML color code (e.g #FFFFFF, yellow) : ","");
                            if (code_child == "" || code_child == null) { return false; }
                        }
                        tag = '=' + code_child;
                    } else { return false; }
                }
                if(code == 'smile') {
                    if(code_child != code) {
                        insertAtCursor(comment, '[img]'+code_child+'[/img]'+spacer);
                        return false;
                    } else { return false; }
                }
                insertAtCursor(comment, '['+code+tag+']'+selected_text+'[/'+code+']'+spacer);
            }
            return false;
        }
    },
    '#form_tool ul li' : function(element){
        element.onmouseover = function() {
            this.className += " sfhover";
        }
        
        element.onmouseout = function() {
            this.className=this.className.replace(/\b(sfhover)\b/, "");
        }
    },
    '#preview_do' : function(element){
        element.onclick = function(){
            var request = new Ajax.Request(
                SITE_HREF+'index.php?n=ajax&sub=preview&nobody=1&ajaxon=1',
                {
                    method: 'post',
                    parameters: 'text=' + encodeURIComponent($F('input_comment')),
                    onComplete: function(reply){
                        $('input_preview').innerHTML = reply.responseText;
                        document.getElementById('input_block').style.display = 'none';
                        document.getElementById('preview_block').style.display = '';
                    }
                }
            );
            return false;
        }
    },
    '#preview_back' : function(element){
        element.onclick = function(){
            document.getElementById('input_preview').innerHTML = '';
            document.getElementById('input_block').style.display = '';
            document.getElementById('preview_block').style.display = 'none';
            return false;
        }
    }
    /*,
    '.quote' : function(element){
        element.onclick = function(){
            comdiv = this.parentNode.parentNode;
            comdiv.id.match(/^post(\d+)$/);
            var req = new JsHttpRequest();
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    document.getElementById('input_comment').value += req.responseText;
                }
            }
            req.caching = false;
            req.open('GET', SITE_HREF+'index.php?n=ajax&sub=getquote&nobody=1&ajaxon=1', true);
            req.send({ postid: RegExp.$1 });
            new Effect.ScrollTo("write_form");
            return false;
        }
    },
    '.scroller' : function(element){
        element.onclick = function(){
            var v=this.getAttribute("href").substring(this.getAttribute("href").lastIndexOf('#') + 1);
            new Effect.ScrollTo(v,{transition:Effect.Transitions.slowstop,duration:2.0});
            return false;
        }
    }
    */
};

Behaviour.register(myrules);

