<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<h4 class='FontComment'>Comment: <a href="<?=$this->url->create('comment/edit') . '?id=' . $id . '&amp;pageType=' . $pageType?>"> #<?=$id?></a></h4>
<div class='comment'>
	<div class='infoComment'>
		<?=$comment["name"]?>
		<?=date( 'Y-m-d H:i' , $comment['timestamp'] ) ?>
		<?=$comment["mail"]?>
		<?=$comment["web"]?>
	</div>
	<div class='contentComment'>
		<p><?=$comment["content"]?></p>
	</div>

<form method='post'>
	<input type='hidden' name='redirect' value="<?=$this->url->create($pageType)?>">
	<input type='hidden' name='key' value="<?=$id?>">
	<input type='hidden' name='pageType' value="<?=$pageType?>">
	<p>
		<input type='submit' name='doEdit' value='Edit' onclick="this.form.action = '<?=$this->url->create('comment/edit')?>'"/>
		<input type='submit' name='doRemove' value='Remove' onClick="this.form.action = '<?=$this->url->create('comment/remove')?>'"/>
	</p>
</form>
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>
