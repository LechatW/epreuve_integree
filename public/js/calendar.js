window.onload = () => {
    let calendarEl = document.querySelector('#calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap',
        locale: 'fr',
        weekends: false,
        initialDate: calendarEl.dataset.view,
        headerToolbar: {
            start: 'title',
            end: 'prev next today',
            middle: ''
        },
        buttonText: {
            today: 'Aujourd\'hui',
            dayGridMonth: 'Mois',
            timeGridWeek: 'Semaine',
            timeGridDay: 'Jour'
        },
        events: JSON.parse(calendarEl.dataset.sessions)
    });
    calendar.render();
}
