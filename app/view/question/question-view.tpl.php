

<?php if(isset($question)): ?>
<?php $questionProp = $question[0]->getProperties(); ?>
	<a class='question-button upper right' href="<?=$this->url->create('question/addAnswer/' . $questionProp['id'] . '') ?>">Svara</a>
<h1 class='clear'>Fråga</h1>
<div class='posts'>
<div class='question'>
	<div class='contentHeader'>
		<h2 class='question-h2'><?=$questionProp['title']?></h2>
	</div>
	
	<div class='user'>
		<div class=''>
			<span class=""><?=$questionProp['created']?></span>
		</div>
		<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUser','params' => [$questionProp['user_id']]]);?>
		
		<a class='bottom' href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a>
	</div>

	<div class='content'>

		<p><?=$questionProp['question']?></p>
	</div>
			
	<div class='tags clear'>
		<?php $tags = $this->di->dispatcher->forward(['controller' => 'tag','action' => 'getTagsIdQuestion','params' => [$questionProp['id']]]);?>
				
		<?php foreach ($tags as $tag) : ?>
			<a class="tag-button" href='<?=$this->url->create("question/tagged/{$tag->tag}")?>'><?=$tag->tag?></a>
		<?php endforeach; ?>
	</div>
</div>
	<a class="question-button right clear marginbu" href="<?=$this->url->create('comment/add/question/' . $question[0]->id . '') ?>">Kommentera</a>

	<?php if($comments): ?>
	<div class='comments clear'>
		<?php foreach ($comments as $comment) : ?> 
		<?php $commentProp = $comment->getProperties(); ?>
		<div class='comment'>
			
			<div class='userComment'>
				<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUser','params' => [$commentProp['user_id']]]);?>
				
			</div>
			
			<div class='comment'>
				<div class='comment-info'>
					<span class=""><?=$commentProp['created']?></span> 
					<a href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a>
				</div>
				<div class="commentText">
				<p><?=$commentProp['comment']?></p>
				</div>
			</div>		
		</div>
		<?php endforeach; ?> 
	</div>
	<?php endif; ?>

</div>
<?php endif; ?>

<?php if($answers): ?>
<div class='posts clear'>
<h2 class='upper ta'>Svar</h2>
<?php foreach ($answers as $answer) : ?> 
<?php $answerProp = $answer->getProperties(); ?>
<div class='question'>
	<div class='user pad'>
		<div class=''>
			<span class=""><?=$questionProp['created']?></span>
		</div>
		<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUser','params' => [$questionProp['user_id']]]);?>
		
		<a class='bottom' href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a>
	</div>

	<div class='content'>
		<p><?=$answerProp['answer']?></p>
	</div>
	
	
	<?php $commentAnswer = $this->di->dispatcher->forward(['controller' => 'comment','action' => 'listCommentAnswer','params' => [$answerProp['idAnswer']]]);?>
</div>
	<a class="question-button right clear marginbu" href="<?=$this->url->create('comment/add/answer/' . $answerProp['idAnswer'] . '') ?>">Kommentera</a>
	<?php if($commentAnswer): ?>


		

	<div class='comments clear'>
		<?php foreach ($commentAnswer as $comment) : ?> 
		<?php $commentProp = $comment->getProperties(); ?>
		<div class='comment'>
			
			<div class='userComment'>
				<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUser','params' => [$commentProp['user_id']]]);?>
				
			</div>
			
			<div class='comment'>
				<div class='comment-info'>
					<span class=""><?=$commentProp['created']?></span> 
					<a href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a>
				</div>
				<div class="commentText">
				<p><?=$commentProp['comment']?></p>
				</div>
			</div>		
		</div>
		<?php endforeach; ?> 
	</div>
	<?php endif; ?>
<?php endforeach; ?> 
<?php endif; ?>
</div>
</div>






