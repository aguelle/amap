document.getElementById('create__link').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('inscription').classList.remove('hidden');
    document.getElementById('connexion').classList.add('hidden');
})

document.getElementById('insc__btn').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'inscription',
        token: getToken(),
        lastname: document.getElementById('insc__lastname').value,
        firstname: document.getElementById('insc__firstname').value,
        email: document.getElementById('insc__email').value,
        pwd: document.getElementById('insc__pwd').value
    };
    fetchApi('POST', data)
        .then(data => {
            if (data['result'] === true) {
                console.log('On connecte la base de données.')
                document.location.replace('member.php');
            }
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

document.getElementById('conn__btn').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'connexion',
        token: getToken(),
        email: document.getElementById('conn__email').value,
        pwd: document.getElementById('conn__pwd').value
    };
    fetchApi('POST', data)
        .then(data => {
            if (data['result'] === true) {
                console.log('On connecte la base de données.')
                document.location.replace('member.php');
            }
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

document.getElementById('index-back__btn').addEventListener('click', function () {
    document.getElementById('inscription').classList.add('hidden');
    document.getElementById('connexion').classList.remove('hidden');
});