<?php
/**
 * Underscore.js template.
 *
 * @package fusion-builder
 */

?>
<script type="text/template" id="fusion-builder-recent-posts-carousel-preview">
	<h4 class="fusion_module_title"><span class="fusion-module-icon {{ fusionAllElements[element_type].icon }}"></span>{{ fusionAllElements[element_type].name }}</h4>
	<#
	var categories = ( null === params.cat_slug || '' === params.cat_slug ) ? 'All' : params.cat_slug;
	var tags = ( null === params.tag_slug || '' === params.tag_slug ) ? 'All' : params.tag_slug;
	#>
	<# if ( 'tag' === params.pull_by ) { #>
		<?php /* translators: The tags. */ ?>
		<?php printf( esc_html__( 'tags = %s', 'fusion-builder' ), '{{ tags }}' ); ?>
	<# } else { #>
		<?php /* translators: The categories. */ ?>
		<?php printf( esc_html__( 'categories = %s', 'fusion-builder' ), '{{ categories }}' ); ?>
	<# } #>
</script>