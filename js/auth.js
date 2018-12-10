function login(username, password) {
    request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    }
    request.open("POST", "../api/users.php/login", true);
    request.send(JSON.stringify({
        "username": username,
        "password": password
    }));
}

function init() {
    let login_form = document.getElementById('log-in-form');
    let signup_form = document.getElementById('sign-up-form');

    login_form.addEventListener('submit', function (event) {
        event.preventDefault();
        login(this.elements['username'].value, this.elements['password'].value);
        window.location = "../pages/homepage.php";
    });

    signup_form.addEventListener('submit', function (event) {
        event.preventDefault();
        signup();
    });
}

init();