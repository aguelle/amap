async function fetchApi(method, data) {
    try {
        const response = await fetch('././api.php', {
            method: method,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });
        return response.json();
    }
    catch (error) {
        console.error('Unable to load api');
    }
}

function getToken() {
    return document.getElementById('token').value;
}

function hideNotif() {
    document.getElementById('notif-index').innerHTML="";
    document.getElementById('notif-member').innerHTML="";
  };
