<?php
/*
Plugin Name: Aus Stocks
Description: Display your Australian Stock Exchange (ASX) Share Price, Graph and Announcements automatically on your website
Version: 1.3.0
Plugin URI: https://ausstocks.com.au
Author: Web and Print Design
Author URI: https://webandprint.design
License: GPL2
*/


global $asx_code;
define( 'ASX_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ASX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );



/**
 * Returns current plugin version.
 * 
 * @return string Plugin version
 */
function asx_plugin_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );	
	return $plugin_folder[$plugin_file]['Version'];
}

//function for adding option values
function asx_register_settings() {
   
   add_option( 'asx_code', '');  
   add_option( 'asx_market', '');   
   
   register_setting( 'asx_options_group', 'asx_code' );   
   register_setting( 'asx_options_group', 'asx_market' );   
   
}
add_action( 'admin_init', 'asx_register_settings' );


//function for register option page
function asx_register_options_page() {
  add_options_page('Aus Stocks Settings', 'Aus Stocks', 'manage_options', 'ausstocks', 'asx_options_page');
}
add_action('admin_menu', 'asx_register_options_page');



function asx_options_page() {    
    
?>
  <div>
  
  	<div>      
  
      <div>
          <a href="https://ausstocks.com.au/product/aus-stocks-subscription/" target="_blank"><img src="<?php echo ASX_PLUGIN_URL;?>assets/subscribe.png" align="right" height="320" style="padding:20px;"> </a>
          <?php screen_icon(); ?>
      <div class="logo"><a target="_blank" href="https://webandprint.design"><img width="200" src="<?php echo ASX_PLUGIN_URL;?>assets/wap_logo.png" alt="Web and Print Development Site" style="max-width: 200px; margin-top:20px;"></a></div>
 
    <h1>Aus Stocks</h1>
    <p>v<?php echo asx_plugin_get_version();?> <a href="https://ausstocks.com.au" target="_blank">ausstocks.com.au</a></p>
    <p>Aus Stocks allows you to automatically display your company ASX share price, interactive price history graph and announcements on your WordPress website.</p> 
	<p>Share Price information is 20 minutes delayed with announcements are added automatically shortly after you lodge them with the stock exchange if you are on the Pro plan. The Free plans offer a 60 minute delayed share price only. </p>
	<p>Simple shortcodes allow you to display them anywhere on your site.</p>
	<p><b>All stock data is supplied on a subscription basis</b>, please visit <a href="https://ausstocks.com.au" target="_blank">ausstocks.com.au</a> to subscribe and for further information.</p>
	
   </div>
   </div>
   <br clear="all">
   	
      
      <div style="float:left;width:33%;min-width:500px;">
          <hr>
          <h2>Settings</h2> 
          <form method="post" action="options.php">
          <?php settings_fields( 'asx_options_group' ); ?>  
          <div>
              <div style="width:150px;float:left;"><strong>ASX Code *</strong></div>
              <div style="float:left;"><input type="text" id="asx_code" name="asx_code" class="regular-text" maxlength="3" style="width:160px" value="<?php echo get_option('asx_code'); ?>" /></div>
          </div>
          <br clear="all">
          <div>
              <div style="width:150px;float:left;"><strong>Stock Market</strong></div>
              <div style="float:left;"><select id="asx_market" name="asx_market" class="regular-text" style="width:160px">
                  <option value="ASX" <? if(get_option('asx_market')=='ASX'){echo " selected";}?>>ASX</option>
                 <!--- <option value="NSX" <? if(get_option('asx_market')=='NSX'){echo " selected";}?>>NSX</option>
                  <option value="NZX" <? if(get_option('asx_market')=='NZX'){echo " selected";}?>>NZX</option>--->
                  </select></div>
          </div>
          <br clear="all">
          <?php  submit_button(); ?>
          </form>
          <p>*&nbsp;&nbsp;Required</p>
      
      </div>
   
   
      <div style="float:left;width:33%">
          <hr>
          <h2>Shortcodes</h2> 
          <i><b>Note: </b>All values are optional, leave blank to display all results</i><br/> 
          <div><h3>Basic, Standard & Premium</h3></div>
          <div><kbd>[asx_basic]</kbd> Share price value only</div>
          <div><h3>Standard & Premium</h3></div>
          <div>Set any of these values to false to hide it</div>
          <div><kbd>[asx_price]</kbd> - last, change, volume, open, high, low, marketcap, moreinfo</div> 
          <div><kbd>[asx_topbar]</kbd> - last, change, volume</div>
          <div><kbd>[asx_graph]</kbd></div>
          <div><h3>Premium</h3></div>
          <div><kbd>[asx_latest_news]</kbd> No. of posts 'num =3' (default 4), Category of posts 'cat=1,2,3'</div>
          <div><kbd>[asx_announcements]</kbd> No. of posts 'num=3', Category of posts 'cat=1,2,3', 'start=2010', 'end=2017'</div> 
          
      </div>
      <div style="float:left;width:33%">
      <a href="https://ausstocks.com.au" target="_blank"><img src="<?php echo ASX_PLUGIN_URL;?>assets/ausstocks_settings_1a.jpg" align="right" style="width:90%">  </a>
    </div>
</div> 
<br clear="all"><hr>
      <p><a href="https://ausstocks.com.au" target="_blank">Visit the Aus Stocks website for further information</a>.
      <br>Aus Stocks is written and developed by <a href="https://webandprint.design" target="_blank">Web and Print Design</a>.</p>
    <?php
}

$asx_code =  get_option('asx_code');


//Add settings link to plugin page
function asx_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=ausstocks">' . __( 'Settings' ) . '</a>';    
    array_unshift($links, $settings_link);
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'asx_add_settings_link' );

//including custom functions and shortcodes required for the plugin
include_once("functions.php");
include_once("Shortcodes.php");