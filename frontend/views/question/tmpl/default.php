<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>


<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<div class="questions<?php echo $this->pageclass_sfx; ?>">

	<h2><?php echo $this->question->title; ?></h2>
	
	<h4>Submitted by <?php echo JFactory::getUser($this->question->userid_creator)->name; ?> at <?php echo $this->question->submitted; ?></h4>
	
	<p><?php echo $this->question->text; ?></p>
	
	<div class="question_options">	
	

	<a href="<?php echo $this->question->link; ?>#answers"><?php echo count($this->question->answers);?></a> Answers.
	
	<?php if ($this->submitanswers):?>
		<a href="<?php echo $this->question->link; ?>#newanswer">Answer</a> this question.
	<?php endif;?>	
	
	</div>
	
	<?php if ($this->viewanswers):?>
		<!-- ANSWERS -->
		<a name="#answers">&nbsp;</a>
		<?php foreach ($this->question->answers as $answer):?>
		<div class="answer" style="padding-bottom:3px; margin-bottom:3px; border-bottom: 1px solid #ccc;">
			<h3><?php echo $answer->title; ?></h3>
			<h5>Submitted by <?php echo $answer->name; ?> at <?php echo $answer->submitted; ?></h5>
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