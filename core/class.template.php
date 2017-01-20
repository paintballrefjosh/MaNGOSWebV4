<?php
/****************************************************************************/
/*  					< MangosWeb Enhanced v3 >  							*/
/*              Copyright (C) <2009 - 2011>  <Wilson212>                    */
/*						  < http://keyswow.com >							*/
/*																			*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/


class MangosTemplate
{	
	public $xml;
	
	function __construct()
	{
		$this->Init();
	}
	
//	************************************************************
// This function sets up what template is going to be used, based on what the user has picked as his/her template

	public function Init()
	{
		global $user, $Config, $DB;
		$template_list = explode(",", $Config->get('templates'));
		if ( $user['id'] == -1 ) // If user is a guest and not logged in 
		{
			if(isset($_GET['theme']))
			{
				setcookie("cur_selected_theme", $_GET['theme'], time() + (3600 * 24 * 365));
				foreach($template_list as $template) 
				{
					$currtmp2[] = $template ;
				}
				$theme = $_GET['theme'];
				$tmple = $currtmp2[$theme];
				
				// If template doesnt exist anymore, then we must load the default one
				if(!$tmple) 
				{ 
					$tmple = $currtmp2['0']; 
				}
				
				$this->slave_tmpl = "templates/".$tmple;
				$this->path = "templates/".$tmple."/template.xml";
				$this->template_number = 0;
				return TRUE;
			}
			elseif(isset($_COOKIE['cur_selected_theme'])) // If a cookie is set
			{
				$ct = (int)$_COOKIE['cur_selected_theme'];
				foreach($template_list as $template) 
				{
					$currtmp2[] = $template ;
				}
				$tmple = $currtmp2[$ct];
				$this->template_number = $ct;
				
				// If template is no longer available
				if(!$tmple) 
				{ 
					$tmple = $currtmp2['0'];
					$this->template_number = 0;
				}
			}
			else
			{
				setcookie("cur_selected_theme", 0, time() + (3600 * 24 * 365));
				foreach($template_list as $template) 
				{
					$currtmp2[] = $template ;
				}
				$tmple = $currtmp2['0'] ;
				$this->template_number = 0;
			}
			$this->slave_tmpl = "templates/".$tmple;
			$this->path = "templates/".$tmple."/template.xml";
			return TRUE;
		}
		else // If user is logged in
		{
			if(isset($_GET['theme']))
			{
				setcookie("cur_selected_theme", $_GET['theme'], time() + (3600 * 24 * 365));
				foreach($template_list as $template) 
				{
					$currtmp2[] = $template ;
				}
				$asd = $_GET['theme'];
				$tmple = $currtmp2[$asd];
				$this->template_number = $asd;
				
				// If template doesnt exist anymore, then we must load the default one
				if(!$tmple) 
				{ 
					$tmple = $currtmp2['0'];
					$this->template_number = 0;
				}
				
				$this->slave_tmpl = "templates/".$tmple;
				$this->path = "templates/".$tmple."/template.xml";
				return TRUE;
			}
			elseif(isset($_COOKIE['cur_selected_theme'])) // If there is a cookie set with the theme
			{
				$tmpl_cookienum = (int)$_COOKIE['cur_selected_theme'];
				$tmpl_num = $user['theme'];
				if($tmpl_cookienum !== $tmpl_num) // If the cookie and set theme in DB are not the same, fix that :)
				{
					$DB->query( "UPDATE `mw_account_extend` SET `theme`='$tmpl_cookienum' WHERE `account_id`='$user[id]'");
					$tmpl_num = $tmpl_cookienum;
				}
				$this->template_number = $tmpl_cookienum;
			}
			else // If a cookie is not set for a theme
			{
				$tmpl_num = $user['theme'];
				setcookie("cur_selected_theme", $tmpl_num, time() + (3600 * 24 * 365));
				$this->template_number = $tmpl_num;
			}
			foreach($template_list as $template) 
			{
				$currtmp2[] = $template ;
			}
			$tmple = $currtmp2[$tmpl_num] ;
			// If persons current template is no longer available, this resets his template to default
			if(!$tmple)
			{ 
				$tmple = $currtmp2['0'];
				$DB->query( "UPDATE `mw_account_extend` SET `theme`='0' WHERE `account_id`='".$user['id']."'" );
				$this->template_number = 0;
			}
			$this->slave_tmpl = "templates/".$tmple;
			$this->path = "templates/".$tmple."/template.xml";
			return TRUE;
		}
	}

//	************************************************************	
// Once the template is decided, we must load the xml that contains the template information, and return it back to the
// index page

	public function loadTemplateXML()
	{
		// First we load the template XML File
		// Return FALSE if cant open, or doesnt exist
		$this->xml = @simplexml_load_file($this->path);
		if($this->xml == FALSE)
		{
			return FALSE;
		}
		
		// Check to see if there is a master template or not
		if(empty($this->xml->masterTemplate))
		{
			$this->master_template = $this->slave_tmpl;
		}
		else
		{
			$this->master_template = "templates/".$this->xml->masterTemplate;
		}
		
		// Establish Header, Footer, and Function paths
		$this->templateHeader = $this->master_template.'/'.$this->xml->bodyHeader;
		$this->templateFooter = ''.$this->master_template.'/'.$this->xml->bodyFooter;
		$this->templateFunctions = ''.$this->master_template.'/'.$this->xml->bodyFunctions;
		
		// Return Array
		$ret = array(
			'path' => $this->slave_tmpl, 
			'script_path' => $this->master_template,
			'name' => $this->xml->name,
			'header' => $this->templateHeader,
			'footer' => $this->templateFooter,
			'functions' => $this->templateFunctions,
			'number' => $this->template_number,
			'author' => $this->xml->author,
			'authorEmail' => $this->xml->authorEmail,
			'authorUrl' => $this->xml->authorUrl,
			'copyright' => $this->xml->copyright,
			'license' => $this->xml->license
			);
		return $ret;
	}
}
?>