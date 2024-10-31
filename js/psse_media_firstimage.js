/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var firstimage_frame;
 
    // Runs when the image button is clicked.
    //$('.song-button').click(function(e){
	$(document).on('click', '.firstimage-button' , function(e){
		
        // Prevents the default action from occuring.
        e.preventDefault();
		target = e.target || e.srcElement;

        // If the frame already exists, re-open it.
        if ( firstimage_frame ) {
            firstimage_frame.open();
            return;
        }

        // Sets up the media library frame
        firstimage_frame = wp.media.frames.firstimage_frame = wp.media({
            title: psse_media_firstimage_js.title,
            button: { text:  psse_media_firstimage_js.button },
            library: { type: 'image' },
			multiple: false
        });

        // Runs when an image is selected.
        firstimage_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = firstimage_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.

			$('#psse_media_firstimage').val(media_attachment.url);
			delete target;
        });
 
        // Opens the media library frame.
        firstimage_frame.open();
    });
});