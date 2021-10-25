<?php
/*
Plugin Name: Loading img
Author: webfood
Plugin URI: http://webfood.info/
Description: Loading img
Version: 0.1
Author URI: http://webfood.info/
Text Domain: Loading img
Domain Path: /languages

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright 2021 (email : webfood.info@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!(is_admin())) {
  function output_loading_img() {
    wp_register_style( 'loading_img', false );
    wp_enqueue_style( 'loading_img' , 0);
  	$theme_color = get_theme_mod( 'theme_color', '#a9a9a9');
  	$svg = file_get_contents(  plugin_dir_path( __FILE__ ).'loading.svg');
  	$svg = base64_encode(str_replace("#a9a9a9", $theme_color, $svg));

    $css = "
      img, iframe {
        background-image: url('data:image/svg+xml;base64,".$svg."') !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size:30% auto !important;
  	  }
  		.adsbygoogle iframe{
        background-size:20% auto !important;
        background-position: 50% 20% !important;
      }
  		";
  
  	wp_add_inline_style( 'loading_img', $css );
  }
  add_action( 'wp_enqueue_scripts', 'output_loading_img', -100);

	function remove_loading_img() {
		echo <<< EOM
<script>
var imgs = document.querySelectorAll( 'img' );
imgs.forEach(function(img) {
  if(img.complete){
		img.setAttribute('style', 'background-image: none !important');
  }else{
		img.onload = function() {
      img.setAttribute('style', 'background-image: none !important');
	  };
	}
});
</script>
EOM;
	}
	add_action( 'shutdown', 'remove_loading_img' );
}
