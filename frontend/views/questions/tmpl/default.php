<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1>Questions View</h1>

<ul>
<?php foreach($this->questions as $question): ?>
	<li>
		<?php echo $question->id . " - " . $question->title . " : " . $question->text; ?>
		&nbsp;
		<a href="<?php echo JRoute::_( "index.php?option=com_ask&view=question&id=" . $question->id ); ?>">[link]</a>
	</li>
<?php endforeach; ?>
</ul>

<div class="pagination">
	<p class="counter">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</p>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>