const growerForm = document.getElementById('growerForm');

document.getElementById('displayGrowerForm').addEventListener('click', function (event) {
    event.preventDefault();
    growerForm.classList.remove('hidden');
})

document.getElementById('addGrower').addEventListener('click', function (event) {
    event.preventDefault();
    const data = {
        action: 'addGrower',
        token: getToken(),
        lastname: document.getElementById('lastname').value,
        firstname: document.getElementById('firstname').value,
        email: document.getElementById('email').value,
        business: document.getElementById('business').value
    };
    console.log(data);
    fetchApi('POST', data)
        .then(data => {
            console.log(data);
            growerForm.classList.add('hidden');
        })
        .catch(error => {
            console.error('Error: ', error);
        })
})