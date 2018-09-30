<?php

namespace Anax\View;

$tags  = isset($tags) ? $tags : null;

?>

<div class="col-sm-2 sidenav">
<div class="tagsSide">
    <p><strong>Tags</strong><p>
        <hr>
<?php

foreach ($tags as $tag) {
    echo '<p> <a href="?tag=' . $tag->id . '&name=' . $tag->name . '">' . $tag->name . '</a></p>';
}

 ?>
    </div>
</div>

<div class="col-sm-8 text-left">
