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

initTabs();
