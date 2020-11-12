var checkbox = document.querySelector('#isRecurrence');
var inputs = document.querySelectorAll('.recurrency_input');
var frequency = document.querySelector('#session_frequency');
var days = document.querySelector('#session_days');
var weekDays = document.querySelector('#session_weekDays');

checkbox.addEventListener('change', () => {
    if(checkbox.checked) {
        document.querySelector('.recurrency').style.display = "flex";
        inputs.forEach(element => element.setAttribute("required","true"));
    } else {
        document.querySelector('.recurrency').style.display = "none";
        inputs.forEach(element => element.removeAttribute("required"));
        inputs.forEach(element => element.value = '');
    }
});

frequency.addEventListener('change', () => {
    if(frequency.value == 'MONTHLY') {
        days.parentNode.style.display = "none";
        days.removeAttribute("required");
        days.value = '';
        document.querySelector('.recurrency_days').style.display = "flex";
        weekDays.parentNode.style.display = "flex";
        weekDays.setAttribute("required","true");
    } else if(frequency.value == 'WEEKLY') {
        weekDays.parentNode.style.display = "none";
        weekDays.removeAttribute("required");
        weekDays.value = '';
        document.querySelector('.recurrency_days').style.display = "flex";
        days.parentNode.style.display = "flex";
        days.setAttribute("required","true");
    } else {
        document.querySelector('.recurrency_days').style.display = "none";
        weekDays.value = '';
        days.value = '';
    }
});

window.onload = () => {
    document.querySelector('.recurrency').style.display = "none";
    document.querySelector('.recurrency_days').style.display = "none";
}