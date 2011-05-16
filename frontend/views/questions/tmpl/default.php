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
	<?php 
	if ($this->categoryView): //Display Category Name with the title
		echo " - " . $this->questions[0]->CategoryName;
	endif;
	?>
</h1>
<?php endif; ?>

<div class="questions<?php echo $this->pageclass_sfx; ?>">

	<?php foreach($this->questions as $question): ?>
		<div class="question">
		
			<div class="boxes">
				<a href="<?php echo $question->link; ?>">
					<span class="votes"><?php echo $question->votes2; ?><br /><span class="label"><?php echo JText::_("VOTES")?></span></span>
					<span class="answers"><?php echo $question->answerscount; ?><br /><span class="label"><?php echo JText::_("ANSWERS_LOWERCASE")?></span></span>
					<span class="impressions"><?php echo $question->impressions; ?><br /><span class="label"><?php echo JText::_("VIEWS")?></span></span>
				</a>
			</div>
			
			<div class="question_body">
				<img class="ask_grvatar_small" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($question->email))); ?>?s=34" style="float:right; border:2px solid #333;" />
				
				<div class="question_data">			
					<h2 class="question_title"><a href="<?php echo $question->link; ?>"><?php echo $question->title; ?></a></h2>
					<h4><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo ($question->userid_creator ? JFactory::getUser($question->userid_creator)->name : $question->name ); ?> <?php echo JText::_("AT")?> <?php echo $question->submitted; ?>. <?php echo JText::_("CATEGORY"); ?>: <a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&catid=" . $question->catid); ?>"><?php echo $question->CategoryName; ?></a></h4>
				</div>
				
				<div class="question_tags">
					<?php 
					if ($question->tags):
						foreach ($question->tags as $tag):
						?>
						<a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&tag=" . $tag); ?>"><?php echo $tag ?></a>
					<?php 
						endforeach;
					endif;
					?>
				</div>
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