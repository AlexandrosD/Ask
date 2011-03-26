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

	<?php foreach($this->questions as $question): ?>
		<div class="question" style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #ccc;">
			<img class="ask_grvatar_small" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($question->email))); ?>?s=34" style="float:right; border:2px solid #333;" />			
			<h2 class="question_title"><a href="<?php echo $question->link; ?>"><?php echo $question->title; ?></a></h2>
			<h4><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo JFactory::getUser($question->userid_creator)->name; ?> <?php echo JText::_("AT")?> <?php echo $question->submitted; ?></h4>
			<p><?php echo $question->text; ?></p>
			<div class="question_options">
				
			<?php if ($this->viewanswers):?>
				<a href="<?php echo $question->link; ?>#answers"><?php echo count($question->answers);?></a> <?php echo JText::_("ANSWERS"); ?>
			<?php endif;?>
				
			<?php if ($this->submitanswers):?>
				<a href="<?php echo $question->link; ?>#newanswer"><?php echo JText::_("ANSWER")?></a> <?php echo JText::_("THIS_QUESTION")?>
			<?php endif;?>
			
			</div>
		</div>
	<?php endforeach; ?>
	
	<div class="pagination">
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	
</div>