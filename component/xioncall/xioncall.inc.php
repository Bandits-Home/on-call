<?php
// NagiosXI On-Call COMPONENT
//

require_once(dirname(__FILE__).'/../componenthelper.inc.php');

// respect the name
$xioncall_component_name="xioncall";

// run the initialization function
xioncall_component_init();

////////////////////////////////////////////////////////////////////////
// COMPONENT INIT FUNCTIONS
////////////////////////////////////////////////////////////////////////

function xioncall_component_init(){
	global $xioncall_component_name;
	
	$versionok=xioncall_component_checkversion();
	
	$desc="";
	if(!$versionok)
		$desc="<b>".gettext("Error: This component requires Nagios XI 2009R1.2B or later.")."</b>";
	
	$args=array(

		// need a name
		COMPONENT_NAME => $xioncall_component_name,
		
		// informative information
		COMPONENT_AUTHOR => "Jim Clark - BanditBBS",
		COMPONENT_DESCRIPTION => gettext("Adds a link to display who is currently On-Call. ").$desc,
		COMPONENT_TITLE => "NagiosXI On-Call",
		COMPONENT_VERSION => "1.1",
		COMPONENT_DATE => "12/19/2013",

		);
		
	register_component($xioncall_component_name,$args);
	
	// add a menu link
	if($versionok)
		register_callback(CALLBACK_MENUS_INITIALIZED,'xioncall_component_addmenu');
	}
	
///////////////////////////////////////////////////////////////////////////////////////////
// MISC FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////////////

function xioncall_component_checkversion(){

	if(!function_exists('get_product_release'))
		return false;
	//requires greater than 2009R1.2
	if(get_product_release()<114)
		return false;

	return true;
	}
	
function xioncall_component_addmenu($arg=null){
	global $xioncall_component_name;
	
	$urlbase=get_component_url_base($xioncall_component_name);
	
	$mi=find_menu_item(MENU_HOME,"menu-home-metrics","id");
	if($mi==null)
		return;
		
	$order=grab_array_var($mi,"order","");
	if($order=="")
		return;
		
	$neworder=$order-0.1;

	add_menu_item(MENU_HOME,array(
		"type" => "link",
		"title" => gettext("NagiosXI On-Call"),
		"id" => "menu-home-xioncall",
		"order" => $neworder,
		"opts" => array(
			"href" => $urlbase."/oncall.php",
			)
		));
	}
?>