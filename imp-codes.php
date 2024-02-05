<?php 
/**
 * 
 * Some Important Code-Snippets
 * 
 */
?>


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