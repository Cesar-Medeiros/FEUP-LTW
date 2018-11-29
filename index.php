<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans+Condensed:300" rel="stylesheet">
</head>



<body>
    <header class="sticky">
        <span id="user_info">
            <i class="fas fa-user-circle fa-2x" value="user"></i>
            <label for="user"><?php echo $_SESSION['username']?></label>

            <a class="header-icons" href="#settings"><i class="fas fa-cog"></i></a>
            <a class="header-icons" href="../actions/action_logout.php"><i class="fas fa-power-off"></i></a>
        </span>

        <a class="logo"><i class="fab fa-reddit fa-4x"></i></a>

        <select id="sort_by" onchange='alert("Call ajax")'>
            <option value="vote">Most voted up</option>
            <option value="time">More recent</option>
            <option value="comments">More comments</option>
        </select>


        <span class="search-bar">
            <i class="icon fa fa-search"></i>
            <input class="input-text" type="text" name="search" placeholder="Search">
        </span>


    </header>

    <aside class="aside probootstrap-aside js-probootstrap-aside">
            <div class="probootstrap-overflow">
              <nav class="probootstrap-nav">
                <ul>
                  <li class="probootstrap-animate active fadeInLeft probootstrap-animated"><a href="channel1.html"><i class="far fa-newspaper"></i> Channel1</a></li>
                  <li class="probootstrap-animate fadeInLeft probootstrap-animated"><a href="channel2.html"><i class="far fa-newspaper"></i> Channel2</a></li>
                  <li class="probootstrap-animate fadeInLeft probootstrap-animated"><a href="channel3.html"><i class="far fa-newspaper"></i> Channel3</a></li>
                  <li class="probootstrap-animate fadeInLeft probootstrap-animated"><a href="channel4.html"><i class="far fa-newspaper"></i> Channel4</a></li>
                  <li class="probootstrap-animate fadeInLeft probootstrap-animated"><a href="channel5.html"><i class="far fa-newspaper"></i> Channel5</a></li>
                </ul>
              </nav>
            </div>
          </aside>

    </aside>
    <nav>
    </nav>

    <section>
    </section>



</body>

</html>