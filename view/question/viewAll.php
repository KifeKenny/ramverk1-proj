<?php

namespace Anax\View;

echo "<h1>Questions</h1><hr>";

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$tags  = isset($tags) ? $tags : null;
$user  = isset($user) ? $user : null;

// $app->get_gravatar($user_mail);
// var_dump($items);
// var_dump($tags);
// var_dump($user);

foreach ($items as $item) {
    $tempUser;
    foreach ($user as $users) {
        if ($users->id == $item->userId) {
            $tempUser = $users;
            continue;
        }
    }

    $arTemp       = array_map('intval', str_split($item->tagsId));
    $commentTags  = [];
    foreach ($tags as $tag) {
        for ($i=0; $i < count($arTemp); $i++) {
            if($arTemp[$i] == $tag->id) {
                array_push($commentTags, $tag->name);
            }
        }
    }

    $userImg = $app->get_gravatar($tempUser->mail, 80);

    $content = '<div class="question">';

    $content .= '<div class="titleQuestion">';
    $content .= '<div class="userDiv left"> <img class="quesImg" src="' . $userImg . '">';
    $content .= '<p class="userName"><em>' . $tempUser->username . '</em></p> </div>';

    $content .= '<h3 class="title"><a href="">' . $item->title . '</a></h3> ';
    for ($i=0; $i < count($commentTags); $i++) {
        $content .= '<p class="tagUnder"><strong>' . $commentTags[$i] . '</strong></p>';
    }
    $content .= '</div>';



    $content .= '<p class="content">' . $item->content . '</p></div>';

    echo $content;
}
