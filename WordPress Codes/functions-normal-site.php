<?php
/**
 * Edufab functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Edufab
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function edufab_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Edufab, use a find and replace
		* to change 'edufab' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'edufab', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'edufab' ),
			'footer' => esc_html__( 'Footer Company', 'ampowr' ),
			'footer-2' => esc_html__( 'Footer Help', 'ampowr' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'edufab_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'edufab_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function edufab_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'edufab_content_width', 640 );
}
add_action( 'after_setup_theme', 'edufab_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edufab_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'edufab' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'edufab' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'edufab_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function edufab_scripts() {
	wp_enqueue_style( 'edufab-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'edufab-style', 'rtl', 'replace' );

	wp_enqueue_script( 'edufab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'edufab_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




/**
 * 
 *  Pritam Custom code ===========================>
 * 
 * */

 if( function_exists('acf_add_options_page') ) {  

	acf_add_options_page(array(
        'page_title'    => 'Options',
        'menu_title'    => 'Options',
        'menu_slug'     => 'Options',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'position' => 2
    ));
}

/**
 * Support Excerpt in Pages
 */

add_post_type_support( 'page', 'excerpt' );


/**
 * Support SVG files
 */

function add_svg_to_upload_mimes( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'add_svg_to_upload_mimes' );


/**
 * Code for Header Menu Active 
 */

 class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        // Add "active" class to the current menu item
        if ($item->current || $item->current_item_ancestor) {
            $item->classes[] = 'active';
        }

        // Call the parent method to generate the menu item
        parent::start_el($output, $item, $depth, $args);
    }
}

/** 
 *  Add Extra class for mobile menu collaps.
 */

 function my_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
    if ( $args->walker->has_children && $depth === 0 ) {
        $item_output = preg_replace('/(<a.*?>[^<]+<\/a>)/', '$1 <span><i class="fas fa-chevron-down"></i></span>', $item_output);
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'my_walker_nav_menu_start_el', 10, 4);


/**
 * Create Custom Post Type : Product
 */

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
add_action('acf/init', 'acf_taxonomy_add_image_field');


/**
 * Create Widget Support
 */

function widget_registration($name, $id, $description,$beforeWidget, $afterWidget, $beforeTitle, $afterTitle){
	register_sidebar( array(
		'name' => $name,
		'id' => $id,
		'description' => $description,
		'before_widget' => $beforeWidget,
		'after_widget' => $afterWidget,
		'before_title' => $beforeTitle,
		'after_title' => $afterTitle,
	));
}

function multiple_widget_init(){
	widget_registration('Product widget', 'product-sidebar-1', 'Category Filter', '', '', '', '');
	widget_registration('Product Sort', 'product-sidebar-2', 'Sort By', '', '', '', '');
}

add_action('widgets_init', 'multiple_widget_init');


/**
 * Create Custom Post Type : Testimonials
 */

 function create_testiminials_post_type() {
	register_post_type( 'testiminials',
		array(
			'labels' => array(
				'name' => 'Testimonials' ,
				'singular_name' => 'Testimonials',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Testimonials',
				'edit_item' => 'Edit Testimonials',
				'new_item' => 'New Testimonials',
				'view_item' => 'View Testimonials',
				'search_items' => 'Search Testimonials',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-businessman',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_testiminials_post_type' );


/**
 * Create Custom Post Type : Jobs
 */

 function create_jobs_post_type() {
	register_post_type( 'jobs',
		array(
			'labels' => array(
				'name' => 'Jobs' ,
				'singular_name' => 'Jobs',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Jobs',
				'edit_item' => 'Edit Jobs',
				'new_item' => 'New Jobs',
				'view_item' => 'View Jobs',
				'search_items' => 'Search Jobs',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-welcome-learn-more',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_jobs_post_type' );

function my_taxonomies_jobs() {
	$labels = array(
	  'name'              => _x('Jobs Categories', 'taxonomy general name' ),
	  'singular_name'     => _x('Jobs Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Search Jobs Categories' ),
	  'all_items'         => __( 'All Jobs Categories' ),
	  'parent_item'       => __( 'Parent Jobs Category' ),
	  'parent_item_colon' => __( 'Parent Jobs Category:' ),
	  'edit_item'         => __( 'Edit Jobs Category' ), 
	  'update_item'       => __( 'Update Jobs Category' ),
	  'add_new_item'      => __( 'Add New Jobs Category' ),
	  'new_item_name'     => __( 'New Jobs Category' ),
	  'menu_name'         => __( 'Jobs Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_ui' => true,
	  'show_admin_column' => true, 
	  'query_var' => true,
	);
	register_taxonomy( 'jobs-category', 'jobs', $args );
}
add_action( 'init', 'my_taxonomies_jobs', 0 );

