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
/*
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');
*/

require_once ("administrator/components/com_ask/helpers/ask.php");
?>
<h2><?php echo JText::_("ANSWER");?> <?php echo JText::_("THIS_QUESTION");?>..</h2>
<form action="<?php echo JRoute::_("index.php?option=com_ask"); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

	<fieldset>
	
		<?php if (JFactory::getUser()->id == 0 ):?>
		<label for="name"><?php echo JText::_("FRM_Q_NAME");?></label>
		<input id="name" name="name" type="text" maxlength="20" value="<?php echo JRequest::getString("name")?>" style="display:block;" />
		<br />
		<?php endif;?>
		
		<label for="email"><?php echo JText::_("FRM_Q_EMAIL");?></label>
		<input id="email" name="email" type="text" maxlength="40" value="<?php echo JRequest::getString("email" , JFactory::getUser()->email ); ?>" style="display:block;" />
		<br />
		
		<label for="title"><?php echo JText::_("FRM_Q_TITLE");?></label>
		<input id="title" name="title" type="text" maxlength="30" value="<?php echo JRequest::getString("title")?>" style="display:block;" />
		<br />
		
		<label for="text"><?php echo JText::_("FRM_Q_TEXT");?></label>
		<textarea id="text" name="text" maxlength="350" rows="10" cols="50" style="display:block;"><?php echo JRequest::getString("text")?></textarea>
		
		<div class="formelm-buttons">
			<button type="button" onclick="Joomla.submitbutton('answer.save')">
				<?php echo JText::_('SUBMIT_ANSWER') ?>
			</button>
		</div>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="question_id" value="<?php echo $this->question->id; ?>" />
		<input id="ip" type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" name="ip" />
		<input id="catid" type="hidden" value="<?php echo $this->question->catid; ?>" name="catid" />
		<input name="returnTo" type="hidden" value="<?php echo AskHelper::getCurrentPageURL(); ?>" name="returnTo" />
		<?php echo JHTML::_( 'form.token' ); ?>
		
	</fieldset>
</form>