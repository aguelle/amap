if (document.getElementById('notif-producer').textContent.length > 0) {
    setTimeout(() => {
        document.getElementById('notif-producer').textContent = '';
    }, 3000);
};

document.getElementById('pwd-modify__link').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('form__pwd-verify').classList.toggle('hidden');
});

document.getElementById('pwd-verify__btn').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'pwd-verify',
        token: getToken(),
        id: document.getElementById('pwd-verify__id').value,
        pwd: document.getElementById('pwd-verify__field').value
    };
    fetchApi('POST', data)
        .then(data => {
            console.log(data);
            if (data['result'] === true) {
                document.getElementById('notif-producer').textContent = data['notif'];
                setTimeout(() => {
                    document.getElementById('notif-producer').textContent = '';
                }, 3000);
                document.getElementById('form__pwd-modify').classList.remove('hidden');
                document.getElementById('form__pwd-verify').classList.add('hidden');
            }
            else {
                document.getElementById('notif-producer').textContent = data['error'];
                setTimeout(() => {
                    document.getElementById('notif-producer').textContent = '';
                }, 3000);
            };
        })
        .catch(error => {
            console.error("Error :", error);
        });
});

document.getElementById('pwd-modify__btn').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'pwd-modify',
        token: getToken(),
        id: document.getElementById('pwd-modify__id').value,
        pwd: document.getElementById('pwd-modify__field').value
    };
    fetchApi('POST', data)
        .then(data => {
            console.log(data);
            if (data['result'] === true) {
                document.getElementById('notif-producer').textContent = data['notif'];
                setTimeout(() => {
                    document.getElementById('notif-producer').textContent = '';
                }, 3000);
                document.getElementById('form__pwd-modify').classList.add('hidden');
                document.getElementById('form__pwd-verify').classList.add('hidden');
            }
            else {
                document.getElementById('notif-producer').textContent = data['error'];
                setTimeout(() => {
                    document.getElementById('notif-producer').textContent = '';
                }, 3000);
            };
        })
        .catch(error => {
            console.error("Error :", error);
        });
})