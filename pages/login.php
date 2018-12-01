<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!--<link rel="stylesheet" href="styles.css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
</head>



<body>
    <header class="identity">

        <a class="logo"><i class="fab fa-reddit fa-4x"></i></a>
        <h1> WebsiteName </h1>

    </header>

    <form method="post">
        <label>Username: <input type="text" name="username"> </label>
        <label>Password: <input type="password" name="password"></label>
        <input type="submit" formaction="../actions/action_login.php" value="Login">
        <input type="submit" formaction="../actions/action_signup.php" value="Signup">
    </form>

</body>

</html>