<?php
/**
 * Add form view
 *
 * Displays the form field for adding terms.
 *
 * @uses 'do_action' "adv_term_fields_show_inner_field_add_{$this->meta_key}" filter.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Images\Views
 *
 * @since 0.1.0
 */
?>
<div class="inside">
	<input type="hidden" name="<?php echo esc_attr( $this->meta_key ); ?>" id="<?php echo esc_attr( $this->meta_slug ); ?>" value="" />
	<a title="<?php echo esc_attr_e('Set Featured Image');?>" href="#" id="set-term-thumbnail-add" data-update="<?php echo esc_attr_e('Set Featured Image');?>" data-choose="<?php echo esc_attr_e('Featured Image');?>" data-delete="<?php echo esc_attr_e('Remove featured image');?>" class="button set-term-thumbnail">
		<?php _e( 'Set Featured Image', 'atf-images' ); ?>
	</a>
</div>