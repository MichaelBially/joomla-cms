<?php //$session = JFactory::getSession();
//$filter_competition = $session->get('filter_competition', NULL);
$filter_competition = $this->state->get('filter_competition', NULL);
if($filter_competition == NULL)
    $filter_competition = array();
    ?>
	<div class="form-group">
		<label class="control-label col-sm-2 col-md-4" for="ak">Disziplinen:</label>
		<div class="col-sm-10 col-md-8">
			<select data-placeholder="Disziplinen" name="filter_competition[]" class="chosen-select" multiple tabindex="3">
				<?php foreach($this->competitions as $a) :?>
					<?php if(in_array($a->competition_shorttext, $filter_competition ))
						$checked = ' selected ';
					else
						$checked = '';
				?>
				<option <?php echo $checked; ?>  value="<?php echo $a->competition_shorttext;?>"><?php echo trim($a->competition_name);?></option>

				<?php endforeach;?>
			</select>
		</div>
	</div>
