<?php get_header(); ?>
    <div class="wrapper">
        <div class="container">
            <h1>Hello world!</h1>
            <div class="products-container">
                <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 12
                        );
                    $loop = new WP_Query( $args );
                    if ( $loop->have_posts() ) {
                        while ( $loop->have_posts() ) : $loop->the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                    } else {
                        echo __( 'No products found' );
                    }
                    wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>