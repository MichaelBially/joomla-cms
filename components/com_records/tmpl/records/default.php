<?php use \Joomla\Component\Content\Administrator\Service\HTML\Icon; 
use Joomla\CMS\Factory;?>

<?php //JHtml::addIncludePath(JPATH_COMPONENT . '/helpers'); 

$app = Factory::getApplication();
$user    = $app->getIdentity(); //Factory::getUser();
//dump($user);
$groups = $user->groups;
//dump($user->groups);
//dump($user->getAuthorisedGroups());
//dump($user->getAuthorisedCategories('com_records', 'core.edit'));

/*
if ($user->authorise('core.edit', 'com_records'))
{
    echo "<p>You may edit all content.</p>";
}

if ($user->authorise('records.edit', 'com_records'))
{
    echo "<p>You may edit all records content.</p>";
}

if ($user->authorise('core.delete', 'com_records'))
{
    echo "<p>You may delete all content.</p>";
}

if ($user->authorise('records.delete', 'com_records'))
{
    echo "<p>You may delete all records content.</p>";
}

if ($user->authorise('core.create', 'com_records'))
{
    echo "<p>You may create content.</p>";
}

if ($user->authorise('records.create', 'com_records'))
{
    echo "<p>You may create records content.</p>";
}
*/
?>


<!-- 
<button type="button" class="btn btn-light">
<i class="bi bi-printer"></i> 
</button>
-->

<h1>Vereinsrekorde</h1>

<?php if(!$this->print) : ?>

<?php /*?>
<div class="navrecords hidden-print">
	<ul class="nav navbar-nav">
		<li><a id="xadvancedSearchLink" href="#">Suchen einblenden</a></li>
		<li><a id="xsortLink" href="#">Sortierung einblenden</a></li>
		<li><a id="xnavigationLink" href="#">Navigation einblenden</a></li>
	</ul>
</div>
<?php */?>
<div class="navrecords hidden-print">
	<button class="btn btn-primary">
		<a class="link-light text-decoration-none" id="advancedSearchLink" href="#">
			<i class="bi bi-arrow-down-square"></i> Suche einblenden
		</a>
	</button>

	<button class="btn btn-primary">
		<a class="link-light text-decoration-none" id="sortLink" href="#">
			<i class="bi bi-arrow-down-square"></i> Sortierung einblenden
		</a>
	</button>
	
	<button class="btn btn-primary">
		<a class="link-light text-decoration-none" id="navigationLink" href="#">
			<i class="bi bi-arrow-down-square"></i> Navigation einblenden
		</a>
	</button>	

</div>
<div class="clearfix"></div>
<form class="form-horizontal" action="index.php?option=com_records&view=list&Itemid=<?php //echo JRequest::getString('Itemid')?>" method="post" name="RecordsFilterForm" id="RecordsFilterForm">
<?php echo $this->loadTemplate('filter'); ?>

<?php echo $this->loadTemplate('sort');?>

	<input type="hidden" name="option" value="com_records" />
	<input type="hidden" name="view" value="records" />
</form>

<?php  endif; ?>

<?php 


$sort = $this->state->get('records_sort', 'agegroup');
if($sort == 'agegroup')
	echo $this->loadTemplate('agegroup'); 
else
	echo $this->loadTemplate('competition'); ?>