<?php

//$this->item = $this->get('Item');

// No direct access
defined('_JEXEC') or die('Restricted access');
 
//print_r($this->item);
$db = JFactory::getDBO();
$columns = $db->getTableColumns('#__parkway_properties');
if(!isset($columns['item_id'])){
    // run your query to add column
    $query='ALTER TABLE #__parkway_properties ADD `item_id` int(10)';
    $db->setQuery($query);
    $result = $db->query();
}


?>
<form action="<?php echo JRoute::_('index.php?option=com_parkway&view=property&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_PARKWAY_PROPERTY_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="property.add" />
    <?php echo JHtml::_('form.token'); ?>
</form>