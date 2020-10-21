function addElement(parentId, elementTag, elementId, html) {
    var parent = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;

    parent.appendChild(newElement);
}

function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

var fieldId = 0;

function addField(option) {
    fieldId++;
    var html = `
    <div class="form-inline">
        <div class="form-group mt-2">
            <input type="text" class="form-control mr-2" id="phonebook_roles_${option}_${fieldId}" name="phonebook[roles_${option}][${fieldId}]" required/>
            <button type="button" class="btn btn-danger" onclick="removeElement(\'field-${fieldId}\'); return false;"><i class="far fa-trash-alt"></i></button>
        </div>
    </div>
    `;

    addElement(option + '-fields-list','div','field-' + fieldId, html);
}