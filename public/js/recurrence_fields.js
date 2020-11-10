var checkbox = document.querySelector('#isRecurrence');
var inputs = document.querySelectorAll('.recurrency_input');

checkbox.addEventListener('change', () => {
    if(checkbox.checked) {
        document.querySelector('.recurrency').style.display = "flex";
        inputs.forEach(element => element.setAttribute("required","true"));
    } else {
        document.querySelector('.recurrency').style.display = "none";
        inputs.forEach(element => element.removeAttribute("required"));
        inputs.forEach(element => element.value = '');
    }
})

window.onload = () => {
    document.querySelector('.recurrency').style.display = "none";
}