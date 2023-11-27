document.getElementById('insc__btn').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'inscription',
        token: getToken(),
        email: document.getElementById('insc__email').value,
        pwd: document.getElementById('insc__pwd').value
    };
    console.log(data);
    fetchApi('POST', data)
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error("Error :", error);
        });
})

document.getElementById('create__btn').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('inscription').classList.remove('hidden');
    document.getElementById('connexion').classList.add('hidden');
})