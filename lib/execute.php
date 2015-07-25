<?php
//* Executing the code to something that works

function pmt_upload_mimes( $existing_mimes = array() ) {
	global $wpdb,$blog_id,$promimes;

	//* run code
	foreach($promimes as $mime) {
		$type = $mime[0];
		$label = $mime[1];
		
		${'pmt_mime_type_'.$type} = get_site_option( 'pmt_mime_type_' . $type );
		${'pmt_mime_type_'.$type.'_pro'} = get_site_option( 'pmt_mime_type_' . $type . '_pro' );
		
		if (is_prosites_active()) {	
			//	$prolevelsql = -1; //resets the query
		
			//* Uses object cache now, when available (needs plugin like batcache, w3 total cache, etc.)
			$prolevelsql = wp_cache_get('hmpl_pro_level_sql_' . $blog_id, 'hmpl_mainblog' );
			
			if ( false === $prolevelsql ) {
				$prolevelsql = $wpdb->get_var($wpdb->prepare("SELECT level FROM {$wpdb->base_prefix}pro_sites WHERE blog_ID = %d", $blog_id));
				wp_cache_set( 'hmpl_pro_level_sql_' . $blog_id, $prolevelsql, 'hmpl_mainblog', 14400 );
			}
			
		}
		
		//* Global active if pro sites isn't activated/installed.
		if (!is_prosites_active()) {
			if (${'pmt_mime_type_'.$type} == 1 ) {
				$existing_mimes[$type] = $label;
			} else if (${'pmt_mime_type_'.$type} == 2 ) {
				unset( $existing_mimes[$type] );
			} else {
				unset( $existing_mimes[$type] );
			}
		} else {
			if ((${'pmt_mime_type_'.$type} == 1) && ${'pmt_mime_type_'.$type.'_pro'} <= $prolevelsql ) {
				$existing_mimes[$type] = $label;
			} else if ((${'pmt_mime_type_'.$type} == 1) && ${'pmt_mime_type_'.$type.'_pro'} >= $prolevelsql) {
				unset( $existing_mimes[$type] );
			} else if (${'pmt_mime_type_'.$type} == 2 ) {
				unset( $existing_mimes[$type] );
			} else {
				unset( $existing_mimes[$type] );
			}
		}
	}


	return $existing_mimes;
}
add_filter('upload_mimes', 'pmt_upload_mimes' );
