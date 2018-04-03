<?php
/*
Plugin Name: DImage 360 
Author URI: http://www.darteweb.com/
Version: 1.3
Author: D'arteweb
Description: DImage 360 Slider use shortcode [dimage url="please enter here image url" control="true"]
*/

function wp_dimage_msg_form_scripts() {
    wp_enqueue_style('d-style', plugins_url( 'css/d-style.css', __FILE__));
	wp_enqueue_script('photo-sphere-js1', plugins_url( 'js/photo-sphere-viewer.min.js', __FILE__),array('jquery'), true);
    wp_enqueue_script('three-min', plugins_url( 'js/three.min.js', __FILE__),array('jquery'), true);
}
add_action('wp_enqueue_scripts','wp_dimage_msg_form_scripts');


class DimagePlugin {
public function dimage_inline_script($atts) {
	$script = '
	jQuery(document).ready(function(){
	var div = document.getElementById("dtcontainer");
        var PSV = new PhotoSphereViewer({
                        panorama: "'.$atts['url'].'",
                        container: div,
                        time_anim : 3000,
                        navbar: '.$atts['control'].',
                        navbar_style: {
                                backgroundColor: "rgba(58, 67, 77, 0.7)"
                        },		
                });
				});';
   wp_enqueue_script('dimage-main-js', plugins_url('js/dimage-main-js.js', __FILE__), array(),'1.0');
   wp_add_inline_script('dimage-main-js', $script );
}	
	
public function dimage_fun($atts) 
{
   $atts = shortcode_atts(
	array(
		'url' => '',
		'control'=>true,
	), $atts, 'dimage' );	
	
	ob_start();
	if($atts['url'] === '')
	{
		echo 'Please enter any URL of image.';	
	}
	$file_headers = @get_headers($atts['url']);
	if(strpos($file_headers[0], 'Not Found') !== false || empty($file_headers))
	{
		echo 'Image Not Found.';	
	}else
	{
	?>
        <div id="dtcontainer"></div>
        <?php  
		self::dimage_inline_script($atts);
	} 	
        return ob_get_clean();
}
}
add_shortcode( 'dimage', array( 'DimagePlugin', 'dimage_fun' ) );
