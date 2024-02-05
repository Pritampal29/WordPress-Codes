<?php
/**
 * Ampowr functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ampowr
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
function ampowr_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Ampowr, use a find and replace
		* to change 'ampowr' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ampowr', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'ampowr' ),
			'footer' => esc_html__( 'Footer Batteries', 'ampowr' ),
			'footer-2' => esc_html__( 'Footer Energy', 'ampowr' ),
			'footer-3' => esc_html__( 'Footer Resources', 'ampowr' ),
			'footer-4' => esc_html__( 'Footer About', 'ampowr' ),
			'footer-5' => esc_html__( 'Footer Articles', 'ampowr' ),
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
			'ampowr_custom_background_args',
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
add_action( 'after_setup_theme', 'ampowr_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ampowr_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ampowr_content_width', 640 );
}
add_action( 'after_setup_theme', 'ampowr_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ampowr_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ampowr' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ampowr' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ampowr_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ampowr_scripts() {
	wp_enqueue_style( 'ampowr-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ampowr-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ampowr-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ampowr_scripts' );

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
        $item_output = preg_replace('/(<a.*?>[^<]+<\/a>)/', '$1 <span class="clickD"><i class="fa-sharp fa-solid fa-caret-down"></i></span>', $item_output);
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'my_walker_nav_menu_start_el', 10, 4);



/** 
 *  Add Extra Class on Language wise Pages - (Body tag)
 */

add_filter('body_class', 'add_extra_class_body');
function add_extra_class_body($classes){
	
$lang =get_language_attributes();
$arr = preg_split('/[\s="]+/', $lang ); 

    if($arr[1] == 'en-GB'){ 
		return array_merge( $classes, array( 'en-body' ) );
	}else if($arr[1] == 'nl-NL'){
		return array_merge( $classes, array( 'nl-body' ) );
	}else if($arr[1] == 'es-ES'){
		return array_merge( $classes, array( 'es-body' ) );
	}
}


/** 
 *  Set Limit of Excerpt Length.
 */

function custom_excerpt_length( $length ) {
    return 15; 
}
add_filter( 'excerpt_length', 'custom_excerpt_length' );



/**
 * Create Custom Post Type : Product
 */

 function create_product_post_type() {
	register_post_type( 'product',
		array(
			'labels' => array(
				'name' => 'Product' ,
				'singular_name' => 'Product',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Product',
				'edit_item' => 'Edit Product',
				'new_item' => 'New Product',
				'view_item' => 'View Product',
				'search_items' => 'Search Product',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-cart',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_product_post_type' );

function my_taxonomies_product() {
	$labels = array(
	  'name'              => _x( 'Product Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Product Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Product Categories' ),
	  'all_items'         => __( 'All Product Categories' ),
	  'parent_item'       => __( 'Parent Product Category' ),
	  'parent_item_colon' => __( 'Parent Product Category:' ),
	  'edit_item'         => __( 'Edit Product Category' ), 
	  'update_item'       => __( 'Update Product Category' ),
	  'add_new_item'      => __( 'Add New Product Category' ),
	  'new_item_name'     => __( 'New Product' ),
	  'menu_name'         => __( 'Product Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_admin_column' => true,
	);
	register_taxonomy( 'product-category', 'product', $args );
  }
  add_action( 'init', 'my_taxonomies_product', 0 );


/**
 * Create Custom Post Type : Battery
 */

 function create_battery_post_type() {
	register_post_type( 'battery',
		array(
			'labels' => array(
				'name' => 'Battery' ,
				'singular_name' => 'Battery',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Battery',
				'edit_item' => 'Edit Battery',
				'new_item' => 'New Battery',
				'view_item' => 'View Battery',
				'search_items' => 'Search Battery',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-block-default',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_battery_post_type' );

function my_taxonomies_battery() {
	$labels = array(
	  'name'              => _x( 'Battery Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Battery Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Battery Categories' ),
	  'all_items'         => __( 'All Battery Categories' ),
	  'parent_item'       => __( 'Parent Battery Category' ),
	  'parent_item_colon' => __( 'Parent Battery Category:' ),
	  'edit_item'         => __( 'Edit Battery Category' ), 
	  'update_item'       => __( 'Update Battery Category' ),
	  'add_new_item'      => __( 'Add New Battery Category' ),
	  'new_item_name'     => __( 'New Battery' ),
	  'menu_name'         => __( 'Battery Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_admin_column' => true,
	);
	register_taxonomy( 'battery-category', 'battery', $args );
  }
  add_action( 'init', 'my_taxonomies_battery', 0 );



/**
 * Create Custom Post Type : Energy Storage
 */

 function create_energy_post_type() {
	register_post_type( 'energy',
		array(
			'labels' => array(
				'name' => 'Energy' ,
				'singular_name' => 'Energy',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Energy',
				'edit_item' => 'Edit Energy',
				'new_item' => 'New Energy',
				'view_item' => 'View Energy',
				'search_items' => 'Search Energy',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-align-pull-left',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_energy_post_type' );

function my_taxonomies_energy() {
	$labels = array(
	  'name'              => _x( 'Energy Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Energy Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Energy Categories' ),
	  'all_items'         => __( 'All Energy Categories' ),
	  'parent_item'       => __( 'Parent Energy Category' ),
	  'parent_item_colon' => __( 'Parent Energy Category:' ),
	  'edit_item'         => __( 'Edit Energy Category' ), 
	  'update_item'       => __( 'Update Energy Category' ),
	  'add_new_item'      => __( 'Add New Energy Category' ),
	  'new_item_name'     => __( 'New Energy' ),
	  'menu_name'         => __( 'Energy Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_admin_column' => true,
	);
	register_taxonomy( 'energy-category', 'energy', $args );
  }
  add_action( 'init', 'my_taxonomies_energy', 0 );


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
	  'name'              => _x( 'Jobs Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Jobs Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Jobs Categories' ),
	  'all_items'         => __( 'All Jobs Categories' ),
	  'parent_item'       => __( 'Parent Jobs Category' ),
	  'parent_item_colon' => __( 'Parent Jobs Category:' ),
	  'edit_item'         => __( 'Edit Jobs Category' ), 
	  'update_item'       => __( 'Update Jobs Category' ),
	  'add_new_item'      => __( 'Add New Jobs Category' ),
	  'new_item_name'     => __( 'New Jobs' ),
	  'menu_name'         => __( 'Jobs Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_admin_column' => true,
	);
	register_taxonomy( 'jobs-category', 'jobs', $args );
  }
  add_action( 'init', 'my_taxonomies_jobs', 0 );



/**
 * Create Custom Post Type : Download
 */

 function create_download_post_type() {
	register_post_type( 'download',
		array(
			'labels' => array(
				'name' => 'Download' ,
				'singular_name' => 'Download',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Download',
				'edit_item' => 'Edit Download',
				'new_item' => 'New Download',
				'view_item' => 'View Download',
				'search_items' => 'Search Download',
				'not_found' =>  'Nothing Found',
				'not_found_in_trash' => 'Nothing found in the Trash',
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon'  => 'dashicons-download',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','page-attributes')
		)
	);

}
add_action( 'init', 'create_download_post_type' );

function my_taxonomies_download() {
	$labels = array(
	  'name'              => _x( 'Download Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Download Category', 'taxonomy singular name' ),
	  'search_items'      => __( 'Download Categories' ),
	  'all_items'         => __( 'All Download Categories' ),
	  'parent_item'       => __( 'Parent Download Category' ),
	  'parent_item_colon' => __( 'Parent Download Category:' ),
	  'edit_item'         => __( 'Edit Download Category' ), 
	  'update_item'       => __( 'Update Download Category' ),
	  'add_new_item'      => __( 'Add New Download Category' ),
	  'new_item_name'     => __( 'New Download' ),
	  'menu_name'         => __( 'Download Categories' ),
	);
	$args = array(
	  'labels' => $labels,
	  'hierarchical' => true,
	  'show_admin_column' => true,
	);
	register_taxonomy( 'download-category', 'download', $args );
  }
  add_action( 'init', 'my_taxonomies_download', 0 );