/* global jQuery, l10n_ATF_Images, validateForm */

( function ($) {
	'use strict';

    /**
     * Globals
     */
    var thumb_modal;
    var set_link;
    var set_link_parent;
    var img_html;
    var del_link;
	var atf_tag_form = $('#addtag');


	/**
	 * Removes the delete link from the form
	 */
    function atfClearDeleteLink(parent) {
        $('.del-term-thumbnail', parent).remove();
    }

	/**
	 * Resets the meta key field to blank
	 */
    function atfResetThumbnailID(parent) {
        $(':input[name="' + l10n_ATF_Images.meta_key + '"]', parent).val('').trigger('atf_change');;
    }

	/**
	 * Removes the selected image from the form
	 */
    function atfRemoveSelectedThumb(el, parent) {
        $('img[data-term-img=' + el.data('term-img') + ']', parent).remove();
    }

	/**
	 * Resets the text of the set thumbnail link
	 */
    function atfResetSetLink(parent) {
        var sl = $('.set-term-thumbnail', parent);
        sl.addClass('button').html(sl.attr('title'));
    }

	/**
	 * Builds the img element for the selected thumbnail
	 */
    function atfBuildThumbnailHTML(image) {
        var img_html = '';
        if ('' !== image) {
            img_html = $('<img />').attr({
                'id': "term-img-" + image.id,
                'src': image.url,
                'class': 'term-feat-img',
                'data-term-img': image.id
            });
        }
        return img_html;
    }

	/**
	 * Builds the "delete thumbnail" link when an image is selected
	 */
    function atfBuildDeleteLinkHTML(image, set_link) {
        var link_html = '';
        if ('' !== image) {
            link_html = $('<a />').attr({
                'href': '#',
                'class': 'del-term-thumbnail',
                'data-term-img': image.id
            }).text(set_link.data('delete'));
        }
        return link_html;
    };

	/**
	 * Resets the Image form field
	 *
	 * Called after the Add Tag form has been submitted.
	 */
	function atfResetTagFormFeatImage( form ) {
		atfResetThumbnailID( form );
		atfResetSetLink( form );
		atfClearDeleteLink( form );
	};


    $('.set-term-thumbnail').on('click', function (e) {
        set_link = $(e.currentTarget);
        set_link_parent = set_link.closest('.inside');

        e.preventDefault();

        // Open the modal
        if (thumb_modal) {
            thumb_modal.open();
            return;
        }

        // Create the media frame.
        thumb_modal = wp.media.frames.thumb_modal = wp.media({
            title: set_link.data('choose'),
            library: {type: 'image'},
            button: {text: set_link.data('update')},
            multiple: false
        });


        // Picking an image
        thumb_modal.on('select', function () {

            // remove the existing delete link
            atfClearDeleteLink(set_link_parent);

            // Get the image
            var image = thumb_modal.state().get('selection').first().toJSON();

            if ('' !== image) {

                // build the thumbnail image
                img_html = atfBuildThumbnailHTML(image);

                //build the delete link
                del_link = atfBuildDeleteLinkHTML(image, set_link);

                // wrap the image in the set link
                set_link.removeClass('button').html(img_html).after(del_link);

                // set the meta value
                $(':input[name="' + l10n_ATF_Images.meta_key + '"]', set_link_parent).val(image.id).trigger('atf_change');

            }
        });

        // Open the modal
        thumb_modal.open();
    });


    /**
     * Deleting the thumbnail from the add form
     */
    $('#term-thumbnail-id-div').on('click', '.del-term-thumbnail', function (e) {
        e.preventDefault();
        var $el = $(e.currentTarget);
        var $parent = $el.closest('.inside');

        atfResetThumbnailID($parent);
        atfRemoveSelectedThumb($el, $parent);
        atfResetSetLink($parent);
        atfClearDeleteLink($parent);
    });


    /**
     * Deleting the thumbnail from the quick edit form
     */
    $('#the-list').on('click', '.del-term-thumbnail', function (e) {
        e.preventDefault();
        var $el = $(e.currentTarget);
        var $parent = $el.closest('.inside');

        atfResetThumbnailID($parent);
        atfRemoveSelectedThumb($el, $parent);
        atfResetSetLink($parent);
        atfClearDeleteLink($parent);
    });



    /**
     * Quick edit
     *
     * Note: the quick-edit form clones elements on open, so we have to delete them when we open
     * another
     */
    $('#the-list').on('click', '.editinline', function (e) {
        e.preventDefault();
        var tr_id = $(e.currentTarget).parents('tr').attr('id');
        var target_img = $('td.' + l10n_ATF_Images.custom_column_name + ' img', '#' + tr_id);
        var img_id;
        var img_src;
        var sl = $('.set-term-thumbnail', '.inline-edit-row');
        var sl_parent = sl.closest('.inside');
        var dl;
        var image = '';

        // if there's an image
        if (target_img.length > 0) {
            img_id = target_img.data('id');
            img_src = target_img.attr('src');
            image = {id: img_id, url: img_src};

            // remove the delete link
            atfClearDeleteLink(sl_parent);

            // build the thumbnail image
            img_html = atfBuildThumbnailHTML(image);

            //build the delete link
            dl = atfBuildDeleteLinkHTML(image, sl);

            // wrap the image in the set link
            sl.removeClass('button').html(img_html).after(dl);

        } else {
            atfResetSetLink(sl_parent);
            atfClearDeleteLink(sl_parent);
        }

        $(':input[name="' + l10n_ATF_Images.meta_key + '"]', '.inline-edit-row').val(img_id).trigger('atf_change');;
    });


	/**
	 * Resets the thumbnail fields
	 *
	 * Checks if the form has been submitted and if there's no ajax error message.
	 */
	$( '#tag-name', atf_tag_form ).on('blur', function(){
		var form = $(this).parents('form');
		if( form.hasClass('atf-submitted') &&  $('#ajax-response').html() == '' ) {
			atfResetTagFormFeatImage( form );
		}
	});


	/**
	 * Reset the featured image field after the form has been submitted
	 *
	 * Note: There is no easy way to check if the form has successfully submitted, since it's ajax-
	 * posted, no change events are fired on any form fields.
	 */
	$( '#submit', atf_tag_form).click( function(){
		var form = $(this).parents('form');

		if ( ! validateForm( form ) ) {
			form.removeClass('atf-submitted');
			return false;
		} else {
			form.addClass('atf-submitted');
		}
	});


})(jQuery);