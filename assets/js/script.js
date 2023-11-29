// To hide notif if present
window.setTimeout(hideNotif, 3000);

// To create an account
document.getElementById('create__link').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('inscription').classList.remove('hidden');
    document.getElementById('connexion').classList.add('hidden');
})

// Inscription
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
                document.location.replace('member.php');
                document.getElementById('notif-member').textContent = data['notif'];
            }
            else {
                document.getElementById('notif-index').textContent = data['error'];
            }
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

// Connexion
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
                document.location.replace('member.php');
                document.getElementById('notif-member').textContent = data['notif'];
            }
            else {
                document.getElementById('notif-index').textContent = data['error'];
            }
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

// Back btn
document.getElementById('index-back__btn').addEventListener('click', function () {
    document.getElementById('inscription').classList.add('hidden');
    document.getElementById('connexion').classList.remove('hidden');
});