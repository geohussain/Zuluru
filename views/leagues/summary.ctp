<?php
$this->Html->addCrumb (__('Leagues', true));
$this->Html->addCrumb (__('Summary', true));
?>

<div class="leagues summary">
<h2><?php __('League Summary');?></h2>
<table class="list">
<tr>
	<th><?php __('Season');?></th>
	<th><?php __('Name');?></th>
	<th><?php __('Spirit Display');?></th>
	<th><?php __('Spirit Questionnaire');?></th>
	<th><?php __('Numeric Spirit?');?></th>
	<th><?php __('Max Score');?></th>
</tr>
<?php
$i = 0;
$league = $season = null;
foreach ($divisions as $division):
	if ($division['League']['id'] == $league) {
		continue;
	}
	$league = $division['League']['id'];
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php
		if ($division['League']['season'] != $season) {
			__($division['League']['season']);
			$season = $division['League']['season'];
		}
		?></td>
		<td><?php
		echo $this->Html->link($division['League']['name'], array('action' => 'edit', 'league' => $division['League']['id']));
		?></td>
		<td><?php __(Inflector::humanize($division['League']['display_sotg'])); ?></td>
		<td><?php echo $division['League']['sotg_questions']; ?></td>
		<td><?php __($division['League']['numeric_sotg'] ? 'Yes' : 'No'); ?></td>
		<td><?php echo $division['League']['expected_max_score']; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<h2><?php __('Division Summary');?></h2>
<table class="list">
<tr>
	<th><?php __('Season');?></th>
	<th><?php __('League');?></th>
	<th><?php __('Division');?></th>
	<th><?php __('Schedule Type');?></th>
	<th><?php __('Games Before Repeat');?></th>
	<th><?php __('First Game');?></th>
	<th><?php __('Last Game');?></th>
	<th><?php __('Roster Deadline');?></th>
	<th><?php __('Allstars');?></th>
	<th><?php __('Remind After');?></th>
	<th><?php __('Finalize After');?></th>
	<th><?php __('Roster Rule');?></th>
</tr>
<?php
$i = 0;
$league = $season = null;
foreach ($divisions as $division):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php
		if ($division['League']['season'] != $season) {
			__($division['League']['season']);
			$season = $division['League']['season'];
		}
		?></td>
		<td><?php
		if ($division['League']['id'] != $league) {
			echo $this->Html->link($division['League']['name'], array('action' => 'edit', 'league' => $division['League']['id']));
			$league = $division['League']['id'];
		}
		?>
		</td>
		<td><?php echo $this->Html->link($division['Division']['name'], array('controller' => 'divisions', 'action' => 'edit', 'division' => $division['Division']['id'])); ?></td>
		<td><?php __(Inflector::humanize($division['Division']['schedule_type'])); ?></td>
		<td><?php echo $division['Division']['games_before_repeat']; ?></td>
		<td><?php echo $this->ZuluruTime->date($division['Division']['open']); ?></td>
		<td><?php echo $this->ZuluruTime->date($division['Division']['close']); ?></td>
		<td><?php echo $this->ZuluruTime->date($division['Division']['roster_deadline']); ?></td>
		<td><?php __(Inflector::humanize($division['Division']['allstars'])); ?></td>
		<td><?php echo $division['Division']['email_after']; ?></td>
		<td><?php echo $division['Division']['finalize_after']; ?></td>
		<td><?php echo $division['Division']['roster_rule']; ?></td>
	</tr>
<?php endforeach; ?>
</table>

</div>
