<?php
add_action( 'admin_menu', 'sunshine_admin_menu', 0 );
function sunshine_admin_menu() {
	global $menu, $sunshine;
	$plugin_dir_path = dirname( __FILE__ );

	add_menu_page( 'Sunshine', 'Sunshine', 'sunshine_manage_options', 'sunshine_admin', 'sunshine_dashboard_display', plugins_url( 'assets/images/sunshine-icon.png' , $plugin_dir_path ) );
	//add_submenu_page('sunshine', 'Settings', 'Settings', 10,  'sunshine');
	add_submenu_page( 'sunshine_admin', __( 'Dashboard','sunshine' ), __( 'Dashboard','sunshine' ), 'sunshine_manage_options',  'sunshine_admin', 'sunshine_dashboard_display' );
	add_submenu_page( 'sunshine_admin', __( 'Settings','sunshine' ),  __( 'Settings','sunshine' ), 'sunshine_manage_options', 'admin.php?page=sunshine' );

	$sunshine_admin_submenu = array();
	$sunshine_admin_submenu[10] = array( __( 'Galleries','sunshine' ), __( 'Galleries','sunshine' ), 'sunshine_manage_options', 'edit.php?post_type=sunshine-gallery' );
	$sunshine_admin_submenu[20] = array( __( 'Product Categories','sunshine' ), __( 'Product Categories','sunshine' ), 'sunshine_manage_options', 'edit-tags.php?taxonomy=sunshine-product-category&post_type=sunshine-product' );
	$sunshine_admin_submenu[30] = array( __( 'Products','sunshine' ), __( 'Products','sunshine' ), 'sunshine_manage_options', 'edit.php?post_type=sunshine-product' );
	$sunshine_admin_submenu[40] = array( __( 'Orders','sunshine' ), __( 'Orders','sunshine' ), 'sunshine_manage_options', 'edit.php?post_type=sunshine-order' );
	
	if ( get_option( 'sunshine_pro_license_active') != 'valid' ) {
		$sunshine_admin_submenu[110] = array( __( 'Add-ons','sunshine' ), __( 'Add-Ons','sunshine' ), 'sunshine_manage_options', 'sunshine_addons', 'sunshine_addons' );
	}
	
	$sunshine_admin_submenu[120] = array( __( 'Support','sunshine' ), __( 'Support','sunshine' ), 'sunshine_manage_options', 'sunshine_support', 'sunshine_support' );
	$sunshine_admin_submenu[130] = array( __( 'System Info','sunshine' ), __( 'System Info','sunshine' ), 'sunshine_manage_options', 'sunshine_system_info', 'sunshine_system_info' );
	$sunshine_admin_submenu = apply_filters( 'sunshine_admin_menu', $sunshine_admin_submenu );
	ksort( $sunshine_admin_submenu );
	foreach ( $sunshine_admin_submenu as $item ) {
		add_submenu_page( 'sunshine_admin', $item[0], $item[1], $item[2], $item[3], ( !empty( $item[4] ) ) ? $item[4] : '' );
	}

	// "Hidden" page for image processor - allows us to make the page but not appear in menu
	// This WordPress variable is essential: it stores which admin pages are registered to WordPress
	global $_registered_pages;

	// Get the name of the hook for this plugin
	$hookname_image_processor = get_plugin_page_hookname( 'sunshine_image_processor', 'admin.php' );
	$hookname_bulk_add_products = get_plugin_page_hookname( 'sunshine_bulk_add_products', 'admin.php' );
	$hookname_invoice_display = get_plugin_page_hookname( 'sunshine_invoice_display', 'admin.php' );

	// Add the callback via the action on $hookname, so the callback function is called when the page "options-general.php?page=my-plugin-hidden-page" is loaded
	if ( !empty( $hookname_image_processor ) )
		add_action( $hookname_image_processor, 'sunshine_image_processor' );
	if ( !empty( $hookname_bulk_add_products ) )
		add_action( $hookname_bulk_add_products, 'sunshine_bulk_add_products' );
	if ( !empty( $hookname_invoice_display ) )
		add_action( $hookname_invoice_display, 'sunshine_invoice_display' );

	// Add this page to the registered pages
	$_registered_pages[$hookname_image_processor] = true;
	$_registered_pages[$hookname_bulk_add_products] = true;
	$_registered_pages[$hookname_invoice_display] = true;

}

add_action( 'parent_file', 'sunshine_submenu_show_fix' );
function sunshine_submenu_show_fix( $parent_file ) {
	global $current_screen;
	$taxonomy = $current_screen->taxonomy;
	if ( $taxonomy == 'sunshine-product-category' || $taxonomy == 'sunshine-product-price-level' || ( isset( $_GET['page'] ) && strpos( $_GET['page'], 'sunshine' ) !== false ) ) {
		$parent_file = 'sunshine_admin';
	}
	return $parent_file;
}

?>