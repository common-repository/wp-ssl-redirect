<?php
  
/**
* Plugin Name: WP SSL Redirect
* Description: A very tiny plugin to force SSL on WordPress websites (via 301 redirects for SEO purpose).
* Version: 1.6
* Author: Rehmat Alam
* Author URI: https://supportivehands.net/
* License: GPL2
*/

defined( 'ABSPATH' ) or die(); // Prevents direct access to plugin dir

add_action('admin_menu', function() {
    add_options_page( 'WP SSL Redirect Settings', 'WP SSL Redirect', 'manage_options', 'wp-ssl-redirect', 'wp_ssl_redirect' );
});
 
add_action( 'admin_init', function() {
    register_setting( 'wp-ssl-redirect-settings', 'wp_ssl_redirect_protocol' );
});
 
 
function wp_ssl_redirect() {
  ?>
    <div class="wrap">
      <h3>WP SSL Redirect Options</h3>
      <hr>
      <?php
        if(is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) {?>
          <div class="notice notice-error">
            <p>All In One SEO Pack is known to create issues with WP SSL Redirect so WP SSL Redirect's features will not work unless you will deactivate <strong>All In One SEO Pack</strong> first.</p>
        </div>
      <?php }?>
      <form action="options.php" method="post">
 
        <?php
          settings_fields( 'wp-ssl-redirect-settings' );
          do_settings_sections( 'wp-ssl-redirect-settings' );
        ?>
        <table>
 
            <tr>
                <th>Preferred Domain</th>
                <td>
 
                    <select name="wp_ssl_redirect_protocol">
                        <option value="auto-detect" <?php echo esc_attr( get_option('wp_ssl_redirect_protocol') ) == 'auto-detect' ? 'selected="selected"' : ''; ?>>Use-default (Uses site url)</option>
                        <option value="www" <?php echo esc_attr( get_option('wp_ssl_redirect_protocol') ) == 'www' ? 'selected="selected"' : ''; ?>>Force www version</option>
                        <option value="non-www" <?php echo esc_attr( get_option('wp_ssl_redirect_protocol') ) == 'non-www' ? 'selected="selected"' : ''; ?>>Force non-www version</option>
                    </select>
 
                </td>
            </tr>
 
            <tr>
                <td><?php submit_button(); ?></td>
            </tr>
 
        </table>
 
      </form>
    </div>
  <?php
}

function rw_has_www($url)
{
  return (bool) (strpos($url, '://www') !== false);
}

function do_the_ssl_redirect() {
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if(!is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
    $ori_url = rtrim($scheme . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '/');
    $redirectUrl = $ori_url;
    if(get_option('wp_ssl_redirect_protocol') == 'www') {
      if(!rw_has_www($ori_url)) {
        $redirectUrl = str_replace('://', '://www.', $ori_url);
      }
    } else if(get_option('wp_ssl_redirect_protocol') == 'non-www') {
      if(rw_has_www($ori_url)) {
        $redirectUrl = str_replace('//www.', '//', $ori_url);
      }
    }
    $redirectUrl = rtrim(str_replace('http://', 'https://', $redirectUrl), '/');
    if($ori_url !== $redirectUrl)
    {
      wp_redirect($redirectUrl, 301);
      exit;
    }
  }
}

add_action('send_headers', 'do_the_ssl_redirect');