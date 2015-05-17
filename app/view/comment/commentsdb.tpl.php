<hr>

<h2>Comments</h2>
	
<?php if (is_array($comments) && !empty($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $comment) : ?>
<div class='topComment'>
<h4 class='FontComment'>Comment:  <a href="<?=$this->url->create('comment/edit/' . $comment->id)?>" title="Edit"> #<?=$comment->id?></a></h4>
<div class='changeComment'>
	<a href="<?=$this->url->create('comment/edit/' . $comment->id) ?>" title="edit">Edit</a>
	<a href="<?=$this->url->create('comment/delete/' . $pageType . '/' . $comment->id ) ?>" title="delete">Delete</a>
</div>
</div>


<div class='comment'>
	<div class='infoComment'>
		<?=$comment->name?>
		<?=$comment->timestamp?>
		<?=$comment->email?>
		<?=$comment->homepage?>
	</div>
	<div class='contentComment'>
		<p><?=$comment->content?></p>
	</div>
	
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>