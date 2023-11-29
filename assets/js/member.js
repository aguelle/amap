if (document.getElementById('notif-member').textContent.length > 0) {
    setTimeout(() => {
        document.getElementById('notif-member').textContent = '';
    }, 3000);
};