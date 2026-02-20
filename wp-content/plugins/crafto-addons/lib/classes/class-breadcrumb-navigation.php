<?php
/**
 * Default Breadcrumb Class File.
 * This class handles breadcrumb navigation options.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Breadcrumb_Navigation' ) ) {

	/**
	 * Define Breadcrumb navigation
	 */
	class Crafto_Breadcrumb_Navigation {

		/**
		 * Customize control type.
		 *
		 * @var array
		 */
		public $opt;

		/**
		 * Constructor
		 */
		public function __construct() {

			$this->opt = array(

				'static_frontpage'                => false,
				'url_blog'                        => '',
				'home_display'                    => true,
				'url_home'                        => home_url( '/' ),
				'home_link'                       => true,
				'title_home'                      => esc_html__( 'Home', 'crafto-addons' ),
				'title_blog'                      => esc_html__( 'Blog', 'crafto-addons' ),
				'separator'                       => ' / ',
				'title_search'                    => esc_html__( 'Search', 'crafto-addons' ),
				'singleblogpost_prefix'           => '',
				'singleblogpost_suffix'           => '',
				'page_prefix'                     => '',
				'page_suffix'                     => '',
				'urltitle_prefix'                 => esc_html__( 'Browse to: ', 'crafto-addons' ),
				'urltitle_suffix'                 => '',
				'archive_category_prefix'         => '',
				'archive_category_suffix'         => '',
				'archive_date_prefix'             => '',
				'archive_date_suffix'             => '',
				'tag_page_prefix'                 => esc_html__( 'Tag: ', 'crafto-addons' ),
				'tag_page_suffix'                 => '',
				'title_404'                       => esc_html__( '404', 'crafto-addons' ),
				'title_portfolio'                 => '',
				'link_current_item'               => false,
				'current_item_urltitle'           => esc_html__( 'Link of current page (click to refresh)', 'crafto-addons' ),
				'current_item_style_prefix'       => '',
				'current_item_style_suffix'       => '',
				'posttitle_maxlen'                => 0,
				'singleblogpost_category_display' => false,
				'singleblogpost_category_prefix'  => '',
				'singleblogpost_category_suffix'  => '',
			);
		}
		// END function breadcrumb (constructor).

		/**
		 * DISPLAY BREADCRUMB
		 */
		public function crafto_display_breadcrumb() {

			global $wpdb, $post, $wp_query, $wp;

			$bcn_homelink = '';
			if ( ( true === $this->opt['static_frontpage'] ) && ( true === $this->opt['home_display'] ) ) { // Hide HOME if it is disabled in the options.
				if ( true === $this->opt['home_link'] ) { // Link home or just display text.
					$bcn_homelink = '<a href="' . esc_url( $this->opt['url_home'] ) . '" title="' . $this->opt['urltitle_prefix'] . $this->opt['title_home'] . $this->opt['urltitle_suffix'] . '">' . $this->opt['title_home'] . '</a>';
				} else {
					$bcn_homelink = $this->opt['title_home'];
				}
			}

			/* -------- BLOG LINK -------- */
			$bcn_bloglink = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url( '/' ) ) . $this->opt['url_blog'] . '" title="' . $this->opt['urltitle_prefix'] . $this->opt['title_blog'] . $this->opt['urltitle_suffix'] . '"><span itemprop="name">' . $this->opt['title_blog'] . '</span></a><meta itemprop="position" content="1" /></li>';

			/* -------- CURRENT ITEM -------- */
			$curitem_urlprefix = '';
			$curitem_urlsuffix = '';
			if ( $this->opt['link_current_item'] ) {
				$current_url       = trailingslashit( home_url( $wp->request ) );
				$curitem_urlprefix = '<a title="' . $this->opt['current_item_urltitle'] . '" href="' . esc_url( $current_url ) . '">';
				$curitem_urlsuffix = '</a>';
			}

			// Get the different types.
			if ( is_search() ) {
				$swg_type = 'search'; // Search.
			} elseif ( is_attachment() ) {
				$swg_type = 'attachment';
			} elseif ( is_page() ) {
				$swg_type = 'page'; // Page.
			} elseif ( is_singular( 'portfolio' ) ) {
				$swg_type = 'portfoliosinglepost'; // Single Portfolio page.
			} elseif ( is_single() ) {
				$swg_type = 'singlepost'; // Single post page.
			} elseif ( is_post_type_archive( 'portfolio' ) ) {
				$swg_type = 'portfolio';
			} elseif ( is_post_type_archive( 'properties' ) ) {
				$swg_type = 'property';
			} elseif ( is_post_type_archive( 'tours' ) ) {
				$swg_type = 'tours';
			} elseif ( is_archive() && is_category() ) {
				$swg_type = 'categories'; // Weblog Categories.
			} elseif ( is_tag() || ( class_exists( 'SimpleTagging' ) && function_exists( 'STP_IsTagView' ) && STP_IsTagView() ) ) {
				$swg_type = 'tag';
			} elseif ( is_archive() && ! is_category() ) {
				$swg_type = 'blogarchive'; // Weblog Archive.
			} elseif ( is_404() ) {
				$swg_type = '404'; // 404.
			} else {
				$swg_type = 'else'; // Everything else (should be weblog article list only).
			}

			/**
			 * Here we set the initial array $result_array. We use this for being able
			 * to apply styles, anchors etc. to each element.
			 * Default is set to false.
			 */
			$result_array = array(
				'middle' => false, // The part between "Home" and the last element of the breadcrumb.
				'last'   => array(// The last element of the breadcrumb.
					'prefix' => false, // prefix.
					'title'  => false, // text.
					'suffix' => false, // suffix.
				),
			);

			switch ( $swg_type ) {
				case 'page':
					$bcn_theparentid = $post->post_parent; // id of the parent page.
					$page_counter    = 2; /* For crafto */
					$bcn_loopcount   = 0; // counter for the array.
					$bcn_titlearray  = array();

					while ( 0 != $bcn_theparentid ) { // phpcs:ignore
						// Get the row of the parent's page;
						// *** Regarding performance this is not a perfect solution since this query is inside a loop ! ***
						// However, the number of queries is reduced to the number of parents.
						$mylink = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_parent FROM $wpdb->posts WHERE ID = %d", $bcn_theparentid ) ); // phpcs:ignore
						// Title of parent into array incl. current permalink (via $bcn_theparentid,.
						// since we set this variable below we can use it here as current id!).

						$bcn_titlearray[ $bcn_loopcount ] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $bcn_theparentid ) ) . '" title="' . $this->opt['urltitle_prefix'] . $mylink->post_title . $this->opt['urltitle_suffix'] . '"><span itemprop="name">' . $mylink->post_title . '</span><meta itemprop="position" content="' . $page_counter . '" /></a></li>';

						// New parent ID of parent.
						$bcn_theparentid = $mylink->post_parent;

						++$bcn_loopcount;
						++$page_counter;
					} // while.

					if ( is_array( $bcn_titlearray ) ) {
						// Reverse the array since it is in a reverse order .
						$bcn_titlearray = array_reverse( $bcn_titlearray );
						// Prepare the output by looping thru the array. We use $sep for not adding the separator before the first element.
						$count       = 0;
						$page_result = '';

						foreach ( $bcn_titlearray as $val ) {
							$sep = '';
							if ( 0 !== $count ) {
								$sep = $this->opt['separator'];
							}

							$page_result = $page_result . $sep . $val;

							++$count;
						}
					}

					$bcn_pagetitle  = trim( get_the_title() ); // page title, we do not use "$post->post_title" since it could display.
					$bcn_pagetitle1 = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $bcn_pagetitle ) . '</span><meta itemprop="position" content="' . $page_counter . '" /></li>'; // wrong title if theme uses more than one LOOP.

					// Result
					// If we have a front page named 'Home' (or similar), we do not want to display the Breadcrumb like this: Home / Home
					// Therefore do not display the Home Link if such certain page is being displayed.
					if ( strtolower( $bcn_pagetitle ) !== strtolower( $this->opt['title_home'] ) ) {  // Check if we are not on home.
						if ( isset( $page_result ) ) {
							if ( '' !== $page_result ) {
								$result_array['middle'] = $page_result;
							}
						}
						$result_array['last']['prefix'] = $this->opt['page_prefix'];
						$result_array['last']['title']  = $bcn_pagetitle1;
						$result_array['last']['suffix'] = $this->opt['page_suffix'];
					}
					break;
				case 'search':
					$search_name                   = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $this->opt['title_search'] . '</span><meta itemprop="position" content="2" /></li>';
					$result_array['last']['title'] = $search_name;

					break;
				case 'singlepost':
					$bcn_pagetitle          = trim( get_the_title() );
					$result_array['middle'] = $bcn_bloglink;

					$counter = 2;
					// Add category.
					if ( true === $this->opt['singleblogpost_category_display'] ) {
						$category      = get_the_category();
						$category_link = get_category_link( $category[0]->term_id );

						$result_array['middle'] .= $this->opt['separator'] . $this->opt['singleblogpost_category_prefix'] . '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $category_link ) . '" title="' . $category[0]->cat_name . '"><span itemprop="name">' . $category[0]->cat_name . '</span></a><meta itemprop="position" content="' . esc_attr( $counter ) . '" /></li>' . $this->opt['singleblogpost_category_suffix'];
						/* Custom for crafto */
						++$counter;
					}

					$result_array['last']['prefix'] = $this->opt['singleblogpost_prefix'];

					// Restrict the length of the title...
					$bcn_post_title = $bcn_pagetitle;
					if ( ( $this->opt['posttitle_maxlen'] >= 1 ) && ( strlen( $bcn_post_title ) > $this->opt['posttitle_maxlen'] ) ) {
						$bcn_post_title = substr( $bcn_post_title, 0, $this->opt['posttitle_maxlen'] - 1 ) . '...';
					}
					$result_array['last']['title'] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $bcn_post_title ) . '</span><meta itemprop="position" content="' . esc_attr( $counter ) . '" /></li>';

					$result_array['last']['suffix'] = $this->opt['singleblogpost_suffix'];

					break;
				case 'attachment':
					$bcn_pagetitle = trim( get_the_title() );
					// wrong title if theme uses more than one LOOP.
					$result_array['middle'] = $bcn_bloglink;
					$counter                = 2;
					// Add category.
					$result_array['last']['prefix'] = $this->opt['singleblogpost_prefix'];

					// Restrict the length of the title...
					$bcn_post_title = $bcn_pagetitle;
					if ( ( $this->opt['posttitle_maxlen'] >= 1 ) && ( strlen( $bcn_post_title ) > $this->opt['posttitle_maxlen'] ) ) {
						$bcn_post_title = substr( $bcn_post_title, 0, $this->opt['posttitle_maxlen'] - 1 ) . '...';
					}
					$result_array['last']['title'] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $bcn_post_title ) . '</span><meta itemprop="position" content="' . esc_attr( $counter ) . '" /></li>';

					$result_array['last']['suffix'] = $this->opt['singleblogpost_suffix'];

					break;
				case 'singlepostcategory':
					$bcn_pagetitle          = esc_html__( 'Blog', 'crafto-addons' );
					$result_array['middle'] = $bcn_bloglink;

					// Restrict the length of the title...
					$bcn_post_title = $bcn_pagetitle;
					if ( ( $this->opt['posttitle_maxlen'] >= 1 ) && ( strlen( $bcn_post_title ) > $this->opt['posttitle_maxlen'] ) ) {
						$bcn_post_title = substr( $bcn_post_title, 0, $this->opt['posttitle_maxlen']-1 ) . '...'; // phpcs:ignore
					}

					$bcn_post_title                 = '<li><a href="' . esc_url( get_permalink( get_page_by_path( ( 'blog' ) ) ) ) . '">' . esc_html( $bcn_post_title ) . '</a></li>';
					$result_array['last']['title']  = $bcn_post_title;
					$result_array['last']['suffix'] = $this->opt['singleblogpost_suffix'];
					break;
				case 'categories':
					$cat_counter            = 2;
					$result_array['middle'] = $bcn_bloglink;

					$object = $wp_query->get_queried_object();

					// Get parents of current category.
					$parent_id       = $object->category_parent;
					$cat_breadcrumbs = '';

					while ( $parent_id ) {
						$category        = get_category( $parent_id );
						$cat_breadcrumbs = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $category->cat_ID ) ) . '" title="' . $this->opt['urltitle_prefix'] . $category->cat_name . $this->opt['urltitle_suffix'] . '"><span itemprop="name">' . esc_html( $category->cat_name ) . '</span><meta itemprop="position" content="' . esc_attr( $cat_counter ) . '" /></a></li>' . $this->opt['separator'] . $cat_breadcrumbs;
						$parent_id       = $category->category_parent;
						++$cat_counter;
					}

					$result_array['last']['prefix']  = $this->opt['archive_category_prefix'];
					$result_array['last']['prefix'] .= $cat_breadcrumbs;

					$cat_name = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $object->cat_name . '</span><meta itemprop="position" content="' . esc_attr( $cat_counter ) . '" /></li>';

					// Current Category.
					$result_array['last']['title']  = $cat_name;
					$result_array['last']['suffix'] = $this->opt['archive_category_suffix'];
					break;
				case 'blogarchive':
					$result_array['middle'] = $bcn_bloglink;
					if ( is_day() ) {
						$archive_name = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( get_the_date() ) . '</span><meta itemprop="position" content="2" /></li>';
						// -- Archive by day
						$result_array['last']['prefix'] = $this->opt['archive_date_prefix'];
						$result_array['last']['title']  = $archive_name;
						$result_array['last']['suffix'] = $this->opt['archive_date_suffix'];

					} elseif ( is_month() ) {
						$archive_name = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( get_the_date( 'F Y' ) ) . '</span><meta itemprop="position" content="2" /></li>';
						// -- Archive by month
						$result_array['last']['prefix'] = $this->opt['archive_date_prefix'];
						$result_array['last']['title']  = $archive_name;
						$result_array['last']['suffix'] = $this->opt['archive_date_suffix'];
					} elseif ( is_year() ) {
						$archive_name = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( get_the_date( 'Y' ) ) . '</span><meta itemprop="position" content="2" /></li>';
						// -- Archive by year
						$result_array['last']['prefix'] = $this->opt['archive_date_prefix'];
						$result_array['last']['title']  = $archive_name;
						$result_array['last']['suffix'] = $this->opt['archive_date_suffix'];
					} elseif ( is_author() ) {
						$archive_name = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( get_the_author() ) . '</span><meta itemprop="position" content="2" /></li>';
						// -- Archive by author
						$result_array['last']['prefix'] = $this->opt['archive_date_prefix'];
						$result_array['last']['title']  = $archive_name;
						$result_array['last']['suffix'] = $this->opt['archive_date_suffix'];
					} else {
						$tag_name                       = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . single_tag_title( '', false ) . '</span><meta itemprop="position" content="2" /></li>';
						$result_array['middle']         = $bcn_bloglink;
						$result_array['last']['prefix'] = $this->opt['tag_page_prefix'];
						$result_array['last']['title']  = $tag_name;
						$result_array['last']['suffix'] = $this->opt['tag_page_suffix'];
					}

					break;
				case '404':
					$result_array['last']['title'] = $this->opt['title_404'];
					break;
				case 'tag':
					$tag_name                       = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . single_tag_title( '', false ) . '</span><meta itemprop="position" content="2" /></li>';
					$result_array['middle']         = $bcn_bloglink;
					$result_array['last']['prefix'] = $this->opt['tag_page_prefix'];
					$result_array['last']['title']  = $tag_name;
					$result_array['last']['suffix'] = $this->opt['tag_page_suffix'];
					break;
				case 'portfolio':
					$result_array['middle']        = $bcn_bloglink;
					$title_portfolio               = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name"></span><meta itemprop="position" content="2" />' . esc_html__( 'Portfolio', 'crafto-addons' ) . '</li>';
					$result_array['last']['title'] = $title_portfolio;
					break;
				case 'portfoliosinglepost':
					// Get single portfolio post.

					$bcn_pagetitle   = trim( get_the_title() );
					$bcn_theparentid = $post->post_parent; // id of the parent page.
					$bcn_loopcount   = 0;// counter for the array.
					$bcn_titlearray  = array();

					while ( 0 != $bcn_theparentid ) { // phpcs:ignore

						$mylink   = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_parent FROM $wpdb->posts WHERE ID = %d", $bcn_theparentid ) );// phpcs:ignore
						$page_url = get_permalink( $bcn_theparentid );
						// Single portfolio title.
						$bcn_titlearray[ $bcn_loopcount ] = '<li><a href="' . esc_url( $page_url ) . '" title="' . $this->opt['urltitle_prefix'] . $mylink->post_title . $this->opt['urltitle_suffix'] . '">' . $mylink->post_title . '</a></li>';

						// New parent ID of parent.
						$bcn_theparentid = $mylink->post_parent;
						++$bcn_loopcount;
					} // while.

					if ( is_array( $bcn_titlearray ) ) {
						// Reverse the array since it is in a reverse order.
						$bcn_titlearray = array_reverse( $bcn_titlearray );
						$count          = 0;
						$page_result    = '';
						foreach ( $bcn_titlearray as $val ) {
							$sep = '';
							if ( 0 !== $count ) {
								$sep = $this->opt['separator'];
							}

							$page_result = $page_result . $sep . $val;

							$count;
						}
					}
					// wrong title if theme uses more than one LOOP.
					$result_array['middle'] = $bcn_bloglink;

					$position_meta = false;
					if ( 'portfolio' === get_post_type() ) {
						if ( isset( $page_result ) ) {
							if ( '' !== $page_result ) {
								$result_array['middle'] .= $page_result;
							}
						}
					}

					$result_array['last']['prefix'] = $this->opt['singleblogpost_prefix'];

					// Restrict the length of the title...
					$bcn_post_title     = $bcn_pagetitle;
					if ( ( $this->opt['posttitle_maxlen'] >= 1 ) && ( strlen( $bcn_post_title ) > $this->opt['posttitle_maxlen'] ))// phpcs:ignore.
						$bcn_post_title = substr( $bcn_post_title, 0, $this->opt['posttitle_maxlen'] - 1 ) . '...';
					if ( $position_meta ) {
						$result_array['last']['title'] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $bcn_post_title . '</span><meta itemprop="position" content="3" /></li>';
					} else {
						$result_array['last']['title'] = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $bcn_post_title . '</span><meta itemprop="position" content="2" /></li>';
					}

					$result_array['last']['suffix'] = $this->opt['singleblogpost_suffix'];
					break;
				case 'else':
					// Get weblog article list (which is very often the front page of the blog).

					$default = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . $this->opt['title_blog'] . '</span><meta itemprop="position" content="2" /></li>';

					$result_array['last']['title'] = $default;
			} // switch

			// Echo the result.

			// MIDDLE PART.

			// The first separator between HOME and the first entry.
			$first_sep = ''; // display first separator only if HOME is disabled in the options AND it is a static front page.
			if ( ( true === $this->opt['static_frontpage'] ) && ( true === $this->opt['home_display'] ) ) {
				$first_sep = $this->opt['separator'];
			}

			// get middle part and add separator(s).
			$middle_part = '';
			if ( false === $result_array['middle'] ) {
				// there is no middle part...

				if ( false === $result_array['last']['title'] ) {
					$first_sep = ''; // we are on home.
				}
			} else {
				// There is a middle part...
				$middle_part = $result_array['middle'] . $this->opt['separator'];
			}

			// LAST PART.
			$last_part = '';
			if ( false !== $result_array['last']['prefix'] ) {
				$last_part .= $result_array['last']['prefix'];
			}

			if ( false !== $result_array['last']['title'] ) {
				$last_part .= $curitem_urlprefix . $result_array['last']['title'] . $curitem_urlsuffix;
			}

			if ( false !== $result_array['last']['suffix'] ) {
				$last_part .= $result_array['last']['suffix'];
			}

			// ECHO.
			$result = "\n";

			if ( false === $this->opt['static_frontpage'] ) {
				if ( ( 'page' === $swg_type ) || ( 'search' === $swg_type ) || ( '404' === $swg_type ) ) {
					$result .= $bcn_bloglink . $this->opt['separator'];
				}
			}

			$result .= $bcn_homelink . $first_sep . $middle_part . $this->opt['current_item_style_prefix'] . $last_part . $this->opt['current_item_style_suffix'] . "\n";
			return $result;
		}
		// END function display.
	}
}
