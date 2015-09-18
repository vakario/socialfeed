<form method="post" id="socialfeed_config">
	<fieldset>
	<legend>{l s='Setting' mod='socialfeed'}</legend>
		<label for="socialfeed_API_key">{l s='API Key' mod='socialfeed'} :</label>
		<input id="socialfeed_API_key" name="socialfeed_API_key" type="text"/>
		
		<label for="socialfeed_API_secret">{l s='API secret' mod='socialfeed'} :</label>
		<input id="socialfeed_API_secret" name="socialfeed_API_secret" type="text"/>
		
		<label for="socialfeed_Access_token_key">{l s='Access Token Key' mod='socialfeed'} :</label>
		<input id="socialfeed_Access_token_key" name="socialfeed_Access_token_key" type="text"/>
		
		<label for="socialfeed_Access_token_secret">{l s='Access Token Secret' mod='socialfeed'} :</label>
		<input id="socialfeed_Access_token_secret" name="socialfeed_Access_token_secret" type="text"/>
		
		<label for="socialfeed_nb_post">{l s='Post number' mod='socialfeed'} :</label>
		<select id="socialfeed_nb_post" name="socialfeed_nb_post">
			<option value="1">1</option>
			<option value="1">2</option>
			<option value="1">3</option>
			<option value="1">4</option>
			<option value="1">5</option>
		</select>
		
		<label>&nbsp;</label>
		<input name="submit_socialfeed" type="submit" value="{l s='Save' mod='socialfeed'}" class="button" />
	</fieldset>
</form>

