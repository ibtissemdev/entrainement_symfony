const listGroupItems = document.querySelectorAll('.list-group-item');
const actions = document.querySelector(('#action'));

const btnCopy = document.querySelector('#btnCopy');
const btnStats = document.querySelector('#btnStats');
const btnDelete = document.querySelector('#btnDelete');

const URL_DELETE = '/ajax/delete';

let selectedItem = null;
let hash = null;

listGroupItems.forEach(item => {
    item.addEventListener('click', function () {
        selectedItem = this;
        selectedItem.classList.add('active');
        hash = selectedItem.dataset.hash;

    })
})

