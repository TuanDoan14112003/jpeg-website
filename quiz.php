<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="JPEG quizzes">
    <meta name="keywords" content="JPEG">
    <meta name="author" content="Gabriel Chee">
    <title>JPEG Quizzes</title>
	<link rel="stylesheet" href="styles/style.css">
</head>

<body>

	<?php
	if(!isset($_SESSION)) session_start(); 
	$page = 'quiz';
	include_once("header.inc")
	?>
	<section class="quiz-content main-content">
		<h2>JPEG Quiz</h2>
		<p>Here is a quiz to test your knowledge of the information that you have seen on this website about JPEGS:
		</p>
		<?php if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) : ?>
		<form id="question-form" method="post" action="https://mercury.swin.edu.au/it000000/formtest.php" novalidate>

			<fieldset>
				<legend>Your information</legend>
				<p class="questions">
					<label for="first_name">Enter your first name:</label>
					<input placeholder="Your first name" type="text" id="first_name" name="first_name"
						required="required" pattern="[a-zA-Z- ]{1,30}">
				</p>


				<p class="questions">
					<label for="last_name">Enter your last name:</label>
					<input placeholder="Your last name" type="text" id="last_name" name="last_name" required="required"
						pattern="[a-zA-Z- ]{1,30}">

				</p>

				<p class="questions">
					<label for="student_id">Enter your student number (EG: 1039941): </label>
					<input placeholder="Your student number" type="text" id="student_id" name="student_id"
						required="required" pattern="^(\d{7}|\d{10})$">
				</p>
			</fieldset>
			<?php 
			require_once "database_credentials.php";
			$connection = mysqli_connect($host,$user,$pwd,$sql_db);
			if ($connection) {
			
				$select_random_questions_query = "SELECT * FROM questions ORDER BY RAND() LIMIT 5;";
				$query_result = mysqli_query($connection,$select_random_questions_query);
				if ($query_result) {
					$question_count = 0;
					$question_list = "";
					while ($row = mysqli_fetch_assoc($query_result)) {
						$question_count += 1;
						echo "<fieldset>";
						echo "<section class='questions'>";
						if ($question_count != 1) $question_list .= ",";
						$question_list .= "{$row['question_id']}";
						
						if ($row['question_type'] == 'multi-choices') {
							echo "<p>Q{$question_count}) {$row['question']} </p>";
							echo "<p class='radio choices'>";
							$choices = json_decode($row['question_choices']);
							shuffle($choices);
							$choice_count = 0;
							$default_selected = false;
							foreach ($choices as $choice) {
								$choice_count += 1;
								if (!$default_selected) {
									$default_selected = true;
									echo "<input id=\"question_{$row['question_id']}_option_{$choice_count}\" type='radio' name='question_{$row['question_id']}' value='{$choice}' required='required' checked> ";
								} else echo "<input id=\"question_{$row['question_id']}_option_{$choice_count}\" type='radio' name='question_{$row['question_id']}' value='{$choice}' required='required'> ";
								echo "<label for=\"question_{$row['question_id']}_option_{$choice_count}\">{$choice}</label>";
							}
							echo "</p>";
							
						} elseif ($row['question_type'] == 'text') {
							echo "<label for='question_{$row['question_id']}'>";
							echo "Q{$question_count}) {$row['question']}";
							echo "</label>";
							echo "<input placeholder='Type your answer here...' id='question_{$row['question_id']}' type='text' name='question_{$row['question_id']}' required>";
						} elseif ($row['question_type'] == 'dropdown') {
							echo "<p class='questions'>";
							echo "<label for='question_{$row['question_id']}'>";
							echo "Q{$question_count}) {$row['question']}";
							echo "</label>";
							// <label for="question_4">Q4) What type of compression does JPEG use?</label>
							echo "<select class='selection' name='question_{$row['question_id']}' id='question_{$row['question_id']}'>";
							$choices = json_decode($row['question_choices']);
							shuffle($choices);
							$choice_count = 0;
							echo "<option value=''>Please select an option</option>";
							foreach ($choices as $choice) {
								echo "<option value='{$choice}'>{$choice}</option>";
							}
							echo "</select>";
							echo "</p>";
						} elseif ($row['question_type'] == 'number') {
							echo "<label for='question_{$row['question_id']}'>";
							echo "Q{$question_count}) {$row['question']}";
							echo "</label>";
							echo "<input placeholder='Type your answer here...' id='question_{$row['question_id']}' type='number' name='question_{$row['question_id']}' required>";
						}
						elseif ($row['question_type'] == 'check-boxes') {
							echo "<p>Q{$question_count}) {$row['question']}</p>";
							echo "<p class='checkbox choices'>";
							$choices = json_decode($row['question_choices']);
							shuffle($choices);
							$choice_count = 0;
							$default_selected = false;
							foreach ($choices as $choice) {
								$choice_count += 1;
								if (!$default_selected) {
									echo "<input id=\"question_{$row['question_id']}_option_{$choice_count}\" type='checkbox' name='question_{$row['question_id']}[]' value='{$choice}' checked> ";
									$default_selected = true;
								}
								else echo "<input id=\"question_{$row['question_id']}_option_{$choice_count}\" type='checkbox' name='question_{$row['question_id']}[]' value='{$choice}' required='required'> ";
								echo "<label for=\"question_{$row['question_id']}_option_{$choice_count}\">{$choice}</label>";
							}
							echo "</p>";
						}
						echo "</section>";
						echo "</fieldset>";
						
					}
					echo "<input type='hidden' name='question_list' value='{$question_list}'>";
					mysqli_free_result($query_result);
				} else {
					echo ("<p> Can't query </p>");
				}
				
				
				mysqli_close($connection);
			} else {
				echo "no";
			}
			?>
			<p class="container1">
				<button class="btn btn1" type="submit">Submit quiz</button>
				<button class="btn btn1" type="reset">Reset quiz</button>
			</p>

		</form>
		<?php else : ?>
			<p class='error'>You must <a href='login.php'>login</a> to do the quiz!</p>
		<?php endif; ?>

	</section>
	<?php
	include_once("footer.inc");
	?>
</body>
</html>