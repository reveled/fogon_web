<?php
/**
 * Crafto AI Helper.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If class `Crafto_Builder_Helper` doesn't exists yet.
if ( ! class_exists( 'Crafto_AI_Helper' ) ) {
	/**
	 * Define `Crafto_AI_Helper` class
	 */
	class Crafto_AI_Helper {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp_ajax_get_modal_ai_image_html', array( $this, 'get_modal_ai_image_html' ) );
			add_action( 'wp_ajax_nopriv_get_modal_ai_image_html', array( $this, 'get_modal_ai_image_html' ) );

			add_action( 'wp_ajax_upload_ai_image', array( $this, 'crafto_upload_ai_image' ) );
			add_action( 'wp_ajax_nopriv_upload_ai_image', array( $this, 'crafto_upload_ai_image' ) );

			add_action( 'wp_ajax_crafto_generate_openai_text', array( $this, 'crafto_generate_openai_text' ) );
			add_action( 'wp_ajax_nopriv_crafto_generate_openai_text', array( $this, 'crafto_generate_openai_text' ) );

			add_action( 'wp_ajax_get_modal_ai_content_html', array( $this, 'get_modal_ai_content_html' ) );
			add_action( 'wp_ajax_nopriv_get_modal_ai_content_html', array( $this, 'get_modal_ai_content_html' ) );

			add_action( 'wp_ajax_crafto_generate_openai_chat', array( $this, 'crafto_generate_openai_chat' ) );
			add_action( 'wp_ajax_nopriv_crafto_generate_openai_chat', array( $this, 'crafto_generate_openai_chat' ) );

			add_action( 'wp_ajax_get_attachment_url', array( $this, 'crafto_get_attachment_url' ) );
			add_action( 'wp_ajax_nopriv_get_attachment_url', array( $this, 'crafto_get_attachment_url' ) );

			add_action( 'wp_ajax_generate_ai_image', array( $this, 'crafto_generate_ai_image_api' ) );
			add_action( 'wp_ajax_nopriv_generate_ai_image', array( $this, 'crafto_generate_ai_image_api' ) );

			add_action( 'admin_footer', array( $this, 'crafto_post_ai_template' ) );

			add_action( 'wp_ajax_crafto_ai_post_actions', array( $this, 'post_actions' ) );
			add_action( 'wp_ajax_nopriv_crafto_ai_post_actions', array( $this, 'post_actions' ) );

			add_action( 'wp_ajax_crafto_ai_update_post', array( $this, 'update_post' ) );
			add_action( 'wp_ajax_nopriv_crafto_ai_update_post', array( $this, 'update_post' ) );
		}

		/**
		 * Function to generate OpenAI Text HTML.
		 */
		public function get_modal_ai_image_html() {
			ob_start();
			?>
			<div id="crafto_ai_image_modal" class="crafto-ai-image-modal">
				<div class="crafto-ai-image-modal-content">
					<div class="crafto-ai-image-template-header">
						<div class="logo">
							<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-image-creator.svg' ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'ai-post-logo', 'crafto-addons' ); ?>">
						</div>
						<div class="close-icon">
							<span><i class="bi bi-x"></i></span>
						</div>
					</div>
					<div class="crafto-ai-image-template-content">
						<div class="form-field">
							<label for="prompt"><?php echo esc_html__( 'Prompt', 'crafto-addons' ); ?></label>
							<textarea id="ai_prompt" placeholder="Enter image prompt..."></textarea>
						</div>
						<div class="form-field half">
							<label for="image_size"><?php echo esc_html__( 'Image Resolution', 'crafto-addons' ); ?></label>
							<select name="image_size" id="image_size">
								<option value="1024x1024" selected><?php echo esc_html__( '1024 x 1024', 'crafto-addons' ); ?></option>
								<option value="1024x1792"><?php echo esc_html__( '1024 x 1792', 'crafto-addons' ); ?></option>
								<option value="1792x1024"><?php echo esc_html__( '1792 x 1024', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<div class="form-field half">
							<label for="image_art"><?php echo esc_html__( 'Art', 'crafto-addons' ); ?></label>
							<select name="image_art" id="image_art">
								<option value="" selected=""><?php echo esc_html__( 'None', 'crafto-addons' ); ?></option>
								<option value="3d_render"><?php echo esc_html__( '3D Render', 'crafto-addons' ); ?></option>
								<option value="anime"><?php echo esc_html__( 'Anime', 'crafto-addons' ); ?></option>
								<option value="ballpoint_pen"><?php echo esc_html__( 'Ballpoint Pen Drawing', 'crafto-addons' ); ?></option>
								<option value="bauhaus"><?php echo esc_html__( 'Bauhaus', 'crafto-addons' ); ?></option>
								<option value="cartoon"><?php echo esc_html__( 'Cartoon', 'crafto-addons' ); ?></option>
								<option value="clay"><?php echo esc_html__( 'Clay', 'crafto-addons' ); ?></option>
								<option value="contemporary"><?php echo esc_html__( 'Contemporary', 'crafto-addons' ); ?></option>
								<option value="cubism"><?php echo esc_html__( 'Cubism', 'crafto-addons' ); ?></option>
								<option value="cyberpunk"><?php echo esc_html__( 'Cyberpunk', 'crafto-addons' ); ?></option>
								<option value="glitchcore"><?php echo esc_html__( 'Glitchcore', 'crafto-addons' ); ?></option>
								<option value="impressionism"><?php echo esc_html__( 'Impressionism', 'crafto-addons' ); ?></option>
								<option value="isometric"><?php echo esc_html__( 'Isometric', 'crafto-addons' ); ?></option>
								<option value="line"><?php echo esc_html__( 'Line Art', 'crafto-addons' ); ?></option>
								<option value="low_poly"><?php echo esc_html__( 'Low Poly', 'crafto-addons' ); ?></option>
								<option value="minimalism"><?php echo esc_html__( 'Minimalism', 'crafto-addons' ); ?></option>
								<option value="modern"><?php echo esc_html__( 'Modern', 'crafto-addons' ); ?></option>
								<option value="origami"><?php echo esc_html__( 'Origami', 'crafto-addons' ); ?></option>
								<option value="pencil"><?php echo esc_html__( 'Pencil Drawing', 'crafto-addons' ); ?></option>
								<option value="pixel"><?php echo esc_html__( 'Pixel', 'crafto-addons' ); ?></option>
								<option value="pointillism"><?php echo esc_html__( 'Pointillism', 'crafto-addons' ); ?></option>
								<option value="pop"><?php echo esc_html__( 'Pop', 'crafto-addons' ); ?></option>
								<option value="realistic"><?php echo esc_html__( 'Realistic', 'crafto-addons' ); ?></option>
								<option value="renaissance"><?php echo esc_html__( 'Renaissance', 'crafto-addons' ); ?></option>
								<option value="retro"><?php echo esc_html__( 'Retro', 'crafto-addons' ); ?></option>
								<option value="steampunk"><?php echo esc_html__( 'Steampunk', 'crafto-addons' ); ?></option>
								<option value="sticker"><?php echo esc_html__( 'Sticker', 'crafto-addons' ); ?></option>
								<option value="ukiyo"><?php echo esc_html__( 'Ukiyo', 'crafto-addons' ); ?></option>
								<option value="vaporwave"><?php echo esc_html__( 'Vaporwave', 'crafto-addons' ); ?></option>
								<option value="vector"><?php echo esc_html__( 'Vector', 'crafto-addons' ); ?></option>
								<option value="watercolor"><?php echo esc_html__( 'Watercolor', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<div class="form-field half">
							<label for="image_lightning"><?php echo esc_html__( 'Lightning', 'crafto-addons' ); ?></label>
							<select name="image_lightning" id="image_lightning">
								<option value="" selected=""><?php echo esc_html__( 'None', 'crafto-addons' ); ?></option>
								<option value="ambient"><?php echo esc_html__( 'Ambient', 'crafto-addons' ); ?></option>
								<option value="backlight"><?php echo esc_html__( 'Backlight', 'crafto-addons' ); ?></option>
								<option value="blue_hour"><?php echo esc_html__( 'Blue Hour', 'crafto-addons' ); ?></option>
								<option value="cinematic"><?php echo esc_html__( 'Cinematic', 'crafto-addons' ); ?></option>
								<option value="cold"><?php echo esc_html__( 'Cold', 'crafto-addons' ); ?></option>
								<option value="dramatic"><?php echo esc_html__( 'Dramatic', 'crafto-addons' ); ?></option>
								<option value="foggy"><?php echo esc_html__( 'Foggy', 'crafto-addons' ); ?></option>
								<option value="golden_hour"><?php echo esc_html__( 'Golden Hour', 'crafto-addons' ); ?></option>
								<option value="hard"><?php echo esc_html__( 'Hard', 'crafto-addons' ); ?></option>
								<option value="natural"><?php echo esc_html__( 'Natural', 'crafto-addons' ); ?></option>
								<option value="neon"><?php echo esc_html__( 'Neon', 'crafto-addons' ); ?></option>
								<option value="studio"><?php echo esc_html__( 'Studio', 'crafto-addons' ); ?></option>
								<option value="warm"><?php echo esc_html__( 'Warm', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<div class="form-field half">
							<label for="image_mood"><?php echo esc_html__( 'Mood', 'crafto-addons' ); ?></label>
							<select name="image_mood" id="image_mood">
								<option value="" selected=""><?php echo esc_html__( 'None', 'crafto-addons' ); ?></option>
								<option value="aggressive"><?php echo esc_html__( 'Aggressive', 'crafto-addons' ); ?></option>
								<option value="angry"><?php echo esc_html__( 'Angry', 'crafto-addons' ); ?></option>
								<option value="boring"><?php echo esc_html__( 'Boring', 'crafto-addons' ); ?></option>
								<option value="bright"><?php echo esc_html__( 'Bright', 'crafto-addons' ); ?></option>
								<option value="calm"><?php echo esc_html__( 'Calm', 'crafto-addons' ); ?></option>
								<option value="cheerful"><?php echo esc_html__( 'Cheerful', 'crafto-addons' ); ?></option>
								<option value="chilling"><?php echo esc_html__( 'Chilling', 'crafto-addons' ); ?></option>
								<option value="colorful"><?php echo esc_html__( 'Colorful', 'crafto-addons' ); ?></option>
								<option value="dark"><?php echo esc_html__( 'Dark', 'crafto-addons' ); ?></option>
								<option value="neutral"><?php echo esc_html__( 'Neutral', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<div class="form-field half">
							<label for="image_number"><?php echo esc_html__( 'Number of Images', 'crafto-addons' ); ?></label>
							<select name="image_number" id="image_number">
								<option value="1"><?php echo esc_html__( '1', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<div class="form-field half">
							<label for="image_quality"><?php echo esc_html__( 'Quality of Images', 'crafto-addons' ); ?></label>
							<select name="image_quality" id="image_quality">
								<option value="standard"><?php echo esc_html__( 'Standard', 'crafto-addons' ); ?></option>
								<option value="hd"><?php echo esc_html__( 'HD', 'crafto-addons' ); ?></option>
							</select>
						</div>
						<button id="generate_image">
							<span><?php echo esc_html__( 'Generate Image', 'crafto-addons' ); ?></span>
							<div class="lds-ripple"></div>
						</button>
						<!-- Container for the generated image -->
					</div>
					<div id="ai_images" class="ai-images"></div>
				</div>
			</div>
			<?php
			$html = ob_get_clean();
			wp_send_json_success( $html );
		}

		/**
		 * Function to generate OpenAI image.
		 */
		public function crafto_generate_ai_image_api() {
			$api_key = get_theme_mod( 'crafto_open_ai_api_key', '' );

			if ( empty( $api_key ) ) {
				wp_send_json_error(
					[
						'error' => __( 'API key is missing.', 'crafto-addons' )
					],
					400
				);
			}

			$prompt          = sanitize_text_field( $_POST['prompt'] );           // phpcs:ignore
			$size            = sanitize_text_field( $_POST['size'] );             // phpcs:ignore
			$image_art       = sanitize_text_field( $_POST['image_art'] );        // phpcs:ignore
			$image_lightning = sanitize_text_field( $_POST['image_lightning'] );  // phpcs:ignore
			$image_mood      = sanitize_text_field( $_POST['image_mood'] );       // phpcs:ignore
			$image_number    = sanitize_text_field( $_POST['image_number'] );     // phpcs:ignore
			$image_quality   = sanitize_text_field( $_POST['image_quality'] );    // phpcs:ignore

			$api_url = 'https://api.openai.com/v1/images/generations';
			$prompts = "{{$prompt}} {{$image_art}} style. {{$image_lightning}} lighting. {{$image_mood}} mood.";

			$body = json_encode( // phpcs:ignore
				array(
					'model'   => 'dall-e-3',
					'prompt'  => $prompts,
					'n'       => 1,
					'size'    => $size,
					'quality' => $image_quality,
				)
			);

			$response = wp_remote_post(
				$api_url,
				array(
					'method'      => 'POST',
					'timeout'     => 50,
					'redirection' => 5,
					'blocking'    => true,
					'headers'     => array(
						'Authorization' => 'Bearer ' . $api_key,
						'Content-Type'  => 'application/json',
					),
					'body'        => $body,
				)
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( 'Error connecting to OpenAI API: ' . $response->get_error_message() );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			if ( isset( $data['data'] ) && is_array( $data['data'] ) ) {
				wp_send_json_success( $data['data'] );
			} else {
				wp_send_json_error( 'Error generating images: ' . ( isset( $data['error']['message'] ) ? $data['error']['message'] : 'Unknown error.' ) );
			}
		}

		/**
		 * Function to generate OpenAI image.
		 */
		public function crafto_upload_ai_image() {
			check_ajax_referer( 'ai_image_upload_nonce', 'security' );

			$image_url = isset( $_POST['image_url'] ) ? esc_url_raw( $_POST['image_url'] ) : ''; // phpcs:ignore
			$aicontrol = isset( $_POST['aicontrol'] ) ? esc_html( $_POST['aicontrol'] ) : ''; // phpcs:ignore

			if ( ! $image_url ) {
				wp_send_json_error( 'No image URL provided.' );
				return;
			}

			$image = media_sideload_image( $image_url, 0, null, 'id' );

			if ( is_wp_error( $image ) ) {
				wp_send_json_error( 'Error uploading image.' );
				return;
			}

			wp_send_json_success(
				[
					'attachment_id' => $image,
					'aicontrol'     => $aicontrol,
				]
			);
		}

		/**
		 * Function to generate OpenAI image.
		 */
		public function crafto_get_attachment_url() {
			$attachment_id     = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0; // phpcs:ignore
			$aicontrol_widgets = isset( $_POST['aicontrol_widgets'] ) ? esc_html( $_POST['aicontrol_widgets'] ) : ''; // phpcs:ignore

			if ( ! $attachment_id ) {
				wp_send_json_error( 'Invalid attachment ID.' );
				return;
			}

			$attachment_url = wp_get_attachment_url( $attachment_id );

			if ( $attachment_url ) {
				wp_send_json_success(
					[
						'url'         => $attachment_url,
						'widget_name' => $aicontrol_widgets,
					]
				);
			} else {
				wp_send_json_error( 'Failed to retrieve attachment URL.' );
			}
		}


		/**
		 * Function to generate OpenAI Text HTML.
		 */
		public function get_modal_ai_content_html() {
			ob_start();
			?>
			<div id="crafto_ai_text_modal" class="crafto-ai-text-modal">
				<div class="crafto-ai-text-modal-content">
					<div class="crafto-ai-template-header">
						<div class="logo">
							<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-content-writer.svg' ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'ai-post-logo', 'crafto-addons' ); ?>">
						</div>
						<div class="close-icon">
							<span><i class="bi bi-x"></i></span>
						</div>
					</div>
					<div class="crafto-ai-template-content">
						<form id="crafto-ai-form" class="crafto-ai-form" action="ai_post_button" method="post">
							<div class="form-field">
								<label for="prompt"><?php echo esc_html__( 'Prompt', 'crafto-addons' ); ?></label>
								<textarea id="prompt" placeholder="Describe what you want."></textarea>
								<p class="description">
									<?php echo esc_html__( 'Define the blog post subject. Examples: WordPress Plugin Installation', 'crafto-addons' ); ?> 
								</p>
							</div>
							<div class="form-field half">
								<label for="language"><?php echo esc_html__( 'Select Language', 'crafto-addons' ); ?></label>
								<select name="language" id="language">
									<option value="english">🇬🇧 English (en)</option>
									<option value="chinese">🇨🇳 中文 (zh)</option>
									<option value="hindi">🇮🇳 हिन्दी (hi)</option>
									<option value="spanish">🇪🇸 Español (es)</option>
									<option value="french">🇫🇷 Français (fr)</option>
									<option value="bengali">🇧🇩 বাংলা (bn)</option>
									<option value="arabic">🇸🇦 العربية (ar)</option>
									<option value="russian">🇷🇺 Русский (ru)</option>
									<option value="portuguese">🇵🇹 Português (pt)</option>
									<option value="indonesian">🇮🇩 Bahasa Indonesia (id)</option>
									<option value="urdu">🇵🇰 اردو (ur)</option>
									<option value="japanese">🇯🇵 日本語 (ja)</option>
									<option value="german">🇩🇪 Deutsch (de)</option>
									<option value="javanese">🇮🇩 Basa Jawa (jv)</option>
									<option value="punjabi">🇮🇳 ਪੰਜਾਬੀ (pa)</option>
									<option value="telugu">🇮🇳 తెలుగు (te)</option>
									<option value="marathi">🇮🇳 मराठी (mr)</option>
									<option value="korean">🇰🇷 한국어 (ko)</option>
									<option value="turkish">🇹🇷 Türkçe (tr)</option>
									<option value="tamil">🇮🇳 தமிழ் (ta)</option>
									<option value="italian">🇮🇹 Italiano (it)</option>
									<option value="vietnamese">🇻🇳 Tiếng Việt (vi)</option>
									<option value="thai">🇹🇭 ไทย (th)</option>
									<option value="polish">🇵🇱 Polski (pl)</option>
									<option value="persian">🇮🇷 فارسی (fa)</option>
									<option value="ukrainian">🇺🇦 Українська (uk)</option>
									<option value="malay">🇲🇾 Bahasa Melayu (ms)</option>
									<option value="romanian">🇷🇴 Română (ro)</option>
									<option value="dutch">🇳🇱 Nederlands (nl)</option>
									<option value="hungarian">🇭🇺 Magyar (hu)</option>
								</select>
							</div>
							<div class="form-field half">
								<label for="maximum-length"><?php echo esc_html__( 'Maximum Tokens', 'crafto-addons' ); ?></label>
								<input type="number" name="maximum_length" id="maximum-length" value="200" min="1">
							</div>
							<div class="form-field half">
								<label for="tone-of-voice"><?php echo esc_html__( 'Choose Writing Style', 'crafto-addons' ); ?></label>
								<select name="tone_of_voice" id="tone-of-voice">
									<option value="professional"><?php esc_attr_e( 'Professional', 'crafto-addons' ); ?></option>
									<option value="funny"><?php esc_attr_e( 'Funny', 'crafto-addons' ); ?></option>
									<option value="casual"><?php esc_attr_e( 'Casual', 'crafto-addons' ); ?></option>
									<option value="excited"><?php esc_attr_e( 'Excited', 'crafto-addons' ); ?></option>
									<option value="witty"><?php esc_attr_e( 'Witty', 'crafto-addons' ); ?></option>
									<option value="sarcastic"><?php esc_attr_e( 'Sarcastic', 'crafto-addons' ); ?></option>
									<option value="feminine"><?php esc_attr_e( 'Feminine', 'crafto-addons' ); ?></option>
									<option value="masculine"><?php esc_attr_e( 'Masculine', 'crafto-addons' ); ?></option>
									<option value="bold"><?php esc_attr_e( 'Bold', 'crafto-addons' ); ?></option>
									<option value="dramatic"><?php esc_attr_e( 'Dramatic', 'crafto-addons' ); ?></option>
									<option value="grumpy"><?php esc_attr_e( 'Grumpy', 'crafto-addons' ); ?></option>
									<option value="secretive"><?php esc_attr_e( 'Secretive', 'crafto-addons' ); ?></option>
								</select>
							</div>

							<div class="form-field half">
								<label for="temperature"><?php echo esc_html__( 'Set Creativity Level', 'crafto-addons' ); ?></label>
								<select name="temperature" id="temperature">
									<option value="0.25"><?php esc_attr_e( 'Economic', 'crafto-addons' ); ?></option>
									<option value="0.5"><?php esc_attr_e( 'Average', 'crafto-addons' ); ?></option>
									<option value="0.75" selected><?php esc_attr_e( 'Good', 'crafto-addons' ); ?></option>
									<option value="1"><?php esc_attr_e( 'Premium', 'crafto-addons' ); ?></option>
								</select>
							</div>

							<div class="form-field">
								<button type="submit" class="button button-primary">
									<span><?php echo esc_html__( 'Generate Content', 'crafto-addons' ); ?></span>
									<div class="lds-ripple"></div>
								</button>
							</div>

							<?php wp_nonce_field( 'crafto-ai-form-response', 'security' ); ?>
						</form>

						<!-- result -->
						<form id="crafto-ai-form-result" class="crafto-ai-form" action="crafto-ai-result" method="post">
							<div class="form-field">
								<label for="content"><?php echo esc_html__( 'Generated Content', 'crafto-addons' ); ?></label>
								<textarea name="content" id="content" cols="30" rows="10" required></textarea>
							</div>
							<div class="form-field">
								<button type="submit" class="button button-primary">
									<span><?php echo esc_html__( 'Insert Content', 'crafto-addons' ); ?></span>
									<div class="lds-ripple"></div>
								</button>
								<div class="description crafto-ai-recreate"><?php echo esc_html__( 'Not satisfied?', 'crafto-addons' ); ?>
									<span><?php echo esc_html__( 'Generate Again.', 'crafto-addons' ); ?></span>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
			<?php
			$html = ob_get_clean();
			wp_send_json_success( $html );
		}

		/**
		 * Function to generate OpenAI Text.
		 */
		public function crafto_generate_openai_text() {
			if ( empty( $_POST['prompt'] ) ) { // phpcs:ignore
				wp_send_json(
					[
						'error'   => true,
						'message' => __( 'Prompt is required!', 'crafto-addons' ),
					]
				);
			}

			$operation      = 'post';
			$prompt_value   = sanitize_text_field( $_POST['prompt'] ); // phpcs:ignore
			$language       = ! empty( $_POST['language'] ) ? sanitize_text_field( $_POST['language'] ) : 'en'; // phpcs:ignore
			$tone_of_voice  = ! empty( $_POST['tone_of_voice'] ) ? sanitize_text_field( $_POST['tone_of_voice'] ) : 'professional'; // phpcs:ignore
			$maximum_length = ! empty( $_POST['maximum_length'] ) ? sanitize_text_field( $_POST['maximum_length'] ) : '200'; // phpcs:ignore

			switch ( $operation ) {
				case 'post':
					$prompt = "write {$prompt_value} in {$language} language and the tone of voice should be {$tone_of_voice}. Limit the content to {$maximum_length} words.";
					break;

			}

			$temperature = ! empty( $_POST['temperature'] ) ? (int) $_POST['temperature'] : 0.75; // phpcs:ignore

			$response = $this->openai_remote_post(
				[
					'prompt'      => [
						'chat'       => [
							[
								'role'    => 'system',
								'content' => "Write in {$language} language about I'm going to give you. Have fields in it. The tone of voice should be {$tone_of_voice}. Limit the content to {$maximum_length} words.",
							],
							[
								'role'    => 'user',
								'content' => $prompt_value,
							],
						],
						'text'       => $prompt,
						'max_tokens' => $maximum_length,
					],
					'temperature' => $temperature,
				]
			);

			$output = $response['output'];

			$total_tokens = sprintf( 'This operation spend %s tokens', $response['total_tokens'] );

			wp_send_json(
				[
					'message'      => 'Generated!',
					'post'         => [
						'content' => $output,
					],
					'total_tokens' => $total_tokens,
				]
			);
			wp_die();
		}

		/**
		 * Function to generate OpenAI Text.
		 */
		public function crafto_generate_openai_chat() {
			$api_key = get_theme_mod( 'crafto_open_ai_api_key', '' );

			if ( empty( $api_key ) ) {
				wp_send_json_error( [ 'error' => 'API key is missing.' ], 400 );
			}

			$api_url    = 'https://api.openai.com/v1/chat/completions';
			$input_chat = isset( $_POST['input_chat'] ) ? wp_unslash( $_POST['input_chat'] ) : ''; // phpcs:ignore

			if ( empty( $input_chat ) ) {
				wp_send_json_error( [ 'error' => 'Chat input cannot be empty.' ], 400 );
			}

			$data = [
				'model'    => 'gpt-4o',
				'messages' => [
					[
						'role'    => 'user',
						'content' => $input_chat,
					],
				],
			];

			$response = wp_remote_post(
				$api_url,
				[
					'headers' => [
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . $api_key,
					],
					'body'    => wp_json_encode( $data ),
					'timeout' => 30,
				]
			);

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( [ 'error' => $response->get_error_message() ], 500 );
			}

			$body             = wp_remote_retrieve_body( $response );
			$decoded_response = json_decode( $body, true );

			if ( ! isset( $decoded_response['choices'][0]['message']['content'] ) ) {
				wp_send_json_error( [ 'error' => 'Invalid response from OpenAI.' ], 500 );
			}

			wp_send_json_success( $decoded_response['choices'][0]['message']['content'] );
		}

		/**
		 * Function to generate OpenAI Post Model HTML.
		 */
		public function crafto_post_ai_template() {
			global $current_screen;

			if ( 'post' !== $current_screen->id ) {
				return;
			}
			?>
			<div class="crafto-ai-template">
				<div class="crafto-ai-template-wrapper">
					<div class="crafto-ai-template-header">
						<div class="components-button is-pressed has-icon logo">
							<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-article-writer.svg' ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'AI', 'crafto-addons' ); ?>">
						</div>
						<div class="components-button is-pressed has-icon crafto-ai-template--close"><span class="dashicons dashicons-no-alt"><i class="bi bi-x"></i></span></div>
					</div>
					<div class="crafto-ai-template-content">
						<form id="crafto-ai-form" class="crafto-ai-form" action="ai_post_button" method="post">
							<div class="form-field">
								<label for="prompt"><?php echo esc_html__( 'Prompt', 'crafto-addons' ); ?></label>
								<textarea id="prompt" placeholder="Describe what you want."></textarea>
								<p class="description">
									<?php echo esc_html__( 'Define the blog post subject. Examples: WordPress Plugin Installation', 'crafto-addons' ); ?> 
								</p>
							</div>
							<div class="form-field half">
								<label for="language"><?php echo esc_html__( 'Select Language', 'crafto-addons' ); ?></label>
								<select name="language" id="language">
									<option value="english">🇬🇧 English (en)</option>
									<option value="chinese">🇨🇳 中文 (zh)</option>
									<option value="hindi">🇮🇳 हिन्दी (hi)</option>
									<option value="spanish">🇪🇸 Español (es)</option>
									<option value="french">🇫🇷 Français (fr)</option>
									<option value="bengali">🇧🇩 বাংলা (bn)</option>
									<option value="arabic">🇸🇦 العربية (ar)</option>
									<option value="russian">🇷🇺 Русский (ru)</option>
									<option value="portuguese">🇵🇹 Português (pt)</option>
									<option value="indonesian">🇮🇩 Bahasa Indonesia (id)</option>
									<option value="urdu">🇵🇰 اردو (ur)</option>
									<option value="japanese">🇯🇵 日本語 (ja)</option>
									<option value="german">🇩🇪 Deutsch (de)</option>
									<option value="javanese">🇮🇩 Basa Jawa (jv)</option>
									<option value="punjabi">🇮🇳 ਪੰਜਾਬੀ (pa)</option>
									<option value="telugu">🇮🇳 తెలుగు (te)</option>
									<option value="marathi">🇮🇳 मराठी (mr)</option>
									<option value="korean">🇰🇷 한국어 (ko)</option>
									<option value="turkish">🇹🇷 Türkçe (tr)</option>
									<option value="tamil">🇮🇳 தமிழ் (ta)</option>
									<option value="italian">🇮🇹 Italiano (it)</option>
									<option value="vietnamese">🇻🇳 Tiếng Việt (vi)</option>
									<option value="thai">🇹🇭 ไทย (th)</option>
									<option value="polish">🇵🇱 Polski (pl)</option>
									<option value="persian">🇮🇷 فارسی (fa)</option>
									<option value="ukrainian">🇺🇦 Українська (uk)</option>
									<option value="malay">🇲🇾 Bahasa Melayu (ms)</option>
									<option value="romanian">🇷🇴 Română (ro)</option>
									<option value="dutch">🇳🇱 Nederlands (nl)</option>
									<option value="hungarian">🇭🇺 Magyar (hu)</option>
								</select>
							</div>
							<div class="form-field half">
								<label for="maximum-length"><?php echo esc_html__( 'Maximum Tokens', 'crafto-addons' ); ?></label>
								<input type="number" name="maximum_length" id="maximum-length" value="200" min="1">
							</div>
							<div class="form-field half">
								<label for="tone-of-voice"><?php echo esc_html__( 'Choose Writing Style', 'crafto-addons' ); ?></label>
								<select name="tone_of_voice" id="tone-of-voice">
									<option value="professional"><?php esc_attr_e( 'Professional', 'crafto-addons' ); ?></option>
									<option value="funny"><?php esc_attr_e( 'Funny', 'crafto-addons' ); ?></option>
									<option value="casual"><?php esc_attr_e( 'Casual', 'crafto-addons' ); ?></option>
									<option value="excited"><?php esc_attr_e( 'Excited', 'crafto-addons' ); ?></option>
									<option value="witty"><?php esc_attr_e( 'Witty', 'crafto-addons' ); ?></option>
									<option value="sarcastic"><?php esc_attr_e( 'Sarcastic', 'crafto-addons' ); ?></option>
									<option value="feminine"><?php esc_attr_e( 'Feminine', 'crafto-addons' ); ?></option>
									<option value="masculine"><?php esc_attr_e( 'Masculine', 'crafto-addons' ); ?></option>
									<option value="bold"><?php esc_attr_e( 'Bold', 'crafto-addons' ); ?></option>
									<option value="dramatic"><?php esc_attr_e( 'Dramatic', 'crafto-addons' ); ?></option>
									<option value="grumpy"><?php esc_attr_e( 'Grumpy', 'crafto-addons' ); ?></option>
									<option value="secretive"><?php esc_attr_e( 'Secretive', 'crafto-addons' ); ?></option>
								</select>
							</div>
							<div class="form-field half">
								<label for="temperature"><?php echo esc_html__( 'Set Creativity Level', 'crafto-addons' ); ?></label>
								<select name="temperature" id="temperature">
									<option value="0.25"><?php esc_attr_e( 'Economic', 'crafto-addons' ); ?></option>
									<option value="0.5"><?php esc_attr_e( 'Average', 'crafto-addons' ); ?></option>
									<option value="0.75" selected><?php esc_attr_e( 'Good', 'crafto-addons' ); ?></option>
									<option value="1"><?php esc_attr_e( 'Premium', 'crafto-addons' ); ?></option>
								</select>
							</div>
							<div class="form-field">
								<button type="submit" class="button button-primary">
									<span><?php echo esc_html__( 'Generate Content', 'crafto-addons' ); ?></span>
									<div class="lds-ripple"></div>
								</button>
							</div>

							<?php wp_nonce_field( 'crafto-ai-form-response', 'security' ); ?>
						</form>

						<!-- result -->
						<form id="crafto-ai-form-result" class="crafto-ai-form" action="crafto-ai-result" method="post">
							<div class="form-field">
								<label for="title"><?php echo esc_html__( 'Generated Article Title', 'crafto-addons' ); ?></label>
								<input type="text" id="title" required>
							</div>

							<div class="form-field">
								<label for="content"><?php echo esc_html__( 'Generated Article Content', 'crafto-addons' ); ?></label>
								<textarea name="content" id="content" cols="30" rows="10" required></textarea>
							</div>
							<div class="form-field">
								<label for="tags"><?php echo esc_html__( 'Suggested Tags', 'crafto-addons' ); ?></label>
								<input type="text" id="tags" required>
							</div>
							<input type="hidden" name="post_id" id="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
							<div class="form-field">
								<button type="submit" class="button button-primary">
									<span><?php echo esc_html__( 'Insert Content', 'crafto-addons' ); ?></span>
									<div class="lds-ripple"></div>
								</button>
								<div class="description crafto-ai-recreate"><?php echo esc_html__( 'Not satisfied?', 'crafto-addons' ); ?><span><?php echo esc_html__( 'Generate Again.', 'crafto-addons' ); ?></span></div>
							</div>
						</form>

					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Function to generate OpenAI Post Actions.
		 */
		public function post_actions() {
			if ( empty( $_POST['prompt'] ) ) { // phpcs:ignore
				wp_send_json(
					[
						'error'   => true,
						'message' => __( 'Prompt is required!', 'crafto-addons' ),
					]
				);
			}

			$operation      = 'post';
			$prompt_value   = sanitize_text_field( $_POST['prompt'] ); // phpcs:ignore
			$language       = ! empty( $_POST['language'] ) ? sanitize_text_field( $_POST['language'] ) : 'en'; // phpcs:ignore
			$tone_of_voice  = ! empty( $_POST['tone_of_voice'] ) ? sanitize_text_field( $_POST['tone_of_voice'] ) : 'professional'; // phpcs:ignore
			$maximum_length = ! empty( $_POST['maximum_length'] ) ? sanitize_text_field( $_POST['maximum_length'] ) : '200'; // phpcs:ignore

			switch ( $operation ) {
				case 'post':
					$prompt = "write blog post about {$prompt_value} with title, content and tags in {$language} language and the tone of voice should be {$tone_of_voice} as JSON. Limit the content to {$maximum_length} words.";
					break;

			}

			$temperature = ! empty( $_POST['temperature'] ) ? (int) $_POST['temperature'] : 0.75; // phpcs:ignore

			$response = $this->openai_remote_post(
				[
					'prompt'      => [
						'chat'       => [
							[
								'role'    => 'system',
								'content' => "Write a blog post in {$language} language about the title I'm going to give you. Have title, content and tags fields in it. The tone of voice should be {$tone_of_voice}, use html tags and return this output as JSON. Limit the content to {$maximum_length} words.",
							],
							[
								'role'    => 'user',
								'content' => $prompt_value,
							],
						],
						'text'       => $prompt,
						'max_tokens' => $maximum_length,
					],
					'temperature' => $temperature,
				]
			);

			$output = $response['output'];

			$json    = json_decode( str_replace( [ '\n    ', '\n' ], '', $output ) );
			$title   = $json->title;
			$content = $json->content;
			$tags    = $json->tags;

			$total_tokens = sprintf( 'This operation spend %s tokens', $response['total_tokens'] );

			wp_send_json(
				[
					'message'      => 'Generated!',
					'post'         => [
						'title'   => $title,
						'content' => $content,
						'tags'    => $tags,
					],
					'total_tokens' => $total_tokens,
				]
			);
		}

		/**
		 * Function to generate OpenAI Post Upadte.
		 */
		public function update_post() {
			if ( empty( $posts = $_POST['posts'] ) ) { // phpcs:ignore
				wp_send_json(
					[
						'error'   => true,
						'message' => __( 'Data is null!', 'crafto-addons' ),
					]
				);
			}

			$args = [
				'ID'           => $posts['post_id'],
				'post_title'   => $posts['title'],
				'post_content' => $posts['content'],
				'post_status'  => 'draft',
			];

			$update_post = wp_update_post( $args );

			if ( is_wp_error( $update_post ) ) {
				wp_send_json(
					[
						'error'   => true,
						'message' => $update_post->get_error_messages(),
					]
				);
			} else {
				wp_set_post_tags( $posts['post_id'], $posts['tags'], false );

				wp_send_json(
					[
						'message'  => __( 'Post Updated. Post ID: ' . $posts['post_id'], 'crafto-addons' ), // phpcs:ignore
						'posts'    => $posts,
						'redirect' => admin_url( 'post.php?post=' . $update_post . '&action=edit' ),
					]
				);
			}
		}

		/**
		 * Function to generate OpenAI Remote Post.
		 *
		 * @param object $data get data.
		 */
		public function openai_remote_post( $data ) {
			$api_key = get_theme_mod( 'crafto_open_ai_api_key', '' );

			if ( empty( $api_key ) ) {
				wp_send_json(
					[
						'error'   => true,
						'message' => __( 'API key is missing.', 'crafto-addons' ),
					]
				);
			}

			if ( ! $data ) {
				wp_send_json(
					[
						'error'   => true,
						'message' => __( 'Someting went wrong!', 'crafto-addons' ),
					]
				);
			}

			$prompt      = $data['prompt'];
			$temperature = isset( $data['temperature'] ) ? (int) $data['temperature'] : 0.75;

			$endpoint = 'https://api.openai.com/v1/chat/completions';
			$body     = [
				'temperature' => $temperature,
				'model'       => 'gpt-4o',
				'messages'    => $prompt['chat'],
			];

			$args = array(
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $api_key,
				),
				'body'    => wp_json_encode( $body ),
				'timeout' => 300,
			);

			$response = wp_remote_post( $endpoint, $args );

			if ( is_wp_error( $response ) ) {
				wp_send_json(
					[
						'error'   => true,
						'message' => $response->get_error_message(),
					]
				);
			}

			$response_body = json_decode( wp_remote_retrieve_body( $response ) );

			if ( isset( $response_body->error->message ) ) {
				wp_send_json(
					[
						'error'   => true,
						'message' => $response_body->error->message,
					]
				);
			} else {

				if ( 'length' === $response_body->choices[0]->finish_reason ) {
					wp_send_json(
						[
							'error'   => true,
							'message' => __( 'Operation failed: Max Token value is not enougth for this prompt!', 'crafto-addons' ),
						]
					);
				}

				$output = $response_body->choices[0]->message->content;

				return [
					'output'       => $output,
					'total_tokens' => $response_body->usage->total_tokens,
				];

			}
		}
	}

	new Crafto_AI_Helper();
}
