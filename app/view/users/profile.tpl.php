<div class='profile'>
	<img class='avatar' src='http://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028.jpg?s=200'>
	<h1><?=$user->acronym?></h1>

</div>
	<?php if($this->session->has('user') && ($this->session->get('user') == $user->acronym || $this->session->get('user') == 'admin')) : ?>
	<div class='marginb'>
		<a class='edit-button' href="<?=$this->url->create('users/edit/' . $user->id) ?>">Redigera</a>
	</div>
	<?php endif; ?>
 <table class='user-table margin'>
    <tr>
        <th class='t'>E-mail</th>
        <td class='t-2'><?=$user->email?></td>
    </tr>
    <tr>
        <th class='t'>Namn</th>
        <td class='t-2'><?=$user->name?></td>
    </tr>
    <tr>
        <th class='t'>Aktiv sedan</th>
        <td class='t-2'><?=$user->active?></td>
    </tr>
</table> 







<?php if($questions || $answers): ?>
<div class='posts'>

	<div class='questions'>
		<?php if($questions) : ?>
			<h2 class='upper clear'>Frågor av <?=$user->acronym?></h2>
				<div class='upper left'>
					<h4>Rubrik</h4>
				</div>
				<div class='upper right'>
					<h4>Datum</h4>
				</div>
			<?php foreach ($questions as $question) : ?>
				<?php $questionProp = $question->getProperties(); ?>
				<div class='question-home clear'>					
					<p><a href='<?=$this->url->create("question/id/{$questionProp['id']}")?>'><?=$questionProp['title']?></a> <span class="right"><?=$questionProp['created']?></span></p>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	
	<div class='answers'>
		<?php if($answers) : ?>
			<h2 class='upper clear'>Svar av <?=$user->acronym?></h2>
				<div class='upper left'>
					<h4>Rubrik</h4>
				</div>
				<div class='upper right'>
					<h4>Datum</h4>
				</div>
			<?php foreach ($answers as $answer) : ?>
				<?php $answerProp = $answer->getProperties(); ?>
				<?php $question = $this->di->dispatcher->forward(['controller' => 'question','action' => 'getQuestion','params' => [$answerProp['question_id']]]);?>
				<div class='question-home clear'>
					<p><a href='<?=$this->url->create("question/id/{$answerProp['question_id']}")?>'><?=$question->title?></a> <span class="right"><?=$answerProp['created']?></span></p>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>