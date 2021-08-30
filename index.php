<?php
/*
  Plugin Name: Bio
  Description: Plugin para exibir a Bio
  Version: 1.0
  Author: AdrianoScpace
  Author URI: http://adriano.space/
 */

add_action('admin_menu', 'plugin_bio_menu');
 
function plugin_bio_menu()
{
  $options = bio_get_config();
  add_menu_page($options['title'], $options['title'], 'manage_options',$options['plugin_name'], $options['initial'] );
}
 
/**
 * Configure admin view
 */
function bio_init()
{
  $options = bio_get_config();
  if(!empty($_POST))
  {
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
  }

  # Está dentro de um dir, por isso volta um nível
  $path    = './../wp-content/plugins/wp-plugin-bio/assets/';
  $content = file_get_contents(__DIR__."/view/form.html");
  $content = str_replace('[@TITLE]', $options['title'], $content);
  $content = str_replace('[@ACTION]', 'page=test-plugin', $content);
  $content = str_replace('[@PATH]', $path, $content);
  echo $content;

}
 
/**
 * Configure page view
 */
function bio_refister_results()
{
    $path    = '/wp-content/plugins/wp-plugin-bio/assets/';
    $content = file_get_contents(__DIR__."/view/template.html");

    return str_replace('[@PATH]', $path, $content);

}

function bio_get_config()
{
  return [
    'title' => 'Bio Configuration',
    'title_page' => 'Bio Configuration Page',
    'plugin_name' => 'bio-plugin',
    'initial' => 'bio_init',
  ];
}

add_shortcode('bio_results', 'bio_refister_results');

?>