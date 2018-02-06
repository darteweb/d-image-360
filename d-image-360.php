<?php
/*
Plugin Name: DImage 360 
Plugin URI: http://www.darteweb.com/
Version: 1.1
Author: D'arteweb
Description: DImage 360 Slider use shortcode [dimage url="http://www.darteweb.com/images/Prague_Getty.jpg"]
*/
function wp_dimage_msg_form_scripts() {
   
    wp_enqueue_style('d-style', plugin_dir_url(__FILE__)."css/d-style.css");
	wp_enqueue_script('photo-sphere-js1', plugin_dir_url(__FILE__).'js/photo-sphere-viewer.min.js',array('jquery'), true);
    wp_enqueue_script('three-min', plugin_dir_url(__FILE__).'js/three.min.js',array('jquery'), true);
}
add_action('wp_enqueue_scripts','wp_dimage_msg_form_scripts');


function dimage_fun( $atts ) {

$atts = shortcode_atts(
	array(
		'url' => '',
	), $atts, 'dimage' );	
ob_start();

?>
<div id="dtcontainer"></div>
<script>
var div = document.getElementById('dtcontainer');
var PSV = new PhotoSphereViewer({
		panorama: '<?php echo $atts['url']; ?>',
		container: div,
		time_anim: 3000,
		navbar: true,
		navbar_style: {
			backgroundColor: 'rgba(58, 67, 77, 0.7)'
		},		
	});
</script>   
<?php  
return ob_get_clean();
}
add_shortcode('dimage', 'dimage_fun' );
