const growerForm = document.getElementById('growerForm');

document.getElementById('displayGrowerForm').addEventListener('click', function(event) {
    event.preventDefault();
    growerForm.classList.toggle('hidden');
})

document.getElementById('addGrower').addEventListener('click', function(event) {
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
            // location.reload();
            if (!data.result) {
                return;
            }
            const growerElement = document.importNode(document.getElementById('growerTemplate').content, true);
            growerElement.querySelector('[data-content="business"]').innerText = data.business;
            document.getElementById('growers').prepend(growerElement);

            growerForm.classList.add('hidden');
        })
        .catch(error => {
            console.error('Error: ', error);
        })
})


const deleteBtns = document.querySelectorAll('#deleteBtn');

deleteBtns.forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.preventDefault();
        const id = parseInt(this.closest('[data-id-product]').dataset.idProduct);
        const data = {
            action: 'deleteProduct',
            token: getToken(),
            id: id
        };
        console.log(data);
        fetchApi('POST', data)
            .then(data => {
                console.log(data);
                // document.querySelector(`[data-id-product="${id}"]`).remove();
            })
            .catch(error => {
                console.error('Error: ', error);
            })
    })
})