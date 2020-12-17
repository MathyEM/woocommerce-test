<?php get_header(); ?>
    <div class="wrapper">
        <div class="employees-container container">
            <div class="employees-header">
                <h1 class="m-0">Hello World!</h1>
                <?php
                    $departments = get_terms( array(
                        'taxonomy' => 'departments',
                        'hide_empty' => false,
                    ) );
                ?>
                <select class="px-5 py-3 mb-4" name="sort-department" id="sort-department">
                    <option <?=($_GET['department'] === "0" ? "selected" : ""); ?> value="0">Alle afdelinger</option>
                    <?php //generate department options based on defined taxonomy terms
                        foreach ($departments as $department) {
                            $index++;
                            echo "<option " . ($_GET['department'] === $department->slug ? 'selected' : '') . " value='$department->slug'>$department->name</option>\n";
                        }
                    ?>
                </select>
            </div>
            <?php

                if ($_GET['department']) { 
                    $terms[0]->slug = $_GET['department'];
                    $terms[0]->name = $_GET['department'];
                } else {
                    $terms = get_terms( array(
                        'taxonomy' => 'departments',
                        'hide_empty' => false,
                    ) );
                }

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
                    <div class="department-section mb-5">
                        <!-- the loop -->
                        <div class="department-card bg-success text-white p-4">
                            <div class="row">
                                <div class="pb-4 col-12">
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
                            <div class="employee-container position-relative">
                                <?php the_post_thumbnail('medium'); ?>
                                <div class="employee-info position-absolute text-white w-100 h-100">
                                    <input class="invisible position-absolute" type="checkbox" name="toggle-info-<?=$post->ID;?>" id="toggle-info-<?=$post->ID;?>">
                                    <div class="info-overlay w-100 h-100 p-2">
                                        <div class="info-wrapper">
                                            <h5 class="font-weight-bold"><?php the_title(); ?></h5>
                                            <h5 class="m-0"><?=$department[0]->name;?>, <?=$job_title;?></h5>
                                            <a class="text-success m-0 mt-2" href="tel:0045<?=$tel_no?>"><h5>+45 <?=$tel_no;?></h5></a>
                                        </div>
                                        <label class="font-weight-bold m-0 px-2" for="toggle-info-<?=$post->ID;?>"><i class="bi bi-chevron-down"></i></label>
                                    </div>
                                </div>
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
    <script>
        jQuery('#sort-department').change(function(){
            var url = new URL(window.location.href);
            url.searchParams.set('department',this.value);
            window.location.href = url.href;
        });
    </script>
<?php get_footer(); ?>