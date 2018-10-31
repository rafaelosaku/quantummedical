<?php
$pg_share = str_replace('/404', '', $pg_url);
?>

<ul class="sharebox">
    <li class="like facebook"><span class="count">0</span><a href="<?= urlencode($pg_share); ?>&app_id=<?= $pg_fb_app; ?>" title="Compartilhe no Facebook"><i class="fa fa-facebook-official aria-hidden="true""></i> Compartilhe no Facebook</a></li>
    <li class="like google aria-hidden="true""><span class="count">0</span><a href="<?= $pg_share; ?>" title="Recomende no Google+"><i class="fa fa-google-plus"></i> Recomende no Google+</a></li>
    <li class="like twitter"><span class="count">0</span><a href="<?= urlencode($pg_share); ?>" rel="&text=<?= $pg_title; ?> <?= $pg_twitter; ?>" title="Conte isso no Twitter"><i class="fa fa-twitter" aria-hidden="true"></i> Conte isso no Twitter</a></li>
</ul>