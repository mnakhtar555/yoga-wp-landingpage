<?php
/*
Template Name: Yoga Landingpage
*/
?>

<?php get_header(); ?>

        <div class="hero-section">
            <div class="model">
                <img src="<?php echo esc_url(get_post_meta($post->ID, 'header_img_url', true ) );?>" class="model-img" alt="">
                <img src="<?php echo esc_url(get_post_meta( $post->ID, 'header_bg_img_url', true) ); ?>" class="header-model-texture" alt="">
            </div>
            <div class="title">
                <h1 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'lp_title', true ); ?></h1>
                <p  data-aos="fade-up" data-aos-duration="1500" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'lp_header_p', true ); ?></p>
                <a href="#"  data-aos="fade-up" data-aos-duration="2000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'lp_header_btn', true ); ?></a>
            </div>
        </div>
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'right_bg_texture_url', true, ) ); ?>" class="half-bg-texture" alt="">
    </div>
    <!-- Header Ends -->
    <!-- Class Options Section -->
    <div class="class">
        <h2 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta($post->ID, 'class_part_title', true ); ?></h2>
        <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'class_part_p', true ); ?></p>
        <div class="class-options">
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <img src="<?php echo esc_url(get_post_meta( $post->ID, 'newbie_img_url', true ) );?>" alt="" class="model-pic">
                <img src="<?php echo esc_url( get_post_meta( $post->ID, 'class_model_texture_url', true ) );?>" alt="" class="bg-texture">
                <h3><?php echo get_post_meta( $post->ID, 'newbie_title', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'newbie_paragraph', true ); ?></p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <img src="<?php echo esc_url( get_post_meta( $post->ID, 'advanced_img_url', true));?>" alt="" class="model-pic">
                <img src="<?php echo esc_url( get_post_meta( $post->ID, 'class_model_texture_url', true ) );?>" alt="" class="bg-texture">
                <h3><?php echo get_post_meta( $post->ID, 'advanced_title', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'advanced_paragraph', true ); ?></p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <img src="<?php echo esc_url(get_post_meta( $post->ID, 'expert_img_url', true ) ); ?>" alt="" class="model-pic">
                <img src="<?php echo esc_url( get_post_meta( $post->ID, 'class_model_texture_url', true ) );?>" alt="" class="bg-texture">
                <h3><?php echo get_post_meta( $post->ID, 'expert_title', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'expert_paragraph', true ); ?></p>
            </div>
        </div>
    </div> 
    <!-- Class section ends -->

    <!-- Our Starts Section -->
    <div class="start">
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'starts_bg_url', true));?>" alt="" class="section-bg">
        <img src="<?php echo get_template_directory_uri();?>/images/start-texture.png" alt="" class="start-texture">
        <h2 data-aos="fade-down" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'starts_part_title', true ); ?></h2>
        <p data-aos="fade-down" data-aos-duration="1500" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'starts_part_p', true ); ?></p>
        <div class="number-cards">
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'circle_one_num', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'circle_one_p', true ); ?></p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'circle_two_num', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'circle_two_p', true ); ?></p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'circle_three_num', true ); ?></h3>
                <p><?php echo get_post_meta( $post->ID, 'circle_three_p', true ); ?></p>
            </div>
        </div>
    </div>
    <!-- Our Starts Section Ends -->
    
    <!-- Best Instructor Section -->
    <div class="instructor">
        <div class="text" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="0">
            <h2><?php echo get_post_meta( $post->ID, 'instructor_title', true ); ?></h2>
            <p><?php echo get_post_meta( $post->ID, 'instructor_p', true ); ?></p>
            <a href="#"><?php echo get_post_meta( $post->ID, 'instructor_btn', true ); ?></a>
        </div>
        <div class="image"><img src="<?php echo esc_url( get_post_meta( $post->ID, 'instructor_img_url', true ) );?>" alt="" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="0"></div>
    </div>
    <!-- Best Instructor Section Ends -->

    <!-- Blog Section -->
    <div class="blog-section">
    	<?php 
    	$yoga_posts = new WP_Query( array(
    			'post_type'		=> 'post',
    			'posts_per_page'=> 1
    	) );
    	while( $yoga_posts->have_posts() ) : $yoga_posts->the_post()
    	?>
        <div class="model-image" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="0"><?php the_post_thumbnail(); ?></div>
        <div class="article" data-aos="fade-up-left" data-aos-duration="1000" data-aos-delay="0">
            <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
            <p>
	            <?php
	            echo wp_trim_words( get_the_content(), 15, '' );
	            ?>
        	</p>
            <a class="read-more" href="<?php the_permalink(); ?>">read more</a>
            
        </div>
        <?php endwhile; wp_reset_postdata();?>
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'right_bg_texture_url', true ) );?>" alt="" class="blog-texture" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="0">

    </div>
    <!-- Blog Section Ends -->
    <!-- Price section -->
    <div class="price">
        <h2 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'price_part_title', true ); ?></h2>
        <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'price_part_p', true ); ?></p>
        <div class="price-cards">
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'newbie_price_card_title', true ); ?></h3>
                <h3><?php echo get_post_meta( $post->ID, 'newbie_price_card_value', true ); ?></h3>
                <img src="<?php echo get_template_directory_uri();?>/images/price-card-icon.png" alt="" class="price-icon">
                <p><?php echo get_post_meta( $post->ID, 'newbie_price_card_text', true ); ?></p>
                <a href="#"><?php echo get_post_meta( $post->ID, 'price_card_btn', true ); ?></a>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'advanced_price_card_title', true ); ?></h3>
                <h3><?php echo get_post_meta( $post->ID, 'advanced_price_card_value', true ); ?></h3>
                <img src="<?php echo get_template_directory_uri();?>/images/price-card-icon.png" alt="" class="price-icon">
                <p><?php echo get_post_meta( $post->ID, 'advanced_price_card_text', true ); ?></p>
                <a href="#"><?php echo get_post_meta( $post->ID, 'price_card_btn', true ); ?></a>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <h3><?php echo get_post_meta( $post->ID, 'expert_price_card_title', true ); ?></h3>
                <h3><?php echo get_post_meta( $post->ID, 'expert_price_card_value', true ); ?></h3>
                <img src="<?php echo get_template_directory_uri();?>/images/price-card-icon.png" alt="" class="price-icon">
                <p><?php echo get_post_meta( $post->ID, 'expert_price_card_text', true ); ?></p>
                <a href="#"><?php echo get_post_meta( $post->ID, 'price_card_btn', true ); ?></a>
            </div>
        </div>
    </div>
    <!-- Price section Ends -->

    <!-- Trainer Section -->
    <div class="trainer">
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'trainer_bg_url', true ) );?>" alt="" class="trainer-bg">
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'trainer_img_url', true ) );?>" alt="" class="model-img">
        <img src="<?php echo esc_url( get_post_meta( $post->ID, 'trainer_texture_url', true ) );?>" alt="" class="model-texture">
        <div class="profile-text">
            <p data-aos="fade-right" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'trainer_p', true ); ?></p>
            <h3 data-aos="fade-left" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'trainer_name', true ); ?></h3>
        </div>
    </div>
    <!-- Trainer Section Ends -->

    <!-- Subscribe Form section -->
    <div class="subscribe">
        <h2  data-aos="fade-down" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'subscribe_title', true ); ?></h2>
        <p  data-aos="fade-down" data-aos-duration="1000" data-aos-delay="0"><?php echo get_post_meta( $post->ID, 'subscribe_p', true ); ?></p>
        <input type="email" name="" id=""  data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
        <button type="submit"  data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">subscribe</button>
    </div>
    <!-- Subscribe Form section Ends -->

<?php get_footer(); ?>