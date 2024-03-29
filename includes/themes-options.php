<?php
/**
 * Create A Simple Theme Options Panel
 *
 */



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Theme_Options' ) ) {

	class WPEX_Theme_Options {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
			}

		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Theme Settings', 'jjp_themes' ),
				esc_html__( 'Theme Settings', 'jjp_themes' ),
				'manage_options',
				'theme-settings',
				array( 'WPEX_Theme_Options', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				// Input
				if ( ! empty( $options['themes_keyword'] ) ) {
					$options['themes_keyword'] = sanitize_text_field( $options['themes_keyword'] );
				} else {
					unset( $options['themes_keyword'] ); // Remove from options if empty
				}

				// Input
				if ( ! empty( $options['themes_header_color'] ) ) {
					$options['themes_header_color'] = sanitize_text_field( $options['themes_header_color'] );
				} else {
					unset( $options['themes_header_color'] ); // Remove from options if empty
				}

			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<style media="screen">

      .CodeMirror {background: #f8f8f8;}

				#themes_header {
					background: #c9c9c9;
					padding: 30px;
					margin-bottom: 30px;
					border-radius: 8px;
				}

				.wp-picker-holder {
					position: absolute;
				}

				#meta-image_secondary-preview,
				#meta-image-preview {
					width: 100%;
					max-width: 300px;
					height: auto;
					margin: 20px 0;
				}
			</style>
      <?php
            // jQuery
            wp_enqueue_script('jquery');
            // This will enqueue the Media Uploader script
            wp_enqueue_media();

						// first check that $hook_suffix is appropriate for your admin page
						wp_enqueue_style( 'wp-color-picker' );
					 	wp_enqueue_script( 'my-script-handle', get_template_directory_uri() . '/includes/js/my-script.js', array('wp-color-picker'), false, true  );


					 wp_enqueue_style('thickbox');
					 wp_enqueue_script('media-upload');
					 wp_register_script('my-custom-media-upload', get_bloginfo("template_url") .
							 '/includes/js/my-script.js', array('jquery','media-upload','thickbox'));
					 wp_enqueue_script('thickbox');

					 wp_enqueue_script( 'js-codemirror', get_template_directory_uri() . '/includes/js/codemirror.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-javascript', get_template_directory_uri() . '/includes/js/javascript.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-active-line', get_template_directory_uri() . '/includes/js/active-line.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-matchbrackets', get_template_directory_uri(). '/includes/js/matchbrackets.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-css', get_template_directory_uri(). '/includes/js/css.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-show-hint', get_template_directory_uri(). '/includes/js/show-hint.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-css-hint', get_template_directory_uri(). '/includes/js/css-hint.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-selection-pointer', get_template_directory_uri(). '/includes/js/selection-pointer.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-xml', get_template_directory_uri(). '/includes/js/xml.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-vbscript', get_template_directory_uri(). '/includes/js/vbscript.js', array('jquery'), THEME_VERSION , TRUE );
					 wp_enqueue_script( 'js-htmlmixed', get_template_directory_uri(). '/includes/js/htmlmixed.js', array('jquery'), THEME_VERSION , TRUE );

					 wp_enqueue_style( 'codemirror', get_template_directory_uri() . '/includes/css/codemirror.css', array(), THEME_VERSION );
					 wp_enqueue_style( 'show-hint', get_template_directory_uri() . '/includes/css/show-hint.css', array(), THEME_VERSION );
					 wp_enqueue_style( 'css-material', get_template_directory_uri() . '/includes/css/material.css', array(), THEME_VERSION );


      ?>

			<div class="wrap">

				<div id="themes_header">
					<h1><strong><?php esc_html_e( 'Theme Options', 'jjp_themes' ); ?></strong></h1>
					<?php
						$title = get_bloginfo('title');
						echo '<h1>'. $title . ' </h1>';
            echo 'Version :'. THEME_VERSION;
					 ?>
				</div>

				<form method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>

					<table class="form-table wpex-custom-admin-login-table">


						<?php // LOGO ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Logo', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_logo = self::get_theme_option( 'themes_logo' ); ?>
								<input class="button button-small " id="logo_file_button" type="button" name="theme_options[themes_logo]" value="Upload File" />
								<input class="set_item_text" id="logo_file" name="theme_options[themes_logo]" type="hidden" value="<?php echo esc_attr( $themes_logo ); ?>" />

								<div class="clear"></div>
								<img id="meta-image-preview" src="<?php echo esc_attr( $themes_logo ); ?>" alt="">
								<div class="clear"></div>
								<?php if (!empty($themes_logo)): ?>
									<a href="#" id="remove_logo_file">Remove Logo</a>
								<?php endif; ?>

							</td>
						</tr>

						<?php // LOGO Secondary ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Logo secondary', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_logo_secondary = self::get_theme_option( 'themes_logo_secondary' ); ?>
								<input class="button button-small " id="logo_secondary_file_button" type="button" name="theme_options[themes_logo_secondary]" value="Upload File" />
								<input class="set_item_text" id="logo_secondary_file" name="theme_options[themes_logo_secondary]" type="hidden" value="<?php echo esc_attr( $themes_logo_secondary ); ?>" />

								<div class="clear"></div>
								<img id="meta-image_secondary-preview" src="<?php echo esc_attr( $themes_logo_secondary ); ?>" alt="">
								<div class="clear"></div>
								<?php if (!empty($themes_logo_secondary)): ?>
									<a href="#" id="remove_logo_secondary_file">Remove Logo</a>
								<?php endif; ?>

							</td>
						</tr>



						<?php // Header Color ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Header Color', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_header_color = self::get_theme_option( 'themes_header_color' ); ?>
								<input type="text" name="theme_options[themes_header_color]" value="<?php echo esc_attr( $themes_header_color ); ?>" class="my-color-field"  data-default-color="#effeff"  />
                <p class="description">The color of themes header color.</p>
							</td>
						</tr>

					</table>


					<br>

					<hr>
					<h2><strong><?php esc_html_e( 'SEO', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
						<?php // KEYWORD ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'KeyWord', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_keyword = self::get_theme_option( 'themes_keyword' ); ?>
								<textarea name="theme_options[themes_keyword]" rows="5" cols="80"><?php echo esc_attr( $themes_keyword ); ?></textarea>
								<p class="description">The meta description tag is a brief and concise summary of your page's content.</p>
							</td>
						</tr>


						<?php // Description ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Description', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_description = self::get_theme_option( 'themes_description' ); ?>
								<textarea name="theme_options[themes_description]" rows="5" cols="80"><?php echo esc_attr( $themes_description); ?></textarea>
							</td>
						</tr>

					</table>

					<br>

					<hr>
					<h2><strong><?php esc_html_e( 'Social Media', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
						<?php // Twitter ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Twitter', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_twitter = self::get_theme_option( 'themes_twitter' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_twitter]" value="<?php echo esc_attr( $themes_twitter ); ?>">
							</td>
						</tr>

						<?php // Facebook ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Facebook', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_facebook = self::get_theme_option( 'themes_facebook' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_facebook]" value="<?php echo esc_attr( $themes_facebook ); ?>">
							</td>
						</tr>

						<?php // Instagram ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Instagram', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_instagram= self::get_theme_option( 'themes_instagram' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_instagram]" value="<?php echo esc_attr( $themes_instagram ); ?>">
							</td>
						</tr>

						<?php // Youtube ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Youtube', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_youtube = self::get_theme_option( 'themes_youtube' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_youtube]" value="<?php echo esc_attr( $themes_youtube ); ?>">
							</td>
						</tr>

						<?php // Linkedin ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Linkedin', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_linkedin = self::get_theme_option( 'themes_linkedin' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_linkedin]" value="<?php echo esc_attr( $themes_linkedin ); ?>">
							</td>
						</tr>

						<?php // spotify ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Spotify', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_spotify = self::get_theme_option( 'themes_spotify' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_spotify]" value="<?php echo esc_attr( $themes_spotify ); ?>">
							</td>
						</tr>
					</table>

					<br>

					<hr>
					<h2><strong><?php esc_html_e( 'Custom Code', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
            <?php // JS ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'JS', 'jjp_themes' ); ?></th>
							<td>
                <?php $themes_js = self::get_theme_option( 'themes_js' ); ?>
                <textarea id="themes_js" name="theme_options[themes_js]"><?php echo esc_attr( $themes_js ); ?></textarea>
                <p class="description">Add custom JavaScript</p>
							</td>
						</tr>

            <?php // CSS ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'CSS', 'jjp_themes' ); ?></th>
							<td>
                <?php $themes_css = self::get_theme_option( 'themes_css' ); ?>
                <textarea id="themes_css" name="theme_options[themes_css]"><?php echo esc_attr( $themes_css ); ?></textarea>
                <p class="description">Add custom CSS</p>
							</td>
						</tr>

            <?php // Analytics ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Mix', 'jjp_themes' ); ?></th>
							<td>
                <?php $themes_mix = self::get_theme_option( 'themes_mix' ); ?>
                <textarea id="themes_analytics" name="theme_options[themes_mix]"><?php echo esc_attr( $themes_mix ); ?></textarea>
                <p class="description">Add HTML MIX</p>
							</td>
						</tr>
					</table>

					<br>

					<hr>
					<h2><strong><?php esc_html_e( 'Address', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
						<?php // address ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Address', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_address = self::get_theme_option( 'themes_address' ); ?>
								<?php wp_editor( $themes_address, 'theme_options[themes_address]', array( 'textarea_rows' =>5,	'media_buttons' => false,	'tinymce'          => array(
								'wp_autoresize_on'      => true,
								'wpautop'               => false,
								'toolbar1'              => 'bold,italic,underline,link,unlink,bullist',
								'toolbar2'              => '',
							),) ); ?>
							</td>
						</tr>


						<?php // Telephone ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Telephone', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_telephone = self::get_theme_option( 'themes_telephone' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_telephone]" value="<?php echo esc_attr( $themes_telephone ); ?>">
							</td>
						</tr>

						<?php // Email ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Email', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_email = self::get_theme_option( 'themes_email' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_email]" value="<?php echo esc_attr( $themes_email ); ?>">
							</td>
						</tr>
					</table>

				
					<hr>
					<h2><strong><?php esc_html_e( 'Hero Banner', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
						<?php // Category News Updates ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Banner News Updates', 'jjp_themes' ); ?></th>
							<td>
								<?php $hero_banner_news_updates = self::get_theme_option( 'hero_banner_news_updates' ); ?>
								<input class="button button-small " id="hero_banner_news_updates_file_button" type="button" name="theme_options[hero_banner_news_updates]" value="Upload File" />
								<input class="set_item_text" id="hero_banner_news_updates_file" name="theme_options[hero_banner_news_updates]" type="hidden" value="<?php echo esc_attr( $hero_banner_news_updates ); ?>" />

								<div class="clear"></div>
								<img id="meta-image_hero_banner_news_updates-preview" src="<?php echo esc_attr( $hero_banner_news_updates ); ?>" alt="" style="width:300px;margin: 30px 0;">
								<div class="clear"></div>
								<?php if (!empty($hero_banner_news_updates)): ?>
									<a href="#" id="remove_logo_hero_banner_news_updates_file">Remove Hero Banner</a>
								<?php endif; ?>

							</td>
						</tr>
					</table>
					
					
					<hr>
					<h2><strong><?php esc_html_e( 'Copyright', 'jjp_themes' ); ?></strong></h2>
					<hr>

					<table class="form-table wpex-custom-admin-login-table">
						<?php // Copyright ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Copyright Text', 'jjp_themes' ); ?></th>
							<td>
								<?php $themes_copy = self::get_theme_option( 'themes_copy' ); ?>
								<input class="regular-text" type="text" name="theme_options[themes_copy]" value="<?php echo esc_attr( $themes_copy ); ?>">
							</td>
						</tr>
					</table>

					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->
		<?php }

	}
}
new WPEX_Theme_Options();

// Helper function to use in your theme to return a theme option value
function myprefix_get_theme_option( $id = '' ) {
	return WPEX_Theme_Options::get_theme_option( $id );
}
