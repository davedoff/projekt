<header id="above">
<?php if($this->session->has('user') && $this->session->get('user') == 'admin') : ?>
	<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUserAcronym','params' => [$this->session->get('user')]]);?>
	<div class="contentAbove upper">
		<a href="<?=$this->url->create("users/id/" . $user->id)?>"><?=($this->session->get('user'))?></a>
		<a href="<?=$this->url->create('users/logout')?>">Logga ut</a> 
	</div>
<?php elseif($this->session->has('user')) : ?>
	<?php $user = $this->di->dispatcher->forward(['controller' => 'users','action' => 'getUserAcronym','params' => [$this->session->get('user')]]);?>
	<div class="contentAbove upper">
		<a href="<?=$this->url->create("users/id/" . $user->id)?>"><?=($this->session->get('user'))?></a>
		<a href="<?=$this->url->create('users/logout')?>">Logga ut</a> 
	</div>
<?php else: ?>
	<div class="contentAbove upper">
		<a href="<?=$this->url->create('users/login')?>">Logga in</a>
		<a href="<?=$this->url->create('users/add')?>">Registrera</a>
	</div>
<?php endif; ?>
</header>


