<?php
	$is_multiple = null;
	if( !empty( $field['config']['multi_upload'] ) ){
		$is_multiple .= ' multiple="multiple"';
	}
	$uniqu_code = uniqid('trupl');		
	if( $field_required !== null ){
		$field_required = null;
		$is_multiple .= ' data-required="true"';
	}
	if( empty( $field['config']['multi_upload_text'] ) ){
		$field['config']['multi_upload_text'] = __( 'Add File', 'caldera-forms' );
		if( !empty( $field['config']['multi_upload'] ) ){
			$field['config']['multi_upload_text'] = __( 'Add Files', 'caldera-forms' );
		}
	}
	$accept_tag = array();
	if( !empty( $field['config']['allowed'] ) ){
		$allowed = array_map('trim', explode(',', trim( $field['config']['allowed'] ) ) );
		$field['config']['allowed'] = array();
		foreach( $allowed as $ext ){
			$ext = trim( $ext, '.' );
			$file_type = wp_check_filetype( 'tmp.'. $ext );
			$field['config']['allowed'][] = $file_type['type'];
			$accept_tag[] = '.' . $ext;
		}
	}else{
		$allowed = get_allowed_mime_types();
		$field['config']['allowed'] = array();
		foreach( $allowed as $ext=>$mime ){
			$field['config']['allowed'][] = $mime;
			$accept_tag[] = '.' . str_replace('|', ',.', $ext );
		}
		
	}
	$accept_tag = 'accept="' . esc_attr( implode(',', $accept_tag) ) . '"';

	$field['config']['max_size'] = wp_max_upload_size();

	$field['config']['notices'] = array(
		'file_exceeds_size_limit' => esc_html__( 'File exceeds the maximum upload size for this site.', 'caldera-forms' ),
		'zero_byte_file' => esc_html__( 'This file is empty. Please try another.', 'caldera-forms' ),
		'invalid_filetype' => esc_html__( 'This file type is not allowed. Please try another.', 'caldera-forms' ),
	);

?><?php echo $wrapper_before; ?>
	<?php echo $field_label; ?>
	<?php echo $field_before; ?>
		<div id="<?php echo $field_id; ?>_file_list" data-field="<?php echo $field_id; ?>" class="cf-multi-uploader-list"></div>

		<button type="button" class="btn btn-block cf-uploader-trigger" data-parent="<?php echo $field_id; ?>"><?php echo esc_html( $field['config']['multi_upload_text'] ); ?></button>

		<input style="display:none;" <?php echo $accept_tag; ?> class="cf-multi-uploader" data-config="<?php echo esc_attr( json_encode( $field['config'] ) ); ?>" data-controlid="<?php echo $uniqu_code; ?>" <?php echo $field_placeholder; ?> <?php echo $is_multiple; ?> type="file" data-field="<?php echo $field_base_id; ?>" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" <?php echo $field_required; ?>>
		<input type="hidden" name="<?php echo $field_name; ?>" value="<?php echo $uniqu_code; ?>">
		<?php echo $field_caption; ?>
	<?php echo $field_after; ?>
<?php echo $wrapper_after; ?>