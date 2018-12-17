<?php 
    include_once '../templates/tpl_common.php';
    draw_head(login_head())
?>

<body>
    <div class="bg-container">
        <div class="bg-image"></div>
        <div class="bg-filter"></div>
    </div>

    <header class="identity">
        <a class="logo"><i class="fab fa-reddit fa-4x"></i></a>
        <h1>WebsiteName</h1>
    </header>



    <div class="login-container">
        <div class="login-wrap">
            <div class="login-html">
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Log In</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>

                <div class="login-form">

                    <div class="log-in-htm">
                        <form accept-charset="utf-8" form method="post" id="log-in-form">
                            <div class="group">
                                <label for="user" class="label">Username</label>
                                <input name="username" maxlength="255" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Password</label>
                                <input name="password" maxlength="255" type="password" class="input" required>
                            </div>

                            <section id="messages"></section>

                            <div class="group">
                                <input type="submit" id="signin_button" class="button" value="Login">
                            </div>
                            <div class="foot-lnk">
                                <a href="#forgot">Forgot Password?</a>
                            </div>
                        </form>
                    </div>

                    <div class="sign-up-htm">
                        <form accept-charset="utf-8" form method="post" id="sign-up-form">
                            <div class="group">

                                <div id="upload-container">
                                    <div id="upload-choose-container">
                                        <input type="file" id="upload-file" name="file" accept="image/jpeg, image/png" />
                                        <button id="choose-upload-button"><img id="img_placeholder" src="../resources/profile/default.png"></button>
                                    </div>
                                    <div id="placeholder">
                                        <button id="cancel-button"><i class="far fa-times-circle"></i></button>
                                    </div>
                                    <div id="error-message"></div>
                                </div>

                            </div>
                            <div class="group">
                                <label for="user" class="label">Username</label>
                                <input name="username" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Password</label>
                                <input name="password" type="password" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Repeat Password</label>
                                <input name="password-conf" type="password" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Email Address</label>
                                <input name="email" type="email" class="input" required>
                            </div>

                            <section id="messages"></section>

                            <div class="group">
                                <input type="submit" id="login_button" class="button" value="Signup">
                            </div>
                            <div class="foot-lnk">
                                <label for="tab-1">Already Member?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php function login_head(){
    return '
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
    <script src="../js/utilities.js" defer></script>
    <script src="../js/image.js" defer></script>
    <script src="../js/auth.js" defer></script>';
}?>