<?php

/**
 * Adv_Term_Fields_Icons Class
 *
 * Adds icons for taxonomy terms.
 *
 * @package Advanced_Term_Fields
 * @subpackage Adv_Term_Fields_Images
 *
 * @since 0.1.0
 *
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Adds featured images for taxonomy terms
 *
 * @version 1.0.0
 *
 * @since 0.1.0
 *
 */
final class Adv_Term_Fields_Images extends Advanced_Term_Fields
{

	/**
	 * Version number
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $version = '0.1.0';


	/**
	 * Metadata database key
	 *
	 * For storing/retrieving the meta value.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $meta_key = 'thumbnail_id';


	/**
	 * Unique singular slug for meta type
	 *
	 * Used in localizing js files.
	 *
	 * @see Adv_Term_Fields_Images::enqueue_admin_scripts()
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public $data_type = 'thumbnail';


	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $file Full file path to calling plugin file
	 */
	public function __construct( $file = '' )
	{
		parent::__construct( $file );
	}


	/**
	 * Loads the class
	 *
	 * @uses Advanced_Term_Fields::show_custom_column()
	 * @uses Advanced_Term_Fields::show_custom_fields()
	 * @uses Advanced_Term_Fields::register_meta()
	 * @uses Advanced_Term_Fields::load_admin_functions()
	 * @uses Advanced_Term_Fields::process_term_meta()
	 * @uses Advanced_Term_Fields::filter_terms_query()
	 * @uses Advanced_Term_Fields::$allowed_taxonomies
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 */
	public function init()
	{
		$this->show_custom_column( $this->allowed_taxonomies );
		$this->show_custom_fields( $this->allowed_taxonomies );
		$this->register_meta();
		$this->load_admin_functions();
		$this->process_term_meta();
		$this->filter_terms_query();
		$this->show_inner_fields();
	}


	/**
	 * Sets labels for form fields
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 */
	public function set_labels()
	{
		$this->labels = array(
			'singular'	  => esc_html__( 'Image',  'atf-images' ),
			'plural'	  => esc_html__( 'Images', 'atf-images' ),
			'description' => esc_html__( 'Set a featured image for this term.', 'atf-images' )
		);
	}


	/**
	 * Loads js admin scripts
	 *
	 * Note: Only loads on edit-tags.php
	 *
	 * @uses Advanced_Term_Fields::$custom_column_name
	 * @uses Advanced_Term_Fields::$meta_key
	 * @uses Advanced_Term_Fields::$data_type
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $hook The slug of the currently loaded page.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts( $hook )
	{
		wp_enqueue_media();
		wp_enqueue_script( 'atf-images', $this->url . 'js/admin.js', array( 'jquery' ), '', true );

		// Term ID
		$term_id = ( ! empty( $_GET['tag_ID'] ) ) ? (int) $_GET['tag_ID'] : 0;

		wp_localize_script( 'atf-images', 'l10n_ATF_Images', array(
			'custom_column_name' => esc_html__( $this->custom_column_name ),
			'meta_key'	         => esc_html__( $this->meta_key ),
			'data_type'	         => esc_html__( $this->data_type ),
			'insertMediaTitle'   => esc_html__( 'Choose an Image', 'atf-images' ),
			'insertIntoPost'     => esc_html__( 'Set featured image', 'atf-images' ),
			'removeFromPost'     => esc_html__( 'Set featured image', 'atf-images' ),
			'term_id'		     => $term_id,
		) );
	}


	/**
	 * Prints out css styles in admin head
	 *
	 * Note: Only loads on edit-tags.php
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function admin_head_styles()
	{
		ob_start();
		include dirname( $this->file ) . "/css/admin.css";
		$css = ob_get_contents();
		ob_end_clean();

		echo $css;
	}


	/**
	 * Displays meta value in custom column
	 *
	 * @see Advanced_Term_Fields::add_column_value()
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $meta_value The stored meta value to be displayed.
	 *
	 * @return string $output The displayed meta value.
	 */
	public function custom_column_output( $meta_value )
	{
		$output = '';

		$image_attributes = wp_get_attachment_image_src( $meta_value );

		if( $image_attributes ) :

			$output = sprintf(
				'<img data-thumbnail="%1$s" data-id="%1$s" class="term-thumbnail" src="%2$s" width="%3$s" height="%4$s" />',
				esc_attr( $meta_value ),
				esc_attr( $image_attributes[0] ),
				esc_attr ($image_attributes[1] ),
				esc_attr ($image_attributes[2] )
				);

		endif;

		return $output;
	}


	/**
	 * Displays inner form field on Add Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::add_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $taxonomy Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_add( $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/add-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Displays inner form field on Edit Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::edit_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 * @uses Advanced_Term_Fields::get_meta() To retrieve meta value.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param object $term Term object.
	 * @param string $taxonomy Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_edit( $term = false, $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/edit-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Displays inner form field on Quick Edit Term form
	 *
	 * @see Advanced_Term_Fields::show_custom_fields()
	 * @see Advanced_Term_Fields::quick_edit_form_field()
	 *
	 * @uses Advanced_Term_Fields::$file To include view.
	 * @uses Advanced_Term_Fields::$meta_key To populate field attributes.
	 *
	 * @access public
	 *
	 * @since 0.1.0
	 *
	 * @param string $column_name Name of the column to edit.
	 * @param string $screen	  The screen name.
	 * @param string $taxonomy	  Current taxonomy slug.
	 *
	 * @return void
	 */
	public function show_inner_field_qedit( $column_name = '' , $screen = '' , $taxonomy = '' )
	{
		ob_start();
		include dirname( $this->file ) . '/views/quick-form-field.php';
		$field = ob_get_contents();
		ob_end_clean();

		echo $field;
	}


	/**
	 * Filter terms listing in WP_Terms_List_Table table on edit-tags.php
	 *
	 * Adds the meta_query argument which tells WP to fire a new WP_Meta_Query() instance.
	 * This handles all the custom SQL queries needed to sort by meta value.
	 *
	 * We have to specifically call for terms that have the meta key set and those that don't, or
	 * else WP will only return terms with the meta_key.
	 *
	 * Note: WP_Terms_List_Table checks $_REQUEST['orderby'] and sets $args['orderby'] when
	 * displaying terms in wp-admin/edit-tags.php.
	 *
	 * Note: We have to override the order to sort by 'meta_value_num' since images are stored as
	 * IDs.
	 *
	 * @see 'get_terms_args' filter in get_terms() wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 *
	 * @param array  $args	   An array of terms query arguments.
	 * @param array  $taxonomies An array of taxonomies.
	 *
	 * @return array $args The filtered terms query arguments.
	 */
	function filter_terms_args( $args, $taxonomies )
	{
		global $pagenow;

		if( ! is_admin() || 'edit-tags.php' !== $pagenow ){
			return $args;
		}

		 // If we're not ordering by any of the allowed keys, return
		$orderby = ( ! empty( $args['orderby'] ) ) ? $args['orderby'] : '' ;
		if ( ! in_array( $orderby, $this->allowed_orderby_keys, true ) ) {
			return $args ;
		}

		// Set the meta query args
		$args['meta_key'] = $this->meta_key;
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'=>$this->meta_key,
				'compare' => 'EXISTS'
			),
			array(
				'key'=>$this->meta_key,
				'compare' => 'NOT EXISTS'
			)
		);

		$args['orderby'] = 'meta_value_num';

		return $args;
	}

}