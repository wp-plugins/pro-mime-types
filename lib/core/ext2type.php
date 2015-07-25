<?php
//* Adds new/unknown files types

add_filter( 'ext2type', 'pmt_ext2type' );

function minimatica_file_types( $types ) {
	
	$types['video'][] = 'webm';	
	$types['image'][] = 'svg';

	return $types;
}

