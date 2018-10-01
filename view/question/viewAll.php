<?php

namespace Anax\View;

$setTag  = isset($_GET['tag']) ? $_GET['tag'] : null;
$tagName = isset($_GET['name']) ? $_GET['name'] : null;
$items = isset($items) ? $items : null;
$tags  = isset($tags) ? $tags : null;
$user  = isset($user) ? $user : null;

?>

<h1>Questions</h1>
<hr>

<p>
    <a href="<?=$app->url->create("question/create")?>">Create a question>>> </a>
</p>


<?php
if ($tagName) {
    echo '<div class="fix"><p class="tagUnder"><strong>' . $tagName . '</strong></p></div>';
}
?>



<?php

foreach ($items as $item) {
    $arTemp       = array_map('intval', str_split($item->tagsId));
    $commentTags  = [];
    $tagOk        = 0;
    foreach ($tags as $tag) {
        for ($i=0; $i < count($arTemp); $i++) {
            if ($arTemp[$i] == $tag->id) {
                array_push($commentTags, $tag->name);
                if ($setTag == $tag->id || $setTag == null) {
                    $tagOk = 1;
                }
            }
        }
    }

    if ($tagOk != 1) {
        continue;
    }

    $tempUser;
    foreach ($user as $users) {
        if ($users->id == $item->userId) {
            $tempUser = $users;
            continue;
        }
    }

    $userImg = $app->getGravatar($tempUser->mail, 80);

    $content = '<div class="question fix">';

    $content .= '<div class="titleQuestion">';
    $content .= '<div class="userDiv left"> <img class="quesImg" src="' . $userImg . '">';
    $content .= '<p class="userName"><em>' . $tempUser->username . '</em></p> </div>';

    $content .= '<h3 class="title"><a href="' . $app->url->create("question/comments/" . $item->id);
    $content .= '">' . $item->title . '</a></h3><div class="fix">';
    for ($i=0; $i < count($commentTags); $i++) {
        $content .= '<p class="tagUnder"><strong>' . $commentTags[$i] . '</strong></p>';
    }
    $content .= '</div><p class="left"><em> published:' . $item->created . '</em></p>';
    $content .= '<p class="right"> Answers:' . $item->comments . '</p>';
    $content .= '</div>';

    $mark = $di->get("textfilter")->parse($item->content, ["markdown"]);
    $content .= '<p class="content">' . $mark->text . '</p></div>';

    echo $content;
}
