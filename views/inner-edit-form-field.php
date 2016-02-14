<?php
/**
 * Edit form view
 *
 * Displays the form field for editing terms.
 *
 * @uses 'do_action' "adv_term_fields_show_inner_field_edit_{$this->meta_key}" filter.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Images\Views
 *
 * @since 0.1.0
 */

$thumbnail_id = $this->get_meta( $term->term_id );
$btn_class = ( '' !== $thumbnail_id ) ? '' : 'button ';
?>

<div class="inside">

	<input type="hidden" name="<?php echo esc_attr( $this->meta_key ); ?>" id="<?php echo esc_attr( $this->meta_slug ); ?>" value="<?php echo $this->get_meta( $term->term_id ); ?>" size="20" />

	<a title="<?php echo esc_attr_e('Set Featured Image');?>" href="#" id="set-term-thumbnail-add" data-update="<?php echo esc_attr_e('Set Featured Image');?>" data-choose="<?php echo esc_attr_e('Featured Image');?>" data-delete="<?php echo esc_attr_e('Remove featured image');?>" class="<?php echo $btn_class;?>set-term-thumbnail">

		<?php  if ( '' !== $thumbnail_id ) : ?>

			<?php $image_attributes = wp_get_attachment_image_src( $thumbnail_id );

			if( $image_attributes ) {

				$image = sprintf(
					'<img data-thumbnail="%1$s" data-id="%1$s" class="term-thumbnail" src="%2$s" width="%3$s" height="%4$s" />',
					esc_attr( $thumbnail_id ),
					esc_attr( $image_attributes[0] ),
					esc_attr ($image_attributes[1] ),
					esc_attr ($image_attributes[2] )
				);

				echo $image;

			}; ?>

		<?php else : ?>

			<?php _e( 'Set Featured Image', 'atf-images' ); ?>

		<?php endif; ?>

	</a>

	<?php if( '' !== $thumbnail_id ) : ?>
		<a title="<?php echo esc_attr_e('Remove Featured Image');?>" href="#" id="del-term-thumbnail-edit" class="del-term-thumbnail">
			<?php _e( 'Remove Featured Image', 'atf-images' ); ?>
		</a>
	<?php endif; ?>

</div>