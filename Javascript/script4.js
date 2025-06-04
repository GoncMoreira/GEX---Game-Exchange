document.getElementById('submit_edition').addEventListener('click', submitEdition);

document.querySelectorAll('.edit_button').forEach(function(button) {button.addEventListener('click', editionManager);});

function editionManager(event){
    event.preventDefault();

    let label = event.target.closest('label');

    if (label.classList.contains('changing')) disableEdition(label);
    else enableEdition(label);
}

function enableEdition(label) {

    let input = label.querySelector('input');

    input.removeAttribute('readonly');

    label.classList.add('changing');

}

function disableEdition(label) {

    let input = label.querySelector('input');

    input.setAttribute('readonly', true);

    label.classList.remove('changing');

}

function submitEdition(event) {
    event.preventDefault();

    let form = document.getElementById('edition_form');

    form.submit();
}
