<?php
/*
Plugin Name: 	vid{one} video chat using Tokbox
Plugin URI: 	http://vidtok.co/vidone
Description: 	vid{one} was created to allow WordPress users the ability to create and host 1:1 video chats on their website.
Version: 		1.1
Author: 		the Blacc Spot Media team
Author URI: 	http://blaccspot.com
License: 		GPLv3 http://www.gnu.org/licenses/gpl.html
*/


/*  DEFINE CONSTANTS
/*---------------------------*/	
	
	/*VARIABELS*/
		$url = str_replace('www.', '', parse_url(site_url()));  
	
	/*VERSION*/
		define("VIDONE_VERSION", "1.1");
		
	/*DOMAIN*/	
		define("DOMAIN", $url['host']);
	
	/*PLUGIN PATH*/
		define("VIDONE_PLUGINPATH", "/" . plugin_basename(dirname(__FILE__)) . "/");
	
	/*PLUGIN FULL URL*/
		define("VIDONE_PLUGINFULLURL", trailingslashit(plugins_url(null, __FILE__ )));
	
	/*PLUGIN FULL DIRECTORY*/
		define("VIDONE_PLUGINFULLDIR", WP_PLUGIN_DIR . VIDONE_PLUGINPATH);
		
	/*PLUGIN WWW PATH*/
		define("VIDONE_WWWPATH", str_replace($_SERVER['DOCUMENT_ROOT'], '', VIDONE_PLUGINFULLDIR));	
		

/* ON WP LOAD
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp', 'wp_set');
	
	/*VID{ONE} SETUP*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/wp.php');
	
	
	
/* ACTIVATION
/*---------------------------*/

	/*INSTALLATION*/
		register_activation_hook(__FILE__,'vidone_install');

	/*PLUGIN ACTIVATION IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/install.php');
	
	/*ACTIVATION NOTICE*/
		add_action('admin_notices', 'vidone_settings_notice');
		
	/*PLUGIN ACTIVATION IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/notices.php');



/*  UNINSTALL
/*---------------------------*/
	
	/*PLUGIN REMOVAL*/
		register_deactivation_hook( __FILE__, 'vidone_uninstall' );
	
	/*PLUGIN REMOVAL IMPLEMENATION*/
		include_once(VIDONE_PLUGINFULLDIR.'functions/installation/uninstall.php');



/*  AJAX REQEUST :: CREATE SESSION
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_create_session', 'vidone_create_session');
		add_action('wp_ajax_nopriv_create_session', 'vidone_create_session');
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/create.php');



/*  AJAX REQEUST :: JOIN SESSION
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_join_session', 'vidone_join_session');  
		add_action('wp_ajax_nopriv_join_session', 'vidone_join_session'); 
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/join.php'); 



/*  AJAX REQEUST :: INVITE EMAIL
/*---------------------------*/
	
	/*ADD ACTION*/
		add_action('wp_ajax_invite_email', 'vidone_invite_email');  
		add_action('wp_ajax_nopriv_invite_email', 'vidone_invite_email');
		
	/*CREATE SESSION*/	
		include_once(VIDONE_PLUGINFULLDIR.'functions/widget/invite.php');   

	
/*  WIDGET SETTINGS
/*---------------------------*/

	/*ADD ACTION*/
		add_action('wp_head', 'vidone_registered');

	/*DISPLAY SETTINGS*/	
		function vidone_registered()
			{ 
				
				$options = get_option('vidone_options');  ?>
				
                <script type="text/javascript">
					VIDONE_REGISTERED 		= '<?php echo $options['registered']; ?>';
					VID						= ''; 
					TOKBOX_SESSION_ID		= '';
					TOKBOX_TOKEN			= '';		
					VIDONE_PLUGIN_URL		= '<?php echo VIDONE_PLUGINFULLURL; ?>';
					VIDONE_INVITE_URL		= "http://<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>?vid="; 
					DOMAIN					= '<?php echo DOMAIN; ?>';  
					VAPI					= '<?php $options = get_option('vidone_options'); echo $options['vapi']; ?>';
			 
					function tw_click(e) {
						u = location.href;
						t = document.title; 
						text = "<?php echo urlencode('Join my live video chat! http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>?vid=" + VID + " <?php echo urlencode('Made possible using @vidtok vid{one} Wordpress Plugin.'); ?>";
						window.open("http://twitter.com/intent/tweet?text=" + text, 'sharer', 'toolbar=0,status=0,width=500,height=360'); 
						return false;
					}
					
					function fbs_click() {
						url = '<?php echo urlencode('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>?vid=' + VID;
						title = 'Join my live video chat!';
						image = 'http://vidtok.co/images/logos/vidtok-logo-v-large.png';
						summary = 'Made possible using @vidtok vid{one} Wordpress Plugin.';
						window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + url + '&p[title]=' + title + '&p[summary]=' + summary + '&p[images][0]=' + image, 'sharer', 'toolbar=0,status=0,width=500,height=360');
						return false;
					}
					
				</script>
                
                
	  <?php }	
