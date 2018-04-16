/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {

    var file_frame;

    var el_header_input = $("#sabian_header_inp");

    var el_header_image = $("#sabian_header_img");

    var el_button = $("#sabian_header_image_btn");
    
    var el_button_remove=$("#sabian_header_image_remove_btn");

    $(document).ready(function () {
        
        init_file_frame();
        
        el_button.click(function () {

            /*Check whether the wp media frame instance exists*/
            if (file_frame !== undefined) {

                file_frame.open();

                return;
            }

        });
        
        el_button_remove.click(function(){
            
            el_header_input.val(-1);
            
            el_header_image.attr("src","");
        });

    });
    
    function init_file_frame() {

            /*Init the wp media frame.*/
            file_frame = wp.media.frames.file_frame = wp.media({

                title: 'Select or upload category image',

                library: {
                    /*Limit only to image*/
                    type: 'image'
                },

                button: {
                    text: 'Select Image'
                },

                multiple: false  // Set to true to allow multiple files to be selected
            });

            /*When an image is selected, run a callback.*/
            file_frame.on('select', function () {

                /*Get the first selected image*/
                var res = file_frame.state().get('selection').first().toJSON();

                /*Assign image to the element*/
                el_header_image.attr("src", res.url);

                el_header_input.val(res.url);
                
                el_button_remove.removeAttr("disabled");

            });
        }
    
})(jQuery);