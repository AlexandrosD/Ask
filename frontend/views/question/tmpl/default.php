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

//include helper functions
require_once ("administrator/components/com_ask/helpers/ask.php");

?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<div class="questions<?php echo $this->pageclass_sfx; ?>">
	<div class="votebox">
		<a class="possitive" href="<?php echo JRoute::_("index.php?option=com_ask&task=question.votepossitive&id=" . $this->question->id)?>"><img src="components/com_ask/media/plus.png" /></a><br/>
		<span class="score"><?php echo $this->question->score2; ?></span><br />
		<a class="negative" href="<?php echo JRoute::_("index.php?option=com_ask&task=question.votenegative&id=" . $this->question->id)?>"><img src="components/com_ask/media/minus.png" /></a>
	</div>
	
	<img class="ask_gravatar_big" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->question->email))); ?>?s=64" style="float:right; border:2px solid #333;" />
	
	<h2>
		<?php echo $this->question->title; ?>
		<?php if ($this->question->editable):?>
		<a href="<?php echo JRoute::_("index.php?option=com_ask&task=question.edit&id=" . $this->question->id) ?>">
			<img src="media/system/images/edit.png" />
		</a>
		<?php endif; ?>
	</h2>
	
	<h4><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo ($this->question->userid_creator ? JFactory::getUser($this->question->userid_creator)->name : $this->question->name); ?> <?php echo JText::_("AT")?> <?php echo JHtml::date($this->question->submitted); ?>. 	<?php echo JText::_("CATEGORY"); ?>: <a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&catid=" . $this->question->catid); ?>"><?php echo $this->question->CategoryName; ?></a></h4>
	
	<div class="question_tags">
		<?php 
		if ($this->question->tags):
			foreach ($this->question->tags as $tag):
				?>
				<a href="<?php echo JRoute::_("index.php?option=com_ask&view=questions&tag=" . $tag); ?>"><?php echo $tag ?></a>
			<?php 
			endforeach;
		endif;
		?>
	</div>
	
	<p><?php echo $this->question->text; ?></p>
	
	<div class="fb_buttons"> 
		<a name="fb_share" type="box_count" href="http://www.facebook.com/sharer.php">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
		&nbsp;
		<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(AskHelper::getCurrentPageURL()); ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:30px;" allowTransparency="true"></iframe>
	</div>
	
	<div class="question_options">	

		<a href="<?php echo $this->question->link; ?>#answers"><?php echo count($this->question->answers);?></a>  <?php echo JText::_("ANSWERS")?>. 
	
		<?php if ($this->submitanswers):?>
		<a href="<?php echo $this->question->link; ?>#newanswer"><?php echo JText::_("ANSWER")?></a>  <?php echo JText::_("THIS_QUESTION")?>! 
		<?php endif;?>
	
	</div>
	
	<?php if ($this->viewanswers):?>
		<!-- ANSWERS -->
		<a name="answers">&nbsp;</a>
		<?php foreach ($this->question->answers as $answer):?>
		<div class="answer<?php if ($answer->chosen){ echo " chosen"; }?> system-<?php echo ($answer->published ? 'published' : 'unpublished');?>" style="padding-bottom:3px; margin-bottom:3px; border-bottom: 1px solid #ccc;">
			<div class="votebox">
				<a class="possitive" href="<?php echo JRoute::_("index.php?option=com_ask&task=question.votepossitive&id=" . $answer->id)?>"><img src="components/com_ask/media/plus.png" /></a><br />
				<span class="score"><?php echo $answer->score2; ?></span><br />
				<a class="negative" href="<?php echo JRoute::_("index.php?option=com_ask&task=question.votenegative&id=" . $answer->id)?>"><img src="components/com_ask/media/minus.png" /></a>
			</div>
			<img class="ask_grvatar_small" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($answer->email))); ?>?s=34" style="float:right; border:2px solid #333;" />
			<h3><?php echo $answer->title; ?></h3>
			<h5><?php echo JText::_("SUBMITTED_BY"); ?> <?php echo $answer->name; ?> <?php echo JText::_("AT"); ?>  <?php echo JHtml::date($answer->submitted); ?></h5>
			<p><?php echo $answer->text; ?></p>
			
			<?php if ($this->isOwner && $answer->chosen != 1 ): //Display "Choose" link ?>
			<span class="choose_answer"><a href="<?php echo JRoute::_("index.php?option=com_ask&task=answer.choose&questionid=" . $this->question->id . "&answerid=" . $answer->id)?>"><?php echo JText::_("CHOOSE")?></a></span>
			<?php endif;?>
			
			<?php if ($this->isOwner && $answer->chosen): //Display "Unchoose" link ?>
			<span class="choose_answer"><a href="<?php echo JRoute::_("index.php?option=com_ask&task=answer.chooseReset&questionid=" . $this->question->id . "&answerid=" . $answer->id)?>"><?php echo JText::_("UNCHOOSE")?></a></span>
			<?php endif;?>
			
		</div>
		<?php endforeach;?>
	<?php endif;?>
	
	<?php if ($this->submitanswers):?>
		<!-- ANSWER FORM -->
		<a name="newanswer">&nbsp;</a>
		<?php echo $this->loadTemplate('form'); ?>
	<?php endif;?>	
	
</div>