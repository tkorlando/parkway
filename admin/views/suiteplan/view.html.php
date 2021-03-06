<?php

defined('_JEXEC') or die;


class ParkwayViewSuiteplan extends JViewLegacy
{
    
    protected $form = null;
    
    public function display($tpl = null)
    {
        
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
                JError::raiseError(500, implode('<br />', $errors));

                return false;
        }
        
        
        $this->addToolbar();
        
                
        //JHtml::_('jquery.framework');

        return parent::display($tpl);
    }
    protected function addToolbar()
    {
            
            $input = JFactory::getApplication()->input;
 
		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);
 
		$isNew = ($this->item->id == 0);
 
		if ($isNew)
		{
			$title = JText::_('COM_PARKWAY_MANAGER_SUITEPLAN_NEW');
		}
		else
		{
			$title = JText::_('COM_PARKWAY_MANAGER_SUITEPLAN_EDIT');
		}

            

// Get the toolbar object instance
            //$bar = JToolBar::getInstance('toolbar');

            JToolbarHelper::title(JText::_('Parkway: Suiteplan'), 'suiteplan');
            //JToolbarHelper::addNew('property.save');
            //JToolbarHelper::apply('property.apply');
            JToolbarHelper::save('suiteplan.save');
            JToolBarHelper::cancel('suiteplan.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
            //JToolbarHelper::addNew('new', 'NEW');
           


            
                    JToolbarHelper::preferences('com_parkway');

            

            JToolbarHelper::help('COM_PARKWAY_JHELP_VIEW_FLOORPLAN', true);

            JHtmlSidebar::setAction('index.php?option=com_parkway');





    }
	
}




