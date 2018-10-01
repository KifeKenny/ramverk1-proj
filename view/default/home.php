<?php

namespace Anax\View;

$users      = isset($users) ? $users : null;
$questions  = isset($questions) ? $questions : null;
$tags       = isset($tags) ? $tags : null;

?>

<h1>Home</h1>
<hr>
<br>

<div class="block">
<h3 class="white">Newest questions &#8595;</h3>
<?php foreach ($questions as $que) : ?>
    <div class="question fix">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($que->user->mail, 80)?>">
                <p class="userName"><?=$que->user->username?></p>
            </div>

            <h3 class="title">
                <a href="<?=$app->url->create("question/comments/" . $que->id)?>">
                    <?=$que->title?>
                </a>

            </h3>
            <div class="fix">
            <?php
            for ($i=0; $i < count($que->tags); $i++) {
                echo '<p class="tagUnder"><strong>' . $que->tags[$i] . '</strong></p>';
            }
            ?>
            </div>
            <p><em>Published: <?=$que->created?></em></p>
        </div>
        <p class="content">
            <?=$di->get("textfilter")->parse($que->content, ["markdown"])->text?>
        </p>
    </div>
<?php endforeach; ?>

</div>

<div class="block">

<h3 class="white">Most active Users &#8595;</h3>
<?php foreach ($users as $use) : ?>
    <div class="question">
        <div class="titleQuestion">
            <div class="userDiv left">
                <img class="quesImg" src="<?=$app->getGravatar($use->mail, 80)?>">
                <p class="userName"><em></em></p>
            </div>
            <h3 class="title">
                <a href="<?=$app->url->create("user/profile/" . $use->id)?>">
                    <?=$use->username?>
                </a>
            </h3>

            <p> Questions: <?=$use->questions?></p>
        </div>
    </div>
<?php endforeach; ?>

</div>

<div class="block">

<h3 class="white">Most populare Tags &#8595;</h3>
<?php foreach ($tags as $name => $amount) : ?>
    <div class="fix">
    <p class="tagUnder" style="float: none;">
        <a href="<?=$app->url->create("question") . "?tag=". $amount[1] . "&name=" . $name?>">
            <strong>
                <?=$name?>: <?=$amount[0]?>
            </strong>
        </a>
    </p>

    </div>
<?php endforeach; ?>

</div>
