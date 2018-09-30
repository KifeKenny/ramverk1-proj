<?php

namespace Anax\View;

$user  = isset($users) ? $users : null;

?>

<h1>Users</h1>
<hr>

<?php
for ($i=0; $i < count($user); $i++) {

    $userImg = $app->get_gravatar($user[$i]->mail, 80);

    $content = '<div class="question">';
    $content .= '<div class="titleQuestion">';

    $content .= '<div class="userDiv left"> <img class="quesImg" src="' . $userImg . '">';
    $content .= '<p class="userName"><em></em></p>';
    $content .= '</div>';
    $content .= '<h3 class="title">';

    $usrUrl = $app->url->create("user/profile/" . $user[$i]->id);
    $content .= '<a href="' . $usrUrl . '">' . $user[$i]->username . '</a></h3>';

    $content .= '<p> Questions: ' . $user[$i]->questions . '</p>';
    $content .= '<p> Comments: ' . $user[$i]->comments . '</p>';



    $content .= '</div>';
    $content .= '</div>';

    echo $content;
}
