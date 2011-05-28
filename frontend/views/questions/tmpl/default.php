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
	
	//Display Category Name with the title
	if ($this->categoryView):
		echo JText::_("LBL_HEAD_CATEGORY") . $this->questions[0]->CategoryName;
	endif;
	
	//Display Tag with the title
	if ($this->tag):
		echo JText::_("LBL_HEAD_TAG") . $this->tag;
	endif;
	
	?>
</h1>
<?php endif; ?>


<?php

if ($this->viewFilteringOptions)
	echo $this->filteringOptions;
 
?>
<div class="questions<?php echo $this->pageclass_sfx; ?>">

	<?php foreach($this->questions as $question): ?>
		<div class="question">
			
			<div class="question_body">
				
				<?php if ($this->viewGravatars):?>
				<img class="ask_gravatar_small" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($question->email))); ?>?s=34" />
				<?php endif; ?>
				
				<div class="question_data">			
					<h2 class="question_title">
						<a href="<?php echo $question->link; ?>"><?php echo $question->title; ?></a>
					</h2>
					
					<h4 class="data"><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo ($question->userid_creator ? JFactory::getUser($question->userid_creator)->name : $question->name ); ?> <?php echo JText::_("ON_DATE")?> <?php echo JHtml::date($question->submitted); ?>.</h4>
					
					<h4 class="category">
						<?php if ($question->catid): //if category?>
							<?php echo JText::_("CATEGORY"); ?>:
							<a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&catid=" . $question->catid); ?>">
								<?php echo $question->CategoryName; ?>
							</a>
						<?php endif; //endif category?>
					</h4>
					
					<span class="tags">
					<?php 
					if ($question->tags):
						echo JText::_("TAGS") . ": ";
						foreach ($question->tags as $tag):
						?>
						<a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&tag=" . $tag); ?>"><?php echo $tag ?></a>
					<?php 
						endforeach;
					endif;
					?>
					</span>
					
				</div>
				
			</div>
			
			<?php if ($this->viewStats): ?>		
			<div class="boxes">
				<a href="<?php echo $question->link; ?>">
					<span class="votes"><?php echo $question->votes2; ?><br /><span class="label"><?php echo JText::_("VOTES")?></span></span>
					<span class="answers"><?php echo $question->answerscount; ?><br /><span class="label"><?php echo JText::_("ANSWERS_LOWERCASE")?></span></span>
					<span class="impressions"><?php echo $question->impressions; ?><br /><span class="label"><?php echo JText::_("VIEWS")?></span></span>
				</a>
			</div>
			<?php endif; ?>
			
		</div>
	<?php endforeach; ?>
	<div class="pagination">
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	
</div>