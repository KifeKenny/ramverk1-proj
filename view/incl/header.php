<!DOCTYPE html>
<meta charset="utf-8">
<head>
  <title><?= $title[0] ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href=<?=$title[1]?>>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand zero" href="<?=$app->url->create("")?>"><img class="pumpkingImg" src=<?=$title[2]?>></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php
        $all_url = ["about", "user", "question"];

        for ($i=0; $i < count($all_url); $i++) {
            $cur_url = $app->url->create($all_url[$i]);
            echo '<li><a style="color: #b77e15;" href=' . $cur_url . '>' . $all_url[$i] . "</a></li>";
        }
        $session = $di->get("session");
        $cur_user = $session->get("current_user");
        $login_url = $app->url->create("user/logout");
        $profile_url = $app->url->create("user/profile/" . $session->get('user_id'));
        $login_name = "Logout";

        $user_mail  = $session->get('user_mail');
        $user_img  = $app->getGravatar($user_mail);

        if (!$cur_user) {
            $login_name = "Login";
            $login_url  = $app->url->create("user/login");
        }
        ?>

    </ul>
    <?php if ($cur_user) : ?>
        <ul class="nav navbar-nav navbar-right">
            <li><img src="<?=$user_img?>"></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=$profile_url?>"><?=$cur_user?></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=$app->url->create("user/edit")?>">Edit</a></li>
        </ul>

    <?php endif; ?>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?=$login_url?>"><?=$login_name?></a></li>
    </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center">
  <div class="row content">
