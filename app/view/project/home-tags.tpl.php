<h2 class='upper margint'>Populära taggar</h2>

<div class=''>
	<?php foreach ($tags as $tag) : ?>
		<a class="tag-button" href='<?=$this->url->create("question/tagged/{$tag->tag}")?>'><?=$tag->tag?></a>
	<?php endforeach; ?>

</div>