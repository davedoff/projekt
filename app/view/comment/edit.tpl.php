<h2>Edit comment: <?=$name?></h2>

<div class='comment-form'>
    <form method='post'>
        <input type='hidden' name="redirect" value="<?=$this->url->create($pageType)?>">
		<input type='hidden' name='pageType' value='<?=$pageType?>'>
		<input type='hidden' name='key' value="<?=$id?>">
        <fieldset>
        <legend>Edit a comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' value='Back' onClick="this.form.action = '<?=$this->url->create($pageType)?>'"/>
			<input type='submit' name='doSave' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/save')?>'"/>
			<input type='reset' value='Reset'/>
        </p>
        </fieldset>
    </form>
</div>