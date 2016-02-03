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
  wp_register_style( 'ts-style', plugins_url('css/style.css', __FILE__) );
  wp_enqueue_style( 'ts-style' );
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
    'alt'         => '',
    'columns' => '2',
  ), $atts ) );

  $queried_post = get_post($post_id);

  static $count;
  if (!isset($count)) {
    $count = 0;
  }

  ob_start();

  if (!empty($queried_post) && $queried_post->post_status == 'publish') : ?>

    <div id="teaser-<?php print $post_id; ?>" class="teaser teaser-<?php echo $count + 1; ?> columns<?php echo $columns ?> <?php print $count % 2 == 0 ? 'even' : 'odd'; $count++; ?>">
      <div class="left">
        <?php if (has_post_thumbnail($post_id)) : ?>
          <div class="thumbnail">
            <a href="<?php print $queried_post->post_name; ?>">
              <?php
                $size = 'i_' . $width . 'x' . $height;
                add_image_size( $size, $width, $height, 1 );

                require_once(ABSPATH . 'wp-admin/includes/image.php');

                $attached = get_post_thumbnail_id($post_id);
                $file = get_attached_file($attached);
                $pathinfo = pathinfo($file);

                $basename = $pathinfo['filename'] . '-' . $width . 'x' . $height . '.' . $pathinfo['extension'];
                $src = $pathinfo['dirname'] . '/' . $basename;

                if (empty($alt)) {
                  $alt = $basename;
                }
                if (!file_exists($src)) {
                  $upload_dir = wp_upload_dir();
                  $metadata = wp_generate_attachment_metadata( $attached, $file );
                  if ($filename = $metadata['sizes'][$size]['file']) {
                    $src = $upload_dir['url'] . '/' . $filename;
                    if ($width != $metadata['sizes'][$size]['width'] || $height != $metadata['sizes'][$size]['height']) {
                      $src = '';
                      $alt = 'Invalid image ratio. Correct size: ' . $metadata['sizes'][$size]['width'] . 'x' . $metadata['sizes'][$size]['height'];
                    }
                  }
                  else {
                    $src = $upload_dir['url'] . '/' . $basename;
                    $alt = 'It was not possible to generate the thumbnail. Make sure you are not trying to upsize the image.';
                  }
                }
                // Get relative path.
                $src = str_replace(getcwd(), '', $src);
                echo '<img src="' . $src . '" width="' . $width . '" height="' . $height . '" class="teaser" alt="' . $alt . '" />';
              ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <div class="right">
        <h2 class="title"><a href="<?php print $queried_post->post_name; ?>"><?php echo $queried_post->post_title; ?></a></h2>

        <?php preg_match("/(.*)<!--more-->/", $queried_post->post_content, $matches); ?>
        <?php if (isset($matches[1])) : ?>
          <?php $summary = preg_replace('/\[(.*)\]/', '', $matches[1]); //Remove shortcodes. ?>
          <div class="summary"><?php print strip_tags($summary); ?></div>
        <?php endif; ?>
      </div>

    </div>
  <?php endif;

  return ob_get_clean();
}
add_shortcode('insert_teaser', 'teaser_shortcode');
