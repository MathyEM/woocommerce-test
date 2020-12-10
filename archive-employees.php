<?php get_header(); ?>
    <div class="container">
        <h1>Hello World!</h1>
        <?php
            $terms = get_terms( array(
                'taxonomy' => 'departments',
                'hide_empty' => false,
            ) );

            // the query
            $args = array( 
                'tax_query' => array(
                    array (
                        'taxonomy' => 'departments',
                        'field' => 'slug',
                        'terms' => 'salgsafdeling',
                    )
                ),
                'post_type' => 'employees',
            );

            $the_query = new WP_Query( $args ); ?>

            
            <?php if ( $the_query->have_posts() ) : ?>
            
                <!-- pagination here -->
            
                <!-- the loop -->
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php $department = wp_get_post_terms($post->ID, 'departments'); ?>

                    <h2><?php the_title(); ?></h2>
                    <h3><?= $department[0]->name; ?></h3>
                    <br>
                <?php endwhile; ?>
                <!-- end of the loop -->
            
                <!-- pagination here -->
            
                <?php wp_reset_postdata(); ?>
            
            <?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
    </div>
<?php get_footer(); ?>