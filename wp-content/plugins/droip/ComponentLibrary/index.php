<?php


namespace ComponentLib;

use Droip\HelperFunctions;

define('DROIP_COMPONENT_LIBRARY_APP_PREFIX', 'DroipComponentLibrary');
define('DROIP_COMPONENT_LIBRARY_ROOT_URL', plugin_dir_url(__FILE__));
define('DROIP_COMPONENT_LIBRARY_ROOT_PATH', plugin_dir_path(__FILE__));

require_once DROIP_COMPONENT_LIBRARY_ROOT_PATH . '/controller/CompLibFormHandler.php';
require_once DROIP_COMPONENT_LIBRARY_ROOT_PATH . '/controller/ShowUserMetadata.php';
require_once DROIP_COMPONENT_LIBRARY_ROOT_PATH . '/controller/ElementGenerator.php';

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

class DroipComponentLibrary
{
  private $component_lib_forms = array();

  public function __construct()
  {
    $this->init();
    add_filter('droip_element_generator_' . DROIP_COMPONENT_LIBRARY_APP_PREFIX, array($this, 'element_generator'), 10, 2);
    add_filter('droip_external_collection_options', [$this, 'modify_external_collection_options'], 10, 2);
    add_filter('droip_collection_comments', [$this, 'droip_collection_comments'], 10, 2);

    add_filter('droip_dynamic_content', [$this, 'droip_dynamic_content'], 10, 2);
  }

  public function init()
  {
    //phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.NonceVerification.Recommended,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    $action = sanitize_text_field(isset($_GET['action']) ? $_GET['action'] : null);
    if ('droip' === $action) {
      $load_for = sanitize_text_field(isset($_GET['load_for']) ? wp_unslash($_GET['load_for']) : null);
      if ('droip-iframe' !== $load_for) {
        add_action('wp_enqueue_scripts', array($this, 'load_editor_assets'), 1);
      }
    }
  }

  public function load_editor_assets()
  {
    wp_enqueue_script(DROIP_COMPONENT_LIBRARY_APP_PREFIX . '-editor', DROIP_COMPONENT_LIBRARY_ROOT_URL . 'assets/js/' . 'editor.min.js', array(), false, array('in_footer' => true));
    wp_add_inline_script(
      DROIP_COMPONENT_LIBRARY_APP_PREFIX . '-editor',
      'const ' . DROIP_COMPONENT_LIBRARY_APP_PREFIX . ' = ' . json_encode(array(
        'base_url' => DROIP_COMPONENT_LIBRARY_ROOT_URL,
      )),
      'before'
    );
    add_action('wp_enqueue_scripts', function () {
      global $droip_editor_assets;
      $droip_editor_assets['scripts'][] = DROIP_COMPONENT_LIBRARY_APP_PREFIX . '-editor';
    }, 50);
  }

  public function add_component_library_script($script_tags)
  {
    $value = $this->component_lib_forms;
    $val = wp_json_encode($value);
    $script = "var " . DROIP_COMPONENT_LIBRARY_APP_PREFIX . " = window." . DROIP_COMPONENT_LIBRARY_APP_PREFIX . " === undefined? {form: $val, root_url:'" . DROIP_COMPONENT_LIBRARY_ROOT_URL . "'} : {..." . DROIP_COMPONENT_LIBRARY_APP_PREFIX . ", form:{...(" . DROIP_COMPONENT_LIBRARY_APP_PREFIX . ".form || {}), ...$val}};";

    $script_tags .= "<script data='" . DROIP_COMPONENT_LIBRARY_APP_PREFIX . "-elements-property-vars'>$script</script>";

    return $script_tags;
  }

  public function load_element_scripts_and_styles()
  {
    add_filter(DROIP_APP_PREFIX . '_add_script_tags', array($this, 'add_component_library_script'));
    //phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.NonceVerification.Recommended,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    $action = sanitize_text_field(isset($_GET['action']) ? $_GET['action'] : null);
    if ('droip' !== $action) {
      add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style(DROIP_COMPONENT_LIBRARY_APP_PREFIX, DROIP_COMPONENT_LIBRARY_ROOT_URL . 'assets/css/' . 'main.min.css');
        wp_enqueue_script(DROIP_COMPONENT_LIBRARY_APP_PREFIX, DROIP_COMPONENT_LIBRARY_ROOT_URL . 'assets/js/' . 'preview.min.js', array(), false, array('in_footer' => true));
      });
    }
  }

  public function element_generator($string, $props)
  {
    $this->load_element_scripts_and_styles();
    $props['component_lib_forms'] = $this->component_lib_forms;
    $hide = false;
    if (
      'droip-login-error' === $props['element']['name'] ||
      'droip-register-error' === $props['element']['name'] ||
      'droip-forgot-password-error' === $props['element']['name'] ||
      'droip-change-password-error' === $props['element']['name'] ||
      'droip-retrieve-username-error' === $props['element']['name']
    ) {
      $hide = true;
    }
    $eg = new ElementGenerator($props);
    $gen = $eg->generate_common_element($hide);
    $this->component_lib_forms = $eg->component_lib_forms;
    return $gen;
  }

  public function modify_external_collection_options($options, $args)
    {
      $commentCollection = [
          'title'               => 'Comments',
          'value'               => 'comments',
          'inherit'             => true,
          'pegination'         => true,
          'default_select_type' => "comment",
          'group'               => [
              ['title' => 'Post Comments', 'value' => "comment", 'itemType' => 'comment'],
              //TODO: need to get all comment type and add it as list here
          ],
      ];
      $options[] = $commentCollection;
      return $options;
    }

    public function droip_collection_comments($value, $args){
      $all_comments = [];
      $c_args = ['post_id' => $args['post_parent']];
      if (isset($args['parent_item_type']) && $args['parent_item_type'] === 'comment') {
        $c_args['parent'] = $args['context']['comment_ID'];
      } else if(isset($args['context']['comment_ID'])){
        $c_args['parent'] = $args['context']['comment_ID'];
      }

      $c_args['current_page'] = 1;
      $c_args['item_per_page'] = 100;
      $ac = HelperFunctions::get_comments($c_args);

      foreach ($ac['data'] as $comment) {
          $all_comments[] = array(
              'id'              => $comment->comment_ID,
              'comment_post_ID'        => $comment->comment_post_ID,
              'comment_author'         => $comment->comment_author,
              'comment_author_email'   => $comment->comment_author_email,
              'comment_author_url'     => $comment->comment_author_url,
              'comment_date'           => $comment->comment_date,
              'comment_date_gmt'       => $comment->comment_date_gmt,
              'comment_content'        => $comment->comment_content,
              'comment_approved'       => $comment->comment_approved,
              'comment_agent'          => $comment->comment_agent,
              'comment_type'           => $comment->comment_type,
              'comment_parent'         => $comment->comment_parent,
              'user_id'        => $comment->user_id,
          );
      }
      return [
                'data'       => $all_comments,
                'pagination' => [],
                'itemType'   => 'comment',
            ];
    }

    public function droip_dynamic_content($value, $args)
    {
        if (isset($args['dynamicContent'])) {
          if ($args['dynamicContent']['type'] === 'comment' ) {
              if(isset($args['options']['comment'], $args['dynamicContent']['value'], $args['options']['comment'][$args['dynamicContent']['value']])) {
                  return $args['options']['comment'][$args['dynamicContent']['value']];
              }else if(isset($args['dynamicContent']['value'])){
                return $args['dynamicContent']['value'];
              }
          }
        }
        return $value;
    }
}


new DroipComponentLibrary();