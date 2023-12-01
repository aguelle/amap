if (document.getElementById('notif-index').textContent.length > 0) {
    setTimeout(() => {
        document.getElementById('notif-index').textContent = '';
    }, 3000);
};

// To create an account
document.getElementById('create__link').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('inscription').classList.remove('hidden');
    document.getElementById('connexion').classList.add('hidden');
    // document.getElementById('switch-container').classList.add('hidden');
});

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
            }
            else {
                document.getElementById('notif-index').textContent = data['error'];
                setTimeout(() => {
                    document.getElementById('notif-index').textContent = '';
                }, 3000);
            };
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

// Connexion
// Switch button
let isProducer = false;
document.getElementById('switch').addEventListener('click', function (event) {
    isProducer = event.target.checked;
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
            if (data['result'] === true && data['producer' === true]) {
                document.location.replace('producer.php');
            }
            else if (data['result'] === true && data['producer'] === false) {
                document.location.replace('member.php');
            }
            else {
                document.getElementById('notif-index').textContent = data['error'];
                setTimeout(() => {
                    document.getElementById('notif-index').textContent = '';
                }, 3000);
            };
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

// Back btn
document.getElementById('index-back__btn').addEventListener('click', function () {
    document.getElementById('inscription').classList.add('hidden');
    document.getElementById('connexion').classList.remove('hidden');
    // document.getElementById('switch-container').classList.remove('hidden');
});
