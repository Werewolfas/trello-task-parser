<html lang="en" class="no-js">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
        <link rel="stylesheet" media="screen" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" media="screen" href="css/screen.css" />
        <link rel="stylesheet" media="print" href="css/print.css" />
        <link href="css/shared?v=UNBr3WWn5VDuBpRrqLgkyIJXeUzc529GlPqXw6YT_hg1" rel="stylesheet"/>
        <script src="js/modernizr?v=qVODBytEBVVePTNtSFXgRX0NCEjh9U_Oj8ePaSiRcGg1"></script>

	<style type="text/css">
		.box {
			height: 100px;
			width: 100px;
			float:left;
		}
	</style>
	</head>
	<body>
	<div class="container">
	<div class="pageControls">
		<form action="index.php" method="post">
			<fieldset>
				<label>Product:</label>
				<textarea name="json" class="row-fluid" rows="6" ></textarea>
				<button type="submit" id="parseButton" class="btn btn-primary">Parse</button>
			</fieldset>	
		</form>

	</div>
	<div id="sprintBacklog">
<?php
// now, process the JSON string 

//$body = file_get_contents('https://trello.com/board/529f33ba8f53744e4e0052df/test.json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {

$body = $_POST["json"];

$result = json_decode($body); 

$pattern_hours = '/\{[0-9]*\}/';
$pattern_sp = '/\([0-9]*\)/';
echo '<div id="sprintBacklog">';
$roman = array(
	1 => 'I',
	2 => 'II',
	3 => 'III',
	4 => 'IV',
	5 => 'V',
	6 => 'VI',
	7 => 'VII',
	8 => 'VIII',
	9 => 'IX',
	10 => 'X',
	11 => 'XI',
	12 => 'XII',
	13 => 'XIII',
	14 => 'XIV',
	15 => 'XV',
	16 => 'XVI',
	17 => 'XVII',
	18 => 'XVIII',
	19 => 'XIX',
	20 => 'XX'
);
$i = 1;
foreach($result->lists as &$list){
	if($list->closed != "true") {
		echo '<div class="backlog-item backlog-item-'.$roman[$i].'">';
		echo '<div class="backlog-item-backlogno">'.$roman[$i].'</div>';
		//echo $list -> name;
		echo '<div class="backlog-item-text">';
			echo '<div class="backlog-item-title">'.preg_replace(array($pattern_hours, $pattern_sp), "", $list -> name).'</div>';
			echo '<div class="backlog-item-description">'.$list->desc.'</div>';
			echo '</div>';
		preg_match($pattern_sp , $list->name, $sp);
		echo '<div class="backlog-item-effort">'.preg_replace('/[^0-9\s]/','',$sp[0]).'</div>';
		echo '</div>';
		foreach($result->cards as &$card) {
				if($card -> idList == $list -> id && $card->closed != "true"){
					if (preg_match('[CR 1]', $card->desc) || preg_match('[CR1]', $card->desc) ) 
						$codeReview = 1;
					else if (preg_match('[CR 2]', $card->desc) || preg_match('[CR2]', $card->desc) ) 
						$codeReview = 2;
					else
						$codeReview = 0;
					echo '<div class="task-item task-item-'.$roman[$i].'">';
						echo '<div class="task-item-backlogno">'.$roman[$i].'</div>';
						echo '<div class="task-item-text">';
							echo '<div class="task-item-title">'.preg_replace(array($pattern_hours, $pattern_sp), "", $card -> name).'</div>';
							echo '<div class="task-item-description">';
							echo $card->desc ;
							echo '</div>';
						echo '</div>';
						preg_match($pattern_sp , $card->name, $sp);
						$taskHours = preg_replace('/[^0-9\s]/','',$sp[0]);
						echo '<div class="task-item-cr">';
							if ($codeReview != 0) {
								$taskHours = $taskHours - $codeReview;
								echo 'CR '.$codeReview;
								}
						echo '</div>';

						echo '<div class="task-item-hours">'.$taskHours.'</div>';
						
					echo '</div>';
				}
		}
		$i++;
	}
}

}
?>
	
</div>
</div>
	    <script src="js/jquery?v=YjIzkCrAal9Aj0snvr_T4C1qo98pW34uyRDs6yAoTbk1"></script>

        <script src="js/bootstrap?v=O1P_RjwNHEgDdP5VxTqH_UDDUs0ftIVxVFXJh8sBGJA1"></script>

        <script src="js/handlebars?v=zcq-GxPolHeYMwjt0z81JsmJFrVAyFMFgZzomrfzPe01"></script>

	</body>
</html>
