
<div class="wrap">
	<h2>Launch Date</h2>
	<p>Use [date] to display Lauch Date</p>

	<form method="post" action="options.php">

		<?php 
		//set the group name. must match register_settings group name!
		settings_fields('ld_options_group'); 
		//get the current values so we can make the fields "stick"
		/*located in the wp_options in phpmyadmin.*/
		$values = get_option('ld_options');
		?>

		<label>Launch Date:</label>
		<br>
		<input id="date" type="text" name="ld_options[date]" value="<?php echo $values['date'] ?>" placeholder="12/20/2014">

		<?php submit_button('Save Date'); ?>

	</form>

</div>



