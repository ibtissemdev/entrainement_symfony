const form = document.querySelector('#shortenForm');
const shortenCard = document.querySelector('#shortenCard');
const inputUrl = document.querySelector('#url');
const btnShortenUrl = document.querySelector('#btnShortenUrl');


const URL_SHORTEN = '/ajax/shorten';

const errorMessages = {
    'INVALID_ARG_URL': "Impossible de raccourcir ce lien. Ce n'est pas une URL valide",// si l'Url n'existe pas
    'MISSING_ARG_URL': 'Veuillez fournir une URL valide'// Si l'URL n'est pas valide
}


form.addEventListener('submit', function (e) {
    e.preventDefault();

    fetch(URL_SHORTEN, {
        method: 'POST',
        body: new FormData(e.target)
    })
        .then(response => response.json())
        .then(handleData);
});

const handleData = function (data) {
    // console.log(data);
    if (data.statusCode >= 400) {
        return handleError(data);
    }
    inputUrl.value = data.link;
    btnShortenUrl.innerText = "Copier";

    btnShortenUrl.addEventListener('click', function (e) {
        e.preventDefault();

        inputUrl.select();
        document.execCommand('copy');

        this.innerText = "Réduire l'URL";
    }, {once: true});
}

const handleError = function (data) {
const alert=document.createElement('div')
alert.classList.add('alert','alert-danger','mt-2');
alert.innerText= errorMessages[data.statusText];

shortenCard.after(alert);//Le message s'affiche après le formulaire
}