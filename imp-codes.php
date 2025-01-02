<?php 
/**
 * 
 * Some Important Code-Snippets
 * 
 */
?>


<?php
/**
 * Change login URL with code functions.php
 */
// Redirect /wp-admin to 404 page
function redirect_wp_admin_to_404() {
    if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false && !is_user_logged_in()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        include(get_404_template());
        exit;
    }
}
add_action('init', 'redirect_wp_admin_to_404');

// Redirect /cd-editor to custom login page
function redirect_cd_editor_to_custom_login() {
    if (strpos($_SERVER['REQUEST_URI'], '/cd-editor') !== false && !is_user_logged_in()) {
        wp_redirect('http://localhost/pritam/Manafort/wp-login.php');
        exit;
    }
}
add_action('init', 'redirect_cd_editor_to_custom_login');
?>

<?php
/**
* #################################################################
*		Show an Extra Column(Template Name) on Every Pages
* #################################################################
*/	
	function add_template_column($columns) {

		$new_columns = array();
		
		foreach ($columns as $key => $value) {
			if ($key == 'author') {
				$new_columns['template'] = __('Template Name');
			}
			$new_columns[$key] = $value;
		}
		return $new_columns;
	}
	add_filter('manage_page_posts_columns', 'add_template_column');

	function display_template_column($column, $post_id) {
		if ($column == 'template') {
			$template = get_page_template_slug($post_id);
			if ($template) {
				$templates = wp_get_theme()->get_page_templates();
				echo isset($templates[$template]) ? $templates[$template] : $template;
			} else {
				echo __('Default Template');
			}
		}
	}
	add_action('manage_page_posts_custom_column', 'display_template_column', 10, 2); ?>



<!-- 
/**
 * Add Dinamic field in cf7
 */ -->
 
<!-- // Add this in CF7 -->
[text your-title readonly "your-post-title"] 
<!-- // Add this Script -->
<script>
	document.addEventListener( 'DOMContentLoaded', function() {
		var postTitle = '<?php echo addslashes( get_the_title() ); ?>';
		document.querySelector( 'input[name="your-title"]' ).value = postTitle;
	} );
</script>

<?php
/** 
 * Remove WordPress version number from scripts and styles
 */ 
function remove_wp_version_strings( $src ) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'remove_wp_version_strings');
add_filter('style_loader_src', 'remove_wp_version_strings');

/** 
 * Remove WordPress version number & Plugin version from scripts and styles
 */ 
function remove_script_version( $src ) {
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'remove_script_version' );
add_filter( 'style_loader_src', 'remove_script_version' );

?>

/**
* Disable add new Plugin option on dashboard
*/
<!-- In config.php file -->
<?php 
	define('DISALLOW_FILE_EDIT', true);
	define('DISALLOW_FILE_MODS', true); 
?>

/**
<!-- Add Error message in Comments form submit without any value -->
*/
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentForm = document.getElementById('commentform');
        const errorMessage = document.createElement('p');
        errorMessage.classList.add('error-message', 'text-danger');
        
        commentForm.addEventListener('submit', function(event) {
            const commentField = document.getElementById('comment');
            if (commentField.value.trim() === '') {
                event.preventDefault();
                errorMessage.textContent = 'Please fill all required * fields.';
                commentForm.insertBefore(errorMessage, commentForm.firstChild);
            }
        });
    });
</script>


/**
* Star Ratins Given By Customer & Manage From Backend by ACF Field.
*/
<?php
$rev_num = get_field('ratings', $post->ID); 
$full_stars = floor($rev_num);
$partial_star = $rev_num - $full_stars;

for ($i = 1; $i <= $full_stars; $i++) { ?>
<li><i class="fas fa-star"></i></li>
<?php } if ($partial_star > 0) { ?>
<li><i class="fas fa-star-half-alt"></i></li>
<?php }
for ($i = ceil($rev_num); $i < 5; $i++) { ?>
<li><i class="far fa-star"></i></li>
<?php } ?>


/**
* Create Custom Post Type with Taxonomy Image Support : Product
*/
<?php
 function create_product_post_type() {
	register_post_type( 'product',
		array(
			'labels' => array(
				'name' => 'Products',
				'singular_name' => 'Product',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Product',
				'edit_item' => 'Edit Product',
				'new_item' => 'New Product',
				'view_item' => 'View Product',
				'search_items' => 'Search Products',
				'not_found' =>  'No products found',
				'not_found_in_trash' => 'No products found in Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-cart',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes','excerpt'),
		)
	);
}
add_action( 'init', 'create_product_post_type' );

/* ----------------------Create Custom Taxonomy Support------------------------ */

function my_taxonomies_product() {
	$labels = array(
	  'name'              => _x('Product Categories', 'taxonomy general name' ),
	  'singular_name'     => _x('Product Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Search Product Categories' ),
	  'all_items'         => __( 'All Product Categories' ),
	  'parent_item'       => __( 'Parent Product Category' ),
	  'parent_item_colon' => __( 'Parent Product Category:' ),
	  'edit_item'         => __( 'Edit Product Category' ), 
	  'update_item'       => __( 'Update Product Category' ),
	  'add_new_item'      => __( 'Add New Product Category' ),
	  'new_item_name'     => __( 'New Product Category' ),
	  'menu_name'         => __( 'Product Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_ui' => true,
	  'show_admin_column' => true, 
	  'query_var' => true,
	);
	register_taxonomy( 'product-category', 'product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );

function acf_taxonomy_add_image_field() {
	acf_add_local_field_group(array(
		'key' => 'group_5f0d2d0c6e3f4',
		'title' => 'Category Image',
		'fields' => array(
			array(
				'key' => 'field_5f0d2d1c6e3f5',
				'label' => 'Category Image',
				'name' => 'category_image',
				'type' => 'image',
				'instructions' => 'Upload the category image here.',
				'required' => 0,
				'conditional_logic' => 0,
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product-category',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}
add_action('acf/init', 'acf_taxonomy_add_image_field'); ?>

/**
* Call Those Taxonomy Image With Category Name.
*/
<?php
    $categories = get_terms(
        array(
            'taxonomy' => 'product-category',
            'hide_empty' => false,
        )
    ); 
    
    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $category_image = get_field('category_image', $category);
            if (!empty($category_image)) { ?>
<div class="swiper-slide">
    <div class="each-cat-box">
        <div class="each-cat-img">
            <img src="<?php echo $category_image['url']; ?>" alt="">
        </div>
        <h5><?php echo $category->name; ?></h5>
    </div>
</div>
<?php } } } ?>


<!-- Show Featured Image in Any-Pages -->
<?php $featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<?php echo $featured_image; ?>

<!-- Get Site title in footer -->
<?php echo get_bloginfo('name');?>

<!-- Fetch Logo from Site-settings menu -->
<?php the_custom_logo(); ?>

/**
* Display Post by Category
*/
<?php 
	$Project = new WP_Query(
		array(
			'post_type'=>'projects', 
			'post_status'=>'publish',
			'posts_per_page'=>'-1' ,
			'post__not_in' / 'post__in' => array(449),
			'orderby' => 'date' ,
			'order' => 'DESC' ,
			'tax_query' => array(
				array(
					'taxonomy' => 'TAXONOMY-NAME',
					'field'    => 'slug',
					'terms'    => array( 'Category_slug' ),  
				)
			)
		)
	);
?>

/**
* Show Specific Design with condition
*/
<?php
$allowed_post_ids = array(108, 449, 136, 134, 129);
if (in_array($post->ID, $allowed_post_ids)) { ?>
<HTML Content>
<?php } else {?>
<HTML Another Content>
<?php } ?>

/**
* Restritct Content word count in listing page
*/

<?php echo wp_trim_words( get_the_content(), 60 ); ?>

/**
* Show Different Jobs in a Single Modal w.r.t Job id (Job PostType)
*/
<div class="job_list">
    <?php           
		$args = array(
			'post_type' =>'jobs',
			'post_status' =>'publish',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'ASC'
		);

		$posts = new WP_Query($args);
		if($posts->have_posts()) {
			$i=1;
			while($posts->have_posts()) {
				$posts->the_post();
				$job_id = get_the_ID();
	?>
    <div class="row justify-content-between align-items-center">
        <div class="col-sm-7">
            <h5><?php echo $i;?>. <?php the_title(); ?></h5>
        </div>
        <div class="col-sm-5 text-end">
            <!-- Button trigger modal -->
            <button type="button" class="common-btn" data-bs-toggle="modal"
                data-bs-target="#jobModal-<?php echo $job_id; ?>"><?php the_field('button_title', $post->ID); ?>
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade car-mod" id="jobModal-<?php echo $job_id; ?>" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="jobModalLabel-<?php echo $job_id; ?>"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="jobModalLabel-<?php echo $job_id; ?>">
                        <img src="<?php the_field('site_logo','option');?>" alt="">
                        <?php the_title(); ?>
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php the_content(); ?>
                    <?php echo do_shortcode('[contact-form-7 id="2982b50" title="Job CV Upload"]'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $i++; } 
		wp_reset_postdata();
	}
	?>
</div>


<?php
/**
 *  Add special metabox for ant posttype
 */

// Add a metabox to the 'events' post type
function add_event_metabox() {
    add_meta_box(
        'event_details_metabox',
        'Event Details',
        'render_event_metabox',
        'events',
        'normal', // You can use 'side' or 'advanced' for the metabox position
        'high'    // You can use 'low', 'default', or 'high' for the priority
    );
}
add_action('add_meta_boxes', 'add_event_metabox');

// Render the content for the metabox
function render_event_metabox($post) {
    // Retrieve existing values from the database
    $event_date = get_post_meta($post->ID, '_event_date', true);

    // Output the HTML for the form
    ?>
    <label for="event_date">Event Date:</label>
    <input type="text" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" placeholder="YYYY-MM-DD" />

    <?php
}

// Save the metabox data
function save_event_metabox($post_id) {
    // Check if it's not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check if the nonce is set
    if (!isset($_POST['event_metabox_nonce']) || !wp_verify_nonce($_POST['event_metabox_nonce'], 'event_metabox_nonce')) return;

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) return;

    // Sanitize and save the data
    $event_date = sanitize_text_field($_POST['event_date']);
    update_post_meta($post_id, '_event_date', $event_date);
}
add_action('save_post', 'save_event_metabox');


/**
 * Show this to frontend
 */

// Assuming you are within the loop
while (have_posts()) : the_post();

    // Get the event date from post meta
    $event_date = get_post_meta(get_the_ID(), '_event_date', true);

    // Output the event date
    if (!empty($event_date)) {
        echo '<p>Event Date: ' . esc_html($event_date) . '</p>';
    }

    // Your other post content goes here
    the_title();
    the_content();

endwhile;



/**
 * Enable Comments in any custom post type
 */
function switch_on_comments_automatically(){
    global $wpdb;
    $wpdb->query( $wpdb->prepare("UPDATE $wpdb->posts SET comment_status = 'open'")); 
}
switch_on_comments_automatically();


/**
 * Add Views Count on Blog Post
 */
function gt_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    return "$count";
}

function gt_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}

function gt_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}

function gt_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo gt_get_post_view();
    }
}

add_filter( 'manage_posts_columns', 'gt_posts_column_views' );

add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' ); ?>

<?php gt_set_post_view(); // Add this to single-post Page ?>
<strong><i class="fa-solid fa-eye"></i>  <?php echo gt_get_post_view(); ?></strong>  // Add this to listing Page


<?php
	/**
	 * Hide Plugin from Dashboard Plugin list
	*/

	 function hide_specific_plugins( $plugins ) {
		$plugins_to_hide = array(
			'side-cart-woocommerce/xoo-wsc-main.php',
			'woo-variation-gallery/woo-variation-gallery.php',
		);
		foreach ( $plugins_to_hide as $plugin ) {
			if ( isset( $plugins[ $plugin ] ) ) {
				unset( $plugins[ $plugin ] );
			}
		}
		return $plugins;
	}
	
	add_filter( 'all_plugins', 'hide_specific_plugins' );
	


    /**
	* Add Extra Fields into Database during Registration Process
	*/

	function save_extra_customer_fields( $customer_id ) {
		if ( isset( $_POST['first_name'] ) && ! empty( $_POST['first_name'] ) ) {
			update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
		}
		
		if ( isset( $_POST['last_name'] ) && ! empty( $_POST['last_name'] ) ) {
			update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
		}
	}
	
	add_action( 'woocommerce_created_customer', 'save_extra_customer_fields' );
