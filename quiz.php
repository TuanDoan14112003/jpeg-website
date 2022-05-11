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
	<!-- <header class="title-background" id="quizjpeg">
		<nav id="navigation">
			<ul class="nav_links">
				<li><a href="index.html">Home</a></li>
				<li><a href="topic.html">Information</a></li>
				<li><a href="enhancements.html">Enhancements</a></li>
				<li><a target="_blank" href="https://www.youtube.com/watch?v=TmwScvE_rLE">Desmonstration Video</a></li>
			</ul>
		</nav>
		<h1 class="page-title">JPEG Quizzes</h1>
	</header> -->
	<?php
	
	$page = 'quiz';
	include_once("header.inc")
	?>
	<section class="quiz-content main-content">
		<h2>JPEG Quiz</h2>
		<p>Here is a quiz to test your knowledge of the information that you have seen on this website about JPEGS:
		</p>

		<form id="question-form" method="post" action="markquiz.php" novalidate>

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
					<label for="student_id">Enter your student number (EG: 103994165): </label>
					<input placeholder="Your student number" type="text" id="student_id" name="student_id"
						required="required" pattern="^(\d{7}|\d{10})$">
				</p>
			</fieldset>

			<!-- <fieldset>
				<legend>
					JPEG
				</legend>
				<p class="questions">
					<label for="question_1">
						Q1) What does the acronym JPEG stand for?
					</label>
					<input placeholder="What does JPEG mean ?" id="question_1" type="text" name="question_1" required>
				</p>
			</fieldset>

			<fieldset>
				<legend>
					JPEG Compression
				</legend>
				<section class="questions">
					<p>Q2) How many steps are there in the compression process?</p>
					<p class="radio choices">
						<input type="radio" id="question_2_option_1" name="question_2" value="100" required="required">
						<label for="question_2_option_1">100</label>

						<input type="radio" id="question_2_option_2" name="question_2" value="1" />
						<label for="question_2_option_2">1</label>

						<input type="radio" id="question_2_option_3" name="question_2" value="3" />
						<label for="question_2_option_3">3</label>

						<input type="radio" id="question_2_option_4" name="question_2" value="5"> 
						<label for="question_2_option_4">5</label>
					</p>
				</section>
			</fieldset>

			<fieldset>
				<legend>
					Other compression type
				</legend>
				<section class="questions">
					<p>Q3) Select the compression types other than JPEG:</p>
					<p class="checkbox choices">
						<input id="question_3_option1" type="checkbox" name="other_tech[]" value="TIFF" />
						<label for="question_3_option1">TIFF</label>

						<input id="question_3_option2" type="checkbox" name="other_tech[]" value="GIF" />
						<label for="question_3_option2">GIF</label>

						<input id="question_3_option3" type="checkbox" name="other_tech[]" value="BMP" />
						<label for="question_3_option3">BMP</label>

						<input id="question_3_option4" type="checkbox" name="other_tech[]" value="HEIF" />
						<label for="question_3_option4">HEIF</label>

						<input id="question_3_option5" type="checkbox" name="other_tech[]" value="PNG" />
						<label for="question_3_option5">PNG</label>

						<input id="question_3_option6" type="checkbox" name="other_tech[]" value="MP4" />
						<label for="question_3_option6">MP4</label>
					</p>
				</section>

			</fieldset>

			<fieldset>
				<legend>
					Compression Type
				</legend>
				<p class="questions">
					<label for="question_4">Q4) What type of compression does JPEG use?</label>
					<select class="selection" name="question_4" id="question_4">
						<option value=''>Please select an option</option>
						<option value="Lossless">Lossless</option>
						<option value="Exporting">Exporting</option>
						<option value="Lossy">Lossy</option>
					</select>
				</p>

			</fieldset>

			<fieldset>
				<legend>
					JPEG History
				</legend>
				<p class="questions">
					<label for="question_5">Q5) When were JPEG's founded?</label>
					<input type="number" id="question_5" name="question_5" min="1800" max="9999">	
				</p>

			</fieldset> -->
			<?php 
			require_once "database_credentials.php";
			
			$connection = mysqli_connect($host,$user,$pwd,$sql_db);
			if ($connection) {
				// echo "Successfully";
			
				$select_random_questions_query = "SELECT * FROM questions ORDER BY RAND() LIMIT 2;";
				$query_result = mysqli_query($connection,$select_random_questions_query);
				if ($query_result) {
					$question_count = 0;
					$question_list = "";
					while ($row = mysqli_fetch_assoc($query_result)) {
						$question_count += 1;
						echo "<fieldset>";
						echo "<section class='questions'>";
						if ($question_count != 1) $question_list .= ",";
						$question_list .= "question_{$row['question_id']}";
						
						if ($row['question_type'] == 'multi-choices') {
							echo "<p>Q{$question_count}) {$row['question']} </p>";
							echo "<p class='radio choices'>";
							$choices = json_decode($row['question_choices']);
							shuffle($choices);
							$choice_count = 0;
							foreach ($choices as $choice) {
								$choice_count += 1;
								echo "<input id=\"question_{$row['question_id']}_option_{$choice_count}\" type='radio' name='question_{$row['question_id']}' value='{$choice}' required='required'> ";
								echo "<label for=\"question_{$row['question_id']}_option_{$choice_count}\">{$choice}</label>";
							}
							echo "</p>";
							
						} elseif ($row['question_type'] == 'text') {
							echo "<label for='question_{$row['question_id']}'>";
							echo "Q{$question_count}) {$row['question']}";
							echo "</label>";
							echo "<input placeholder='Type your answer here...' id='question_{$row['question_id']}' type='text' name='question_{$row['question_id']}' required>";
						}
						echo "</section>";
						echo "</fieldset>";
						
					}
					echo "<input type='hidden' name='question_list' value='{$question_list}'>";
					
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
	</section>
	<?php
	include_once("footer.inc")
	?>
</body>
</html>