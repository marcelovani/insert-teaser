<?php
/*
Plugin Name: Insert Teaser
Plugin URI: http://gginternational.net
Description: Allow you to insert a teaser excerpt of any post in any part of the page using shortcodes.
Version: 1.0
Author: Marcelo Vani
Author URI: https://about.me/marcelovani
License: GPL
*/

/**
 * Add CSS.
 */
function teaser_shortcode_css() {
  $plugindir = get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
  wp_enqueue_style( 'style-name', $plugindir . '/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'teaser_shortcode_css' );

/**
 * Teaser shortcode callback.
 * @param $atts
 * @return string
 */
function teaser_shortcode( $atts ) {
  $post_id = 0;
  $width = 0;
  $height = 0;

  extract( shortcode_atts( array(
    'post_id'      => '',
    'width'       => '150',
    'height'       => '150',
    'columns' => '2',
  ), $atts ) );

  $queried_post = get_post($post_id);

  static $count;
  if (!isset($count)) {
    $count = 0;
  }

  ob_start();

  if (!empty($queried_post) && $queried_post->post_status == 'publish') : ?>

    <div id="teaser-<?php print $post_id; ?>" class="teaser columns<?php echo $columns ?> <?php print $count % 2 == 0 ? 'even' : 'odd'; $count++; ?>">
      <div class="left">
        <?php if (has_post_thumbnail($post_id)) : ?>
          <div class="thumbnail">
            <a href="<?php print $queried_post->post_name; ?>">
              <?php print get_the_post_thumbnail($post_id, array($width, $height)); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <div class="right">
        <h2 class="title"><a href="<?php print $queried_post->post_name; ?>"><?php echo $queried_post->post_title; ?></a></h2>

        <?php preg_match("/(.*)<!--more-->/", $queried_post->post_content, $matches); ?>
        <?php if (isset($matches[1])) : ?>
          <div class="summary"><?php print $matches[1]; ?></div>
        <?php endif; ?>
      </div>

    </div>
  <?php endif;

  return ob_get_clean();
}
add_shortcode('insert_teaser', 'teaser_shortcode');
