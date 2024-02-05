/**
*
* ISOTOPE Gallery Used for Various (Blogs,News,Jobs etc) Pages.
*
*/


<!-- Isotope menu -->
<div class="container _inport">
    <?php the_content();?>
    <div class="row">
        <div class="col-12">
            <div class="menu_iso text-center" id="custom-filter">
                <!--------------------------------------- Show all Categories --------------------------------------->
                <ul class="d-flex flex-wrap justify-content-center">
                    <li>
                        <button class="btn _in active text-uppercase" data-filter="*">Show all</button>
                    </li>
                    <?php
            $categories = get_terms('projects-category');
            foreach ($categories as $category) { ?>
                    <li>
                        <button class="btn _in"
                            data-filter=".<?php echo $category->slug; ?>"><?php echo $category->name; ?></button>
                    </li>
                    <?php     } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container port_gallery ">
        <div class="row" id="portfolio-items">

            <?php
            $args = array(
                'post_type' => 'projects',
                'posts_per_page' => -1,
                'orderby' => 'date' ,
                'order' => 'ASC' ,

            );
            $query = new WP_Query($args);

            while ($query->have_posts()) {
                $query->the_post();
                $categories = get_the_terms(get_the_ID(), 'projects-category');
                $category_classes = '';
                if ($categories) {
                    foreach ($categories as $category) {
                        $category_classes .= $category->slug . ' ';
                    }
                }
                ?>
            <!--------------------------------------- Show all Posts wrt Categories --------------------------------------->
            <div class="col-md-4 filterDiv gallery-item w-100  <?php echo $category_classes;?>">
                <a href="<?php the_permalink();?>">
                    <div class="port_grid card text-center">
                        <figure class="snip1205 orange">
                            <?php $featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                            <img src="<?php echo $featured_image; ?>" alt="" class="w-100" />
                        </figure>
                        <h4><?php the_title(); ?></h4>
                    </div>
                </a>
            </div>
            <?php } wp_reset_postdata();?>

        </div>
    </div>
</div>

<!-- Isotope Gallery -->




<!--------------------------------------- For Transition Effect --------------------------------------->
<script src="https://isotope.metafizzy.co/isotope.pkgd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script>
$(document).ready(function() {
    var customContainer = jQuery("#portfolio-items");
    customContainer.isotope({
        filter: "*",
        transitionDuration: "0.8s",
        animationOptions: {
            duration: 7500,
            queue: false
        },

        layoutMode: "fitRows",
        fitRows: {
            gutter: 0
        }
    });

    jQuery("#custom-filter ul li:first-child > button").addClass("is-checked");

    jQuery("#custom-filter button").click(function() {
        jQuery("#custom-filter .is-checked").removeClass("is-checked");
        jQuery(this).addClass("is-checked");

        var customSelector = jQuery(this).attr("data-filter");
        customContainer.isotope({
            filter: customSelector,
            transitionDuration: "0.8s",
            animationOptions: {
                duration: 7500,
                queue: false
            },
            layoutMode: "fitRows",
            fitRows: {
                gutter: 0
            }
        });
        return false;
    });
});
</script>



<script>

// For Adding Hashtag In Link

$(document).ready(function($) {
    var currentHash = '*';

    function changeHash(newHash) {
        window.location.hash = newHash;
        if (newHash === '*') {
            $("#portfolio-items .filterDiv").show('1000');
        } else {
            $("#portfolio-items .filterDiv").not('.' + newHash).hide('3000');
            $("#portfolio-items .filterDiv").filter('.' + newHash).show('3000');
        }
    }

    $(".btn").on('click', function() {
        var filter = $(this).data('filter');
        if (filter !== currentHash) {
            $(".btn[data-filter='" + currentHash + "']").removeClass('active'); // Remove "active" from the previous filter
            $(this).addClass('active'); // Add "active" to the clicked filter
            currentHash = filter;
            changeHash(filter);
        }
    });

    var initialHash = window.location.hash.replace('#', '');
    if (initialHash) {
        $(".btn[data-filter='" + initialHash + "']").click();
    }
});

</script>