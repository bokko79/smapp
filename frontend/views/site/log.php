<?php
$formatter = \Yii::$app->formatter;
?>
<table>
<?php foreach ($logs as $key => $log) {
	echo '<tr><td style="padding: 3px 5px;"><b>'.$log->user->username. '</b></td><td>'.$log->eventCode()['name'].'</td><td>on '.$formatter->asDate($log->created_at, 'long').' at '.$formatter->asTime($log->created_at, 'short').'</td></tr>';
} ?>	
</table>
