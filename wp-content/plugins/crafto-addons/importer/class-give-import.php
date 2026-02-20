<?php
/**
 * Crafto Importer Give WP Class
 *
 * Handles the import process for give wp plugin.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Give_Import' ) ) {
	/**
	 * Define Crafto_Give_Import Class
	 */
	class Crafto_Give_Import {

		/**
		 * Import GiveWP campaigns from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_campaigns( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_campaigns_table           = $prefix . 'give_campaigns';
			$give_campaign_forms_table      = $prefix . 'give_campaign_forms';
			$give_sequential_ordering_table = $prefix . 'give_sequential_ordering';

			$counter = 1;
			foreach ( $xml->campaign as $item ) {
				$form_id        = (int) $item->form_id;
				$campaign_title = sanitize_text_field( (string) $item->campaign_title );
				$short_desc     = sanitize_text_field( (string) $item->short_desc );
				$campaign_image = esc_url_raw( (string) $item->campaign_image );
				$campaign_goal  = (int) $item->campaign_goal;
				$start_date     = sanitize_text_field( (string) $item->start_date );
				$date_created   = sanitize_text_field( (string) $item->date_created );
				$payment_id     = (int) $item->payment_id;
				$amount         = (int) $item->amount;
				$campaign_id    = (int) $item->campaign_id;

				$wpdb->insert(
					$give_campaigns_table,
					[
						'campaign_page_id' => null,
						'form_id'          => $form_id,
						'campaign_type'    => 'core',
						'campaign_title'   => $campaign_title,
						'campaign_url'     => '',
						'short_desc'       => $short_desc,
						'long_desc'        => '',
						'campaign_logo'    => '',
						'campaign_image'   => $campaign_image,
						'campaign_goal'    => $campaign_goal ?? 0,
						'goal_type'        => 'amount',
						'status'           => 'active',
						'start_date'       => $start_date,
						'end_date'         => null,
						'date_created'     => $date_created,
					]
				);

				$wpdb->insert(
					$give_campaign_forms_table,
					[
						'campaign_id' => $counter,
						'form_id'     => $form_id,
					]
				);

				$wpdb->insert(
					$give_sequential_ordering_table,
					[
						'payment_id' => $payment_id,
					]
				);

				$counter++;
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}

		/**
		 * Import GiveWP revenue from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_revenue( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_revenue_table = $prefix . 'give_revenue_table';

			foreach ( $xml->item as $item ) {
				$form_id     = (int) $item->form_id;
				$payment_id  = (int) $item->donation_id;
				$amount      = (int) $item->amount;
				$campaign_id = (int) $item->campaign_id;

				$wpdb->insert(
					$give_revenue_table,
					[
						'donation_id' => $payment_id,
						'form_id'     => $form_id,
						'amount'      => $amount,
						'campaign_id' => $campaign_id,
					]
				);
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}

		/**
		 * Import GiveWP comments from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_comments( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_comments_table = $prefix . 'give_comments';

			foreach ( $xml->give_comment as $item ) {
				$comment_parent   = (int) $item->comment_parent;
				$comment_date     = (string) $item->comment_date;
				$comment_date_gmt = (string) $item->comment_date_gmt;

				$wpdb->insert(
					$give_comments_table,
					[
						'user_id'          => 0,
						'comment_content'  => __( 'Status changed from Pending to Complete.', 'crafto-addons' ),
						'comment_parent'   => $comment_parent, // comment_parent == domaintion ID.
						'comment_type'     => 'donation',
						'comment_date'     => $comment_date,
						'comment_date_gmt' => $comment_date_gmt,
					]
				);
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}

		/**
		 * Import GiveWP donors from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_donors( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_donors_table    = $prefix . 'give_donors';
			$give_donormeta_table = $prefix . 'give_donormeta';

			$counter = 1;
			foreach ( $xml->give_donor as $item ) {
				$user_id         = (int) $item->user_id;
				$email           = (string) $item->email;
				$name            = (string) $item->name;
				$purchase_value  = (string) $item->purchase_value;
				$purchase_count  = (int) $item->purchase_count;
				$payment_ids     = (string) $item->payment_ids;
				$date_created    = (string) $item->date_created;
				$verify_key      = (string) $item->verify_key;
				$verify_throttle = (string) $item->verify_throttle;
				$post_metas      = $item->post_meta;

				$wpdb->insert(
					$give_donors_table,
					[
						'user_id'         => $user_id,
						'email'           => $email,
						'name'            => $name,
						'phone'           => '',
						'purchase_value'  => $purchase_value,
						'purchase_count'  => $purchase_count,
						'payment_ids'     => $payment_ids,
						'date_created'    => $date_created,
						'token'           => '',
						'verify_key'      => $verify_key,
						'verify_throttle' => $verify_throttle,
					]
				);

				if ( ! empty( $post_metas ) ) {
					foreach ( $post_metas as $postmeta ) {
						$first_name = (string) $postmeta->first_name;
						$last_name  = (string) $postmeta->last_name;

						$wpdb->insert(
							$give_donormeta_table,
							[
								'donor_id'   => $counter,
								'meta_key'   => '_give_donor_first_name',
								'meta_value' => $first_name,
							]
						);

						$wpdb->insert(
							$give_donormeta_table,
							[
								'donor_id'   => $counter,
								'meta_key'   => '_give_donor_last_name',
								'meta_value' => $last_name,
							]
						);
					}
				}

				$counter++;
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}

		/**
		 * Import GiveWP form meta from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_formmeta( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_formmeta_table = $prefix . 'give_formmeta';

			foreach ( $xml->give_formmeta as $meta ) {
				$meta_id    = (int) $meta->xpath( 'column[@name="meta_id"]' )[0];
				$form_id    = (int) $meta->xpath( 'column[@name="form_id"]' )[0];
				$meta_key   = (string) $meta->xpath( 'column[@name="meta_key"]' )[0];
				$meta_value = (string) $meta->xpath( 'column[@name="meta_value"]' )[0];

				$wpdb->insert(
					$give_formmeta_table,
					[
						'meta_id'    => $meta_id,
						'form_id'    => $form_id,
						'meta_key'   => $meta_key,
						'meta_value' => $meta_value,
					]
				);
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}


		/**
		 * Import GiveWP form meta from XML.
		 *
		 * @param string   $xml_file    Full path to the XML file.
		 * @param int|null $blog_id   Optional. Multisite blog ID to import into.
		 * @return true|WP_Error
		 */
		public function import_parse_give_donationmeta( $xml_file, $blog_id = null ) {
			// Load XML file.
			$xml = simplexml_load_file( $xml_file );

			if ( ! $xml ) {
				return new WP_Error( 'xml_error', 'Failed to parse the XML file.' );
			}

			global $wpdb;
			$switched = false;

			if ( is_multisite() && $blog_id !== null && get_current_blog_id() !== $blog_id ) {
				switch_to_blog( $blog_id );
				$switched = true;
			}

			$prefix = $wpdb->prefix;

			$give_donationmeta_table = $prefix . 'give_donationmeta';

			foreach ( $xml->give_donationmeta as $meta ) {
				$meta_id     = (int) $meta->xpath( 'column[@name="meta_id"]' )[0];
				$donation_id = (int) $meta->xpath( 'column[@name="donation_id"]' )[0];
				$meta_key    = (string) $meta->xpath( 'column[@name="meta_key"]' )[0];
				$meta_value  = (string) $meta->xpath( 'column[@name="meta_value"]' )[0];

				$wpdb->insert(
					$give_donationmeta_table,
					[
						'meta_id'     => $meta_id,
						'donation_id' => $donation_id,
						'meta_key'    => $meta_key,
						'meta_value'  => $meta_value,
					]
				);
			}

			if ( $switched ) {
				restore_current_blog();
			}

			return true;
		}
	}
}
