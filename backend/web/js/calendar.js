"use strict";

(function($, window){
    function startOfDay(date) {
        const clonedDate = new Date(date);

        clonedDate.setHours(0);
        clonedDate.setMinutes(0);
        clonedDate.setSeconds(0);
        clonedDate.setMilliseconds(0);

        return clonedDate;
    }

    function startOfMonth(date) {
        const clonedDate = startOfDay(new Date(date));

        clonedDate.setDate(1);

        return clonedDate;
    }

    function getCalendarHeight() {
        if (window.matchMedia('(min-width: 1600px)').matches) {
            return '100%';
        } else {
            return 'auto';
        }
    }

    let val = $.ajax({
        url: '/shop-admin/otcher/calendar/ajax-calendar',
        type: 'get',
        async: false,
        dataType: 'json',
    }).responseText;
    let values = $.parseJSON(val);
    $('#calendar').each(function () {
        const calendarEl = this;
        const curYear = (new Date()).getFullYear();
        const curMonth = ('0' + ((new Date()).getMonth() + 1)).substr(-2);
        const eventsSources = values;
        const datepicker = $('.sa-calendar-datepicker').datepicker({
            language: 'ru',
            classes: 'datepicker-sa-embedded',
            inline: true,
            onRenderCell: function (date, cellType) {
                if (cellType === 'day') {
                    const currentDay = date.getTime();
                    let dotsHtml = '';

                    eventsSources.forEach(function(eventSource) {
                        eventSource.events.map(function(event) {
                            const startDate = startOfDay(new Date(event.start)).getTime();
                            const endDate = event.end ? startOfDay(new Date(event.end)).getTime() : startDate;

                            if (
                                (startDate < currentDay && endDate > currentDay) ||
                                (startDate === currentDay)
                            ) {
                                dotsHtml += '<div class="datepicker-sa-dot" style="--datepicker-sa-dot--color: ' + event.color + '"></div>';
                            }
                        });
                    });

                    if (dotsHtml) {
                        return {
                            html: date.getDate()
                                + '<div class="datepicker-sa-dots">'
                                + dotsHtml
                                + '</div>'
                        }
                    }
                }
            },
            onSelect: function onSelect(fd, date) {
                if (date) {
                    calendar.changeView('timeGridDay', date);
                } else if (calendar.view.type === 'timeGridDay') {
                    calendar.changeView('dayGridMonth');
                }
            },
        }).data('datepicker');
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'ru',
            initialView: 'dayGridMonth',
            customButtons: {
                'sa-sidebar': {
                    text: '',
                    click: function() {
                        window.stroyka.layoutSidebar.open();
                    }
                }
            },
            viewDidMount: function() {
                calendarEl.querySelectorAll('.fc-sa-sidebar-button').forEach((button) => {
                    if (button.classList.contains('fc-sa-sidebar-button')) {
                        button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"><path d="M7,14v-2h9v2H7z M14,7h2v2h-2V7z M12.5,6C12.8,6,13,6.2,13,6.5v3c0,0.3-0.2,0.5-0.5,0.5h-2 C10.2,10,10,9.8,10,9.5v-3C10,6.2,10.2,6,10.5,6H12.5z M7,2h9v2H7V2z M5.5,5h-2C3.2,5,3,4.8,3,4.5v-3C3,1.2,3.2,1,3.5,1h2 C5.8,1,6,1.2,6,1.5v3C6,4.8,5.8,5,5.5,5z M0,2h2v2H0V2z M9,9H0V7h9V9z M2,14H0v-2h2V14z M3.5,11h2C5.8,11,6,11.2,6,11.5v3 C6,14.8,5.8,15,5.5,15h-2C3.2,15,3,14.8,3,14.5v-3C3,11.2,3.2,11,3.5,11z"></path></svg>';
                    }
                });
            },
            headerToolbar: {
                left: 'sa-sidebar prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            height: getCalendarHeight(),
            navLinks: true,
            buttonText: {
                today: 'Сегодня',
                month: 'Месяц',
                week: 'Неделя',
                day: 'День',
                list: 'Список',
            },
            editable: true,
            selectable: true,
            selectMirror: true,
            droppable: true,

            select: function(info) {
                const eventTitle = prompt('Введите название нового события:');

                let date = JSON.stringify(info.start);
                let dateEnd = JSON.stringify(info.end);
                // date = date.slice(1,11);
                // dateEnd = dateEnd.slice(1,11);
                console.log('info.end', date);
                if (eventTitle) {

                    $.ajax({
                        url: '/shop-admin/otcher/calendar/ajax-add',
                        type: "get",
                        data: {
                            title: eventTitle,
                            date: date,
                            dateEnd: dateEnd,
                            color: '#a61c00',
                            colorText: '#ffffff',
                        },
                        success: function(res){
                            console.log(res);
                            calendar.addEvent({
                                title: eventTitle,
                                start: info.start,
                                end: info.end,
                                allDay: info.allDay,
                            });
                        },
                        error: function (res) {
                            // console.log('errors', res);
                        }
                    });

                    // console.log('eventTitle', calendar.addEvent());
                }

                calendar.unselect();
            },

            eventClick: function(info) {

                if (confirm('Вы уверены, что хотите удалить это событие?')) {
                    var id = info.event._def.publicId;
                    $.ajax({
                        url: '/shop-admin/otcher/calendar/delete',
                        // type: "post",
                        data: {
                            id: id,
                            // _csrf: yii.getCsrfToken()
                        },
                        dataType: 'json',
                        success: function(res){
                            info.event.remove();
                        },
                        error: function (res) {
                            // console.log('errors', res);
                        }
                    });
                    info.event.remove();
                }
            },
            eventSources: eventsSources,
            datesSet: function(event) {
                if (['dayGridMonth', 'timeGridWeek', 'listWeek'].includes(event.view.type)) {
                    datepicker.clear();
                    const startMonth = startOfMonth(event.start);

                    if (event.view.type === 'dayGridMonth' && event.start.getDate() !== 1) {
                        startMonth.setMonth(startMonth.getMonth() + 1);
                    }

                    if (startMonth.getTime() !== startOfMonth(datepicker.date).getTime()) {
                        datepicker.date = startMonth;
                    }
                } else if (event.view.type === 'timeGridDay') {
                    const selectedDates = datepicker.selectedDates.map(function(date) {
                        return startOfDay(date).getTime();
                    });

                    if (selectedDates.length !== 1 || selectedDates[0] !== startOfDay(event.start).getTime()) {
                        datepicker.selectDate(event.start);
                    }
                }
            },
            windowResize: function() {
                calendar.setOption('height', getCalendarHeight());
            },
        });

        calendar.render();
    });
}(jQuery, window));
