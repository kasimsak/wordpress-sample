<?php
/**
 * Cordiace WP - Customizations Goes Here
 *
 * @package Cordiace WP
 * @author Team Cordiace
 */

/**
 * Add Extra Attributes to Enqueued Stylesheets.
 *
 * @param string $html The link tag html targeted towards the DOM.
 * @param string $handle The id we used to enqueue the stylesheet.
 * @return string
 */
function add_extra_attributes_to_enqueued_css( $html, $handle ) {

	$search = "media='all'";

	if ( 'bootstrap' === $handle ) {
		return str_replace( $search, "media='all' integrity='sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2' crossorigin='anonymous'", $html );
	}

	if ( 'flexpanel' === $handle ) {
		return str_replace( $search, "media='screen'", $html );
	}

	if ( 'font-awesome' === $handle ) {
		return str_replace( $search, "media='all' integrity='sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==' crossorigin='anonymous'", $html );
	}

	return $html;

}

add_filter( 'style_loader_tag', 'add_extra_attributes_to_enqueued_css', 10, 2 );

/**
 * Fn to defer loading of css files. For SEO Purposes.
 *
 * @param string $html The link tag html targeted towards the DOM.
 * @param string $handle The id we / plugins used to enqueue the stylesheet.
 * @return string
 */
function defer_stylesheets( $html, $handle ) {

	// Defer CSS.
	$rel_needle   = "rel='stylesheet'";
	$rel_replace  = "rel='preload' as='style' onload='this.rel=\"stylesheet\"'";
	$css_to_defer = array(
		'wp-block-library',
		'wp-block-library-theme',
		'contact-form-7',
		'bootstrap',
		'font-awesome',
		'gfont-monteserrat',
		'recent-posts-widget-with-thumbnails-public-style',
		'heateor_sss_frontend_css',
		'heateor_sss_sharing_default_svg',
	);

	if ( in_array( $handle, $css_to_defer, true ) ) {
		return str_replace( $rel_needle, $rel_replace, $html );
	}

	return $html;

}

add_filter( 'style_loader_tag', 'defer_stylesheets', 10, 2 );

/**
 * Add Extra Attributes to Enqueued Scripts for the theme
 *
 * @param string $tag The HTML tag element to be inserted in the DOM.
 * @param string $handle The ID that we used to enqueue the script.
 * @return string
 */
function add_extra_attributes_to_enqueued_js( $tag, $handle ) {

	$search = '></script>';

	if ( 'jquery' === $handle ) {
		return str_replace( $search, " integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'" . $search, $tag );
	}

	if ( 'bootstrap-bundle' === $handle ) {
		return str_replace( $search, " integrity='sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx' crossorigin='anonymous'" . $search, $tag );
	}

	if ( 'font-awesome' === $handle ) {
		return str_replace( $search, " integrity='sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==' crossorigin='anonymous'" . $search, $tag );
	}

	return $tag;

}

add_filter( 'script_loader_tag', 'add_extra_attributes_to_enqueued_js', 10, 2 );

/**
 * Add Scripts Specific to a Page.
 *
 * @return string
 */
function add_page_specific_scripts() {

	if ( is_front_page() ) {
		return get_template_part( 'template-parts/scripts/front-page', 'scripts' );
	}

	if ( is_tax( 'service-category' ) ) {
		return get_template_part( 'template-parts/scripts/service-category', 'scripts' );
	}

}

add_action( 'wp_footer', 'add_page_specific_scripts', 100 );

/**
 * Primary Contact Deatils for the Contact page.
 *
 * @return array
 */
function get_primary_contact_details() : array {

	return array(
		array(
			'icon'  => 'map-marker-alt',
			'title' => 'OFFICE',
			'value' => get_theme_mod( 'address_primary' ),
		),
		array(
			'icon'  => 'phone',
			'title' => 'PHONE',
			'value' => get_theme_mod( 'phone_primary' ),
		),
		array(
			'icon'  => 'envelope',
			'title' => 'EMAIL ADDRESS',
			'value' => get_theme_mod( 'email_primary' ),
		),
		array(
			'icon'  => 'business-time',
			'title' => 'OPENING HOURS',
			'value' => get_theme_mod( 'working_hrs_primary' ),
		),
	);

}

/**
 * Get Service Categories with details.
 *
 * @return array
 */
function get_service_category_with_items() : array {

	$categories = get_terms(
		array(
			'taxonomy' => 'service-category',
			'meta_key' => 'ir73_order',
			'orderby'  => 'meta_value_num',
			'order'    => 'asc',
		)
	);

	$result = array();

	foreach ( $categories as $category ) {
		$posts = get_posts(
			array(
				'post_type'   => 'service',
				'numberposts' => -1,
				'tax_query'   => array(
					array(
						'taxonomy' => 'service-category',
						'field'    => 'slug',
						'terms'    => array( $category->slug ),
					),
				),
				'meta_key'    => 'ir73_order',
				'orderby'     => 'meta_value_num',
				'order'       => 'asc',
			)
		);
		$items = array(
			'title' => $category->name,
			'icon'  => get_field( 'service_icon', $category ),
			'url'   => get_term_link( $category->term_id ),
			'slug'  => $category->slug,
			'items' => $posts,
		);
		array_push( $result, $items );
	}

	return $result;

}

/**
 * To Print Dynamic Breadcrumb.
 *
 * @return void
 */
function print_breadcrumb() {
	?>
	<div class="breadcrumb-wrapper">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo esc_url( site_url() ); ?>">Home</a></li>
				<?php if ( is_page() ) : ?>
					<?php the_title( '<li class="breadcrumb-item active">', '</li>' ); ?>
				<?php elseif ( is_home() ) : ?>
					<li class="breadcrumb-item active">Insights</li>
				<?php elseif ( is_singular( 'post' ) ) : ?>
					<li class="breadcrumb-item"><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Insights</a></li>
					<?php the_title( '<li class="breadcrumb-item active">', '</li>' ); ?>
				<?php elseif ( is_singular( 'service' ) ) : ?>
					<?php $term = get_the_terms( get_the_ID(), 'service-category' )[0]; ?>
					<li class="breadcrumb-item active">
						<?php echo wp_kses_post( $term->name ); ?>
					</li>
				<?php elseif ( is_singular() ) : ?>
					<?php
					global $post;
					$post_type        = get_post_type( $post );
					$post_type_object = get_post_type_object( $post_type );
					?>
					<li class="breadcrumb-item">
						<a href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>">
							<?php echo wp_kses_post( $post_type_object->label ); ?>
						</a>
					</li>
					<?php the_title( '<li class="breadcrumb-item active">', '</li>' ); ?>
				<?php elseif ( is_tax() ) : ?>
					<li class="breadcrumb-item active">
						<?php echo wp_kses_post( get_queried_object()->name ); ?>
					</li>
				<?php endif; ?>
			</ol>
		</nav>
	</div>
	<?php
}
