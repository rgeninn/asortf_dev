init = () => {
    initTabs();
    initWYSIWYGS();
    bindHeaderListeners();
}


initTabs = ()=> {
    $('.tablinks').on('click', (e)=> {
        const clicked = $(e.currentTarget);
        const tabToDisplay = clicked.data('display');
        $('.tabcontent').removeClass('active')
        $('.tablinks').removeClass('active')
        $(clicked).addClass('active')
        $(`#${tabToDisplay}`).addClass('active')
    });
}

initWYSIWYGS = ()=> {
    const quillDescription = new Quill('#description', {
        theme: 'snow',
        modules: {
            toolbar:  ['bold', 'italic', 'underline','link']
        }
    });

    const quillTab1 = new Quill('#tab_1_content', {
        theme: 'snow',
        modules: {
            toolbar:  ['bold', 'italic', 'underline','link']
        }
    });


    const quillTab2 = new Quill('#tab_2_content', {
        theme: 'snow',
        modules: {
            toolbar:  ['bold', 'italic', 'underline','link']
        }
    });

    const quillTab3 = new Quill('#tab_3_content', {
        theme: 'snow',
        modules: {
            toolbar:  ['bold', 'italic', 'underline','link']
        }
    });
}


bindHeaderListeners = () => {
    bannerImagePreview();

}

bannerImagePreview = () => {
    const fileInput = $('#header_image_preview');
    fileInput.on('change', (e)=> {
        $('#header_image_preview_target')[0].src =  URL.createObjectURL(e.target.files[0])

    })
}

init();

