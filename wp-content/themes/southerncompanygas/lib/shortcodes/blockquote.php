<?php
/**
 * Add an element to fusion-builder.
 *
 * @package fusion-builder
 * @since 1.0
 */

if ( ! class_exists( 'FusionSC_Blockquote' ) ) {
	/**
	 * Shortcode class.
	 *
	 * @since 1.0
	 */
	class FusionSC_Blockquote extends Fusion_Element {

		/**
		 * An array of the shortcode arguments.
		 *
		 * @access protected
		 * @since 1.0
		 * @var array
		 */
		protected $args;

		/**
		 * Constructor.
		 *
		 * @access public
		 * @since 1.0
		 */
		public function __construct() {
			parent::__construct();
			add_filter( 'fusion_attr_blockquote-shortcode', [ $this, 'attr' ] );
			add_filter( 'fusion_attr_blockquote-shortcode-heading', [ $this, 'heading_attr' ] );
			add_filter( 'fusion_attr_blockquote-shortcode-sep', [ $this, 'sep_attr' ] );

			add_shortcode( 'fusion_blockquote', [ $this, 'render' ] );

		}

		/**
		 * Gets the default values.
		 *
		 * @static
		 * @access public
		 * @since 2.0.0
		 * @return array
		 */
		public static function get_element_defaults() {

			global $fusion_settings;

			return [
				'hide_on_mobile'       => fusion_builder_default_visibility( 'string' ),
				'class'                => '',
				'id'                   => '',
				'content_align'        => 'left',
				'font_size'            => '',
				'letter_spacing'       => '',
				'line_height'          => '',
				'margin_bottom'        => $fusion_settings->get( 'blockquote_margin', 'bottom' ),
				'margin_bottom_mobile' => $fusion_settings->get( 'blockquote_margin_mobile', 'bottom' ),
				'margin_top'           => $fusion_settings->get( 'blockquote_margin', 'top' ),
				'margin_top_mobile'    => $fusion_settings->get( 'blockquote_margin_mobile', 'top' ),
				'size'                 => 1,
				'style_tag'            => '',
				'text_color'           => '',
			];
		}

		/**
		 * Maps settings to param variables.
		 *
		 * @static
		 * @access public
		 * @since 2.0.0
		 * @return array
		 */
		public static function settings_to_params() {
			return [
				'blockquote_margin[top]'           => 'margin_top',
				'blockquote_margin[bottom]'        => 'margin_bottom',
				'blockquote_margin_mobile[top]'    => 'margin_top_mobile',
				'blockquote_margin_mobile[bottom]' => 'margin_bottom_mobile',
				'blockquote_style_type'            => 'style_type',
			];
		}

		/**
		 * Used to set any other variables for use on front-end editor template.
		 *
		 * @static
		 * @access public
		 * @since 2.0.0
		 * @return array
		 */
		public static function get_element_extras() {
			$fusion_settings = fusion_get_fusion_settings();
			return [
				'content_break_point' => $fusion_settings->get( 'content_break_point' ),
			];
		}

		/**
		 * Maps settings to extra variables.
		 *
		 * @static
		 * @access public
		 * @since 2.0.0
		 * @return array
		 */
		public static function settings_to_extras() {

			return [
				'content_break_point' => 'content_break_point',
			];
		}

		/**
		 * Render the shortcode
		 *
		 * @access public
		 * @since 1.0
		 * @param  array  $args    Shortcode parameters.
		 * @param  string $content Content between shortcode.
		 * @return string          HTML output.
		 */
		public function render( $args, $content = '' ) {

			global $fusion_settings;

			$defaults = FusionBuilder::set_shortcode_defaults( self::get_element_defaults(), $args, 'fusion_blockquote' );
			$defaults = apply_filters( 'fusion_builder_default_args', $defaults, 'fusion_blockquote', $args );

			$defaults['margin_top']           = FusionBuilder::validate_shortcode_attr_value( $defaults['margin_top'], 'px' );
			$defaults['margin_bottom']        = FusionBuilder::validate_shortcode_attr_value( $defaults['margin_bottom'], 'px' );
			$defaults['margin_top_mobile']    = FusionBuilder::validate_shortcode_attr_value( $defaults['margin_top_mobile'], 'px' );
			$defaults['margin_bottom_mobile'] = FusionBuilder::validate_shortcode_attr_value( $defaults['margin_bottom_mobile'], 'px' );

			extract( $defaults );

			$this->args = $defaults;

			if ( 1 === count( explode( ' ', $this->args['style_type'] ) ) ) {
				$style_type .= ' solid';
			}

			if ( ! $this->args['style_type'] || 'default' === $this->args['style_type'] ) {
				$this->args['style_type'] = $style_type = $fusion_settings->get( 'blockquote_style_type' );
			}

			// Make sure the title text is not wrapped with an unattributed p tag.
			$content = preg_replace( '!^<p>(.*?)</p>$!i', '$1', trim( $content ) );

			if ( false !== strpos( $style_type, 'underline' ) || false !== strpos( $style_type, 'none' ) ) {

				$html = sprintf(
					'<blockquote %s><h%s %s>%s</h%s></blockquote>',
					FusionBuilder::attributes( 'blockquote-shortcode' ),
					$size,
					FusionBuilder::attributes( 'blockquote-shortcode-heading' ),
					do_shortcode( $content ),
					$size
				);

			} else {

				if ( 'right' === $this->args['content_align'] ) {

					$html = sprintf(
						'<blockquote %s><h%s %s>%s</h%s></blockquote>',
						FusionBuilder::attributes( 'blockquote-shortcode' ),
						$size,
						FusionBuilder::attributes( 'blockquote-shortcode-heading' ),
						do_shortcode( $content ),
						$size
					);
				} elseif ( 'center' === $this->args['content_align'] ) {

					$html = sprintf(
						'<blockquote %s><h%s %s>%s</h%s></blockquote>',
						FusionBuilder::attributes( 'blockquote-shortcode' ),
						$size,
						FusionBuilder::attributes( 'blockquote-shortcode-heading' ),
						do_shortcode( $content ),
						$size
					);

				} else {

					$html = sprintf(
						'<blockquote %s><h%s %s>%s</h%s></blockquote>',
						FusionBuilder::attributes( 'blockquote-shortcode' ),
						$size,
						FusionBuilder::attributes( 'blockquote-shortcode-heading' ),
						do_shortcode( $content ),
						$size
					);
				}
			}

			$style = '';
			if ( ! ( '' === $this->args['margin_top_mobile'] && '' === $this->args['margin_bottom_mobile'] ) && ! ( '0px' === $this->args['margin_top_mobile'] && '20px' === $this->args['margin_bottom_mobile'] ) ) {
				$style  = '<style type="text/css">';
				$style .= '@media only screen and (max-width:' . $fusion_settings->get( 'content_break_point' ) . 'px) {';
				$style .= '.fusion-blockquote{margin-top:' . $defaults['margin_top_mobile'] . '!important;margin-bottom:' . $defaults['margin_bottom_mobile'] . '!important;}';
				$style .= '}';
				$style .= '</style>';
			}

			$html = $style . $html;

			return $html;

		}

		/**
		 * Builds the attributes array.
		 *
		 * @access public
		 * @since 1.0
		 * @return array
		 */
		public function attr() {

			$attr = fusion_builder_visibility_atts(
				$this->args['hide_on_mobile'],
				[
					'class' => 'fusion-blockquote blockquote',
					'style' => '',
				]
			);

			if ( 'center' === $this->args['content_align'] ) {
				$attr['class'] .= ' fusion-title-center';
			}

			$title_size = 'two';
			if ( '1' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'one';
			} elseif ( '2' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'two';
			} elseif ( '3' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'three';
			} elseif ( '4' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'four';
			} elseif ( '5' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'five';
			} elseif ( '6' == $this->args['size'] ) { // phpcs:ignore WordPress.PHP.StrictComparisons
				$title_size = 'six';
			}

			$attr['class'] .= ' fusion-title-size-' . $title_size;

			if ( $this->args['font_size'] ) {
				$attr['style'] .= 'font-size:' . fusion_library()->sanitize->get_value_with_unit( $this->args['font_size'] ) . ';';
			}

			if ( $this->args['margin_top'] ) {
				$attr['style'] .= 'margin-top:' . $this->args['margin_top'] . ';';
			}

			if ( $this->args['margin_bottom'] ) {
				$attr['style'] .= 'margin-bottom:' . $this->args['margin_bottom'] . ';';
			}

			if ( '' === $this->args['margin_top'] && '' === $this->args['margin_bottom'] ) {
				$attr['style'] .= ' margin-top:0px; margin-bottom:0px';
				$attr['class'] .= ' fusion-title-default-margin';
			}

			if ( $this->args['class'] ) {
				$attr['class'] .= ' ' . $this->args['class'];
			}
			
			$attr['style'] .= ' background-color: transparent !important; border: none !important;';

			if ( $this->args['id'] ) {
				$attr['id'] = $this->args['id'];
			}

			return $attr;

		}

		/**
		 * Builds the heading attributes array.
		 *
		 * @access public
		 * @since 1.0
		 * @return array
		 */
		public function heading_attr() {

			$attr = [
				'class' => 'title-heading-' . $this->args['content_align'],
				'style' => '',
			];

			if ( '' !== $this->args['margin_top'] || '' !== $this->args['margin_bottom'] ) {
				$attr['style'] .= 'margin:0;';
			}

			if ( $this->args['font_size'] ) {
				$attr['style'] .= 'font-size:1em;';
			}

			if ( $this->args['text_color'] ) {
				$attr['style'] .= 'color:' . fusion_library()->sanitize->color( $this->args['text_color'] ) . ';';
			}

			if ( $this->args['style_tag'] ) {
				$attr['style'] .= $this->args['style_tag'];
			}

			return $attr;

		}

		/**
		 * Builds the dynamic styling.
		 *
		 * @access public
		 * @since 1.1
		 * @return array
		 */
		public function add_styling() {

			global $wp_version, $content_media_query, $six_fourty_media_query, $three_twenty_six_fourty_media_query, $ipad_portrait_media_query, $fusion_settings, $dynamic_css_helpers;

			$main_elements = apply_filters( 'fusion_builder_element_classes', [ '.fusion-blockquote' ], '.fusion-blockquote' );
			$top_margin    = fusion_library()->sanitize->size( $fusion_settings->get( 'blockquote_margin_mobile', 'top' ) ) . '!important';
			$bottom_margin = fusion_library()->sanitize->size( $fusion_settings->get( 'blockquote_margin_mobile', 'bottom' ) ) . '!important';

			$css[ $content_media_query ][ $dynamic_css_helpers->implode( $main_elements ) ]['margin-top']          = $top_margin;
			$css[ $content_media_query ][ $dynamic_css_helpers->implode( $main_elements ) ]['margin-bottom']       = $bottom_margin;
			$css[ $ipad_portrait_media_query ][ $dynamic_css_helpers->implode( $main_elements ) ]['margin-top']    = $top_margin;
			$css[ $ipad_portrait_media_query ][ $dynamic_css_helpers->implode( $main_elements ) ]['margin-bottom'] = $bottom_margin;

			return $css;

		}

		/**
		 * Adds settings to element options panel.
		 *
		 * @access public
		 * @since 1.1
		 * @return array $sections Title settings.
		 */
		public function add_options() {

			return [
				'blockquote_shortcode_section' => [
					'label'       => esc_html__( 'Blockquote', 'fusion-builder' ),
					'description' => '',
					'id'          => 'blockquote_shortcode_section',
					'type'        => 'accordion',
					'icon'        => 'fusiona-H',
					'fields'      => [
						'blockquote_margin'        => [
							'label'       => esc_html__( 'Blockquote Top/Bottom Margins', 'fusion-builder' ),
							'description' => esc_html__( 'Controls the top/bottom margin of the blockquotes. Leave empty to use corresponding heading margins.', 'fusion-builder' ),
							'id'          => 'blockquote_margin',
							'default'     => [
								'top'    => '0px',
								'bottom' => '30px',
							],
							'transport'   => 'postMessage',
							'type'        => 'spacing',
							'choices'     => [
								'top'    => true,
								'bottom' => true,
							],
						],
						'blockquote_margin_mobile' => [
							'label'       => esc_html__( 'Blockquote Mobile Top/Bottom Margins', 'fusion-builder' ),
							'description' => esc_html__( 'Controls the top/bottom margin of the blockquotes on mobiles. Leave empty together with desktop margins to use corresponding heading margins.', 'fusion-builder' ),
							'id'          => 'blockquote_margin_mobile',
							'transport'   => 'postMessage',
							'default'     => [
								'top'    => '0px',
								'bottom' => '20px',
							],
							'type'        => 'spacing',
							'choices'     => [
								'top'    => true,
								'bottom' => true,
							],
						],
					],
				],
			];
		}

		/**
		 * Sets the necessary scripts.
		 *
		 * @access public
		 * @since 1.1
		 * @return void
		 */
		public function add_scripts() {

			Fusion_Dynamic_JS::enqueue_script(
				'fusion-blockquote',
				get_stylesheet_directory() . '/lib/js/min/fusion-blockquote-min.js',
				get_stylesheet_directory() . '/lib/js/min/fusion-blockquote-min.js',
				array( 'jquery' ),
				'1',
				true
			);

		}
	}
}

new FusionSC_Blockquote();

/**
 * Map shortcode to Fusion Builder.
 *
 * @since 1.0
 */
function fusion_element_blockquote() {

	global $fusion_settings;

	fusion_builder_map(
		fusion_builder_frontend_data(
			'FusionSC_Blockquote',
			[
				'name'            => esc_attr__( 'Blockquote', 'fusion-builder' ),
				'shortcode'       => 'fusion_blockquote',
				'icon'            => 'fusiona-H',
		        'preview'         =>  get_stylesheet_directory() . '/lib/previews/fusion-blockquote-preview.php',
		        'preview_id'      => 'fusion-builder-blockquote-preview',
				'allow_generator' => true,
				'inline_editor'   => true,
				'params'          => [
					[
						'type'        => 'tinymce',
						'heading'     => esc_attr__( 'Blockquote', 'fusion-builder' ),
						'description' => esc_attr__( 'Insert the blockquote text.', 'fusion-builder' ),
						'param_name'  => 'element_content',
						'value'       => esc_attr__( 'Your Content Goes Here', 'fusion-builder' ),
						'placeholder' => true,
					],
					[
						'type'        => 'radio_button_set',
						'heading'     => esc_attr__( 'Blockquote Alignment', 'fusion-builder' ),
						'description' => esc_attr__( 'Choose to align the blockquote left or right.', 'fusion-builder' ),
						'param_name'  => 'content_align',
						'value'       => [
							'left'   => esc_attr__( 'Left', 'fusion-builder' ),
							'center' => esc_attr__( 'Center', 'fusion-builder' ),
							'right'  => esc_attr__( 'Right', 'fusion-builder' ),
						],
						'default'     => 'left',
						'group'       => esc_attr__( 'Design', 'fusion-builder' ),
					],
					[
						'type'        => 'colorpickeralpha',
						'heading'     => esc_attr__( 'Font Color', 'fusion-builder' ),
						/* translators: URL for the link. */
						'description' => sprintf( esc_html__( 'Controls the color of the title, ex: #000. Leave empty if the global color for the corresponding heading size (h1-h6) should be used: %s.', 'fusion-builder' ), $to_link ),
						'param_name'  => 'text_color',
						'value'       => '',
						'default'     => $fusion_settings->get( 'content_box_title_color' ),
						'group'       => esc_attr__( 'Design', 'fusion-builder' ),
					],
					[
						'type'        => 'radio_button_set',
						'heading'     => esc_attr__( 'HTML Blockquote Size', 'fusion-builder' ),
						'description' => esc_attr__( 'Choose the size of the HTML heading that should be used, h1-h6.', 'fusion-builder' ),
						'param_name'  => 'size',
						'value'       => [
							'1' => 'H1',
							'2' => 'H2',
							'3' => 'H3',
							'4' => 'H4',
							'5' => 'H5',
							'6' => 'H6',
						],
						'default'     => '1',
						'group'       => esc_attr__( 'Design', 'fusion-builder' ),
					],
					[
						'type'        => 'textfield',
						'heading'     => esc_attr__( 'Font Size', 'fusion-builder' ),
						/* translators: URL for the link. */
						'description' => sprintf( esc_html__( 'Controls the font size of the title. Enter value including any valid CSS unit, ex: 20px. Leave empty if the global font size for the corresponding heading size (h1-h6) should be used: %s.', 'fusion-builder' ), $to_link ),
						'param_name'  => 'font_size',
						'value'       => '',
						'group'       => esc_attr__( 'Design', 'fusion-builder' ),
					],
					[
						'type'             => 'dimension',
						'heading'          => esc_attr__( 'Margin', 'fusion-builder' ),
						'description'      => esc_attr__( 'Spacing above and below the title. In px, em or %, e.g. 10px.', 'fusion-builder' ),
						'param_name'       => 'dimensions',
						'value'            => [
							'margin_top'    => '',
							'margin_bottom' => '',
						],
						'group'            => esc_attr__( 'Design', 'fusion-builder' ),
						'remove_from_atts' => true,
					],
					[
						'type'             => 'dimension',
						'heading'          => esc_attr__( 'Mobile Margin', 'fusion-builder' ),
						'description'      => esc_attr__( 'Spacing above and below the title on mobiles. In px, em or %, e.g. 10px.', 'fusion-builder' ),
						'param_name'       => 'margin_mobile',
						'value'            => [
							'margin_top_mobile'    => '',
							'margin_bottom_mobile' => '',
						],
						'group'            => esc_attr__( 'Design', 'fusion-builder' ),
						'remove_from_atts' => true,
					],
					[
						'type'        => 'checkbox_button_set',
						'heading'     => esc_attr__( 'Element Visibility', 'fusion-builder' ),
						'param_name'  => 'hide_on_mobile',
						'value'       => fusion_builder_visibility_options( 'full' ),
						'default'     => fusion_builder_default_visibility( 'array' ),
						'description' => esc_attr__( 'Choose to show or hide the element on small, medium or large screens. You can choose more than one at a time.', 'fusion-builder' ),
					],
					[
						'type'        => 'textfield',
						'heading'     => esc_attr__( 'CSS Class', 'fusion-builder' ),
						'param_name'  => 'class',
						'value'       => '',
						'description' => esc_attr__( 'Add a class to the wrapping HTML element.', 'fusion-builder' ),
					],
					[
						'type'        => 'textfield',
						'heading'     => esc_attr__( 'CSS ID', 'fusion-builder' ),
						'param_name'  => 'id',
						'value'       => '',
						'description' => esc_attr__( 'Add an ID to the wrapping HTML element.', 'fusion-builder' ),
					],
				],
			]
		)
	);
}
add_action( 'fusion_builder_before_init', 'fusion_element_blockquote' );
