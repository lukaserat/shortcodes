var img = jQuery('<img>').css({
    position: 'fixed',
    left: '-9999px'
});
  
jQuery('img[data-src]').each(function () {
    var self = jQuery(this),
        highres_url = self.data('src'),
        preloader = img.clone()
                       .attr('src', highres_url)
    ;

    preloader.on('load', function () {
        // should be 'cached' by now
        self.attr('src', highres_url);
    }).appendTo('body');

});
