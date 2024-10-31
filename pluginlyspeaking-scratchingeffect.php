<?php 
/**
 * Plugin Name: PluginlySpeaking ScratchingEffect
 * Plugin URI: http://pluginlyspeaking.com/plugins/scratching-effect/
 * Description: Get a scratching effect on an image.
 * Author: PluginlySpeaking
 * Version: 3.0
 * Author URI: http://www.pluginlyspeaking.com
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'psse_add_script' );

function psse_add_script() {
	wp_enqueue_style( 'psse_css', plugins_url('css/psse.css', __FILE__));
	wp_enqueue_script( 'psse_js', plugins_url('js/psse.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script("jquery");
}

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', 'psse_add_admin_style' );
function psse_add_admin_style() {
	wp_enqueue_style( 'psse_admin', plugins_url('css/psse_admin.css', __FILE__));
}

function psse_create_type() {
  register_post_type( 'scratching_effect_ps',
    array(
      'labels' => array(
        'name' => 'Scratching Effect',
        'singular_name' => 'Scratching Effect'
      ),
      'public' => true,
      'has_archive' => false,
      'hierarchical' => false,
      'supports'           => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

add_action( 'init', 'psse_create_type' );


function psse_admin_css() {
    global $post_type;
    $post_types = array( 
                        'scratching_effect_ps',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#edit-slug-box, #post-preview, #view-post-btn{display: none;}</style>';
}

function psse_remove_view_link( $action ) {

    unset ($action['view']);
    return $action;
}

add_filter( 'post_row_actions', 'psse_remove_view_link' );
add_action( 'admin_head-post-new.php', 'psse_admin_css' );
add_action( 'admin_head-post.php', 'psse_admin_css' );

function psse_check($cible,$test){
  if($test == $cible){return ' checked="checked" ';}
}

add_action('add_meta_boxes','psse_init_advert_metabox');

function psse_init_advert_metabox(){
  add_meta_box('psse_advert_metabox', 'Upgrade to PRO Version', 'psse_add_advert_metabox', 'scratching_effect_ps', 'side', 'low');
}

function psse_add_advert_metabox($post){	
	?>
	
	<ul style="list-style-type:disc;padding-left:20px;">
		<li>More scratching shape</li>
		<li>Multiple outcomes</li>
		<li>% before discovered</li>
		<li>Device restriction</li>
		<li>User restriction</li>
		<li>And more...</li>
	</ul>
	<a style="text-decoration: none;display:inline-block; background:#33b690; padding:8px 25px 8px; border-bottom:3px solid #33a583; border-radius:3px; color:white;" target="_blank" href="http://pluginlyspeaking.com/plugins/scratching-effect/">See all PRO features</a>
	<span style="display:block;margin-top:14px; font-size:13px; color:#0073AA; line-height:20px;">
		<span class="dashicons dashicons-tickets"></span> Code <strong>SE10OFF</strong> (10% OFF)
	</span>
	<?php 
	
}

add_action('add_meta_boxes','psse_init_content_metabox');

function psse_init_content_metabox(){
  add_meta_box('psse_content_metabox', 'Build your Scratching Effect', 'psse_add_content_metabox', 'scratching_effect_ps', 'normal');
}

function psse_add_content_metabox($post){
	$prefix = '_scratching_effect_';

	$first_image = get_post_meta($post->ID, $prefix.'first_image',true);
	$second_image = get_post_meta($post->ID, $prefix.'second_image',true);
	$scratch_shape = get_post_meta($post->ID, $prefix.'scratch_shape',true);
	if($scratch_shape == "")
		$scratch_shape = "round";
	
	$scratch_size = get_post_meta($post->ID, $prefix.'scratch_size',true);
	if($scratch_size == "")
		$scratch_size = "medium";
	
	$offset_x = get_post_meta($post->ID, $prefix.'offset_x',true);
	if($offset_x == "")
		$offset_x = "0";
	$offset_y = get_post_meta($post->ID, $prefix.'offset_y',true);
	if($offset_y == "")
		$offset_y = "0";
	
	$action_lose = get_post_meta($post->ID, $prefix.'action_lose',true);
	
	$lose_url = get_post_meta($post->ID, $prefix.'lose_url',true);
	$lose_modal = get_post_meta($post->ID, $prefix.'lose_modal',true);

	
	?>
	
	<h2 class="psse_admin_title">Images settings</h2>
	
		<table class="psse_table_100_3td">
			<tr>
				<td class="psse_td_label">
					<label for="first_image" >Scratchable Image : </label>
				</td>
				<td>
					<input type="text" id="psse_media_firstimage" name="first_image" class="psse_url_input" value="<?php echo $first_image; ?>" />
					<input type="button" class="button firstimage-button" value="Choose an image" />
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td class="psse_td_label">
					<label for="second_image" >Discovered Image : </label>
				</td>
				<td>
					<input type="text" id="psse_media_secondimage" name="second_image" class="psse_url_input" value="<?php echo $second_image; ?>" />
					<input type="button" class="button secondimage-button" value="Choose an image" />
				</td>
				<td>
				</td>
			</tr>
		</table>
		
	<h2 class="psse_admin_title">Scratching styling</h2>
		
	<table class="psse_table_100_3td">
		<tr>
			<td class="psse_td_label">
				<label for="scratch_shape">Scratching shape : </label>
			</td>
			<td class="psse_td_thin">
				<select name="scratch_shape" class="psse_select_150p">
					<option <?php selected( $scratch_shape, "round"); ?> value="round">Round</option>
					<option <?php selected( $scratch_shape, "star");  ?> value="star">Star</option>
				</select>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td class="psse_td_label">
				<label for="scratch_size">Scratching size : </label>
			</td>
			<td class="psse_td_thin">
				<select name="scratch_size" class="psse_select_150p">
					<option <?php selected( $scratch_size, "small"); ?> value="small">Small</option>
					<option <?php selected( $scratch_size, "medium");  ?> value="medium">Medium</option>
					<option <?php selected( $scratch_size, "big");  ?> value="big">Big</option>
				</select>
			</td>
			<td>
			</td>
		</tr>
	</table>
	
	<h2 class="psse_admin_title">Post scratching settings</h2>

	<table class="psse_table_100_3td">
		<tr>
			<td class="psse_win_lose_no psse_td_label">
				<label for="action_lose">Click on the discovered image : </label>
			</td>
			<td>
				<input type="radio" id="psse_lose_nothing" class="psse_radio_margin" name="action_lose" value="nothing" <?php echo (empty($action_lose)) ? 'checked="checked"' : psse_check($action_lose,'nothing'); ?>><label class="psse_no_v_align" for="psse_lose_nothing">No action</label>
				<input type="radio" id="psse_lose_url" class="psse_radio_margin" name="action_lose" value="url" <?php echo (empty($action_lose)) ? '' : psse_check($action_lose,'url'); ?>><label class="psse_no_v_align" for="psse_lose_url">Open an URL</label>
				<input type="radio" id="psse_lose_modal" class="psse_radio_margin" name="action_lose" value="modal" <?php echo (empty($action_lose)) ? '' : psse_check($action_lose,'modal'); ?>><label class="psse_no_v_align" for="psse_lose_modal">Open a Modal Popup</label>
			</td>
		</tr>
		<tr class="psse_lose_url">
			<td class="psse_td_label">
				<label for="lose_url">URL : </label>
			</td>
			<td>
				<input type="text" name="lose_url" value="<?php echo $lose_url; ?>" />
			</td>
		</tr>
		<tr class="psse_lose_modal">
			<td class="psse_td_label">
				<label for="lose_modal">Modal Popup : </label>
			</td>
			<td>
				<?php
					$args_lose_modal = array('post_type' => 'psmp_modal', 'numberposts'=>-1);
					$custom_posts_lose_modal = get_posts($args_lose_modal);
					
					if ( $custom_posts_lose_modal ) {
						echo '<select name="lose_modal" class="psse_select_150p">';
						foreach ( $custom_posts_lose_modal as $post ) {
							echo '<option '.selected( $lose_modal, $post->ID).' value="'.$post->ID.'">'.$post->post_title.'</option>';
						}
						echo '</select>';
					} else {
						echo '<span class="psse_desc">There is no Modal Popup available. You have to create a <a href="https://wordpress.org/plugins/modal-popup/" target="_blank">Modal Popup</a> in order to display it.</span>';
					}
				?>
			</td>
		</tr>
	</table>

	<h2 class="psse_admin_title">Advanced scratching settings</h2>
	<span class="psse_desc" >Those settings are used to correct an offset issue, due to floating elements on the screen.</span>
	
	<table class="psse_table_100_3td">
		<tr>
			<td class="psse_td_label">
				<label for="offset_x">Offset Axis X : </label>
			</td>
			<td class="psse_td_thin">
				<input type="text" name="offset_x" value="<?php echo $offset_x; ?>" />
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td class="psse_td_label">
				<label for="offset_y">Offset Axis Y : </label>
			</td>
			<td class="psse_td_thin">
				<input type="text" name="offset_y" value="<?php echo $offset_y; ?>" />
			</td>
			<td>
			</td>
		</tr>
	</table>	
	
	
	<script type="text/javascript">
		$=jQuery.noConflict();
		jQuery(document).ready( function($) {
			if($('#psse_lose_nothing').is(':checked')) {
				$('.psse_lose_url').hide();
				$('.psse_lose_modal').hide();
			} 
			if($('#psse_lose_url').is(':checked')) {
				$('.psse_lose_url').show();
				$('.psse_lose_modal').hide();
			} 
			if($('#psse_lose_modal').is(':checked')) {
				$('.psse_lose_url').hide();
				$('.psse_lose_modal').show();
			} 
			
			$('input[name=action_lose]').live('change', function(){
				if($('#psse_lose_nothing').is(':checked')) {
					$('.psse_lose_url').hide();
					$('.psse_lose_modal').hide();
				} 
				if($('#psse_lose_url').is(':checked')) {
					$('.psse_lose_url').show();
					$('.psse_lose_modal').hide();
				} 
				if($('#psse_lose_modal').is(':checked')) {
					$('.psse_lose_url').hide();
					$('.psse_lose_modal').show();
				} 
			});
	
		});
	</script>
	
	<?php


}

add_action( 'admin_enqueue_scripts', 'psse_firstimage_enqueue' );
function psse_firstimage_enqueue() {
	global $typenow;
	if( $typenow == 'scratching_effect_ps' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'psse_media_firstimage-js', plugin_dir_url( __FILE__ ) . 'js/psse_media_firstimage.js', array( 'jquery' ) );
		wp_localize_script( 'psse_media_firstimage-js', 'psse_media_firstimage_js',
			array(
				'title' => __( 'Choose or Upload an image'),
				'button' => __( 'Use this file'),
			)
		);
		wp_enqueue_script( 'psse_media_firstimage-js' );
	}
}

add_action( 'admin_enqueue_scripts', 'psse_secondimage_enqueue' );
function psse_secondimage_enqueue() {
	global $typenow;
	if( $typenow == 'scratching_effect_ps' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'psse_media_secondimage-js', plugin_dir_url( __FILE__ ) . 'js/psse_media_secondimage.js', array( 'jquery' ) );
		wp_localize_script( 'psse_media_secondimage-js', 'psse_media_secondimage_js',
			array(
				'title' => __( 'Choose or Upload an image'),
				'button' => __( 'Use this file'),
			)
		);
		wp_enqueue_script( 'psse_media_secondimage-js' );
	}
}

add_action( 'manage_scratching_effect_ps_posts_custom_column' , 'psse_custom_columns', 10, 2 );

function psse_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$pre_slug = '' ;
		$pre_slug = $post->post_title;
		$slug = sanitize_title($pre_slug);
    	$shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[scratching_effect_ps name="'.$slug.'"]</strong>';
	    echo $shortcode; 
	    break;
    }
}

function psse_add_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_scratching_effect_ps_posts_columns' , 'psse_add_columns');

add_action('save_post','psse_save_metabox');
function psse_save_metabox($post_id){
	
	$prefix = '_scratching_effect_';
	
	//Metabox Settings
	if(isset($_POST['first_image'])){
		update_post_meta($post_id, $prefix.'first_image', esc_url($_POST['first_image']));
	}	
	if(isset($_POST['second_image'])){
		update_post_meta($post_id, $prefix.'second_image', esc_url($_POST['second_image']));
	}	
	if(isset($_POST['scratch_shape'])){
		update_post_meta($post_id, $prefix.'scratch_shape', sanitize_text_field($_POST['scratch_shape']));
	}	
	if(isset($_POST['scratch_size'])){
		update_post_meta($post_id, $prefix.'scratch_size', sanitize_text_field($_POST['scratch_size']));
	}
	if(isset($_POST['offset_x'])){
		update_post_meta($post_id, $prefix.'offset_x', sanitize_text_field($_POST['offset_x']));
	}	
	if(isset($_POST['offset_y'])){
		update_post_meta($post_id, $prefix.'offset_y', sanitize_text_field($_POST['offset_y']));
	}	
	if(isset($_POST['action_lose'])){
		update_post_meta($post_id, $prefix.'action_lose', sanitize_text_field($_POST['action_lose']));
	}
	if(isset($_POST['lose_url'])){
		update_post_meta($post_id, $prefix.'lose_url', esc_url($_POST['lose_url']));
	}
	if(isset($_POST['lose_modal'])){
		update_post_meta($post_id, $prefix.'lose_modal', sanitize_text_field($_POST['lose_modal']));
	}
}

function psse_shortcode($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
		
	global $post;
    $args = array('post_type' => 'scratching_effect_ps', 'numberposts'=>-1);
    $custom_posts = get_posts($args);
	$output = '';
	foreach($custom_posts as $post) : setup_postdata($post);
	$sanitize_title = sanitize_title($post->post_title);
	if ($sanitize_title == $name)
	{
	$prefix = '_scratching_effect_';
	$scratch_shape = get_post_meta( get_the_id(), $prefix . 'scratch_shape', true );
	$scratch_size = get_post_meta( get_the_id(), $prefix . 'scratch_size', true );
	$offset_x = get_post_meta( get_the_id(), $prefix . 'offset_x', true );
	if ($offset_x == '')
					$offset_x = 0;	
	$offset_y = get_post_meta( get_the_id(), $prefix . 'offset_y', true );
	if ($offset_y == '')
					$offset_y = 0;	
	$brush = plugins_url('img/'.$scratch_shape.'-'.$scratch_size.'.png', __FILE__);
    $first_image = get_post_meta( get_the_id(), $prefix . 'first_image', true );
	list($width_image, $height_image) = getimagesize($first_image);
	$second_image = get_post_meta( get_the_id(), $prefix . 'second_image', true );
	$action_disco = get_post_meta( get_the_id(), $prefix . 'action_lose', true );
	if ($action_disco == '')
		$action_disco = "nothing";	
	if ($action_disco == 'url')
		$action_disco_value = get_post_meta( get_the_id(), $prefix . 'lose_url', true );
	if ($action_disco == 'modal')
		$action_disco_value = get_post_meta( get_the_id(), $prefix . 'lose_modal', true );
				
	$postid = get_the_ID();

	$output = '';
	$output .= '<div class="psse_container" id="scratchable_'.$postid.'" style="width:'.$width_image.'px;height:'.$height_image.'px;">';
	$output .= '  <canvas class="psse_canvas" id="canvas_'.$postid.'" width="'.$width_image.'" height="'.$height_image.'"></canvas>';
	if($action_disco == "nothing")
		$output .= '  <img id="disc_'.$postid.'" style="visibility: hidden;" src="'.$second_image.'">';
	if ($action_disco == 'url')
		$output .= '  <a href="'.$action_disco_value.'"><img id="disc_'.$postid.'" style="visibility: hidden;" src="'.$second_image.'"></a>';	
	if ($action_disco == 'modal')
		$output .= '  <a href="#" id="psmp_open_'.$action_disco_value.'"><img id="disc_'.$postid.'" style="visibility: hidden;" src="'.$second_image.'"></a>';	
	$output .= '</div>';
	$output .= '<script type="text/javascript">';
	$output .= '$j=jQuery.noConflict();';
	$output .= '$j(document).ready(function()';
	$output .= '{';
	$output .= 'ScratchCard("'.$postid.'","'.$first_image.'","'.$brush.'",'.$offset_x.','.$offset_y.');';
	$output .= '});';
	$output .= '</script>';
	}
	endforeach; wp_reset_query();
	return $output;
}
add_shortcode( 'scratching_effect_ps', 'psse_shortcode' );


	
?>