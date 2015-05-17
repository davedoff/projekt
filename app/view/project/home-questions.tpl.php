<h2 class='upper margint'>Senaste frågor</h2>
				<div class='upper left'>
					<h4>Rubrik</h4>
				</div>
				<div class='upper right'>
					<h4>Datum</h4>
				</div>
<?php if($questions): ?>
<div class='postsHome'>
	<div class='questions'>
	<?php foreach ($questions as $question) : ?>
		<?php $questionProp = $question->getProperties(); ?>
		<div class='questionHome'>
		
			<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUser','params' => [$questionProp['user_id']]]);?>

			<div>    
				<div class='question-home clear'>
					<div class=''>
						<a class='left' href='<?=$this->url->create("question/id/{$questionProp['id']}")?>'><?=$question->title?></a>
						<span class='right'><?=$questionProp['created']?></span></br>
						<span class='created-home'>Skapad av <a class=''href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a></span>
					</div>
					
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>

						

