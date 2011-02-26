<?php
defined('_JEXEC') or die;

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
	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	
	<div class="formelm-buttons">
		<button type="button" onclick="Joomla.submitbutton('question.save')">
		<?php echo JText::_('JSAVE') ?>
		</button>
		<button type="button" onclick="Joomla.submitbutton('question.cancel')">
		<?php echo JText::_('JCANCEL') ?>
		</button>
	</div>
	
</form>