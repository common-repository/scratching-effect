/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var secondimage_frame;
 
    // Runs when the image button is clicked.
    //$('.song-button').click(function(e){
	$(document).on('click', '.secondimage-button' , function(e){
		
        // Prevents the default action from occuring.
        e.preventDefault();
		target = e.target || e.srcElement;

        // If the frame already exists, re-open it.
        if ( secondimage_frame ) {
            secondimage_frame.open();
            return;
        }

        // Sets up the media library frame
        secondimage_frame = wp.media.frames.secondimage_frame = wp.media({
            title: psse_media_secondimage_js.title,
            button: { text:  psse_media_secondimage_js.button },
            library: { type: 'image' },
			multiple: false
        });

        // Runs when an image is selected.
        secondimage_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = secondimage_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.

			$('#psse_media_secondimage').val(media_attachment.url);
			delete target;
        });
 
        // Opens the media library frame.
        secondimage_frame.open();
    });
});