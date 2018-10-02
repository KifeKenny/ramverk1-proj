<?php

namespace Anax\View;

$items  = isset($items) ? $items : null;
$answer = isset($answer) ? $answer : null;

// var_dump($answer);

?>

<div class="question">
    <div class="titleQuestion">
        <div class="userDiv left">
            <img class="quesImg" src="<?=$app->getGravatar($answer->user->mail, 80)?>">
            <p class="userName"><?=$answer->user->username?></p>
        </div>
        <?php if ($answer->type == "Question") : ?>
            <h3 class="title" style="color: white"><?=$answer->title?></h3>
        <?php endif; ?>
        <div class="fix">

        <?php
        if ($answer->type == "Question") {
            for ($i=0; $i < count($answer->tags); $i++) {
                echo '<p class="tagUnder"><strong>' . $answer->tags[$i]->name . '</strong></p>';
            }
        }
        ?>

        </div>
        <p><em>Published: <?=$answer->created?></em></p>
    </div>
    <p class="content">
        <?=$di->get("textfilter")->parse($answer->content, ["markdown"])->text?>
    </p>
</div>

<p><strong>Create a comment for ↗ </strong></p>

<?= $form ?>
