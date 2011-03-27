<?php
/*------------------------------------------------------------------------
# com_ask - Ask (Questions)
# ------------------------------------------------------------------------
# @author    Alexandros D
# @copyright Copyright (C) 2011 Alexandros D. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @Website: http://alexd.mplofa.com
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

?>
<form action="<?php echo JRoute::_('index.php?option=com_ask&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="ask-form">
        <fieldset class="adminform">
                <legend>EDIT</legend>
                <ul class="adminformlist">
<?php foreach($this->form->getFieldset() as $field): ?>
                        <li><?php echo $field->label;echo $field->input;?></li>
<?php endforeach; ?>
						<li><input id="jform_ip" type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" name="jform[ip]" /></li>
                </ul>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="question.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
