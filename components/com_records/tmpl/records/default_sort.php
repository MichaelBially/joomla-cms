<?php // $session = JFactory::getSession();
//$sort = $session->get('records_sort', 'agegroup'); ?>

<?php $sort = $this->state->get('records_sort', 'agegroup'); ?>

<div id="sort" class="container-fluid hidden-print">

        <div class="row">
            <div class="col-md-12">
                <h4>Sortierung</h4>
            </div>
        </div>

        <input type="radio" name="records_sort" value="agegroup" <?php if($sort == 'agegroup') echo 'checked'?> onClick="submit();"/> Altersklassen
  
        <input type="radio" name="records_sort" value="competition" <?php if($sort == 'competition') echo 'checked' ?> onClick="submit();" /> Disziplinen<br>
    <p>&nbsp;</p>
</div>
