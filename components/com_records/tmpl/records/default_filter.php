<?php /**$session = JFactory::getSession();
$filter_name = $session->get('filter_name', NULL);
$filter_year = $session->get('filter_year', 0);
//$filter_type = $session->get('filter_type', 0);
$filter_halle = $session->get('filter_halle', 0);
$filter_freiluft = $session->get('filter_freiluft', 0);
$filter_mit = $session->get('filter_mit', 0);
$filter_ohne = $session->get('filter_ohne', 0);
$filter_alte_recorde = $session->get('filter_alte_recorde', 0);
*/
$filter_name = $this->state->get('filter_name', NULL);
$filter_year = $this->state->get('filter_year', 0);
$filter_halle = $this->state->get('filter_halle', 0);
$filter_freiluft = $this->state->get('filter_freiluft', 0);
$filter_mit = $this->state->get('filter_mit', 0);
$filter_ohne = $this->state->get('filter_ohne', 0);
$filter_alte_recorde = $this->state->get('filter_alte_recorde', 0);

?>

<div id="advancedSearch" class="container-fluid hidden-print">
	<div>
		<h4>Suche</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
						<div class="form-group">
							<label class="control-label col-sm-2 col-md-4" for="surname">Name:</label>
							<div class="col-sm-10 col-md-8">
								<input type="text" class="form-control" name="filter_name" id="athlete" value="<?php echo $filter_name; ?>" />
							</div>
						</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-check form-switch">
  					<input class="form-check-input" type="checkbox" value="1" name="filter_alte_recorde" <?php if($filter_alte_recorde == 1) echo 'checked'?>>
  					<label class="form-check-label" for="flexSwitchCheckChecked">auch in alten Rekorden suchen</label>
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="row" >
						<?php  echo $this->loadTemplate('filteragegroup'); ?>
						<?php  echo $this->loadTemplate('filtercompetition'); ?>
				</div>
				<div class="row">
						<div class="form-group">
							<label class="control-label col-sm-2 col-md-4" for="year">Saison:</label>
							<div class="col-sm-10 col-md-8">
								<select id="year" name="filter_year" class="form-control">
									<option <?php if($filter_year == '0') echo 'selected ';?>value="0"><?php echo 'Jahr auswählen'?></option>
									<?php foreach($this->years as $y) :?>
										<option <?php if($filter_year == $y->year) echo 'selected ';?>><?php echo $y->year;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<?php /*
					<div class="form-group">
						<label class="control-label col-sm-4" for="type">Rekordart:</label>
						<div class="col-sm-8">
							<select id="type" name="filter_type" class="form-control">
								<option value="0" <?php if($filter_type == 0) echo 'selected';?>>Disziplinen mit/ohne Rekorde</option>
								<option value="1" <?php if($filter_type == 1) echo 'selected';?>>Disziplinen mit Rekorde</option>
								<option value="2" <?php if($filter_type == 2) echo 'selected';?>>Disziplinen ohne Rekorde</option>
							</select>
						</div>
					</div>
					*/ ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-check form-switch">
  					<input class="form-check-input" type="checkbox" value="1" name="filter_freiluft"  <?php if($filter_freiluft == 1) echo 'checked'?>>
  					<label class="form-check-label" for="flexSwitchCheckChecked">Freiluft-Rekorde</label>
				</div>
				
				<div class="form-check form-switch">
  					<input class="form-check-input" type="checkbox" value="1" name="filter_halle"  <?php if($filter_halle == 1) echo 'checked'?>>
  					<label class="form-check-label" for="flexSwitchCheckChecked">Hallen-Rekorde</label>
				</div>
				
				<div class="form-check form-switch">
  					<input class="form-check-input" type="checkbox" value="1" name="filter_ohne" <?php if($filter_ohne == 1) echo 'checked'?>>
  					<label class="form-check-label" for="flexSwitchCheckChecked">Disziplinen/Altersklassen ohne Rekorde</label>
				</div>

				<div class="form-check form-switch">
  					<input class="form-check-input" type="checkbox" value="1" name="filter_mit" <?php if($filter_mit == 1) echo 'checked'?>>
  					<label class="form-check-label" for="flexSwitchCheckChecked">Disziplinen/Altersklassen mit Rekorde</label>
				</div>
				

			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<input type="submit" class="btn btn-info" name="suchen" value="Suchen" />
			<input id="resetBtn" type="button" class="btn btn-info" name="reset" value="Reset" />
		</div>
	</div>
	<p>&nbsp;</p>
</div>


