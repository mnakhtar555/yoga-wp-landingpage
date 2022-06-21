var frame, gframe;

;(function($){

    //image upload
    $(document).ready(function(){
        var image_url = $( '#header_img_url' ).val();
        if( image_url ){
            $('#image-container').html(`<image src="${image_url}" />` );
        }

        $('#upload_image' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: false,                
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#header_img_id').val(attachment.id);
                $('#header_img_url').val(attachment.sizes.large.url);
                $('#image-container').html(`<img src="${attachment.sizes.large.url}" />`);
            });
            frame.open();
            return false;
        });

        //Header Image BG Texture
        var bg_image_url = $( '#header_bg_img_url').val();
        if( bg_image_url ){
            $('#bg-image-container').html( `<image src="${bg_image_url}" />` );
        }
        $('#upload_header_bg_img').on('click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Bg Image',
                button: {
                    text: 'Upload Bg Image'
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#header_bg_img_id').val(attachment.id);
                $('#header_bg_img_url').val(attachment.sizes.medium.url);
                $('#bg-image-container').html(`<img src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });

        //Right Half BG Texture
        var right_bg_texture_url = $( '#right_bg_texture_url').val();
        if( right_bg_texture_url ){
            $('#right-bg-texture-container').html( `<image src="${right_bg_texture_url}" />` );
        }
        $('#upload_right_bg_texture').on('click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Right Bg Texture',
                button: {
                    text: 'Upload Right Bg Texture'
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#right_bg_texture_id').val(attachment.id);
                $('#right_bg_texture_url').val(attachment.sizes.medium.url);
                $('#right-bg-texture-container').html(`<img src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });

        //Newbie Class Model Image
        var newbie_model_url = $( '#newbie_img_url' ).val();
        if( newbie_model_url ){
            $('#newbie-img-container' ).html( `<image src="${newbie_model_url}" />`);
        }
        $( '#newbie_model_img' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Newbie Model Image',
                button: {
                    text: 'Upload Newbie Model Image',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $( '#newbie_img_id').val(attachment.id);
                $('#newbie_img_url').val(attachment.sizes.medium.url );
                $('#newbie-img-container' ).html( `<img src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });

        //Advanced Class Model Image
        var advanced_model_url = $('#advanced_img_url' ).val();
        if( advanced_model_url ){
            $('#advanced-img-container').html(`<image src="${advanced_model_url}" />`);
        }
        $( '#advanced_model_img' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Advanced Model Image',
                button: {
                    text: 'Upload Advanced Model Image',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#advanced_img_id' ).val(attachment.id);
                $('#advanced_img_url' ).val(attachment.sizes.medium.url );
                $('#advanced-img-container' ).html(`<img src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });
        //Expert Class Model Image
        var expert_model_url = $( '#expert_img_url' ).val();
        if( expert_model_url ){
            $('#expert-img-container' ).html( `<image src="${expert_model_url}" />`);
        }
        $('#expert_model_img' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Expert Model Image',
                button: {
                    text: 'Upload Expert Model Image',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#expert_img_id' ).val(attachment.id );
                $('#expert_img_url').val(attachment.sizes.medium.url);
                $('#expert-img-container').html(`<img src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });

        //Class Model Texture
        var class_model_texture_url = $( '#class_model_texture_url' ).val();
        if( class_model_texture_url ){
            $('#class-model-texture-container').html(`<image src="${class_model_texture_url}" />`);
        }
        $('#class_model_texture').on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Class Model Texture',
                button: {
                    text: 'Upload Class Model Texture',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#class_model_texture_id' ).val( attachment.id );
                $('#class_model_texture_url').val( attachment.sizes.medium.url);
                $('#class-model-texture-container').html(`<image src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });
        //Starts Section BG Image
        var starts_bg_url = $( '#starts_bg_url' ).val();
        if( starts_bg_url ){
            $( '#starts-bg-container' ).html( `<image src="${starts_bg_url}" />`);
        }
        $( '#upload_starts_bg' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Starts BG',
                button: {
                    text: 'Upload Starts BG Image',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $( '#starts_bg_id' ).val( attachment.id );
                $( '#starts_bg_url' ).val( attachment.sizes.large.url );
                $( '#starts-bg-container' ).html(`<image src="${attachment.sizes.large.url}" />`);
            });
            frame.open();
            return false;
        });
        //Instructor Section Image
        var instructor_image = $( '#instructor_img_url' ).val();
        if( instructor_image ){
            $( '#instructor-image-container' ).html( `<image src="${instructor_image}" />`);
        }
        $( '#upload_instructor_image' ).on( 'click', function(){
            if( frame ){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Instructor Image',
                button: {
                    text: 'Upload Instructor Image',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get( 'selection' ).first().toJSON();
                $( '#instructor_img_id' ).val( attachment.id );
                $( '#instructor_img_url' ).val( attachment.sizes.medium.url );
                $( '#instructor-image-container' ).html( `<image src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });
        //Price card Icon
        var price_card_icon = $( '#price_card_icon_url' ).val();
        if( price_card_icon ){
            $( '#price-card-icon-container' ).html( `<image src="${price_card_icon}" />`);
        }
        $( '#upload_price_card_icon' ).on( 'click', function(){
            if( frame ){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Icon',
                button: {
                    text: 'Upload Price Card Icon',
                },
                multiple: false,
            });
            frame.on( 'select', function(){
                var attachment=frame.state().get( 'selection' ).first().toJSON();
                $( '#price_card_icon_id' ).val( attachment.id );
                $( '#price_card_icon_url' ).val( attachment.sizes.thumbnail.url );
                $( '#price-card-icon-container' ).html( `<image src="${attachment.sizes.thumbnail.url}" />`);
            });
            frame.open();
            return false;
        });
        //Trainer Section Bg Image
        var trainer_bg = $( '#trainer_bg_url' ).val();
        if( trainer_bg )  {
            $('#trainer-bg-container' ).html( `<image src="${trainer_bg}" />`);
        }
        $('#upload_trainer_bg').on('click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Trainer Bg',
                button: {
                    text: 'Upload Trainer Bg',
                },
                multiple: false
            });
            frame.on( 'select', function(){
                var attachment= frame.state().get('selection').first().toJSON();
                $( '#trainer_bg_id' ).val( attachment.id );
                $( '#trainer_bg_url' ).val( attachment.sizes.large.url);
                $( '#trainer-bg-container' ).html( `<image src="${attachment.sizes.large.url}" />`);
            });
            frame.open();
            return false;
        });
        //Trainer Image
        var trainer_img = $( '#trainer_img_url' ).val();
        if( trainer_img ){
            $('#trainer-img-container' ).html( `<image src="${trainer_img}" />`);
        }
        $('#upload_trainer_img').on( 'click', function(){
            if( frame ){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Trainer Image',
                button: {
                    text: 'Upload Trainer Image',
                },
                multiple: false
            });
            frame.on( 'select', function(){
                var attachment = frame.state().get('selection' ).first().toJSON();
                $('#trainer_img_id' ).val( attachment.id );
                $('#trainer_img_url' ).val( attachment.sizes.thumbnail.url );
                $('#trainer-img-container' ).html(`<image src="${attachment.sizes.thumbnail.url}" />`);
            });
            frame.open();
            return false;
        });
        //Trainer Texture Image
        var trainer_texture = $( '#trainer_texture_url' ).val();
        if( trainer_texture ){
            $('#trainer-texture-container').html( `<image src="${trainer_texture}" />`);
        }
        $( '#upload_trainer_texture' ).on( 'click', function(){
            if(frame){
                frame.open();
                return false;
            }
            frame = wp.media({
                title: 'Select Trainer Texture',
                button: {
                    text: 'Upload Trainer Texture',
                },
                multiple: false,
            });
            frame.on('select', function(){
                var attachment=frame.state().get('selection').first().toJSON();
                $('#trainer_texture_id').val( attachment.id );
                $('#trainer_texture_url').val( attachment.sizes.medium.url);
                $('#trainer-texture-container').html( `<image src="${attachment.sizes.medium.url}" />`);
            });
            frame.open();
            return false;
        });

    }); //Document ready
    
})(jQuery);