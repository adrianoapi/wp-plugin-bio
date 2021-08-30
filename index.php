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
  add_menu_page(
    $options['title'      ], 
    $options['title'      ],
    'manage_options',
    $options['plugin_name'],
    $options['initial'    ]
  );
}

function bio_db_read()
{
  return json_decode(file_get_contents(__DIR__.'/db/database.json'), true);
}
 
/**
 * Configure admin view
 */
function bio_init()
{
  $options = bio_get_config();

  if(!empty($_POST))
  {
    $contentJson = [
      "isActive" => true,
      "english" => $_POST['bio_english'],
      "portuguese" => $_POST['bio_portuguese'],
      "image" => $_POST['image'],
    ];

    $fp = fopen(__DIR__.'/db/database.json', 'w');
    fwrite($fp, json_encode($contentJson));
    fclose($fp);
  }

  // Read db json
  $json = bio_db_read();

  # Está dentro de um dir, por isso volta um nível
  $path    = '../'.$options['path'].'assets/';
  $content = file_get_contents(__DIR__."/view/form.html");
  $content = str_replace('[@TITLE]', $options['title'], $content);
  $content = str_replace('[@ACTION]', 'page='.$options['plugin_name'], $content);
  $content = str_replace('[@PATH]', $path, $content);
  $content = str_replace('[@bio_english]', $json['english'], $content);
  $content = str_replace('[@bio_portuguese]', $json['portuguese'], $content);
  $content = str_replace('[@IMAGE_PERFIL]', $json['image'], $content);
  
  echo $content;

}
 
/**
 * Configure page view
 */
function bio_register_results()
{
    $json    = bio_db_read();
    $options = bio_get_config();
    $path    = $options['path'].'assets/';
    $content = file_get_contents(__DIR__."/view/template.html");
    $content = str_replace('[@PANEL_CONTENT_EN]', $json['english'], $content);
    $content = str_replace('[@PANEL_CONTENT_PT]', $json['portuguese'], $content);
    $content = str_replace('[@IMAGE_PERFIL]', $json['image'], $content);

    return str_replace('[@PATH]', $path, $content);

}

function bio_get_config()
{
  return [
    'title'       => 'Bio Configuration',
    'title_page'  => 'Bio Configuration Page',
    'plugin_name' => 'bio-plugin',
    'initial'     => 'bio_init',
    'path'        => '/wp-content/plugins/wp-plugin-bio/',
  ];
}

add_shortcode('bio_results', 'bio_register_results');

?>