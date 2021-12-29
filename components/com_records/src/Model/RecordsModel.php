<?php
/**
 * @package     Mywalks.Site
 * @subpackage  com_mywalks
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace TSV\Component\Records\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;

/**
 * This models supports retrieving lists of articles.
 *
 * @since  1.6
 */
class RecordsModel extends ListModel
{
    var $_records = NULL;
    var $_classes = NULL;
    var $_classes_male = NULL;
    var $_classes_female = NULL;
    var $_diszis = NULL;
    var $_agegroups = NULL;
    var $_competitions = NULL;
    
    
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see     \JController
     * @since   1.6
     */
    public function __construct($config = array())     // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ToDo
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'title', 'a.title',
            );
        }
        
        parent::__construct($config);
    }
    
    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   3.0.1
     */
    protected function populateState($ordering = 'ordering', $direction = 'ASC')          // <<<<<<< ToDo
    {
        $app = Factory::getApplication();
        
        // List state information
  /*      $value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
        $this->setState('list.limit', $value);
        
        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);
        
        $orderCol = $app->input->get('filter_order', 'a.id');
        
        if (!in_array($orderCol, $this->filter_fields))
        {
            $orderCol = 'a.id';
        }
        
        $this->setState('list.ordering', $orderCol);
        
        $listOrder = $app->input->get('filter_order_Dir', 'ASC');
        
        if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
        {
            $listOrder = 'ASC';
        }
        
        $this->setState('list.direction', $listOrder);
    */    
        $params = $app->getParams();
        $this->setState('params', $params);
        

        
        $app = Factory::getApplication();
//dump($app->input);
        
/*        $filter_name = $this->getUserStateFromRequest('com_records.records.filter_name', 'filter_name', NULL, 'string', false);
        $this->setState('filter_name', $filter_name);
        
        $filter_year = $this->getUserStateFromRequest('com_records.records.filter_year', 'filter_year', 0, 'string', false);
        $this->setState('filter_year', $filter_year);

        if($app->input->get('filter_halle') == null)
            $this->setState('filter_halle', 0);
        else
        {
            $filter_halle = $this->getUserStateFromRequest('com_records.records.filter_halle', 'filter_halle', 1, 'string', false);
            $this->setState('filter_halle', $filter_halle);
        }
        
        if($app->input->get('filter_freiluft') == null)
            $this->setState('filter_freiluft', 0);
        else
        {
            $filter_freiluft = $this->getUserStateFromRequest('com_records.records.filter_freiluft', 'filter_freiluft', 1, 'string', false);
            $this->setState('filter_freiluft', $filter_freiluft);
        }
        
        if($app->input->get('filter_mit') == null)
            $this->setState('filter_mit', 0);
        else 
        {
            $filter_mit = $this->getUserStateFromRequest('com_records.records.filter_mit', 'filter_mit', 1, 'string', false);
            $this->setState('filter_mit', $filter_mit);
        }
        
        if($app->input->get('filter_ohne') == null)
            $this->setState('filter_ohne', 0);
        else 
        {
            $filter_ohne = $this->getUserStateFromRequest('com_records.records.filter_ohne', 'filter_ohne', 1, 'string', false);
            $this->setState('filter_ohne', $filter_ohne);
        }
        
        if($app->input->get('filter_agegroup') == null)
            $this->setState('filter_agegroup', null);
        else 
        {
            $filter_agegroup = $this->getUserStateFromRequest('com_records.records.filter_agegroup', 'filter_agegroup', NULL, 'string', false);
            $this->setState('filter_agegroup', $filter_agegroup);
        }
        
        if($app->input->get('filter_competition') == null)
            $this->setState('filter_competition', null);
        else
        {
            $filter_competition = $this->getUserStateFromRequest('com_records.records.filter_competition', 'filter_competition', NULL, 'string', false);
            $this->setState('filter_competition', $filter_competition);
        }
        
//        if($app->input->get('filter_alte_recorde') == null)
 //          $this->setState('filter_alte_recorde', 0);
//        else
        {
            $filter_alte_recorde = $this->getUserStateFromRequest('com_records.records.filter_alte_recorde', 'filter_alte_recorde', NULL, 'string', false);
            $this->setState('filter_alte_recorde', $filter_alte_recorde);
        }
    
*/
$session = $app->getSession();

        $filter_name = $session->get('filter_name', null);
        $filter_year = $session->get('filter_year', 0);
        //$filter_type = $session->get('filter_type', 0);
        $filter_halle = $session->get('filter_halle', 1);
        $filter_freiluft = $session->get('filter_freiluft', 1);
        $filter_mit = $session->get('filter_mit', 1);
        $filter_ohne = $session->get('filter_ohne', 1);
        $filter_agegroup = $session->get('filter_agegroup', NULL);
        $filter_competition = $session->get('filter_competition', NULL);
        $filter_alte_recorde = $session->get('filter_alte_recorde', NULL);
        $sort = $session->get('records_sort','agegroup');
        
        if($app->input->getString('suchen'))
        {
            $filter_name = $app->input->getString('filter_name', NULL);
            $filter_year = $app->input->getString('filter_year', 0);
            //$filter_type = JRequest::getString('filter_type', 0);
            
            $filter_halle = $app->input->getString('filter_halle', 0);
            $filter_freiluft = $app->input->getString('filter_freiluft', 0);
            $filter_mit = $app->input->getString('filter_mit', 0);
            $filter_ohne = $app->input->getString('filter_ohne', 0);
            $filter_alte_recorde = $app->input->getString('filter_alte_recorde', 0);
            
            $filter_agegroup = $app->input->getVar("filter_agegroup");
            $filter_competition = $app->input->getVar("filter_competition");
        }
        
        $sort = $app->input->getString('records_sort',  $sort);
        
        $this->setState('filter_name', $filter_name);
        $session->set('filter_name', $filter_name);
        
        $this->setState('filter_year', $filter_year);
        $session->set('filter_year', $filter_year);
        
        $this->setState('filter_agegroup', $filter_agegroup);
        $session->set('filter_agegroup', $filter_agegroup);
        
        $this->setState('filter_competition', $filter_competition);
        $session->set('filter_competition', $filter_competition);
        
        $this->setState('records_sort', $sort);
        $session->set('records_sort', $sort);
        
        //$this->setState('filter_type', $filter_type);
        //$session->set('filter_type', $filter_type);
        
        $this->setState('filter_halle', $filter_halle);
        $session->set('filter_halle', $filter_halle);
        
        $this->setState('filter_freiluft', $filter_freiluft);
        $session->set('filter_freiluft', $filter_freiluft);
        
        $this->setState('filter_mit', $filter_mit);
        $session->set('filter_mit', $filter_mit);
        
        $this->setState('filter_ohne', $filter_ohne);
        $session->set('filter_ohne', $filter_ohne);
        
        $this->setState('filter_alte_recorde', $filter_alte_recorde);
        $session->set('filter_alte_recorde', $filter_alte_recorde);
       

    }
    
    function getRecordsQuery()
    {
        $db = $this->getDBO();
        $query = 'select record.id as record_id, DATE_FORMAT( record.date,"%d.%m.%Y") as date1, DATE_FORMAT( record.date2,"%d.%m.%Y") as date3, record.*, competition.*, agegroup.* from ';
        $query .= ' #__records_record as record, ';
        $query .= ' #__records_competition as competition, #__records_agegroup as agegroup ';
        $query .= ' where competition_id = competition.id ';
        $query .= ' and record.agegroup_id = agegroup.id ';
        $query .= ' and record.nr in (-1, 0) ';
        
        //$filter_type = $this->getState('filter_type', 0);
        $filter_halle = $this->getState('filter_halle', 1);
        $filter_freiluft = $this->getState('filter_freiluft', 1);
        $filter_mit = $this->getState('filter_mit', 1);
        $filter_ohne = $this->getState('filter_ohne', 1);
        $filter_alte_recorde = $this->getState('filter_alte_recorde', 0);
        
        /*		if($filter_type == 1)
         {
         $query .= ' and record.nr <> -1 ';
         }
         elseif($filter_type == 2)
         {
         $query .= ' and record.nr = -1 ';
         }
         */
        if($filter_halle == 1 && $filter_freiluft == 1)
            ;
        elseif($filter_halle == 1)
        $query .= ' and competition.stadion = "H" ';
        elseif($filter_freiluft == 1)
        $query .= ' and competition.stadion = "F" ';
        else
            $query .= ' and competition.stadion = "X" ';
            
            if($filter_mit == 1 && $filter_ohne == 1)
                ;
            elseif($filter_mit == 0 && $filter_ohne == 0)
            {
                // das macht keinen Sinn, weil dann nix angezeigt wird...
                $query .= ' and record.nr = -9999 ';
            }
            else
            {
                if($filter_mit == 1)
                    $query .= ' and record.nr <> -1 ';
                    
                    if($filter_ohne == 1)
                        $query .= ' and record.nr = -1 ';
            }
            
            $filter_name = $this->getState('filter_name',NULL);
            
            if($filter_name <> NULL)
            {
                //$filter = explode(' ', $filter_name);
                $query .= 'and (record.id in ';
                $query .= '(select record_id ';
                $query .= 'from #__records_person as person, #__records_rekord_person as rp ';
                $query .= 'where rp.person_id = person.id ';
                $query .= 'and (1<>1 ';
                
                //foreach($filter as $f) :
                //$query .= 'or person.surname like "%'.$f.'%" or person.firstname like "%'.$f.'%" ';
                //endforeach;
                $query .= 'or person.surname like "%'.$filter_name.'%" or person.firstname like "%'.$filter_name.'%" ';
                $query .= ' or concat(person.surname, ", ", person.firstname) like "'.$filter_name.'" ';
                $query .= ' or concat(person.firstname, " ", person.surname) like "'.$filter_name.'" ';
                
                $query .= ')';
                $query .= ')';
                
                if($filter_alte_recorde == 1)
                {
                    $query .= ' or (exists (select record_id ';
                    $query .= ' from #__records_person as p, #__records_rekord_person as rp , #__records_record as r ';
                    $query .= '		where rp.person_id = p.id ';
                    $query .= '		and r.competition_id = record.competition_id ';
                    $query .= '		and r.agegroup_id = record.agegroup_id ';
                    $query .= '		and rp.record_id = r.id ';
                    $query .= '		and r.nr > 0 ';
                    $query .= 'and ( ';
                    $query .= ' p.surname like "%' . $filter_name . '%" or p.firstname like "%' . $filter_name . '%" ';
                    $query .= ' or concat(p.surname, ", ", p.firstname) like "' . $filter_name . '" ';
                    $query .= ' or concat(p.firstname, " ", p.surname) like "' . $filter_name . '" ';
                    $query .= ')))';
                }
                $query .= ')';
                
            }
            
            $filter_year = $this->getState('filter_year', 0);
            if($filter_year <> 0)
            {
                $query .= 'and DATE_FORMAT(record.date,"%Y") = '. $filter_year .' ';
            }
            
            $filter_agegroup = $this->getState('filter_agegroup', NULL);
            if($filter_agegroup <> NULL)
            {
                $agegroup = implode(',', $filter_agegroup);
                $query .= ' and agegroup.id in ('.$agegroup.') ';
            }
            
            $filter_competition = $this->getState('filter_competition', NULL);
            if($filter_competition <> NULL)
            {
                $competition = implode('","', $filter_competition);
                $query .= ' and competition_shorttext in ("'.$competition.'") ';
            }
            
            $sort = $this->getState('records_sort', 'agegroup');
            
            if($sort == 'agegroup')
                $query .= ' order by agegroup.agegroup_sortkz, typ_id, competition.competition_sortkz,  record.id';
                else
                    $query .= ' order by typ_id, competition.competition_sortkz, agegroup.agegroup_sortkz, record.id';
                    
                    //echo '<p>'.$query.'</p>';
//echo $query;                    
                    return $query;
    }
    
    function getRecordPerson($record_id)
    {
        $db = $this->getDBO();
        
        $query = 'select person.* from ';
        $query .= ' #__records_rekord_person as rp, ';
        $query .= ' #__records_person as person ';
        $query .= 'where rp.person_id = person.id ';
        $query .= 'and record_id = '.$record_id;
        
        $db->setQuery($query);
        $person = $db->loadObjectList();
        
        $name='';
        foreach ($person as $p)
        {
            if($name <> '')
                $name .= '<br />';
                $name .= $p->firstname.' '.$p->surname;
        }
        
        return $name;
    }
    
    function getList()
    {
        if(!$this->_records)
        {
            $db = $this->getDBO();
            $query = $this->getRecordsQuery();
            $db->setQuery($query);
            $records = $db->loadObjectList();
            
            $classes = array();
            $diszis = array();
            $classes_male = array();
            $classes_female = array();
            
            foreach($records as $record) :
                if (in_array($record->agegroup_shorttext, $classes))
                    ;
                else
                {
                    if($record->gender == 'M')
                        $classes_male[] = $record->agegroup_shorttext;
                        else
                            $classes_female[] = $record->agegroup_shorttext;
                }
                $classes[] = $record->agegroup_shorttext;
            
                $disziplinen = (object) array();
                $disziplinen->shorttext = $record->competition_shorttext;
                $disziplinen->text = $record->competition_text;
                $disziplinen->typ = $record->typ_id;
                if (in_array($disziplinen, $diszis))
                    ;
                else
                    $diszis[] = $disziplinen;
                
                unset($disziplinen);
                
                $record->person = $this->getRecordPerson($record->record_id);
             endforeach;
                
             $this->_records = $records;
             $this->_classes = $classes;
             $this->_classes_male = $classes_male;
             $this->_classes_female = $classes_female;
             $this->_diszis  = $diszis;
        }
        
        return $this->_records;
    }
    
    function getClassesMale()
    {
        return $this->_classes_male;
    }
    
    function getClassesFemale()
    {
        return $this->_classes_female;
    }
    
    function getClasses()
    {
        return $this->_classes;
    }
    
    function getAllAgegroups()
    {
        if(!$this->_agegroups)
        {
            $db = $this->getDbo();
            $query = 'select * from #__records_agegroup order by gender, agegroup_sortkz';
            $db->setQuery($query);
            $this->_agegroups = $db->loadObjectList();
        }
        return $this->_agegroups;
    }
    
    function getAllCompetitions()
    {
        if(!$this->_competitions)
        {
            $db = $this->getDbo();
            $query = 'select competition_name, competition_shorttext from #__records_competition group by competition_name, competition_shorttext order by typ_id,  competition_sortkz';
            $db->setQuery($query);
            $this->_competitions = $db->loadObjectList();
        }
        return $this->_competitions;
    }
    
    function getDiszis()
    {
        return $this->_diszis;
    }
    
    function getRecordYears()
    {
        $db = $this->getDBO();
        $query = 'select DATE_FORMAT( record.date,"%Y") as year from #__records_record as record where nr <> -1 group by DATE_FORMAT( record.date,"%Y") order by DATE_FORMAT( record.date,"%Y") DESC ';
        $db->setQuery($query);
        $years = $db->loadObjectList();
        return $years;
    }
    
    function getCompetitionTyp()
    {
        $db = $this->getDbo();
        $query = 'select * from #__records_competitiontype';
        $db->setQuery($query);
        $typ = $db->loadObjectList('id');
        return $typ;
    }
    
    
    
    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  A prefix for the store id.
     *
     * @return  string  A store id.
     *
     * @since   1.6
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        
        return parent::getStoreId($id);
    }
    
    /**
     * Get the master query for retrieving a list of walks subject to the model state.
     *
     * @return  \JDatabaseQuery
     *
     * @since   1.6
     */
    protected function getListQuery()
    {
 //       echo $this->getState('statetest', 'xxxd');
 
        
        echo $this->getState('list.direction');
        
        // Get the current user for authorisation checks
        $user = Factory::getUser();
        
        // Create a new query object.
        $db    = $this->getDbo();
        $query = $db->getQuery(true);
        
        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'records.*
                ')
            );
        $query->from('#__records_record AS records');
        
        $params      = $this->getState('params');
        
        // Add the list ordering clause.
        //$query->order($this->getState('list.ordering', 'records.id') . ' ' . $this->getState('list.direction', 'ASC'));

        return $query;
    }
    
    /**
     * Method to get a list of walks.
     *
     * Overridden to inject convert the attribs field into a \JParameter object.
     *
     * @return  mixed  An array of objects on success, false on failure.
     *
     * @since   1.6
     */
    public function getItems()
    {
        $items  = parent::getItems();
       
        return $items;
    }
    
    /**
     * Method to get the starting number of items for the data set.
     *
     * @return  integer  The starting number of items available in the data set.
     *
     * @since   3.0.1
     */
    public function getStart()
    {
        return $this->getState('list.start');
    }
}?>