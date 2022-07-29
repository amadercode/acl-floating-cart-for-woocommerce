jQuery(function ($) {

 var focawoAdminHelper= {
     ajax: function (data) {
         return jQuery.post(focawo_admin_object.ajax_url, data);//Ajax url,Data

     }
 };
//Custom Cart Icon
$(document).on('click','.focawo-icon-btn-custom',function(e) {
    e.preventDefault();
    var currentDom=$(this);
    var imgDom=currentDom.parent().parent().find('img');
    var inputDom=currentDom.parent().parent().find('input');
    var image = wp.media({
        title: 'Custom Cart Icon',
        // mutiple: true if you want to upload multiple files at once
        multiple: false
    })
    .open()
    .on('select', function(e){
        // This will return the selected image from the Media Uploader, the result is an object
        var uploaded_image = image.state().get('selection').first();
        var image_url = uploaded_image.toJSON().url;
        imgDom.attr('src',image_url);
        inputDom.val(image_url);
        currentDom.text('Revert to Default Icon');
        currentDom.addClass('focawo-icon-btn-defualt').removeClass('focawo-icon-btn-custom');
    });
});
$(document).on('click','.focawo-icon-btn-defualt',function(e) {
    e.preventDefault();
    var imgDom=$(this).parent().parent().find('img');
    var inputDom=$(this).parent().parent().find('input');
    if (confirm('Are you confirm to revert default icon?')) {
        inputDom.val('')
        imgDom.attr('src',$(this).attr('data-src'));
        $(this).text('Upload Custom Icon');
        $(this).addClass('focawo-icon-btn-custom').removeClass('focawo-icon-btn-defualt');


    }

});

});