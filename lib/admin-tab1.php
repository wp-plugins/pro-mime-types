<?php

//* Tab one section info
function pmt_settings_section_callback_tab_1() { 
	global $promimes;
	
	echo __( 'The options below will allow you to allow or disallow certain file types for upload within your WordPress installation.', 'promimetypes' );
		
	echo '<br /><h3>';
	if ( is_prosites_active() ) {
		echo __( 'Pro Sites is installed and active!', 'promimetypes' );
	} else {
		echo __( 'Pro Sites is not installed and/or active!', 'promimetypes' );
	}
	echo '</h3>';
	
	echo __( 'When Pro Sites is installed, you can also select the level from which you\'d like the mime type to be uploadable.', 'promimetypes' );
	echo '<br />';
	echo __( 'If you use Pro Sites please be cautious that the files will not be automatically removed when a Pro Site expires or lowers his subscription.', 'promimetypes' );
	
	echo '<h3>' . __('File types are color coded by danger', 'promimetypes') . '</h3>';
	
	echo '<span style="color:#1E7A00;">' . __('Green is considered safe.', 'promimetypes') . '</span><br />';
	echo '<span style="color:#0044FF;">' . __('Blue is considered unwanted.', 'promimetypes') . '</span><br />';
	echo '<span style="color:#FF8800;">' . __('Orange is considered likely dangerous.', 'promimetypes') . '</span><br />';
	echo '<span style="color:#FF0000;">' . __('Red is considered dangerous.', 'promimetypes') . '</span><br /><br />';
	
	echo '<em>' . __('Hover over a non-green "Mime Type" to see the reason of danger.', 'promimetypes') . '</em><br />';
	
	echo '<br /><hr><br />';
	
	if(isset($_POST['pmt_submit'])){	
		if (!isset($_POST['pmt_option']['pmt_mime_type'])) {
			$_POST['pmt_option']['pmt_mime_type'] = 'false'; //If no checked box in post set value to false
		}
		
		foreach((array)$_POST['pmt_option'] as $key => $value) {
			update_site_option($key,$value);
		}
		
	}
		
	//* # Le form
	?>
		<form method="post" action="">
			<?php settings_fields('pmt_settings'); ?>
						
			<p style="margin-bottom:30px;">
				<h3><?php _e('Image formats', 'promimetypes' ); ?></h3>
				
				<table style="width:auto;text-align:left;border-collapse:separate;border-spacing:28px 14px;">
					<tr>
						<th><?php _e('File Extension', 'promimetypes'); ?></th>
						<th><?php _e('Allow upload', 'promimetypes'); ?></th>
					<?php if (is_prosites_active()) { ?> 
						<th><?php _e('Minimum ProSite Level', 'promimetypes'); ?></th>
					<?php } ?>
						<th><?php _e('Mime Label', 'promimetypes'); ?></th>
					</tr>
					
					<?php							
					//* START MIMES OPTIONS LOOP
					foreach ($promimes as $mime) {
						$type = esc_attr($mime[0]);
						$label = esc_attr($mime[1]);
						$danger = esc_attr($mime[2]);
						$dangerreason = esc_attr($mime[3]);
						
						if ($danger == 0) {
							$dangercolor = 'color:#1E7A00;';
						} else if ($danger == 1) {
							$dangercolor = 'color:#0044FF;';
						} else if ($danger == 2) {
							$dangercolor = 'color:#FF8800;';
						} else if ($danger == 3) {
							$dangercolor = 'color:#FF0000;';
						}
						
						${'pmt_mime_type_'.$type} = get_site_option( 'pmt_mime_type_' . $type );
						${'pmt_mime_type_'.$type.'_pro'} = get_site_option( 'pmt_mime_type_' . $type . '_pro' );
					?>
					
					<tr>
						<td>
							<label for="pmt_option[pmt_mime_type_<?php echo $type; ?>]" class="input_label" style="<?php echo $dangercolor; ?>" title="<?php echo $dangerreason; ?>"><?php echo $type; ?></label>
						</td>
						<td>
							<select name="pmt_option[pmt_mime_type_<?php echo $type; ?>]">
								<option value="1" <?php selected( ${'pmt_mime_type_'.$type}, 1 ); ?>>
									<?php _e( 'Allow', 'promimetypes' ) ?>
								</option>							
								<option value="2" <?php selected( ${'pmt_mime_type_'.$type}, 2 ); ?>>		
									<?php _e( 'Disallow', 'promimetypes' ) ?>
								</option>
							</select>
						</td>
						<?php if ( is_prosites_active() ) { ?>
						<td>
							<select name="pmt_option[pmt_mime_type_<?php echo $type; ?>_pro]">
							
								<?php 
								$pro_levels = (array)get_site_option('psts_levels', '0');
																
								if (!empty ($pro_levels) ) {
									
									// Add support for level 0 (free)
									?>
										<option value="0" <?php selected( ${'pmt_mime_type_'.$type.'_pro'}, 0 ); ?>>
												<?php _e( 'Free', 'promimetypes' ); ?>
										</option>
									<?php
									
									// All other levels
									foreach ($pro_levels as $pro_level => $value) {
										?>
										<option value="<?php echo $pro_level; ?>" <?php selected( ${'pmt_mime_type_'.$type.'_pro'}, $pro_level ); ?>>
											<?php echo esc_attr($value['name']); ?>
										</option>
										<?php
									}
								}
							?>
							</select>
							
						</td>
						<?php } ?>
						
						<td style="<?php echo $dangercolor; ?>">
							<?php echo $label; ?>
						</td>
						
					</tr>
					<?php 
					//* END MIMES OPTIONS LOOP
					} 
					?>
				</table>
			</p>
			
			<p>
				<input name="pmt_submit" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	<?php
	//* # Le Form end
}