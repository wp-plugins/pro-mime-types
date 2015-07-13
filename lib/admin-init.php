<?php
//* Add network menu
//* Located under Settings
//* Super Admin (MS) / Admin (Single) only
//* Uses /lib/shortcode.php

// shorthand needs testing before produciton
// add_action( is_multisite() ? ('network_admin_menu', 'pmt_add_menu_ms') : ('admin_menu', 'pmt_add_menu_single') );
if (is_multisite()) {
	add_action('network_admin_menu', 'pmt_add_menu_ms'); // multisite menu
} else {
	add_action('admin_menu', 'pmt_add_menu_single'); // single menu
}

//* Initiate options page
function pmt_add_menu_ms() {
	add_submenu_page( 'settings.php', 'Pro Mime Types', 'Pro Mime Types', 'manage_options', 'pmt_admin_page', 'pmt_admin_page' );
}
function pmt_add_menu_single() {
	add_submenu_page( 'options-general.php', 'Pro Mime Types', 'Pro Mime Types', 'manage_options', 'pmt_admin_page', 'pmt_admin_page' );
}

//* Render page
function pmt_admin_page() {
	global $wpdb, $current_site;
	
	if ( false == pmt_site_admin() ) {
		return false; // There you go. Only (super-)admin.
	}
	
	//* # Register settings
//	register_setting( 'pmt_tab_1', 'pmt_settings' ); //not needed
	
	//* # Tab 1
	add_settings_section(
		'pmt_pluginPage_section_tab_1', //id
		__( 'Pro Mime Types Options', 'promimetypes' ), //title
		'pmt_settings_section_callback_tab_1', //callback function
		'pmt_tab_1' //menu_slug
	);
		
	//* # Tab 2
	add_settings_section(
		'pmt_pluginPage_section_tab_2', //id
		__( 'Globally Active Mime Types', 'promimetypes' ), //title
		'pmt_settings_section_callback_tab_2', //callback function
		'pmt_tab_2' //menu_slug
	);
	
	//* # Init settings	
	?>
	<div class="wrap">
		<h2>Pro Mime Types</h2>
		
		<?php if(isset($_POST['pmt_submit'])) { ?>
			<div id="message" class="updated">
				<p>
					<?php _e( 'Options are Saved', 'promimetypes' ) ?>
				</p>
			</div>
		<?php }
		
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_options'; //save tab location
		?>
		
		<h2 class="nav-tab-wrapper">
			<a href="?page=pmt_admin_page&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'Options', 'promimetypes' ); ?></a>
			<a href="?page=pmt_admin_page&tab=list_active_mime_types" class="nav-tab <?php echo $active_tab == 'list_active_mime_types' ? 'nav-tab-active' : ''; ?>"><?php echo __( 'View globally active Mime Types', 'promimetypes' ); ?></a>
		</h2>
		
		<?php 
			//* # display tab content
			if( $active_tab == 'display_options' ) {
				do_settings_sections( 'pmt_tab_1' );
			} else {		
				do_settings_sections( 'pmt_tab_2' );
			}
		?>
		
	</div>
	<?php
}