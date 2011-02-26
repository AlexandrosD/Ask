<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ask'); ?>" method="post" name="adminForm">
    <table class="adminlist">
    
		<thead>
			<tr>
		        <th width="10">ID</th>
        		<th width="10">&nbsp;</th>                     
        		<th>Title</th>
        		<th>Published</th>
        		<th>Type</th>
        		<th>Parent</th>
        		<th>Answer</th>
        		<th>Category</th>
        		<th>Tags</th>
        		<th>Submitted</th>
        		<th>Modified</th>
        		<th>Submitted By</th>
        		<th>Modified By</th>
        		<th>Impressions</th>
			</tr>
		</thead>
            
        <tfoot>
    	  	<tr>
        		<td colspan="15"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
           	
        <tbody>
	       	<?php foreach($this->items as $i => $item): ?>
	        <tr class="row<?php echo $i % 2; ?>">
	                <td>
	                        <?php echo $item->id; ?>
	                </td>
	                <td>
	                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
	                </td>
	                <td>
	                	<a href="<?php echo JRoute::_('index.php?option=com_ask&task=question.edit&id=' . $item->id . '&answers=' . JRequest::getInt("answers", 0)); ?>"><?php echo $item->title; ?></a>
	                </td>
	                <td class="center">
	                	<?php echo JHtml::_('jgrid.published', $item->published, $i , "questions."); ?>
	                </td>
	                <td class="center">
	                	<?php if ($item->question){echo "Question"; } else { echo "Answer"; } ?>
	                </td>
	                <td>
	                	<?php 
	                		if ($item->parentData){
	                			echo "<a href='" . JRoute::_('index.php?option=com_ask&task=question.edit&id=' . $item->parentData->id) ."'>";
	                			echo $item->parentData->title;
	                			echo "</a>";
	                		}
	                		else {
	                			echo "N/A";
	                		}
	                	?>
	                </td>
	                <td>
	                	<?php if ($item->question):?>
	                		<a href="<?php echo JRoute::_('index.php?option=com_ask&task=question.edit&question=0&parent=' . $item->id)?>">Answer</a>
	                	<?php else:?>
	                		N/A
	                	<?php endif;?>
	                </td>
	                <td class="center">
	                	(Phase II)
	                </td>
	                <td class="center">
	                	(Phase II)
	                </td>
	                <td class="center">
	                	<?php echo $item->submitted; ?>
	                </td>
	                <td class="center">
	                	<?php echo $item->modified; ?>
	                </td>
	                <td class="center">
	                	<?php echo JFactory::getUser($item->userid_creator)->name ? JFactory::getUser($item->userid_creator)->name : $item->name; ?>
	                </td>
	                <td class="center">
	                	<?php 
	                	if( $item->userid_modifier){
	                		echo JFactory::getUser($item->userid_modifier)->name;
	                	}
	                	?>
	                </td>
	                <td class="center">
	                	<?php echo $item->impressions; ?>
	                </td>
	        </tr>
			<?php endforeach; ?>
        
        </tbody>
        
	</table>
    
    <div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="answers" value="<?php echo JRequest::getInt('answers',0); ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
    </div>
    
</form>
