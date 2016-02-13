<?php
/**
 * Quick-edit form view
 *
 * Displays the form field for quick-editing terms.
 *
 * @uses 'do_action' "adv_term_fields_show_inner_field_qedit_{$this->meta_key}" filter.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Images\Views
 *
 * @since 0.1.0
 */
?>
<div class="inside">

	<input id="inline-<?php echo esc_attr( $this->meta_slug ); ?>" type="hidden" class="ptitle" name="<?php echo esc_attr( $this->meta_key ); ?>" value="" size="20" />

	<p>
		<a title="<?php echo esc_attr_e('Set Featured Image');?>" href="#" id="inline-set-term-thumbnail" data-update="<?php echo esc_attr_e('Set Featured Image');?>" data-choose="<?php echo esc_attr_e('Featured Image');?>" data-delete="<?php echo esc_attr_e('Remove featured image');?>" data-target="#inline-<?php echo esc_attr( $this->meta_slug ); ?>" class="set-term-thumbnail">
			<?php _e( 'Set Featured Image', 'atf-images' ); ?>
		</a>
	</p>

</div>