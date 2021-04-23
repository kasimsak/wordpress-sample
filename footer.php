<?php

/**
 * The Footer
 *
 * This Page Displays the footer section of our theme
 *
 * @package WordPress
 * @subpackage fazaa
 * @author cordiace
 */

?>

<section class="page-section" id="contactUs">
	<div class="container-fluid">
		<div class="row no-gutters">
			<div class="container formContent">
				<!-- <h1><?php pll_e( 'Contact Us' ); ?></h1> -->
				<!--Form-->
				<div class="row no-gutters">
					<div class="col-lg-12">
						<div class="col-lg-4">
							<!-- Info Div -->
							<div class="infoForm rounded">
								<!--Phone-->
								<div class="form-group row">
									<div for="name" class="col-lg-4 col-sm-12 col-form-label"><?php pll_e( 'Phone' ); ?>:</div>
									<div class="col-lg-6 col-sm-12">
										<p><?php echo esc_html( get_theme_mod( 'phone_number' ) ); ?></p>
									</div>
								</div>
								<!-- Email-->
								<div class="form-group row">
									<div for="contact" class="col-lg-4 col-sm-12 col-form-label"><?php pll_e( 'E-mail' ); ?>:</div>
									<div class="col-lg-8 col-sm-12">
										<p><?php echo esc_html( get_theme_mod( 'email_id' ) ); ?></p>
									</div>
								</div>
							</div>
							<!--- FORM STARTS -->
							<?php
							$form_id = pll_current_language() === 'en' ? 199 : 5;
							echo do_shortcode( '[contact-form-7 id="' . $form_id . '" title="Contact Form 1" html_class="mt-1 rounded"]' );
							?>
						</div>
					</div>
				</div>
			</div>
			<!--MAP-->
			<iframe src="<?php echo esc_attr( get_theme_mod( 'map_source' ) ); ?>" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="location"></iframe>
		</div>
		<div class="container mt-6em">
			<!-- Download -->
			<div class="col-md-12 mt-5 <?php echo pll_current_language() === 'en' ? 'text-left' : 'text-right'; ?>">
				<a href="<?php echo get_theme_mod( 'app_store' ) ?? '#'; ?>" target="_blank" class="appImg">
					<img src="<?php echo esc_url( IR73_Helper::get_assets_url( 'images/app_store.jpg' ) ); ?>" alt="">
				</a>
				<a href="<?php echo get_theme_mod( 'play_store' ) ?? '#'; ?>" class="appImg">
					<img src="<?php echo esc_url( IR73_Helper::get_assets_url( 'images/android_store.jpg' ) ); ?>" alt="">
				</a>
				<a href="<?php echo get_theme_mod( 'app_gallery' ) ?? '#'; ?>" class="appImg">
					<img src="<?php echo esc_url( IR73_Helper::get_assets_url( 'images/huawei_store.jpg' ) ); ?>" alt="">
				</a>
				<?php
				$sidebar_id = pll_current_language() === 'en' ? 'sidebar-footer-1' : 'sidebar-footer-ar-1';
				if ( is_active_sidebar( $sidebar_id ) ) {
					dynamic_sidebar( $sidebar_id );
				}
				?>
			</div>
		</div>
	</div>
</section>

<?php wp_footer(); ?>

<script type="text/javascript">

	$(function() {
		$(".info>p").each(function() {
			var textMaxChar = 60;
			var text = $(this).text();

			length = text.split(' ').length;
			if (length > textMaxChar) {
				var lastWord = text.split(' ')[textMaxChar];
				var lastWordIndex = text.indexOf(lastWord);
				$(this).text(text.substr(0, lastWordIndex) + '...');
			}
		});
	});

	$(document).ready(function() {
		$(window).on('load', function() {

			window.addEventListener("scroll", (event) => {
				var scroll = this.scrollY;
				console.log(scroll);
			});

			let carouselOne = $('#carousel_1').owlCarousel({
				margin: 10,
				nav: true,
				responsiveClass: true,
				loop: true,
				<?php
				if ( pll_current_language() !== 'en' ) {
					?>
					rtl: true,
					<?php
				}
				?>
				responsive: {
					0: {
						items: 1,
						nav: true,
						dots: true
					},
					600: {
						items: 2,
						nav: true,
						dots: true
					},
					800: {
						items: 2,
						nav: true,
						dots: true
					},
					1000: {
						items: 4,
						nav: true,
						dots: true,
						loop: false
					}
				}
			});

			// Carousel

			$('#carousel_2').owlCarousel({
				margin: 10,
				nav: true,
				responsiveClass: true,
				loop: true,
				<?php
				if ( pll_current_language() !== 'en' ) {
					?>
					rtl: true,
					<?php
				}
				?>
				responsive: {
					0: {
						items: 1,
						nav: true,
						dots: true
					},
					600: {
						items: 2,
						nav: true,
						dots: true
					},
					800: {
						items: 2,
						nav: true,
						dots: true
					},
					1000: {
						items: 4,
						nav: true,
						dots: true,
						loop: false
					}
				}
			});
		});

		// $('.openFancyBox').on('click', function() {
		// 	var id = $(this).data("id")
		// 	$.fancybox.open($('#news' + id), {
		// 		touch: false,
		// 		infobar: false

		// 	});
		// });

		// window.addEventListener("scroll", (event) => {
		// 	var scroll = this.scrollY;
		// 	console.log(scroll);
		// });

		// Change Icon Colors
		<?php global $social_icons_color; ?>
		$('.social_icons').find('li a').css('color', "<?php echo esc_html( $social_icons_color ); ?>")

	});
</script>

</body>

</html>
