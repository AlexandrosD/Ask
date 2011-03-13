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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

?>
<h1>EDIT</h1>

<form action="<?php echo JRoute::_('index.php?option=com_ask&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	
	<?php if (!$this->user->id): ?>
	<div class="formelm">
		<?php echo $this->form->getLabel("name");?>
		<?php echo $this->form->getInput("name");?>
	</div>
	<?php endif; ?>
		
	<div class="formelm">
		<?php echo $this->form->getLabel("title");?>
		<?php echo $this->form->getInput("title");?>
	</div>
	
	<div class="formelm">
		<?php echo $this->form->getLabel("text");?>
		<?php echo $this->form->getInput("text");?>
	</div>
	
	<?php 
	//HIDDEN FIELDS
	echo $this->form->getInput("id");
	echo $this->form->getInput("userid_creator");
	echo $this->form->getInput("userid_modifier");
	echo $this->form->getInput("submitted");
	echo $this->form->getInput("modified");
	echo $this->form->getInput("question");
	echo $this->form->getInput("parent");
	echo $this->form->getInput("votes_possitive");
	echo $this->form->getInput("votes_negative");
	echo $this->form->getInput("impressions");
	echo $this->form->getInput("published");
	echo $this->form->getInput("chosen");	
	?>
	
	<input type="hidden" name="task" value="form.save" />
	<input type="hidden" name="return" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
	
	<div class="formelm-buttons">
		<button type="button" onclick="Joomla.submitbutton('form.save')">
		<?php echo JText::_('JSAVE') ?>
		</button>
		<button type="button" onclick="Joomla.submitbutton('form.cancel')">
		<?php echo JText::_('JCANCEL') ?>
		</button>
	</div>
	
</form>