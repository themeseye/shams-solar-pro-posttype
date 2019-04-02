<?php 
/*
 Plugin Name: Shams Solar Pro Posttype
 lugin URI: https://www.themeseye.com/
 Description: Creating new post type for shams solar pro Theme.
 Author: Themeseye
 Version: 1.0
 Author URI: https://www.themeseye.com/
*/

define( 'shams_solar_pro_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'shams_solar_pro_posttype_create_post_type' );
add_action( 'init', 'createcategory');

function shams_solar_pro_posttype_create_post_type() {
  register_post_type( 'testimonials',
    array(
  		'labels' => array(
  			'name' => __( 'Testimonials','shams-solar-pro-posttype' ),
  			'singular_name' => __( 'Testimonials','shams-solar-pro-posttype' )
  		),
  		'capability_type' => 'post',
  		'menu_icon'  => 'dashicons-businessman',
  		'public' => true,
  		'supports' => array(
  			'title',
  			'editor',
  			'thumbnail'
  		)
		)
	);
  register_post_type( 'services',
    array(
      'labels' => array(
        'name' => __( 'Services','shams-solar-pro-posttype' ),
        'singular_name' => __( 'Services','shams-solar-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'project',
    array(
      'labels' => array(
        'name' => __( 'Projects','shams-solar-pro-posttype' ),
        'singular_name' => __( 'Projects','shams-solar-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Team','shams-solar-pro-posttype' ),
        'singular_name' => __( 'Team','shams-solar-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
}
/*--------------- Project section ----------------*/
function createcategory() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Project Category', 'shams-solar-pro-posttype' ),
    'singular_name'     => __( 'Project Category', 'shams-solar-pro-posttype' ),
    'search_items'      => __( 'Search Ccats', 'shams-solar-pro-posttype' ),
    'all_items'         => __( 'All Project Category', 'shams-solar-pro-posttype' ),
    'parent_item'       => __( 'Parent Project Category', 'shams-solar-pro-posttype' ),
    'parent_item_colon' => __( 'Parent Project Category:', 'shams-solar-pro-posttype' ),
    'edit_item'         => __( 'Edit Project Category', 'shams-solar-pro-posttype' ),
    'update_item'       => __( 'Update Project Category', 'shams-solar-pro-posttype' ),
    'add_new_item'      => __( 'Add New Project Category', 'shams-solar-pro-posttype' ),
    'new_item_name'     => __( 'New Project Category Name', 'shams-solar-pro-posttype' ),
    'menu_name'         => __( 'Project Category', 'shams-solar-pro-posttype' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'createcategory' ),
  );
  register_taxonomy( 'createcategory', array( 'project' ), $args );
}
// --------------- Services ------------------
// Serives section
function shams_solar_pro_posttype_images_metabox_enqueue($hook) {
  if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
    wp_enqueue_script('sayara-automotive-pro-posttype-images-metabox', plugin_dir_url( __FILE__ ) . '/js/img-metabox.js', array('jquery', 'jquery-ui-sortable'));

    global $post;
    if ( $post ) {
      wp_enqueue_media( array(
          'post' => $post->ID,
        )
      );
    }

  }
}
add_action('admin_enqueue_scripts', 'shams_solar_pro_posttype_images_metabox_enqueue');

function shams_solar_pro_posttype_bn_meta_callback_services( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    
}


function shams_solar_pro_posttype_bn_meta_save_services( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
 
  
}
add_action( 'save_post', 'shams_solar_pro_posttype_bn_meta_save_services' );

// Service Meta
function our_services_posttype_bn_custom_meta_services() {

    add_meta_box( 'bn_meta', __( 'Service Meta', 'testimonial-posttype-pro' ), 'our_services_posttype_bn_meta_callback_services', 'services', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'our_services_posttype_bn_custom_meta_services');
}
function our_services_posttype_bn_meta_callback_services( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $meta_image = get_post_meta( $post->ID, 'meta-image', true );
    ?>
  <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <p>
            <label for="meta-image"><?php echo esc_html('Icon Image'); ?></label><br>
            <input type="text" name="meta-image" id="meta-image" class="meta-image regular-text" value="<?php echo esc_attr($meta_image); ?>">
            <input type="button" class="button image-upload" value="Browse">
          </p>
          <div class="image-preview"><img src="<?php echo $bn_stored_meta['meta-image'][0]; ?>" style="max-width: 250px;"></div>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

function our_services_posttype_bn_meta_save_services( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Save Image
  if( isset( $_POST[ 'meta-image' ] ) ) {
      update_post_meta( $post_id, 'meta-image', esc_url_raw($_POST[ 'meta-image' ]) );
  }
 
}

/*------------------ Testimonial section -------------------*/

/* Adds a meta box to the Testimonial editing screen */
function shams_solar_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'shams-solar-pro-posttype-testimonial-meta', __( 'Enter Details', 'shams-solar-pro-posttype' ), 'shams_solar_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'shams_solar_pro_posttype_bn_testimonial_meta_box');
}

/* Adds a meta box for custom post */
function shams_solar_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'shams_solar_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
	$desigstory = get_post_meta( $post->ID, 'shams_solar_pro_posttype_testimonial_desigstory', true );
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php _e( 'Designation', 'shams-solar-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="shams_solar_pro_posttype_testimonial_desigstory" id="shams_solar_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function shams_solar_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['shams_solar_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['shams_solar_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'shams_solar_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'shams_solar_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'shams_solar_pro_posttype_testimonial_desigstory']) );
	}

}

add_action( 'save_post', 'shams_solar_pro_posttype_bn_metadesig_save' );

/*---------------Testimonials shortcode -------------------*/
function shams_solar_pro_posttype_testimonial_func( $atts ) {

    $testimonial = ''; 
    $testimonial = '<div id="testimonials">
                    <div class="row">';
    $custom_url = '';
      $new = new WP_Query( array( 'post_type' => 'testimonials' ) );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();

          $post_id = get_the_ID();
          $excerpt = wp_trim_words(get_the_excerpt(),25);
          if(has_post_thumbnail()) {
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );
            $thumb_url = $thumb['0'];
          }
          $designation= get_post_meta($post_id,'shams_solar_pro_posttype_testimonial_desigstory',true);
            $testimonial .= '<div class="col-md-6 col-lg-6">
                        <div class="testi-data "> 
                          <div class="testimonial_box w-100 mb-3 box-testi">
                            <div class="short_text pb-3">
                              <p>'.$excerpt.'</p>
                            </div>
                            <div class="row">
                              <div class="col-lg-3 col-md-4">
                                <div class="textimonial-img">
                                  <img src="'.$thumb_url.'" alt=""/>
                                </div>
                              </div>
                              <div class="col-lg-9 col-md-8">
                                <div class="content_box w-100">
                                    <h4 class="testimonial_name">
                                      <a href="'.get_permalink().'">'.get_the_title().'</a>
                                    </h4>
                                    <p class="dest_testimonials"><cite>'.esc_html($designation).'</cite></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>';  
            $testimonial .= '</div>';

            if($k%3 == 0){
                $testimonial.= '<div class="clearfix"></div>'; 
            } 
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $testimonial = '<h2 class="center">'.__('Not Found','shams-solar-pro-posttype').'</h2>';
      endif;
    $testimonial.= '</div></div>';
  return $testimonial;
  //
}
add_shortcode( 'shams-solar-pro-testimonials', 'shams_solar_pro_posttype_testimonial_func' );

/*------------------ Featured services section -------------------*/

/* Adds a meta box to the services editing screen */
function shams_solar_pro_posttype_bn_services_meta_box() {
  add_meta_box( 'shams-solar-pro-posttype-testimonial-meta', __( 'Enter Details', 'shams-solar-pro-posttype' ), 'shams_solar_pro_posttype_bn_services_meta_callback', 'services', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'shams_solar_pro_posttype_bn_services_meta_box');
}

/* Adds a meta box for custom post */
function shams_solar_pro_posttype_bn_services_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'shams_solar_pro_posttype_posttype_services_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );  
  ?>
  <div id="testimonials_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function shams_solar_pro_posttype_project_bn_metadesig_save( $post_id ) {
  if (!isset($_POST['shams_solar_pro_posttype_posttype_services_meta_nonce']) || !wp_verify_nonce($_POST['shams_solar_pro_posttype_posttype_services_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Save desig.
    // Save eye
    if( isset( $_POST[ 'meta-eyeicon' ] ) ) {
        update_post_meta( $post_id, 'meta-eyeicon', esc_url($_POST[ 'meta-eyeicon' ]) );
    }
    

}

add_action( 'save_post', 'shams_solar_pro_posttype_project_bn_metadesig_save' );
/*------------------ Team section -------------------*/

/* Adds a meta box to the Team editing screen */
function shams_solar_pro_posttype_bn_team_meta_box() {
  add_meta_box( 'shams-solar-pro-posttype-team-meta', __( 'Enter Details', 'shams-solar-pro-posttype' ), 'shams_solar_pro_posttype_bn_team_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'shams_solar_pro_posttype_bn_team_meta_box');
}

/* Adds a meta box for custom post */
function shams_solar_pro_posttype_bn_team_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'shams_solar_pro_posttype_posttype_team_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  $twitterurl = get_post_meta( $post->ID, 'meta-twitter', true );
  $facebookurl = get_post_meta( $post->ID, 'meta-facebook', true );
  $linkedinurl = get_post_meta( $post->ID, 'meta-linkedin', true );
  $youtubeurl = get_post_meta( $post->ID, 'meta-youtube', true );
  $googleurl = get_post_meta( $post->ID, 'meta-google', true );
  $desginaton = get_post_meta( $post->ID, 'shams_solar_pro_posttype_team_desgination_title', true );
  ?>
  <div id="team_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Twitter', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-twitter" id="meta-twitter" value="<?php echo esc_attr( $twitterurl ); ?>" />
          </td>
        </tr>
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Facebook', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-facebook" id="meta-facebook" value="<?php echo esc_attr( $facebookurl ); ?>" />
          </td>
        </tr>
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Linkedin', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-linkedin" id="meta-linkedin" value="<?php echo esc_attr( $linkedinurl ); ?>" />
          </td>
        </tr>
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Youtube', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-youtube" id="meta-youtube" value="<?php echo esc_attr( $youtubeurl ); ?>" />
          </td>
        </tr>
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Google', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-google" id="meta-google" value="<?php echo esc_attr( $googleurl ); ?>" />
          </td>
        </tr>
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Designation', 'shams-solar-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="shams_solar_pro_posttype_team_desgination_title" id="shams_solar_pro_posttype_team_desgination_title" value="<?php echo esc_attr( $desginaton ); ?>" />
          </td>
        </tr>
        
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function shams_solar_pro_posttype_team_bn_metadesig_save( $post_id ) {
  if (!isset($_POST['shams_solar_pro_posttype_posttype_team_meta_nonce']) || !wp_verify_nonce($_POST['shams_solar_pro_posttype_posttype_team_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Save desig.
  
  if( isset( $_POST[ 'meta-facebook' ] ) ) {
    update_post_meta( $post_id, 'meta-facebook', sanitize_text_field($_POST[ 'meta-facebook']) );
  }
  if( isset( $_POST[ 'meta-twitter' ] ) ) {
    update_post_meta( $post_id, 'meta-twitter', sanitize_text_field($_POST[ 'meta-twitter']) );
  }
  if( isset( $_POST[ 'meta-linkedin' ] ) ) {
    update_post_meta( $post_id, 'meta-linkedin', sanitize_text_field($_POST[ 'meta-linkedin']) );
  }
  if( isset( $_POST[ 'meta-youtube' ] ) ) {
    update_post_meta( $post_id, 'meta-youtube', sanitize_text_field($_POST[ 'meta-youtube']) );
  }
  if( isset( $_POST[ 'meta-google' ] ) ) {
    update_post_meta( $post_id, 'meta-google', sanitize_text_field($_POST[ 'meta-google']) );
  }
   if( isset( $_POST[ 'shams_solar_pro_posttype_team_desgination_title' ] ) ) {
    update_post_meta( $post_id, 'shams_solar_pro_posttype_team_desgination_title', sanitize_text_field($_POST[ 'shams_solar_pro_posttype_team_desgination_title']) );
  }
  
}

add_action( 'save_post', 'shams_solar_pro_posttype_team_bn_metadesig_save' );

/*------------ SHORTCODES ----------------*/


/* services shortcode */
function shams_solar_pro_posttype_services_func( $atts ) {
  $services = '';
  $services = '<div class="row" id="services">';
  $query = new WP_Query( array( 'post_type' => 'services') );

    if ( $query->have_posts() ) :

  $k=1;
  $new = new WP_Query('post_type=services');

  while ($new->have_posts()) : $new->the_post();
        $custom_url ='';
        $post_id = get_the_ID();
        $services_icon= get_post_meta($post_id,'meta-image',true);
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
        $url = $thumb['0'];
        $excerpt = wp_trim_words(get_the_excerpt(),10);
        $custom_url = get_permalink();
        $services .= '<div class="col-lg-4 col-md-6 col-sm-6 services-box">
                        <div class="mb-4 mt-1"> 
                          <div class="courses postbox" >
                            <div class="postpic box">
                              <div class="service-img">
                                <img src="'.esc_url($url).'">
                              </div>
                              <div class="box-content">
                                 <div class="services_icons">
                                    <div class="services_icon">
                                      <img class="text-center" src="'.esc_url($services_icon).'">
                                    </div>
                                  </div>
                                <p class="post">'.$excerpt.'</p>   
                                </div>
                              </div>
                              <h4 class="title"><a href="'.esc_url($custom_url).'">'.esc_html(get_the_title()) .'</a></h4>
                          </div>
                      </div>
                  </div>';


    if($k%2 == 0){
      $services.= '<div class="clearfix"></div>';
    }
      $k++;
  endwhile;
  else :
    $services = '<h2 class="center">'.esc_html__('Post Not Found','shams-solar-pro').'</h2>';
  endif;
  $services .= '</div>';
  return $services;
}

add_shortcode( 'shams-solar-pro-services', 'shams_solar_pro_posttype_services_func' );


/* Team shortcode */
function shams_solar_pro_posttype_team_func( $atts ) {
  $team = '';
  $team = '<div class="row" id="team">';
  $query = new WP_Query( array( 'post_type' => 'team') );

    if ( $query->have_posts() ) :

  $k=1;
  $new = new WP_Query('post_type=team');

  while ($new->have_posts()) : $new->the_post();
        $custom_url ='';
        $post_id = get_the_ID();
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
        $url = $thumb['0'];
        $facebookurl = get_post_meta($post_id,'meta-facebook',true);
        $twitter = get_post_meta($post_id,'meta-twitter',true);
        $linkedinurl = get_post_meta($post_id,'meta-linkedin',true);
        $youtubeurl = get_post_meta($post_id,'meta-youtube',true);
        $googleurl = get_post_meta($post_id,'meta-google',true);
        $desginaton = get_post_meta($post_id,'shams_solar_pro_posttype_team_desgination_title',true);
        $excerpt = wp_trim_words(get_the_excerpt(),15);
        $custom_url = get_permalink();
        $team .= '<div class="col-lg-3 mb-3 col-md-4 col-sm-6 team_box">
                    <div class="testi-data mt-4"> 
                      <div class="box w-100 categorybox" >
                          <div class="team-img box-img">
                              <img src="'.esc_url($url).'">
                            <div class="content">
                              <ul class="icon">';
                                 if($facebookurl != '' || $linkedinurl != '' || $twitter != ''){ 
                                   if($linkedinurl != ''){
                                      $team .= '<li><a class="" href="'.esc_url($linkedinurl).'" target="_blank"><i class="fab fa-linkedin-in"></i></a></a></li>';
                                     } if($facebookurl != ''){
                                      $team .= '<li><a class="" href="'.esc_url($facebookurl).'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';                          
                                     } 
                                     if($twitter != ''){
                                      $team .= '<li><a class="" href="'.esc_url($twitter).'" target="_blank"><i class="fab fa-twitter"></i></a></li>';                          
                                     } 
                                     if($youtubeurl != ''){
                                      $team .= '<li><a class="" href="'.esc_url($youtubeurl).'" target="_blank"><i class="fab fa-youtube"></i></a></li>';                          
                                     } 
                                     if($googleurl != ''){
                                      $team .= '<li><a class="" href="'.esc_url($googleurl).'" target="_blank"><i class="fab fa-google"></i></a></li>';                          
                                     } 
                                  }
                              $team .=   '</ul>  
                            </div>
                          </div>       
                      </div>
                      <div class="content_box w-100">
                        <div class="team-box">
                          <h4 class="team_name"><a href="'.esc_url($custom_url).'">'.esc_html(get_the_title()) .'</a></h4>
                        </div>                               
                        <div class="team_paragraph"><p class="dest_team">'.$desginaton.'</p>
                        </div>
                      </div>
                    </div>
                  </div>';

    if($k%2 == 0){
      $team.= '<div class="clearfix"></div>';
    }
      $k++;
  endwhile;
  else :
    $team = '<h2 class="center">'.esc_html__('Post Not Found','shams-solar-pro').'</h2>';
  endif;
  $team .= '</div>';
  return $team;
}

add_shortcode( 'shams-solar-pro-team', 'shams_solar_pro_posttype_team_func' );

// --------------- projects Shortcode --------------

function shams_solar_pro_posttype_projects_func( $atts ) {
  $projects = '';
  $projects = '<div class="row" id="our_projects">';
  $query = new WP_Query( array( 'post_type' => 'project') );

    if ( $query->have_posts() ) :

  $k=1;
  $new = new WP_Query('post_type=project');
  while ($new->have_posts()) : $new->the_post();

        $post_id = get_the_ID();
        $project_cat= get_post_meta($post_id,'meta-project-cat',true);
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );
        if(has_post_thumbnail()) { $thumb_url = $thumb['0']; }
        $url = $thumb['0'];
        $custom_url ='';
        $excerpt = wp_trim_words(get_the_excerpt(),10);
        $custom_url = get_permalink();
        $projects .= '
            <div class="col-lg-4 col-md-6 col-sm-6 project-box">
              <div class="box">
                <img src="'.esc_url($thumb_url).'" />
                <div class="box-content">
                    <h4 class="title"><a href="'.esc_url($custom_url).'">'.esc_html(get_the_title()) .'</a></h4>
                </div>
              </div>
            </div>';
    if($k%2 == 0){
      $projects.= '<div class="clearfix"></div>';
    }
      $k++;
  endwhile;
  else :
    $projects = '<h2 class="center">'.esc_html__('Post Not Found','shams_solar_pro_posttype').'</h2>';
  endif;
  return $projects;
}

add_shortcode( 'shams-solar-pro-projects', 'shams_solar_pro_posttype_projects_func' );