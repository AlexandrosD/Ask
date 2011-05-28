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
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_ask'); ?>" method="post" name="adminForm">
    <table class="adminlist">
    
		<thead>
			<tr>
		        <th width="10">ID</th>
        		<th width="10">&nbsp;</th>                     
        		<th><?php echo JText::_("TBL_TITLE")?></th>
        		<th><?php echo JText::_("TBL_PUBLISHED")?></th>
        		<?php if ($this->viewAnswers):?>
        		<th><?php echo JText::_("TBL_PARENT")?></th>
        		
        		<?php else: ?>
        		<th><?php echo JText::_("TBL_ANSWER")?></th>
        		
        		<th><?php echo JText::_("TBL_TAGS")?></th>
        		
        		<th><?php echo JText::_("TBL_CATEGORY")?></th>
        		<th><?php echo JText::_("TBL_ANSWERS")?></th>
        		<?php endif; ?>
        		
        		
        		<th><?php echo JText::_("TBL_VOTES")?></th>
        		<th><?php echo JText::_("TBL_SCORE")?></th>
        		
        		<th><?php echo JText::_("TBL_SUBMITTED")?></th>
        		<th><?php echo JText::_("TBL_MODIFIED")?></th>
        		<th><?php echo JText::_("TBL_SUBMITTED_BY")?></th>
        		<th><?php echo JText::_("TBL_MODIFIED_BY")?></th>
        		<?php if (!$this->viewAnswers):?>
        		<th><?php echo JText::_("TBL_IMPRESSIONS")?></th>
        		<?php endif; ?>
        		<th>IP</th>
			</tr>
		</thead>
            
        <tfoot>
    	  	<tr>
        		<td colspan="17"><?php echo $this->pagination->getListFooter(); ?></td>
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
	                <?php if ($this->viewAnswers):?>
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
	                <?php else: ?>
	                <td>
	                	<?php if ($item->question):?>
	                		<a href="<?php echo JRoute::_('index.php?option=com_ask&task=question.edit&question=0&parent=' . $item->id . '&catid=' . $item->catid ); ?>">Answer</a>
	                	<?php else: ?>
	                		N/A
	                	<?php endif; ?>
	                </td>
	                <td class="center">
	                	<?php 
	                	if ($item->tags)
	                		foreach ($item->tags as $tag)
	                			echo $tag . " "
	                	?>
	                </td>
	                <td class="center">
	                	<?php echo ($item->CategoryName); ?>
	                </td>
	                <td>
	                	<?php echo $item->answerscount; ?>
	                </td>
	                <?php endif; ?>
	                
	                
	                <td>
	                	<?php echo $item->votes; ?>
	                </td>
	                <td>
	                	<?php echo $item->score; ?>
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
	                <?php if (!$this->viewAnswers):?>
	                <td class="center">
	                	<?php echo $item->impressions; ?>
	                </td>
	                <?php endif; ?>
	                <td class="center">
	                	<?php echo $item->ip; ?>
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
