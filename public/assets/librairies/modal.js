function modal_init() {
    const modal_open = $('.modal_open')
    const modal = $(modal_open.data('modal_id'));

    modal_open.on('click', ()=> {
        modal.css('display', 'flex');


        modal.find('.modal_close').on('click', ()=> {
            modal.hide();
        })

    })
}

modal_init()
