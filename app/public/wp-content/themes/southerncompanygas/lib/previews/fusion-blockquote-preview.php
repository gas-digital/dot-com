<?php
/**
 * Underscore.js template.
 *
 * @package fusion-builder
 */

$fusion_settings     = fusion_get_fusion_settings();
?>
<script type="text/template" id="fusion-builder-blockquote-preview">

	<div class="fusion-blockquote-preview">
		<#
		var style_type = ( params.style_type ) ? params.style_type.replace( ' ', '_' ) : 'default';
		var
		content = params.element_content,
		text_blocks       = jQuery.parseHTML( content ),
		shortcode_content = '',
		text_color        = params.text_color,
		styleTag          = '';

		if ( text_color && ( -1 !== text_color.replace( /\s/g, '' ).indexOf( 'rgba(255,255,255' ) || '#ffffff' === text_color ) ) {
			text_color = '#dddddd';
		}

		jQuery(text_blocks).each(function() {
			shortcode_content += jQuery(this).text();
		});

		var align = 'align-' + params.content_align;

		if ( text_color ) {
			styleTag += 'color: ' + text_color + ';';
		}
		#>

		<span class="{{ style_type }}" style="{{{ styleTag }}}"><sub class="title_text {{ align }}">{{ shortcode_content }}</sub></span>
	</div>

</script>
