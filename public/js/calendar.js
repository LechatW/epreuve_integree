window.onload = () => {
    let calendarEl = document.querySelector('#calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap',
        locale: 'fr',
        initialDate: calendarEl.dataset.view,
        headerToolbar: {
            start: 'prev next today',
            center: 'title',
            end: 'dayGridMonth timeGridWeek timeGridDay'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            dayGridMonth: 'Mois',
            timeGridWeek: 'Semaine',
            timeGridDay: 'Jour'
        },
        events: JSON.parse(calendarEl.dataset.sessions),
    });
    calendar.render();
}