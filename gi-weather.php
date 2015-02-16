<?php
/*
Plugin Name: GI Weather
Description: This plugin integrates Open Weather API with WordPress users and other popular plugins
Version: 1.0.0
Plugin URI: http://gicoder.net/
Author: GI Coder
Author URI: http://gicoder.net/
*/


//load_plugin_textdomain( 'giw', false, 'gi-weather/languages' );


include(dirname(__FILE__).'/classes/gi_weather_settings.php');
include(dirname(__FILE__).'/classes/gi_weather_functions.php');

$obj = new gi_weather_settings_section();
$weather = new GIWeatherFunctions();

include(dirname(__FILE__).'/classes/gi_widget.php');


