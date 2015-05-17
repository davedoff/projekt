<h1>Alla taggar</h1>


	<?php foreach ($tags as $tag) : ?>
		<a class="question-button inline" href='<?=$this->url->create("question/tagged/{$tag->tag}")?>'><?=$tag->tag?></a>
	<?php endforeach; ?>

