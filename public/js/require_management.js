window.onload = () => {
    var inputs = document.querySelectorAll('.form-control');
    var newNumber = document.querySelector('input[name="newNumber"]');
    var numberName = document.querySelector('input[name="numberName"]');
    
    inputs.forEach(input => input.addEventListener('keyup', () => {
        if(newNumber.value === "" && numberName.value === "") {
            inputs.forEach(element => element.removeAttribute("required"));
        } else if(input.value !== "") {
            inputs.forEach(input => input.setAttribute("required","true"));
        }
    }))
}





