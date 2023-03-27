jQuery(function($) {
    // Define the media uploader
    var uploader = wp.media({
      title: 'Select Images',
      button: {
        text: 'Add Images'
      },
      library: {
        type: 'image',
        uploadedTo: wp.media.view.settings.post.id // The ID of the current post
      },
      multiple: true,
      maxFileUploads: 6 // Set the maximum number of files to upload
    });
  
    // When the 'Add Images' button is clicked, open the media uploader
    $('.ttc-upload-image-gallery').click(function() {
      uploader.open();
    });
  
    // When images are selected, add them to the image list and hidden field
    uploader.on('select', function() {
      // Get the selected images and add them to a list
      var images = [];
      var urls = [];
      var selection = uploader.state().get('selection');
      if (selection.length > 6) {
        alert('You can only upload up to 6 images.');
        return false;
      }
      $('.ttc-image-boxes').empty();
      selection.each(function(attachment) {
        var image = $('<img>').attr('src', attachment.attributes.url);
        images.push($('<div>').addClass('ttc-image-box').append(image));
        urls.push(attachment.attributes.url);
      });
  
      // Add the list of images to the ttc-image-boxes wrapper
      $('.ttc-image-boxes').append(images);
  
      // Add the URLs of the selected images to the hidden field
      $('.ttc-hidden-image-url').val(urls.join(','));
    });
  });