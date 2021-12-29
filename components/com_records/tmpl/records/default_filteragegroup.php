<div>

<?php //$session = JFactory::getSession();
      //$filter_agegroup = $session->get('filter_agegroup', NULL);
      $filter_agegroup = $this->state->get('filter_agegroup', NULL);
      if($filter_agegroup == NULL)
      	$filter_agegroup = array(); 
?>

	<div class="form-group">
		<label class="control-label col-sm-2 col-md-4" for="ak">Altersklassen:</label>
		<div class="col-sm-10 col-md-8">
		<select id="ak" data-placeholder="Altersklasse" name="filter_agegroup[]" class="form-control chosen-select" multiple tabindex="2">
			<?php foreach($this->agegroups as $a) :?>
				<?php if(in_array(''.$a->id, $filter_agegroup ))
					$checked = ' selected ';
				else
					$checked = '';
				?>

				<option <?php echo $checked; ?>  value="<?php echo $a->id;?>"><?php echo trim($a->agegroup_name);?></option>

			<?php endforeach;?>
		</select>
		</div>
	</div>
</div>
