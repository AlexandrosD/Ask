<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1>Single Question</h1>
<h2><?php echo $this->question->title; ?></h2>
<?php 
if( ! $this->viewanswers){
?>
	<p>Not authorized to view answers...</p>
<?php 
}
else{
	echo '<p>Authorized to view Answers!!</p>';
}

foreach ( $this->question->answers as $answer ) {
?>
	<p>
		<?php echo $answer->text; ?>
	</p>
<?php 
}
?>