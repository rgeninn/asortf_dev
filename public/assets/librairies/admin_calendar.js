document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: mobileCheck() ? "timeGridDay" : "timeGridWeek",
        windowResize: function(view) {
            if (window.innerWidth >= 768 ) {
                calendar.changeView('timeGridWeek');
                $('.btn.active').removeClass('active');
                $('#calendar_week').addClass('active')
            } else {
                calendar.changeView('timeGridDay');
            }
        },
        height:  "calc(100% - 160px)",
        locale: 'fr',
        selectable: true,
        selectMirror: true,
        headerToolbar: false,
        nowIndicator: true,

        select: async function (event) {
            const modal = $('#new_event_modal');
            const date_container = modal.find('#date_container');
            let html = '';

            if(event.allDay) {
                html +=
                    ` <div class="control required">
                            <label for="date">Jour de l'évènement</label>
                            <input type="date" readonly id="date" value="${moment(event.start).format('YYYY-MM-DD')}">
                        </div>`
            } else {
                html += `
                <div class="control date_input required">
                            <label for="start_date">Date de début</label>
                            <input type="date" readonly id="start_date" value="${moment(event.start).format('YYYY-MM-DD')}">
                            <input type="time" readonly id="start_time" value="${moment(event.start).format('HH:mm')}">
                        </div>
                        <div class="control date_input required">
                            <label for="end_date">Date de fin</label>
                            <input type="date" readonly id="end_date" value="${moment(event.end).format('YYYY-MM-DD')}">
                            <input type="time" readonly id="end_time" value="${moment(event.end).format('HH:mm')}">
                        </div>`
            }

            date_container.html(html)
            modal.css('display', 'flex');

            modal.find('.modal_close').on('click', ()=> {
                modal.find('.note.error').remove();
                modal.find('.error').removeClass('error')
                modal.hide();
            })

            modal.on('submit', (e)=>{
                e.preventDefault();
                createEvent(modal, event, calendar)
            })
        },
        eventClick: function(info) {
            // TODO: Display context menu + delete
        }
    });
    calendar.render();
    renderHeader(calendar);
});


createEvent = function(form, fcEvent, calendar) {

    if(form.find('#name').val().length !== 0) {
        const event = {
            'title': $('#name').val(),
            'description': $('#description').val(),
            'start': fcEvent.start,
            'end': fcEvent.end,
            'allDay': fcEvent.allDay,
            'registration': $('#event_registration').val(),
            'editable': true
        };
        form.find('.note.error').remove();
        form.find('.error').removeClass('error')
        // TODO AJAX REQUEST

        calendar.addEvent(event);
        form[0].reset();
        form.hide();

        // // Add event
        // fetch("eventHandler.php", {
        //     method: "POST",
        //     headers: { "Content-Type": "application/json" },
        //     body: JSON.stringify({ request_type:'addEvent', start:start.startStr, end:start.endStr, event_data: formValues}),
        // })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.status == 1) {
        //             Swal.fire('Event added successfully!', '', 'success');
        //         } else {
        //             Swal.fire(data.error, '', 'error');
        //         }
        //
        //         // Refetch events from all sources and rerender
        //         calendar.refetchEvents();
        //     })
        //     .catch(console.error);
        //}
    } else {
        const errorContainer= form.find('#name').closest('.control');
        if(!errorContainer.hasClass('error')) {
            errorContainer.addClass('error');
            errorContainer.append('<small class="note error">Merci d\'ajouter un nom à l\'évènement</small>')
        }
    }

}

renderHeader = function(calendar) {
    $('#today').html(calendar.currentData.viewTitle)

    $('#calendar_prev').on('click', ()=> {
        calendar.prev();
        $('#today').html(calendar.currentData.viewTitle)
    });

    $('#calendar_next').on('click', ()=> {
        calendar.next();
        $('#today').html(calendar.currentData.viewTitle)
    });

    $('#calendar_today').on('click', ()=> {
        calendar.today();
        $('#today').html(calendar.currentData.viewTitle)
    });

    $('#calendar_day').on('click', (e)=> {
        calendar.changeView('timeGridDay')
        $('.btn.active').removeClass('active');
        $(e.currentTarget).addClass('active')

    });

    $('#calendar_week').on('click', (e)=> {
        calendar.changeView('timeGridWeek')
        $('.btn.active').removeClass('active');
        $(e.currentTarget).addClass('active')
    });

    $('#calendar_month').on('click', (e)=> {
        calendar.changeView('dayGridMonth')
        $('.btn.active').removeClass('active');
        $(e.currentTarget).addClass('active')
    });
}

mobileCheck = function () {
    return window.innerWidth < 768;
};
