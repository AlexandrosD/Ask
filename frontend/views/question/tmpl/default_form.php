<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/*
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');
*/
?>
<h2>Answer this question..</h2>
<form action="<?php echo JRoute::_("index.php?option=com_ask"); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

	<fieldset>
	
		<?php if (JFactory::getUser()->id == 0 ):?>
		<label for="name">Your Name</label>
		<input id="name" name="name" type="text" maxlength="20" value="<?php echo JRequest::getString("name")?>" style="display:block;" />
		<br />
		<?php endif;?>
		
		<label for="title">Title</label>
		<input id="title" name="title" type="text" maxlength="30" value="<?php echo JRequest::getString("title")?>" style="display:block;" />
		<br />
		
		<label for="text">Text</label>
		<textarea id="text" name="text" maxlength="350" rows="10" cols="50" style="display:block;"><?php echo JRequest::getString("text")?></textarea>
		
		<div class="formelm-buttons">
			<button type="button" onclick="Joomla.submitbutton('answer.save')">
				<?php echo JText::_('Submit Answer') ?>
			</button>
		</div>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="question_id" value="<?php echo $this->question->id; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		
	</fieldset>
</form>