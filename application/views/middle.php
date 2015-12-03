<h1><?php echo $projectName ?></h1>

<!-- タグ一覧 -->
<div class="row">
    <div class="col s12">
<?php
foreach($tags as $tag){
    echo '<div class="chip">' .$tag. '</div>';
}
?>
    </div>
</div>

<pre><code class="haxe"><?php echo $program; ?></code></pre>

<div class="row description">
    <div class="col s10 offset-s1">
        <div class="card-panel white">
            <span>
                <?php echo nl2br($description); ?>
            </span>
        </div>
    </div>
</div>

<!-- pvなどのデータ群 -->
<div>

</div>
