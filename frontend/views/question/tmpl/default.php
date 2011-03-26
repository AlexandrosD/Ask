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
?>


<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<div class="questions<?php echo $this->pageclass_sfx; ?>">
	
	<img class="ask_grvatar_big" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->question->email))); ?>?s=64" style="float:right; border:2px solid #333;" />
	
	<h2><?php echo $this->question->title; ?></h2>
	
	<h4><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo JFactory::getUser($this->question->userid_creator)->name; ?> <?php echo JText::_("AT")?> <?php echo $this->question->submitted; ?></h4>
	
	<p><?php echo $this->question->text; ?></p>
	
	<div class="question_options">	
	

	<a href="<?php echo $this->question->link; ?>#answers"><?php echo count($this->question->answers);?></a>  <?php echo JText::_("ANSWERS")?> 
	
	<?php if ($this->submitanswers):?>
		<a href="<?php echo $this->question->link; ?>#newanswer"><?php echo JText::_("ANSWER")?></a>  <?php echo JText::_("THIS_QUESTION")?> 
	<?php endif;?>	
	
	</div>
	
	<?php if ($this->viewanswers):?>
		<!-- ANSWERS -->
		<a name="#answers">&nbsp;</a>
		<?php foreach ($this->question->answers as $answer):?>
		<div class="answer" style="padding-bottom:3px; margin-bottom:3px; border-bottom: 1px solid #ccc;">
			<img class="ask_grvatar_small" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($answer->email))); ?>?s=34" style="float:right; border:2px solid #333;" />
			<h3><?php echo $answer->title; ?></h3>
			<h5><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo $answer->name; ?> <?php echo JText::_("AT"); ?>  <?php echo $answer->submitted; ?></h5>
			<p><?php echo $answer->text; ?></p>
		</div>
		<?php endforeach;?>
	<?php endif;?>
	
	<?php if ($this->submitanswers):?>
		<!-- ANSWER FORM -->
		<a name="#newanswer">&nbsp;</a>
		<?php echo $this->loadTemplate('form'); ?>
	<?php endif;?>	
	
</div>