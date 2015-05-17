<h2 class='upper margint'>Aktiva användare</h2>
<?php if($users): ?>
<table>
	<tr>
	    <th class='t upper'>Användarnamn</th>
	    <th class='upper'>E-mail</th>
	    <th class='upper'>Namn</th>
	</tr>
	
	<?php foreach ($users as $user) : ?>
	<tr>
		<td class='t'><a href="<?=$this->url->create('users/id/' . $user->id) ?>"><?=$user->acronym?></a></td>
		<td><?=$user->email?></td>
		<td><?=$user->name?></td>
	</tr>	
	<?php endforeach; ?>
	
</table>
<?php endif; ?>