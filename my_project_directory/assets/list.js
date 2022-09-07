const listGroupItems = document.querySelectorAll('.list-group-item');
const actions = document.querySelector('#actions');

const btnCopy = document.querySelector('#btnCopy');
const btnStats = document.querySelector('#btnStats');
const btnDelete = document.querySelector('#btnDelete');

const URL_DELETE = '/ajax/delete';

let selectedItem = null;
let hash = null;

listGroupItems.forEach(item => {
    item.addEventListener('click', function () {
        if (selectedItem === this) {
            selectedItem = null;
            hash = null;
            this.classList.remove('active');
            return;
        }

        listGroupItems.forEach(item => item.classList.remove('active'));

        selectedItem = this;
        hash = selectedItem.dataset.hash;
        selectedItem.classList.add('active');
        toogleButtonsInteraction()

    })
});

btnCopy.addEventListener('click', function(){
    const link = document.querySelector(`anchor_${hash}`);
});

const toogleButtonsInteraction = function (isDisabled = false) {
    Array.from(actions.children).forEach(button => {
        button.disabled = isDisabled;
    })
}

