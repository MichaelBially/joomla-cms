<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 John Smith. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
$app=Factory::getApplication();

dump($this->record);
?>
<h2>Rekord bearbeiten</h2>

<p><?php //print_r($this->record); ?></p>

<form action="index.php?option=com_records" method="post" name="adminForm" >
	<h3 class="mb-4"><?php echo $this->record->agegroup_name. ' - ' .$this->record->competition_text;?></h3>
	
<?php dump($app->getMessageQueue());?>



	<div class="row mb-3">
  		<label class="col-sm-2 col-form-label">Ergebnis </label>
  		<div class="col-sm-6">
  			<input type="text" name="record_result" class="form-control" id="inputErgebnis" placeholder="Ergebnis" value="<?php echo $this->record->result;?>" />
  		</div>
		<div class="col-sm-1" ><?php echo $this->record->measurement;?></div>  		
	</div>
	
	<div class="row mb-3">
  		<label class="col-sm-2 col-form-label">Datum von </label>
  		<div class="col-sm-6">
  			<input type="text" name="record_date" class="form-control" id="inputDate" placeholder="jahr-monat-tag" value="<?php echo $this->record->date;?>" />
	  		<small>
    		    Datum in der Form Jahr-Monat-Tag (z.B. 2020-12-03)
      		</small>
  		</div>
	</div>
	
	<div class="row mb-3">
  		<label class="col-sm-2 col-form-label">Datum bis </label>
  		<div class="col-sm-6">
  			<input type="text" name="record_date2" class="form-control" id="inputDate" placeholder="jahr-monat-tag" value="<?php echo $this->record->date2;?>" />
	  		<small>
    	    	Datum in der Form Jahr-Monat-Tag (z.B. 2020-12-03)
      		</small>
  		</div>
	</div>
	
	<div class="row mb-3">
  		<label class="col-sm-2 col-form-label">Ort </label>
  		<div class="col-sm-6">
  			<input  type="text" name="record_location" class="form-control" id="inputOrt" placeholder="Ort" value="<?php echo $this->record->location;?>" />
  		</div>
	</div>
	
	<div class="row mb-3">
  		<label for="inputRekorHalter" class="col-sm-2 form-label">Rekord-Halter</label>
  		<div class="col-sm-6">
  			<textarea class="form-control" name="record_person" id="inputRekordHalter" rows="3"><?php echo $this->record->person?></textarea>
  			<small>
    	    	Personen in der Form Nachname, Vorname;<br>mehrere Personen durch ; getrennt
      		</small>
  		</div>
	</div>

	<input type="hidden" name="record_id" value="<?php echo $this->record->record_id;?>" >
	<input type="hidden" name="record_competition_id" value="<?php echo $this->record->competition_id;?>" >
	<input type="hidden" name="record_agegroup_id" value="<?php echo $this->record->agegroup_id;?>" >
	<input type="hidden" name="record_nr" value="<?php echo $this->record->nr;?>" >
	<input type="hidden" name="Itemid" value="<?php echo $app->input->get('Itemid');?>" >
	<input id="task" type="hidden" name="task" value="">

	<button class="btn btn-primary" type="submit" name="saveandback" onclick="$(task).val('record.saveandback')">speichern und zurück</button>
	<button class="btn btn-secondary" type="submit" name="save" onclick="$(task).val('record.save')">speichern</button>
	<button class="btn btn-secondary" type="submit" name="cancel" onclick="$(task).val('record.cancel')">abbrechen</button>

</form>