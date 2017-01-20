<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo (string)$Config->get('site_title'); ?> Terms of Service</title>
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW, NOSNIPPET, NOARCHIVE" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<style type="text/css" title="currentStyle" media="screen">
			@import "modules/notice/notice.css";
			body 
			{
				color: #FFF;
			}
			img 
			{
				border: 0px;
			}
		</style>
		<script type="text/javascript">
			function Set_Cookie( name, value, expires, path, domain, secure ) 
			{
		        var today = new Date();
		        today.setTime(today.getTime());
		        var expires_date = new Date(today.getTime() + (expires ? expires * 1000 * 60 * 60 * 24 : 0));
		        document.cookie = name + "=" +escape(value) + (expires ? ";expires=" + expires_date.toGMTString() : "" ) + (path ? ";path=" + path : "" ) +(domain ? ";domain=" + domain : "" ) + (secure ? ";secure" : "");
		    }
			function checkForm() 
			{
				if (checkboxFunc()) 
				{
					Set_Cookie('agreement_accepted', 'true', '365');
					window.location.reload();
				}
			}
			function checkboxFunc()
			{
				if (terms_accepted=="")
				{
					alert("\You must accept the Terms of Service before you can enter!");
				} 
				else 
				{
					return true;
				}
			}
			var terms_accepted="";
		</script>
	</head>
	<body>
	    <div style="background-color: #000000; width: 100%;">
	    <div id="postshell21" style="width: 700px; margin-top: 50px">
	    <div class="resultbox">
	    <div class="postdisplay">
	    <div class="border">
	    <div class="postingcontainer21">
	    <div class="insert">
	    <table id="posttable21" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td>
					<form action="GET">
						<table class="tabelbasic1" cellspacing="0" cellpadding="15" width="100%" style="font-size: 10pt">
							<tr>
								<td>
									<textarea name="S1" cols="80" rows="25" style="width: 100%; color: #ffac04; border: 1px #777777 solid;" readonly="readonly"><?php readfile('modules/notice/ToS.html'); ?></textarea>
								</td>
							</tr>
							<tr>
								<td align="center">
									<p>
										<input id="accepted" onclick="terms_accepted='accepted'" type="checkbox" value="ON" style="background: none; border: none" />
										<label for="accepted"><b>I have read and understood this agreement and agree to be bound by all its terms.</b></label>
									</p>
								</td>
							</tr>
							<tr>
								<td align="center">
									<a href="http://google.com"><img src="modules/notice/images/decline.gif" alt="Decline" /></a>
									<a href=""><img src="modules/notice/images/agree.gif" onclick="checkForm()" alt="Agree" /></a>
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	    </div>
	    </div>
	    </div>
	    </div>
	    </div>
	    </div>
	    </div>
	</body>
</html>