<?php
/*
  Plugin Name: Bio
  Description: Plugin para exibir a Bio
  Version: 1.0
  Author: AdrianoScpace
  Author URI: http://adriano.space/
 */

function bio_refister_results()
{
    $path    = '/wp-content/plugins/wp-plugin-bio/assets/';
    $content = file_get_contents(__DIR__."/template.html");

    return str_replace('[@PATH]', $path, $content);

?>
    

<?php
}

add_shortcode('bio_results', 'bio_refister_results');

?>