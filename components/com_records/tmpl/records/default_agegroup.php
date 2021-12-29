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

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$app = Factory::getApplication();
$user    = $app->getIdentity();

$Itemid = $app->input->get('Itemid');

?>
<?php //dump($app->getMessageQueue());?>

<?php //dump($this->records);?>
<?php if($this->records == NULL) :?>
	<p>Keine Rekorde gefunden</p>
<?php else :?>

	<div class="container-fluid hidden-print">
		<div id="records_navigation">
    		<div class="row">
        		<div class="col-md-12">
	        		<h4>Navigation</h4>
        		</div>
    		</div>

			<?php if($this->classes_male <> NULL) :?>			
				<ul class="pagination">
					<?php foreach($this->classes_male as $class) :?>
						<li class="page-item"><a class="page-link" href="<?php echo '#'.$class;?>"><?php echo $class;?></a></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?>
			<?php if($this->classes_female <> NULL) :?>
				<ul class="pagination">
					<?php foreach($this->classes_female as $class) :?>
						<li class="page-item"><a class="page-link" href="<?php echo '#'.$class;?>"><?php echo $class;?></a></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?>
		</div>
	</div>




<table id="record_table" class="table table-border table-responsive table-hover">
<?php $agegroup_shorttext = '';
	  $competition_id = -1; 
	  $i = 1; ?>
	  
<?php foreach($this->records as $record) :?>
	<?php if($record->agegroup_shorttext <> $agegroup_shorttext) :?>
		<?php $oldrecord = $record; ?>
		</tr>
		<tr>
			<td colspan="6"><a name="<?php echo $record->agegroup_shorttext;?>"></a><h3><?php echo $record->agegroup_name;?></h3></td>
		</tr>
		<?php $agegroup_shorttext = $record->agegroup_shorttext;
	   	   $competition_id = -1; ?>
	<?php endif; ?>
	
	
		<?php $noaddnew=false;?>
			<?php if($record->competition_id <> $competition_id) :?>	
			
				<?php if($competition_id != -1) :?>

					<?php /*if($oldrecord->maxnr > 0) :?>

    						<td class="record_history" data-record_id="<?php echo $oldrecord->record_id;?>" data-loaded="no" data-max_nr="<?php echo $oldrecord->maxnr;?>"><a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin anzuzeigen" style="cursor:pointer;"><img src="<?php echo Uri::base();?>media/com_records/images/history_open.png" /></a></td>

						<?php else:?>
						<td></td>
					<?php endif; */?>
				<?php endif;?>
				<?php $oldrecord = $record; ?>
				</tr>			
			
				<?php $i++; ?>
				<tr id="toogle<?php echo $record->record_id?>" >
				<td class="record_name"><?php echo $record->competition_name?><br /><span class="record_description"><?php echo $record->competition_description;?></span></td>
				<?php $competition_id = $record->competition_id;?>
			<?php else :?>
				<?php $noaddnew = true;?>
				<td></td>
				</tr>
				<tr id="toogle<?php echo $record->record_id?>" >
				<td></td>
				<?php $oldrecord = $record; ?>
			<?php endif;?>
		
		<td class="record_result" nowrap>
			<?php if($record->nr == -1): 
				echo '';
			else :
				echo $record->result.' '.$record->measurement;
			endif;?>
		</td>
		
		<td class="record_person">
			<?php if($record->nr == -1) :?>
				<?php echo 'kein Rekord';?>
			<?php else: ?>
				<?php echo $record->person; ?>
			<?php endif;?>
		</td>
			
		<?php if($record->nr == -1) :?>
			<?php echo '<td></td>';?>
		<?php else: ?>		
			<?php if($record->date1 <> $record->date3) :?>
				<td class="record_date"><?php echo substr($record->date1,0,3).'/'.$record->date3;?></td>
			<?php else :?>
	    		<td class="record_date"><?php echo $record->date1;?></td>
    		<?php endif;?>
		<?php endif;?>
    	
    	<td class="record_location"><?php echo $record->location;?></td>
    	
    	<?php if($record->maxnr > 0) :?>

    		<td class="record_history" data-record_id="<?php echo $oldrecord->record_id;?>" data-loaded="no" data-max_nr="<?php echo $oldrecord->maxnr;?>">
    			<a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin anzuzeigen" style="cursor:pointer;">
    				<i class="bi bi-arrow-down-square-fill"></i>
    			</a>
    		</td>
		<?php else:?>
			<td></td>
		<?php endif;?>

    	<?php if ($user->authorise('records.create', 'com_records')) : ?><td>
 	
    	<td nowrap>
    		<?php if ($record->nr != -1) :?>
    		<button class="btn btn-light ">
    			<a href="index.php?option=com_records&task=record.edit&record_id=<?php echo $record->record_id;?>&Itemid=<?php echo $Itemid;?>">
    				<i class="bi bi-pencil"></i>
    			</a>
    		</button>
    		<?php else: ?>
    			<button class="btn btn-light" disabled>
	   				<i class="bi bi-pencil"></i>
    			</button>
    		<?php endif; ?>
    		<?php if($noaddnew == false ): $noaddnew=false;?>  
    		<button class="btn btn-info">
    			<a href="index.php?option=com_records&task=record.addnew&competition_id=<?php echo $record->competition_id;?>&agegroup_id=<?php echo $record->agegroup_id;?>&Itemid=<?php echo $Itemid;?>">
    				<i class="bi bi-person-plus"></i>
    			</a>
    		</button>
    		<?php endif;?>
    	</td>
    	
    	<?php endif;?>

<?php endforeach;?>

		<?php /*if($record->maxnr > 0) :?>

				<td class="record_history" data-record_id="<?php echo $record->record_id;?>" data-loaded="no" data-max_nr="<?php echo $record->maxnr;?>"><a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin anzuzeigen" style="cursor:pointer;"><img src="<?php echo Uri::base();?>media/com_records/images/history_open.png" /></a></td>

		<?php else:?>
			<td></td>
		<?php endif; */?>
</tr>
</table>


<?php endif;?>