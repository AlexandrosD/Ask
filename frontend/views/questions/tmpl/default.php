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

	<?php foreach($this->questions as $question): ?>
		<div class="question" style="margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #ccc;">
			<h2 class="question_title"><a href="<?php echo $question->link; ?>"><?php echo $question->title; ?></a></h2>
			<h4>Submitted by <?php echo JFactory::getUser($question->userid_creator)->name; ?> at <?php echo $question->submitted; ?></h4>
			<p><?php echo $question->text; ?></p>
			<div class="question_options">
				
			<?php if ($this->viewanswers):?>
				<a href="<?php echo $question->link; ?>#answers"><?php echo count($question->answers);?></a> Answers.
			<?php endif;?>
				
			<?php if ($this->submitanswers):?>
				<a href="<?php echo $question->link; ?>#newanswer">Answer</a> this question.
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