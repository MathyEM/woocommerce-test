<?php get_header(); ?>
    <div class="wrapper">
        <h1>Hello World!</h1>
        <div class="employees-container container">
            <?php
                $terms = get_terms( array(
                    'taxonomy' => 'departments',
                    'hide_empty' => false,
                ) );
                
                foreach ($terms as $term) {            
                    // the query
                    $args = array( 
                        'tax_query' => array(
                            array (
                                'taxonomy' => 'departments',
                                'field' => 'slug',
                                'terms' => $term->slug,
                            )
                        ),
                        'post_type' => 'employees',
                    );

                    $the_query = new WP_Query( $args );
            ?>            
                <?php if ( $the_query->have_posts() ) : ?>
                    <!-- <pre>
                        <?php //var_dump($terms); ?>
                    </pre> -->
                    <div class="department-section">
                        <!-- the loop -->
                        <div class="department-card bg-success text-white p-5">
                            <div class="row">
                                <div class="pb-5 col-12">
                                    <h2><?=$term->name;?></h2>
                                </div>
                                <div class="col-6">
                                    <h3 class="font-weight-normal"><?php echo get_option('business_name');?></h3>
                                    <h3 class="font-weight-normal"><?php echo get_option('street_address');?></h3>
                                    <h3 class="font-weight-normal"><?php echo get_option('city');?></h3>
                                </div>
                                <div class="col-6">
                                    <h3 class="font-weight-normal"><?php echo get_option('support_phone');?></h3>
                                </div>
                            </div>
                        </div>
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <?php
                                $department = wp_get_post_terms($post->ID, 'departments');
                                $job_title = get_post_meta($post->ID, 'employee_title')[0];
                                $tel_no = get_post_meta($post->ID, 'employee_tel')[0];
                            
                            ?>
                            <div class="employee-container">
                                <?php the_post_thumbnail('medium'); ?>
                                <h2><?php the_title(); ?></h2>
                                <h3><?=$department[0]->name;?></h3>
                                <h4><?=$job_title;?></h4>
                                <a href="tel:0045<?=$tel_no?>"><h4>+45 <?=$tel_no;?></h4></a>
                            </div>
                        <?php endwhile; ?>
                        <!-- end of the loop -->            
                        <?php wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>
            <?php } ?>
        </div>
    </div>
<?php get_footer(); ?>