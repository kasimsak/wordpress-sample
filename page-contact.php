<?php
/**
 * Contact Template
 *
 * @package Cordiace WP
 * @author Team Cordiace
 */

get_header();

get_template_part( 'template-parts/innerpage', 'banner' );

$primary_address_details = get_primary_contact_details();
$alternate_address_tiles = get_alternate_address_tiles();
?>

<section class="container" id="contact-section">
	<div class="row">
		<div class="col-md-4 primary-contact-details">
			<div class="primary-contact-inner">
				<div class="primary-cont-title">
					<h3><?php echo esc_html( get_theme_mod( 'address_primary_title' ) ); ?></h3>
				</div>

				<?php
				if ( ! empty( $primary_address_details ) ) :
					foreach ( $primary_address_details as $address ) :
						if ( empty( $address['value'] ) ) {
							continue;
						}
						get_template_part( 'template-parts/contact/primary', 'address-tile', $address );
					endforeach;
				endif;
				?>

			</div>
		</div>
		<div class="col-md-8 primary-contact-form-wrapper">
			<div class="primary-contact-form-inner">
				<h3>Write to us</h3>
				<div class="prim-cont-form">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							the_content();
						endwhile;
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="container my-5">

	<?php if ( ! empty( $alternate_address_tiles ) ) : ?>
		<div class="row d-flex flex-wrap">
			<?php foreach ( $alternate_address_tiles as $address ) : ?>
				<div class="col-md-4 address-container d-flex">
					<?php get_template_part( 'template-parts/contact/alternate', 'address-tiles', $address ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>

<?php
get_footer();
