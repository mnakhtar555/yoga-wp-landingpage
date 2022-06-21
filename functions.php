<?php 

function nakhtar_yoga_landingpage_basic(){
	load_theme_textdomain( 'nakhtaryoga', get_template_directory() . '/lang' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', 
		array(
			'height' 	=> '40px',
			'width'		=> '40px',
		)
	);

}
add_action( 'after_setup_theme', 'nakhtar_yoga_landingpage_basic' );

//Adding Styles and Scripts files,

function nakhtar_yoga_styles_scripts(){
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fontawesome.css' );
	wp_enqueue_style( 'aos', get_template_directory_uri() . '/css/aos.css' );
	wp_enqueue_style( 'nakhtar', get_template_directory_uri() . '/css/style.css' );

	//scripts
	wp_enqueue_script( 'aos-script', get_template_directory_uri() . '/js/aos.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery', 'aos-script' ), time(), true );


}
add_action( 'wp_enqueue_scripts', 'nakhtar_yoga_styles_scripts' );

//Menu 
class Menus{
	public function __construct(){
		add_action( 'init', [ $this, 'nakhtar_yoga_menu_register' ] );
	}

	public function nakhtar_yoga_menu_register(){
		register_nav_menus( 
			array(
				'nakhtar_yoga_top_menu'		=> esc_html__( 'Main Menu', 'nakhtaryoga' ),
				'nakhtar_footer_menu'		=> esc_html__( 'Footer Menu', 'nakhtaryoga' ),
				'nakhtar_footer_second_nav'	=> esc_html__( 'Footer Second Navigation', 'nakhtaryoga' )
			) 
	);
	}

	public function get_menu_id( $location ){
		$locations = get_nav_menu_locations();
		$menu_id = $locations[ $location ];

		return !empty( $menu_id ) ? $menu_id : '';
	}
}
$menu_class = new Menus();


//Custom Fields For Landing Page 

class NakhtarYogaMb{

    public function __construct(){

        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_add_metabox' ) );
        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_class_add_mb' ) );
        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_starts_add_mb' ) );
        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_instructor_add_mb' ) );
        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_pricing_add_mb' ) );
        add_action( 'admin_menu', array( $this, 'nakhtar_yoga_trainer_add_mb' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_save_mb_data' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_image_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_class_data_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_class_image_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_starts_data_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_starts_img_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_instructor_data_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_price_data_save' ) );
        add_action( 'save_post', array( $this, 'nakhtar_yoga_trainer_data_save' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'nakhtar_yoga_assets' ) );
    }

    public function nakhtar_yoga_assets(){
    	wp_enqueue_style( 'nakhtar-yoga-style',get_template_directory_uri() . '/css/nakhtar-admin.css' );
    	
    	wp_enqueue_script( 'nakhtar-yoga-script', get_template_directory_uri() . '/js/nakhtar-admin.js', array( 'jquery'), time(), true );
    }

    private function is_secured( $nonce_field, $action, $post_id ){
        $nonce = isset( $_POST[ $nonce_field ] ) ? $_POST[ $nonce_field ] : '';
        if( $nonce == '' ){
            return false;
        }
        if( ! wp_verify_nonce( $nonce, $action ) ){
            return false;
        }
        if( ! current_user_can( 'edit_post', $post_id ) ){
            return false;
        }
        if( wp_is_post_autosave( $post_id ) ){
            return false;
        }
        if( wp_is_post_revision( $post_id ) ){
            return false;
        }
        return true;
    }

    public function nakhtar_yoga_add_metabox(){
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_id'];
	$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );

		if( $yoga_template == 'landingpage.php' ){
	        add_meta_box( 
	            'nakhtar_yoga_lp_title', 
	            __( 'Landingpage Contents', 'nakhtaryoga' ),
	            array( $this, 'nakhtar_yoga_lp_mb_display' ),
	            'page' 
	        );
	        add_meta_box(
	        	'nakhtar_yoga_header_image',
	        	__( 'Header Image', 'nakhtaryoga' ),
	        	array( $this, 'nakhtar_yoga_header_img_display' ),
	        	'page'
	        );
	        
	    }
    }
    public function nakhtar_yoga_class_add_mb(){
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_id'];
		$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
    	if( $yoga_template == 'landingpage.php' ){
    		//Classes Section Metaboxes
	        add_meta_box(
	        	'nakhtar_yoga_class_mb',
	        	__( 'Class Section Contents', 'nakhtaryoga' ),
	        	array( $this, 'nakhtar_yoga_class_display' ),
	        	'page'
	        );
	        add_meta_box(
	        	'nakhtar_yoga_class_images_mb',
	        	__( 'Class Section Images', 'nakhtaryoga' ),
	        	array( $this, 'nakhtar_yoga_class_images_display' ),
	        	'page'
	        );
    	}
    }
    //Our Starts Section Metabox
    public function nakhtar_yoga_starts_add_mb(){
    	$post_id = $_GET[ 'post' ] ? $_GET[ 'post' ] : $_POST[ 'post_id' ];
    	$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
    	if( $yoga_template == 'landingpage.php' ){
    		add_meta_box(
    			'nakhtar_yoga_starts_mb',
    			__( 'Our Starts Section Content', 'nakhtaryoga' ),
    			array( $this, 'nakhtar_yoga_starts_mb_display' ),
    			'page'
    		);
    		add_meta_box(
    			'nakhtar_yoga_starts_images',
    			__( 'Our Starts Section BG', 'nakhtaryoga' ),
    			array( $this, 'nakhtar_yoga_starts_images_display' ),
    			'page'
    		);
    	}
    }
    //Best Instructor Section Metabox
    public function nakhtar_yoga_instructor_add_mb(){
    	$post_id = $_GET[ 'post' ] ? $_GET[ 'post' ] : $_POST[ 'post_id' ];
    	$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
    	if( $yoga_template == 'landingpage.php' ){
    		add_meta_box(
    			'nakhtar_yoga_instructor_mb',
    			__( 'Best Instructor Section Content', 'nakhtaryoga' ),
    			array( $this, 'nakhtar_yoga_instructor_mb_display' ),
    			'page'
    		);
    	}
    }
    //Pricing Section Metabox
    public function nakhtar_yoga_pricing_add_mb(){
    	$post_id = $_GET[ 'post' ] ? $_GET[ 'post' ] : $_POST[ 'post_id' ];
    	$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
    	if( $yoga_template == 'landingpage.php' ){
    		add_meta_box(
    			'nakhtar_yoga_pricing_mb',
    			__( 'Price Section Content', 'nakhtaryoga' ),
    			array( $this, 'nakhtar_yoga_pricing_mb_display' ),
    			'page'
    		);
    	}
    }
    //Trainer Section Metabox
    public function nakhtar_yoga_trainer_add_mb(){
    	$post_id = $_GET[ 'post' ] ? $_GET[ 'post' ] : $_POST[ 'post_id' ];
    	$yoga_template = get_post_meta( $post_id, '_wp_page_template', TRUE );
    	if( $yoga_template == 'landingpage.php' ){
    		add_meta_box(
    			'nakhtar_yoga_trainer_mb',
    			__( 'Trainer Section Content', 'nakhtaryoga' ),
    			array( $this, 'nakhtar_yoga_trainer_mb_display' ),
    			'page'
    		);
    	}
    }

    public function nakhtar_yoga_lp_mb_display( $post ){
        $lp_title = get_post_meta( $post->ID, 'lp_title', true );
        $lp_header_p = get_post_meta( $post->ID, 'lp_header_p', true );
        $lp_header_btn = get_post_meta( $post->ID, 'lp_header_btn', true );

        wp_nonce_field( 'lp_title', 'lp_title_field' );
        $metabox_html = <<<EOD
            <p>
                <label for="lp_title">Page Title:</label>
                <input class="widefat" type="text" name="lp_title" id="lp-title" value="{$lp_title}" />
            </p>
            <p>
                <label for="lp_header_p">Header Paragraph:</label>
                <input class="widefat" type="text" name="lp_header_p" id="lp-header-p" value="{$lp_header_p}" />
            </p>
            <p>
                <label for="lp_header_btn">Header Button:</label>
                <input class="widefat" type="text" name="lp_header_btn" id="lp-header-btn" value="{$lp_header_btn}" />
            </p>
                
        EOD;

        echo $metabox_html;
    }

    function nakhtar_yoga_header_img_display( $post ){
        $image_id = esc_attr( get_post_meta( $post->ID, 'header_img_id', true ) );
        $image_url = esc_attr( get_post_meta( $post->ID, 'header_img_url', true ) );
        $bg_image_id = esc_attr( get_post_meta( $post->ID, 'header_bg_img_id', true ) );
        $bg_image_url = esc_attr( get_post_meta( $post->ID, 'header_bg_img_url', true ) );
        $right_bg_texture_id = esc_attr( get_post_meta( $post->ID, 'right_bg_texture_id', true ) );
        $right_bg_texture_url = esc_attr( get_post_meta( $post->ID, 'right_bg_texture_url', true ) );
        wp_nonce_field( 'header_image', 'header_image_nonce' );

        $metabox_html = <<<EOD
            <div class="fields">
                <div class="input_c">
                    <button id="upload_image">Upload Image</button>
                    <input type="hidden" name="header_img_id" id="header_img_id" value="{$image_id}" />
                    <input type="hidden" name="header_img_url" id="header_img_url" value="{$image_url}"/>
                    <div id="image-container"></div>
                </div>
                <div class="input_c">
                    <button id="upload_header_bg_img">Upload Image</button>
                    <input type="hidden" name="header_bg_img_id" id="header_bg_img_id" value="{$bg_image_id}" />
                    <input type="hidden" name="header_bg_img_url" id="header_bg_img_url" value="{$bg_image_url}"/>
                    <div id="bg-image-container"></div>
                </div>
                <div class="input_c">
                    <button id="upload_right_bg_texture">Upload Image</button>
                    <input type="hidden" name="right_bg_texture_id" id="right_bg_texture_id" value="{$right_bg_texture_id}" />
                    <input type="hidden" name="right_bg_texture_url" id="right_bg_texture_url" value="{$right_bg_texture_url}"/>
                    <div id="right-bg-texture-container"></div>
                </div>
            </div>
        EOD;

        echo $metabox_html;
    }


    public function nakhtar_yoga_save_mb_data( $post_id ){
        if( ! $this->is_secured( 'lp_title_field', 'lp_title', $post_id ) ){
            return $post_id;
        }
        $lp_title = isset( $_POST[ 'lp_title' ] ) ? $_POST[ 'lp_title' ] : '';
        $lp_header_p = isset( $_POST[ 'lp_header_p' ] ) ? $_POST[ 'lp_header_p' ] : '';
        $lp_header_btn = isset( $_POST[ 'lp_header_btn' ] ) ? $_POST[ 'lp_header_btn' ] : '';

        if( $lp_title == '' || $lp_header_p == '' ){
            return $post_id;
        }

        $lp_title = sanitize_text_field( $lp_title );
        $lp_header_p = sanitize_text_field( $lp_header_p );

        update_post_meta( $post_id, 'lp_title', $lp_title );
        update_post_meta( $post_id, 'lp_header_p', $lp_header_p );
        update_post_meta( $post_id, 'lp_header_btn', $lp_header_btn );
    }

    // Image Upload save
    public function nakhtar_yoga_image_save( $post_id ){
        if( ! $this->is_secured( 'header_image_nonce', 'header_image', $post_id ) ){
            return $post_id;
        }
        $image_id = isset( $_POST[ 'header_img_id' ] ) ? $_POST[ 'header_img_id' ] : '';
        $image_url = isset( $_POST[ 'header_img_url' ] ) ? $_POST[ 'header_img_url' ] : '';
        $bg_image_id = isset( $_POST[ 'header_bg_img_id' ] ) ? $_POST[ 'header_bg_img_id' ] : '';
        $bg_image_url = isset( $_POST[ 'header_bg_img_url' ] ) ? $_POST[ 'header_bg_img_url' ] : '';
        $right_bg_texture_id = isset( $_POST[ 'right_bg_texture_id' ] ) ? $_POST[ 'right_bg_texture_id' ] : '';
        $right_bg_texture_url = isset( $_POST[ 'right_bg_texture_url' ] ) ? $_POST[ 'right_bg_texture_url' ] : '';

        update_post_meta( $post_id, 'header_img_id', $image_id );
        update_post_meta( $post_id, 'header_img_url', $image_url );
        update_post_meta( $post_id, 'header_bg_img_id', $bg_image_id );
        update_post_meta( $post_id, 'header_bg_img_url', $bg_image_url );
        update_post_meta( $post_id, 'right_bg_texture_id', $right_bg_texture_id );
        update_post_meta( $post_id, 'right_bg_texture_url', $right_bg_texture_url );
    }

    //Class Section Metaboxes
    public function nakhtar_yoga_class_display( $post ){
    	$class_title = get_post_meta( $post->ID, 'class_part_title', true );
    	$class_sec_p = get_post_meta( $post->ID, 'class_part_p', true );
    	$newbie_title = get_post_meta( $post->ID, 'newbie_title', true );
    	$newbie_paragraph = get_post_meta( $post->ID, 'newbie_paragraph', true );
    	$advanced_title = get_post_meta( $post->ID, 'advanced_title', true );
    	$advanced_paragraph = get_post_meta( $post->ID, 'advanced_paragraph', true );
    	$expert_title = get_post_meta( $post->ID, 'expert_title', true );
    	$expert_paragraph = get_post_meta( $post->ID, 'expert_paragraph', true );

    	wp_nonce_field( 'class_section', 'class_section_fields' );

    	$metabox_html = <<<EOD
            <div class="nakhtar-mb-section">
	            <p>
	                <label for="class_part_title">Class Section Title:</label>
	                <input class="widefat" type="text" name="class_part_title" id="class-part-title" value="{$class_title}" />
	            </p>
	            <p>
	                <label for="class_part_p">Class Section Paragraph:</label>
	                <input class="widefat" type="text" name="class_part_p" id="class-part-p" value="{$class_sec_p}" />
	            </p>
	            <p>
	            	<label for="newbie_title">Newbie Class Title:</label>
	            	<input class="widefat" type="text" name="newbie_title" id="newbie_title" value="{$newbie_title}" />
	            </p>
	            <p>
	            	<label for="newbie_paragraph">Newbie Class Paragraph: </label>
	            	<input class="widefat" type="text" name="newbie_paragraph" id="newbie_paragraph" value="{$newbie_paragraph}" />
	            </p>
	            <p>
	            	<label for="advanced_title">Advanced Class Title:</label>
	            	<input class="widefat" type="text" name="advanced_title" id="advanced_title" value="{$advanced_title}" />
	            </p>
	            <p>
	            	<label for="advanced_paragraph">Advanced Class Paragraph: </label>
	            	<input class="widefat" type="text" name="advanced_paragraph" id="advanced_paragraph" value="{$advanced_paragraph}" />
	            </p>
	            <p>
	            	<label for="expert_title">Expert Class Title:</label>
	            	<input class="widefat" type="text" name="expert_title" id="expert_title" value="{$expert_title}" />
	            </p>
	            <p>
	            	<label for="expert_paragraph">Expert Class Paragraph: </label>
	            	<input class="widefat" type="text" name="expert_paragraph" id="expert_paragraph" value="{$expert_paragraph}" />
	            </p>
            </div>                
EOD;

        echo $metabox_html;
    }

    public function nakhtar_yoga_class_images_display( $post ){
    	$newbie_img_id = esc_attr( get_post_meta( $post->ID, 'newbie_img_id', true ) );
    	$newbie_img_url = esc_attr( get_post_meta( $post->ID, 'newbie_img_url', true ) );
    	$advanced_img_id = esc_attr( get_post_meta( $post->ID, 'advanced_img_id', true ) );
    	$advanced_img_url = esc_attr( get_post_meta( $post->ID, 'advanced_img_url', true ) );
    	$expert_img_id = esc_attr( get_post_meta( $post->ID, 'expert_img_id', true ) );
    	$expert_img_url = esc_attr( get_post_meta( $post->ID, 'expert_img_url', true ) );
    	$class_model_texture_id = esc_attr( get_post_meta( $post->ID, 'class_model_texture_id', true ) );
    	$class_model_texture_url = esc_attr( get_post_meta( $post->ID, 'class_model_texture_url', true ) );

    	wp_nonce_field( 'class_section_img', 'class_section_img_fields');

    	$metabox_html = <<<EOD
    		<div class="fields">
    			<div class="input_c">
	    			<p>Newbie Model Image</p>
    				<button id="newbie_model_img">Upload Image</button>
    				<input type="hidden" name="newbie_img_id" id="newbie_img_id" value="{$newbie_img_id}" />
    				<input type="hidden" name="newbie_img_url" id="newbie_img_url" value="{$newbie_img_url}" />
    				<div id="newbie-img-container"></div>
    			</div>
    			<div class="input_c">
	    			<p>Advanced Model Image</p>
    				<button id="advanced_model_img">Upload Image</button>
    				<input type="hidden" name="advanced_img_id" id="advanced_img_id" value="{$advanced_img_id}" />
    				<input type="hidden" name="advanced_img_url" id="advanced_img_url" value="{$advanced_img_url}" />
    				<div id="advanced-img-container"></div>
    			</div>
    			<div class="input_c">
	    			<p>Expert Model Image</p>
    				<button id="expert_model_img">Upload Image</button>
    				<input type="hidden" name="expert_img_id" id="expert_img_id" value="{$expert_img_id}" />
    				<input type="hidden" name="expert_img_url" id="expert_img_url" value="{$expert_img_url}" />
    				<div id="expert-img-container"></div>
    			</div>
    			<div class="input_c">
	    			<p>Class Model BG Texture</p>
    				<button id="class_model_texture">Upload Image</button>
    				<input type="hidden" name="class_model_texture_id" id="class_model_texture_id" value="{$class_model_texture_id}" />
    				<input type="hidden" name="class_model_texture_url" id="class_model_texture_url" value="{$class_model_texture_url}" />
    				<div id="class-model-texture-container"></div>
    			</div>
    		</div>
EOD;

    	echo $metabox_html;
    }

    public function nakhtar_yoga_class_data_save( $post_id ){
        if( ! $this->is_secured( 'class_section_fields', 'class_section', $post_id ) ){
            return $post_id;
        }
        $class_title = isset( $_POST[ 'class_part_title' ] ) ? $_POST[ 'class_part_title' ] : '';
        $class_sec_p = isset( $_POST[ 'class_part_p' ] ) ? $_POST[ 'class_part_p' ] : '';
        $newbie_title = isset( $_POST[ 'newbie_title' ] ) ? $_POST[ 'newbie_title' ] : '';
        $newbie_paragraph = isset( $_POST[ 'newbie_paragraph' ] ) ? $_POST[ 'newbie_paragraph' ] : '';
        $advanced_title = isset( $_POST[ 'advanced_title' ] ) ? $_POST[ 'advanced_title' ] : '';
        $advanced_paragraph = isset( $_POST[ 'advanced_paragraph' ] ) ? $_POST[ 'advanced_paragraph' ] : '';
        $expert_title = isset( $_POST[ 'expert_title' ] ) ? $_POST[ 'expert_title' ] : '';
        $expert_paragraph = isset( $_POST[ 'expert_paragraph' ] ) ? $_POST[ 'expert_paragraph' ] : '';

        if( $class_title == '' || $class_sec_p == '' || $newbie_title == '' || $newbie_paragraph == '' || $advanced_title == '' || $advanced_paragraph == '' || $expert_title == '' || $expert_paragraph == '' ){
            return $post_id;
        }

        $class_title = sanitize_text_field( $class_title );
        $class_sec_p = sanitize_text_field( $class_sec_p );
        $newbie_title = sanitize_text_field( $newbie_title );
        $newbie_paragraph = sanitize_text_field( $newbie_paragraph );
        $advanced_title = sanitize_text_field( $advanced_title );
        $advanced_paragraph = sanitize_text_field( $advanced_paragraph );
        $expert_title = sanitize_text_field( $expert_title );
        $expert_paragraph = sanitize_text_field( $expert_paragraph );

        update_post_meta( $post_id, 'class_part_title', $class_title );
        update_post_meta( $post_id, 'class_part_p', $class_sec_p );
        update_post_meta( $post_id, 'newbie_title', $newbie_title );
        update_post_meta( $post_id, 'newbie_paragraph', $newbie_paragraph );
        update_post_meta( $post_id, 'advanced_title', $advanced_title );
        update_post_meta( $post_id, 'advanced_paragraph', $advanced_paragraph );
        update_post_meta( $post_id, 'expert_title', $expert_title );
        update_post_meta( $post_id, 'expert_paragraph', $expert_paragraph );
    }

    public function nakhtar_yoga_class_image_save( $post_id ){
    	if( ! $this->is_secured( 'class_section_img_fields', 'class_section_img', $post_id ) ){
    		return $post_id;
    	}
    	$newbie_img_id = isset( $_POST['newbie_img_id' ] ) ? $_POST['newbie_img_id'] : '';
    	$newbie_img_url = isset( $_POST[ 'newbie_img_url'] ) ? $_POST[ 'newbie_img_url' ] : '';
    	$advanced_img_id = isset( $_POST['advanced_img_id' ] ) ? $_POST['advanced_img_id'] : '';
    	$advanced_img_url = isset( $_POST[ 'advanced_img_url'] ) ? $_POST[ 'advanced_img_url' ] : '';
    	$expert_img_id = isset( $_POST[ 'expert_img_id' ] ) ? $_POST[ 'expert_img_id' ] : '';
    	$expert_img_url = isset( $_POST[ 'expert_img_url' ] ) ? $_POST[ 'expert_img_url' ] : '';
    	$class_model_texture_id = isset( $_POST[ 'class_model_texture_id' ] ) ? $_POST[ 'class_model_texture_id' ] : '';
    	$class_model_texture_url = isset( $_POST[ 'class_model_texture_url' ] ) ? $_POST[ 'class_model_texture_url' ] : '';


    	update_post_meta( $post_id, 'newbie_img_id', $newbie_img_id );
    	update_post_meta( $post_id, 'newbie_img_url', $newbie_img_url );
    	update_post_meta( $post_id, 'advanced_img_id', $advanced_img_id );
    	update_post_meta( $post_id, 'advanced_img_url', $advanced_img_url );
    	update_post_meta( $post_id, 'expert_img_id', $expert_img_id );
    	update_post_meta( $post_id, 'expert_img_url', $expert_img_url );
    	update_post_meta( $post_id, 'class_model_texture_id', $class_model_texture_id );
    	update_post_meta( $post_id, 'class_model_texture_url', $class_model_texture_url );
    }

    //Our Starts Section
    public function nakhtar_yoga_starts_mb_display( $post ){

    	$starts_part_title = get_post_meta( $post->ID, 'starts_part_title', true );
    	$starts_part_p = get_post_meta( $post->ID, 'starts_part_p', true );
    	$circle_one_num = get_post_meta( $post->ID, 'circle_one_num', true );
    	$circle_two_num = get_post_meta( $post->ID, 'circle_two_num', true );
    	$circle_three_num = get_post_meta( $post->ID, 'circle_three_num', true );
    	$circle_one_p = get_post_meta( $post->ID, 'circle_one_p', true );
    	$circle_two_p = get_post_meta( $post->ID, 'circle_two_p', true );
    	$circle_three_p = get_post_meta( $post->ID, 'circle_three_p', true );

    	wp_nonce_field( 'starts_section', 'starts_section_fields' );

    	$metabox_html = <<<EOD
    		<div class="nakhtar-mb-section">
    			<p>
    				<label for="starts_part_title">Starts Part Title :</label>
    				<input class="widefat" type="text" name="starts_part_title" id="starts_part_title" value="{$starts_part_title}" />
    			</p>
    			<p>
    				<label for="starts_part_p">Starts Part Paragraph :</label>
    				<input class="widefat" type="text" name="starts_part_p" id="starts_part_p" value="{$starts_part_p}" />
    			</p>
    			<p>
    				<label for="circle_one_num">First Circle Number:</label>
    				<input class="" type="text" name="circle_one_num" id="circle_one_num" value="{$circle_one_num}" />
    				<label for="circle_two_num">Second Circle Number: </label>
    				<input type="text" name="circle_two_num" id="circle_two_num" value="{$circle_two_num}" />
    				<label for="circle_three_num">Third Circle Number: </label>
    				<input type="text" name="circle_three_num" id="circle_three_num" value="{$circle_three_num}" />
    			</p>
    			<p>
    				<label for="circle_one_p">First Circle Text: </label>
    				<input class="widefat" type="text" name="circle_one_p" id="circle_one_p" value="{$circle_one_p}" />
    			</p>
    			<p>
    				<label for="circle_two_p">Second Circle Text: </label>
    				<input class="widefat" type="text" name="circle_two_p" id="circle_two_p" value="{$circle_two_p}" />
    			</p>
    			<p>
    				<label for="circle_three_p">Third Circle Text: </label>
    				<input class="widefat" type="text" name="circle_three_p" id="circle_three_p" value="{$circle_three_p}" />
    			</p>
    		</div>
    EOD;

    echo $metabox_html;
    }
    public function nakhtar_yoga_starts_images_display($post){
    	$starts_bg_id = esc_attr( get_post_meta( $post->ID, 'starts_bg_id', true ) );
    	$starts_bg_url = esc_attr( get_post_meta( $post->ID, 'starts_bg_url', true ) );

    	wp_nonce_field( 'starts_section_img', 'starts_section_img_fields' );

    	$metabox_html = <<<EOD
    		<div class="fields">
    			<div class="input_c">
    				<button id="upload_starts_bg">Upload Image</button>
    				<input type="hidden" name="starts_bg_id" id="starts_bg_id" value="{$starts_bg_id}" />
    				<input type="hidden" name="starts_bg_url" id="starts_bg_url" value="{$starts_bg_url}" />
    				<div id="starts-bg-container"></div>
    			</div>
    		</div>
    EOD;

    echo $metabox_html;
    }

    public function nakhtar_yoga_starts_data_save( $post_id ){
    	if( ! $this->is_secured( 'starts_section_fields', 'starts_section', $post_id ) ){
    		return $post_id;
    	}

    	$starts_part_title = isset( $_POST[ 'starts_part_title' ] ) ? $_POST[ 'starts_part_title' ] : '';
    	$starts_part_p = isset( $_POST[ 'starts_part_p' ] ) ? $_POST[ 'starts_part_p' ] : '';
    	$circle_one_num = isset( $_POST[ 'circle_one_num' ] ) ? $_POST[ 'circle_one_num' ] : '';
    	$circle_two_num = isset( $_POST[ 'circle_two_num' ] ) ? $_POST[ 'circle_two_num' ] : '';
    	$circle_three_num = isset( $_POST[ 'circle_three_num' ] ) ? $_POST[ 'circle_three_num' ] : '';
    	$circle_one_p = isset( $_POST[ 'circle_one_p'] ) ? $_POST[ 'circle_one_p' ] : '';
    	$circle_two_p = isset( $_POST[ 'circle_two_p' ] ) ? $_POST[ 'circle_two_p' ] : '';
    	$circle_three_p = isset( $_POST[ 'circle_three_p' ] ) ? $_POST[ 'circle_three_p' ] : '';

    	if( $starts_part_title == '' || $starts_part_p == '' || $circle_one_num == '' || $circle_two_num == '' || $circle_three_num == '' || $circle_one_p == '' || $circle_two_p == '' || $circle_three_p == ''){
    		return $post_id;
    	}

    	$starts_part_title = sanitize_text_field( $starts_part_title );
    	$starts_part_p = sanitize_text_field( $starts_part_p );
    	$circle_one_num = sanitize_text_field( $circle_one_num );
    	$circle_two_num = sanitize_text_field( $circle_two_num );
    	$circle_three_num = sanitize_text_field( $circle_three_num );
    	$circle_one_p = sanitize_text_field( $circle_one_p );
    	$circle_two_p = sanitize_text_field( $circle_two_p );
    	$circle_three_p = sanitize_text_field( $circle_three_p );

    	update_post_meta( $post_id, 'starts_part_title', $starts_part_title );
    	update_post_meta( $post_id, 'starts_part_p', $starts_part_p );
    	update_post_meta( $post_id, 'circle_one_num', $circle_one_num );
    	update_post_meta( $post_id, 'circle_two_num', $circle_two_num );
    	update_post_meta( $post_id, 'circle_three_num', $circle_three_num );
    	update_post_meta( $post_id, 'circle_one_p', $circle_one_p );
    	update_post_meta( $post_id, 'circle_two_p', $circle_two_p );
    	update_post_meta( $post_id, 'circle_three_p', $circle_three_p );
    }

    public function nakhtar_yoga_starts_img_save( $post_id ){
    	if( ! $this->is_secured( 'starts_section_img_fields', 'starts_section_img', $post_id ) ){
    		return $post_id;
    	}
    	$starts_bg_id = isset( $_POST[ 'starts_bg_id' ] ) ? $_POST[ 'starts_bg_id' ] : '';
    	$starts_bg_url = isset( $_POST[ 'starts_bg_url' ] ) ? $_POST[ 'starts_bg_url' ] : '';

    	update_post_meta( $post_id, 'starts_bg_id', $starts_bg_id );
    	update_post_meta( $post_id, 'starts_bg_url', $starts_bg_url );
    }

    public function nakhtar_yoga_instructor_mb_display( $post ){
    	$instructor_title = get_post_meta( $post->ID, 'instructor_title', true );
    	$instructor_p = get_post_meta( $post->ID, 'instructor_p', true );
    	$instructor_btn = get_post_meta( $post->ID, 'instructor_btn', true );
    	$instructor_img_id = esc_attr( get_post_meta( $post->ID, 'instructor_img_id', true ) );
    	$instructor_img_url = esc_attr( get_post_meta( $post->ID, 'instructor_img_url', true ) );

    	wp_nonce_field( 'instructor_section', 'instructor_section_fields' );

    	$metabox_html = <<<EOD
    		<div class="instructor-section">
    			<p>
    				<label for="instructor_title">Instructor Section Title: </label>
    				<input class="widefat" type="text" name="instructor_title" id="instructor_title" value="{$instructor_title}" />
    			</p>
    			<p>
    				<label for="instructor_p">Instructor Section Paragraph</label>
    				<input class="widefat" type="text" name="instructor_p" id="instructor_p" value="{$instructor_p}" />
    			</p>
    			<p>
    				<label for="instructor_btn">Instructor Section Paragraph</label>
    				<input class="widefat" type="text" name="instructor_btn" id="instructor_btn" value="{$instructor_btn}" />
    			</p>
    			<p>Instructor Section Image:</p>
    			<button id="upload_instructor_image">Upload Image</button>
    			<input type="hidden" name="instructor_img_id" id="instructor_img_id" value="{$instructor_img_id}" />
    			<input type="hidden" name="instructor_img_url" id="instructor_img_url" value="{$instructor_img_url}" />
    			<div id="instructor-image-container"></div>
    		</div>
    EOD;

    	echo $metabox_html;
    }
    public function nakhtar_yoga_instructor_data_save( $post_id ){
    	if( ! $this->is_secured( 'instructor_section_fields', 'instructor_section', $post_id ) ){
    		return $post_id;
    	}
    	$instructor_title = isset( $_POST['instructor_title'] ) ? $_POST[ 'instructor_title' ] : '';
    	$instructor_p = isset( $_POST[ 'instructor_p' ] ) ? $_POST[ 'instructor_p' ] : '';
    	$instructor_btn = isset( $_POST[ 'instructor_btn' ] ) ? $_POST[ 'instructor_btn' ] : '';
    	$instructor_img_id = isset( $_POST[ 'instructor_img_id' ] ) ? $_POST[ 'instructor_img_id' ] : '';
    	$instructor_img_url = isset( $_POST[ 'instructor_img_url' ] ) ? $_POST[ 'instructor_img_url' ] : '';

    	if( $instructor_title == '' || $instructor_p == '' ){
    		return $post_id;
    	}
    	$instructor_title = sanitize_text_field( $instructor_title );
    	$instructor_p = sanitize_text_field( $instructor_p );
    	update_post_meta( $post_id, 'instructor_title', $instructor_title );
    	update_post_meta( $post_id, 'instructor_p', $instructor_p );
    	update_post_meta( $post_id, 'instructor_btn', $instructor_btn );
    	update_post_meta( $post_id, 'instructor_img_id', $instructor_img_id );
    	update_post_meta( $post_id, 'instructor_img_url', $instructor_img_url );
    }

    public function nakhtar_yoga_pricing_mb_display($post){
    	$price_part_title = get_post_meta( $post->ID, 'price_part_title', true );
    	$price_part_p = get_post_meta( $post->ID, 'price_part_p', true );
    	$newbie_price_card_title = get_post_meta( $post->ID, 'newbie_price_card_title', true );
    	$newbie_price_card_value = get_post_meta( $post->ID, 'newbie_price_card_value', true );
    	$newbie_price_card_text = get_post_meta( $post->ID, 'newbie_price_card_text', true );
    	$advanced_price_card_title = get_post_meta( $post->ID, 'advanced_price_card_title', true );
    	$advanced_price_card_value = get_post_meta( $post->ID, 'advanced_price_card_value', true );
    	$advanced_price_card_text = get_post_meta( $post->ID, 'advanced_price_card_text', true );
    	$expert_price_card_title = get_post_meta( $post->ID, 'expert_price_card_title', true );
    	$expert_price_card_value = get_post_meta( $post->ID, 'expert_price_card_value', true );
    	$expert_price_card_text = get_post_meta( $post->ID, 'expert_price_card_text', true );
    	$price_card_btn = get_post_meta( $post->ID, 'price_card_btn', true );
    	$price_card_icon_id = esc_attr( get_post_meta( $post->ID, 'price_card_icon_id', true ) );
    	$price_card_icon_url = esc_attr( get_post_meta( $post->ID, 'price_card_icon_url', true ) );

    	wp_nonce_field( 'price_section', 'price_section_fields' );

    	$metabox_html = <<<EOD
    		<div class="price-part-mb">
    			<p>
    				<label for="price_part_title">Price Section Title:</label>
    				<input class="widefat" type="text" name="price_part_title" id="price_part_title" value="{$price_part_title}" />
    			</p>
    			<p>
    				<label for="price_part_p">Price Section Paragraph:</label>
    				<input class="widefat" type="text" name="price_part_p" id="price_part_p" value="{$price_part_p}" />
    			</p>
    			<p>
    				<label for="newbie_price_card_title">Newbie Price Card Title: </label>
    				<input class="widefat" type="text" name="newbie_price_card_title" id="newbie_price_card_title" value="{$newbie_price_card_title}" />
    			</p>
    			<p>
    				<label for="newbie_price_card_value">Newbie Price Card Value: </label>
    				<input class="widefat" type="text" name="newbie_price_card_value" id="newbie_price_card_value" value="{$newbie_price_card_value}" />
    			</p>
    			<p>
    				<label for="newbie_price_card_text">Newbie Price Card Text:</label>
    				<input class="widefat" type="text" name="newbie_price_card_text" id="newbie_price_card_text" value="{$newbie_price_card_text}" />
    			</p>
    			<p>
    				<label for="advanced_price_card_title">Advanced Price Card Title:</label>
    				<input class="widefat" type="text" name="advanced_price_card_title" id="advanced_price_card_title" value="{$advanced_price_card_title}" />
    			</p>
    			<p>
    				<label for="advanced_price_card_value">Advanced Price Card Value:</label>
    				<input class="widefat" type="text" name="advanced_price_card_value" id="advanced_price_card_value" value="{$advanced_price_card_value}" />
    			</p>
    			<p>
    				<label for="advanced_price_card_text">Advanced Price Card Text: </label>
    				<input class="widefat" type="text" name="advanced_price_card_text" id="advanced_price_card_text" value="{$advanced_price_card_text}" />
    			</p>
    			<p>
    				<label for="expert_price_card_title">Expert Price Card Title:</label>
    				<input class="widefat" type="text" name="expert_price_card_title" id="expert_price_card_title" value="{$expert_price_card_title}" />
    			</p>
    			<p>
    				<label for="expert_price_card_value">Expert Price Card Value: </label>
    				<input class="widefat" type="text" name="expert_price_card_value" id="expert_price_card_value" value="{$expert_price_card_value}" />
    			</p>
    			<p>
    				<label for="expert_price_card_text">Expert Price Card Text: </label>
    				<input class="widefat" type="text" name="expert_price_card_text" id="expert_price_card_text" value="{$expert_price_card_text}" />
    			</p>
    			<p>
    				<label for="price_card_btn">Price Card Button Text: </label>
    				<input class="widefat" type="text" name="price_card_btn" id="price_card_btn" value="{$price_card_btn}" />
    			</p>
    			<div>
    				<p for="price_card_icon">Price Card Icon: </p>
    				<button id="upload_price_card_icon">Upload Image</button>
    				<input type="hidden" name="price_card_icon_id" id="price_card_icon_id" value="{$price_card_icon_id}" />
    				<input type="hidden" name="price_card_icon_url" id="price_card_icon_url" value="{$price_card_icon_url}" />
    				<div id="price-card-icon-container"></div>
    			</div>
    		</div>
    EOD;

    	echo $metabox_html;
    }

    public function nakhtar_yoga_price_data_save( $post_id ){
    	if( ! $this->is_secured( 'price_section_fields', 'price_section', $post_id ) ){
    		return $post_id;
    	}

    	$price_part_title = isset( $_POST[ 'price_part_title' ] ) ? $_POST[ 'price_part_title' ] : '';
    	$price_part_p = isset( $_POST[ 'price_part_p' ] ) ? $_POST[ 'price_part_p' ] : '';
    	$newbie_price_card_title = isset( $_POST[ 'newbie_price_card_title' ] ) ? $_POST['newbie_price_card_title' ] : '';
    	$newbie_price_card_value = isset( $_POST[ 'newbie_price_card_value' ] ) ? $_POST[ 'newbie_price_card_value' ] : '';
    	$newbie_price_card_text = isset( $_POST[ 'newbie_price_card_text' ] ) ? $_POST[ 'newbie_price_card_text' ] : '';
    	$advanced_price_card_title = isset( $_POST[ 'advanced_price_card_title' ] ) ? $_POST[ 'advanced_price_card_title' ] : '';
    	$advanced_price_card_value = isset( $_POST[ 'advanced_price_card_value' ] ) ? $_POST[ 'advanced_price_card_value' ] : '';
    	$advanced_price_card_text = isset( $_POST[ 'advanced_price_card_text' ] ) ? $_POST[ 'advanced_price_card_text' ] : '';
    	$expert_price_card_title = isset( $_POST[ 'expert_price_card_title' ] ) ? $_POST['expert_price_card_title' ] : '';
    	$expert_price_card_value = isset( $_POST[ 'expert_price_card_value' ] ) ? $_POST[ 'expert_price_card_value' ] : '';
    	$expert_price_card_text = isset( $_POST[ 'expert_price_card_text' ] ) ? $_POST[ 'expert_price_card_text' ] : '';
    	$price_card_btn = isset( $_POST[ 'price_card_btn' ] ) ? $_POST[ 'price_card_btn' ] : '';
    	$price_card_icon_id = isset( $_POST[ 'price_card_icon_id' ] ) ? $_POST[ 'price_card_icon_id' ] : '';
    	$price_card_icon_url = isset( $_POST[ 'price_card_icon_url' ] ) ? $_POST[ 'price_card_icon_url' ] : '';

    	if( $price_part_title == '' || $price_part_p == '' || $newbie_price_card_title == '' || $newbie_price_card_value == '' || $newbie_price_card_text == '' || $advanced_price_card_title == '' || $advanced_price_card_value == '' || $advanced_price_card_text == '' || $expert_price_card_title == '' || $expert_price_card_value == '' || $expert_price_card_text == '' || $price_card_btn == '' ){
    		return $post_id;
    	}

    	$price_part_title = sanitize_text_field( $price_part_title );
    	$price_part_p = sanitize_text_field( $price_part_p );
    	$newbie_price_card_title = sanitize_text_field( $newbie_price_card_title );
    	$newbie_price_card_value = sanitize_text_field( $newbie_price_card_value );
    	$newbie_price_card_text = sanitize_text_field( $newbie_price_card_text );
    	$advanced_price_card_title = sanitize_text_field( $advanced_price_card_title );
    	$advanced_price_card_value = sanitize_text_field( $advanced_price_card_value );
    	$advanced_price_card_text = sanitize_text_field( $advanced_price_card_text );
    	$expert_price_card_title = sanitize_text_field( $expert_price_card_title );
    	$expert_price_card_value = sanitize_text_field( $expert_price_card_value );
    	$expert_price_card_text = sanitize_text_field( $expert_price_card_text );
    	$price_card_btn = sanitize_text_field( $price_card_btn );

    	update_post_meta( $post_id, 'price_part_title', $price_part_title );
    	update_post_meta( $post_id, 'price_part_p', $price_part_p );
    	update_post_meta( $post_id, 'newbie_price_card_title', $newbie_price_card_title );
    	update_post_meta( $post_id, 'newbie_price_card_value', $newbie_price_card_value );
    	update_post_meta( $post_id, 'newbie_price_card_text', $newbie_price_card_text );
    	update_post_meta( $post_id, 'advanced_price_card_title', $advanced_price_card_title );
    	update_post_meta( $post_id, 'advanced_price_card_value', $advanced_price_card_value );
    	update_post_meta( $post_id, 'advanced_price_card_text', $advanced_price_card_text );
    	update_post_meta( $post_id, 'expert_price_card_title', $expert_price_card_title );
    	update_post_meta( $post_id, 'expert_price_card_value', $expert_price_card_value );
    	update_post_meta( $post_id, 'expert_price_card_text', $expert_price_card_text );
    	update_post_meta( $post_id, 'price_card_btn', $price_card_btn );
    	update_post_meta( $post_id, 'price_card_icon_id', $price_card_icon_id );
    	update_post_meta( $post_id, 'price_card_icon_url', $price_card_icon_url );
    }

    public function nakhtar_yoga_trainer_mb_display($post){
    	$trainer_p = get_post_meta( $post->ID, 'trainer_p', true );
    	$trainer_name = get_post_meta( $post->ID, 'trainer_name', true );
    	$trainer_bg_id = esc_attr( get_post_meta( $post->ID, 'trainer_bg_id', true ) );
    	$trainer_bg_url = esc_attr( get_post_meta( $post->ID, 'trainer_bg_url', true ) );
    	$trainer_img_id = esc_attr( get_post_meta( $post->ID, 'trainer_img_id', true ) );
    	$trainer_img_url = esc_attr( get_post_meta( $post->ID, 'trainer_img_url', true ) );
    	$trainer_texture_id = esc_attr( get_post_meta( $post->ID, 'trainer_texture_id', true ) );
    	$trainer_texture_url = esc_attr( get_post_meta( $post->ID, 'trainer_texture_url', true ) );
    	$subscribe_title = get_post_meta( $post->ID, 'subscribe_title', true );
    	$subscribe_p = get_post_meta( $post->ID, 'subscribe_p', true );

    	wp_nonce_field( 'trainer_section', 'trainer_section_fields' );

    	$metabox_html = <<<EOD
    		<div class="trainer-section">
    			<p>
    				<label for="trainer_p">Trainer Section Text:</label>
    				<input class="widefat" type="text" name="trainer_p" id="trainer_p" value="{$trainer_p}" />
    			</p>
    			<p>
    				<label for="trainer_name">Trainer Name: </label>
    				<input class="widefat" type="text" name="trainer_name" id="trainer_name" value="{$trainer_name}" />
    			</p>
    			<div class="trainer-images">
    				<label for="trainer_bg_id">Trainer BG Image: </label>
    				<button id="upload_trainer_bg">Upload Image</button>
    				<input type="hidden" name="trainer_bg_id" id="trainer_bg_id" value="{$trainer_bg_id}" />
    				<input type="hidden" name="trainer_bg_url" id="trainer_bg_url" value="{$trainer_bg_url}" />
    				<div id="trainer-bg-container"></div>
    				<label for="trainer_img_id">Trainer Image:</label>
    				<button id="upload_trainer_img">Upload Image</button>
    				<input type="hidden" name="trainer_img_id" id="trainer_img_id" value="{$trainer_img_id}" />
    				<input type="hidden" name="trainer_img_url" id="trainer_img_url" value="{$trainer_img_url}" />
    				<div id="trainer-img-container"></div>
    				<label>Trainer Image Texture:</label>
    				<button id="upload_trainer_texture">Upload Image</button>
    				<input type="hidden" name="trainer_texture_id" id="trainer_texture_id" value="{$trainer_texture_id}" />
    				<input type="hidden" name="trainer_texture_url" id="trainer_texture_url" value="{$trainer_texture_url}" />
    				<div id="trainer-texture-container"></div>
    			</div>
    			<p>
    				<label for="subscribe_title">Subscribe Section Title:</labe>
    				<input class="widefat" type="text" name="subscribe_title" id="subscribe_title" value="{$subscribe_title}" />
    			</p>
    			<p>
    				<label for="subscribe_p">Subscribe Section Text:</label>
    				<input class="widefat" type="text" name="subscribe_p" id="subscribe_p" value="{$subscribe_p}" />
    			</p>
    		</div>
    EOD;
    	echo $metabox_html;
    }

    public function nakhtar_yoga_trainer_data_save( $post_id ){
    	if( ! $this->is_secured( 'trainer_section_fields', 'trainer_section', $post_id ) ){
    		return $post_id;
    	}

    	$trainer_p = isset( $_POST[ 'trainer_p' ] ) ? $_POST[ 'trainer_p' ] : '';
    	$trainer_name = isset( $_POST[ 'trainer_name' ] ) ? $_POST[ 'trainer_name' ] : '';
    	$trainer_bg_id = isset( $_POST[ 'trainer_bg_id' ] ) ? $_POST[ 'trainer_bg_id' ] : '';
    	$trainer_bg_url = isset( $_POST[ 'trainer_bg_url' ] ) ? $_POST[ 'trainer_bg_url' ] : '';
    	$trainer_img_id = isset( $_POST[ 'trainer_img_id' ] ) ? $_POST[ 'trainer_img_id' ] : '';
    	$trainer_img_url = isset( $_POST[ 'trainer_img_url' ] ) ? $_POST[ 'trainer_img_url' ] : '';
    	$trainer_texture_id = isset( $_POST[ 'trainer_texture_id' ] ) ? $_POST[ 'trainer_texture_id' ] : '';
    	$trainer_texture_url = isset( $_POST[ 'trainer_texture_url' ] ) ? $_POST[ 'trainer_texture_url' ] : '';
    	$subscribe_p = isset( $_POST[ 'subscribe_p' ] ) ? $_POST[ 'subscribe_p' ] : '';
    	$subscribe_title = isset( $_POST[ 'subscribe_title' ] ) ? $_POST[ 'subscribe_title' ] : '';

    	if( $trainer_p == '' || $trainer_name == '' || $subscribe_title == '' || $subscribe_p == ''){
    		return $post_id;
    	}

    	update_post_meta( $post_id, 'trainer_p', $trainer_p );
    	update_post_meta( $post_id, 'trainer_name', $trainer_name );
    	update_post_meta( $post_id, 'trainer_bg_id', $trainer_bg_id );
    	update_post_meta( $post_id, 'trainer_bg_url', $trainer_bg_url );
    	update_post_meta( $post_id, 'trainer_img_id', $trainer_img_id );
    	update_post_meta( $post_id, 'trainer_img_url', $trainer_img_url );
    	update_post_meta( $post_id, 'trainer_texture_id', $trainer_texture_id );
    	update_post_meta( $post_id, 'trainer_texture_url', $trainer_texture_url );
    	update_post_meta( $post_id, 'subscribe_title', $subscribe_title );
    	update_post_meta( $post_id, 'subscribe_p', $subscribe_p );
    }
}
new NakhtarYogaMb();
//Yoga Landing Page Metaboxex Ends

//Yoga Landingpage Widgets
function nakhtar_yoga_widgets_register(){
	register_sidebar(
		array(
			'name'				=> __( 'Footer Widgets', 'nakhtaryoga' ),
			'description'		=> __( 'Put your footer widget here', 'nakhtaryoga' ),
			'id'				=> 'footer-left-widget',
			'before_widget'		=> '',
			'after_widget'		=> '',
			'before_title'		=> '<h3>',
			'after_title'		=> '</h3>'
		)
	);
	register_sidebar(
		array(
			'name'				=> __( 'Footer Right Widets', 'nakhtaryoga' ),
			'description'		=> __( 'Footer Navigation Itms will go here', 'nakhtaryoga' ),
			'id'				=> 'footer-nav-widgets',
			'before_widget'		=> '<div class="page-nav" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">',
			'after_widget'		=> '</div>',
			'before_title'		=> '',
			'after_title'		=> ''
		)
	);
}
add_action( 'widgets_init', 'nakhtar_yoga_widgets_register' );

?>