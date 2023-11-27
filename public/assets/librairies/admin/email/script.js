init = function() {
    const preview = $('.preview');
    const emails = $('.list .mail');
    console.log(mobileCheck())
    if(mobileCheck()) {
        console.log('mobile')
        bindMobileEvents(preview, emails);
    }
}

bindMobileEvents = function(preview, emails) {
    emails.on('click', ()=> {
        const closePreview = $('#close_preview')
        //AJAX REUEST TO GET EMAIL

        preview.addClass('open');
        closePreview.show();

        closePreview.on('click', () => {
            // TODO: Empty preview
            preview.removeClass('open');
            closePreview.hide();
        })



    });



}

mobileCheck = function () {
    console.log(window.innerWidth)
    return window.innerWidth < 768;
};


init();
