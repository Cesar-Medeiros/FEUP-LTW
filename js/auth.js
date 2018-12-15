function login(username, password) {
    var URL = "../api/users.php/login";

    let sendObj = JSON.stringify({
        "username": username,
        "password": password
    });

    ajax(URL, "POST", sendObj)
        .then(function () {
            window.location = "../pages/homepage.php";
        })
        .catch(function (responseJSON) {
            var type = Object.keys(responseJSON.info)[0];
            var content = responseJSON.info[type];
            let message_elem = login_form.querySelector('#messages');
            message_elem.appendChild(messageHTML(type, content));
            login_form.reset();
        });
}

function signup(username, password, email) {
    var URL = "../api/users.php";

    let sendObj = JSON.stringify({
        "username": username,
        "password": password,
        "email": email
    });

    ajax(URL, "POST", sendObj)
        .then(function () {
            // window.location = "../pages/homepage.php";
        })
        .catch(function (responseJSON) {
            var type = Object.keys(responseJSON.info)[0];
            var content = responseJSON.info[type];
            let message_elem = signup_form.querySelector('#messages');
            message_elem.appendChild(messageHTML(type, content));
            signup_form.reset();
        });
}

function messageHTML(type, content){
    let div = document.createElement("div");
    div.className = type;
    div.textContent = content;
    return div;
}


//----------------------------------------------------------

let login_form = document.getElementById('log-in-form');
let signup_form = document.getElementById('sign-up-form');

login_form.addEventListener('submit', function (event) {
    event.preventDefault();
    login(this.elements['username'].value, this.elements['password'].value);
});

signup_form.addEventListener('submit', function (event) {
    event.preventDefault();
    console.log("t");
    console.log(this.elements['password'].value);
    console.log(this.elements['password-conf'].value);
    console.log(this.elements['password'].value == this.elements['password-conf'].value);
    if (this.elements['password'].value == this.elements['password-conf'].value) {
        console.log("1");
        signup(this.elements['username'].value, this.elements['password'].value, this.elements['email'].value);
    } else {
        console.log("2");
        this.elements['password-conf'].setCustomValidity('Password doesn\'t match');
    }
});