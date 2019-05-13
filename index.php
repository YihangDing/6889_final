<html>
	<head>
	<title>Tweet Filter</title>
	<link href="main.css" type="text/css" rel="stylesheet">	
	</head>

<body> 
	<div class = 'header'>
		<a href="index.php">
        <p><img src="images/logo.png"/></p>
        </a>
	</div>

	<div class="banner">
	</div> 

	<div class = 'button'>
		<form action="#" method="post">
			<select name = "mode">
				<option value="normal">Normal</option>
				<option value="work">Work</option>
				<option value="child">Child</option>
			</select>
			<input type="submit" name="submit" value="Select Filter Mode" />
		</form>
		<?php
			# Get current mode from button, now test on: suit_adult
			# mode: normal, work, child
			# default mode: child
			$mode = "child";
			if (isset($_POST["submit"])){
				$mode = $_POST["mode"];
				# echo "selected: ".$mode;
			}
			echo "<br>Current mode: ".$mode."<br>";
		?>
	</div>

	<div class = 'counter'>
		<?php
			# read counter info from counter.txt, get counter info
			$cnt_path = 'counter.txt'; 
			$cnt_txt = fopen($cnt_path, 'r');
			$line = fgets($cnt_txt);
			#echo $line."<br>";
			$line_split = explode("\t", $line);
			echo "Of <strong>".$line_split[0]."</strong> Tweets we processed, <strong>".$line_split[1]."</strong> (<strong>".$line_split[2]."%</strong>) have been filtered.";
		?>
	</div>

	<div class = 'display'>
	<?php
	# get all txt file from foler 'text_file'
	$dir_path = "text_file/";
	if(is_dir($dir_path)){
		$files = opendir($dir_path);
		if($files){
			while(($file_name = readdir($files)) !== FALSE){
				if($file_name != '.' && $file_name != '..'){
					# display the file names
					?>
					<div class = 'single'>
					<?php
					# echo $file_name."<br>";
					$obj = fopen($dir_path.$file_name, "r");
					while (!feof($obj)){
						$line = fgets($obj);
						# split line 'picture & results to get corresponding pic name'
						if (substr($line,0,3) == 'pic'){
						# echo 'ppppiiiccc'.$line."<br>";
							$splitted_pic = explode("   ", $line);
							# echo count($splitted);
							# echo json_encode($splitted)."<br>";
						# split corresponding result
						}
						elseif (substr($line,0,3) == 'res') {
							$splitted_res = explode("   ", $line);
						}
						else{
							echo $line."<br>";
						}
					}
					# display image, result
					for($i = 1; $i < count($splitted_pic); $i++){								
								#echo "picture/".$splitted_pic[$i]."\t";
								?>
								<div class = "single_image">
									<p>
										<img src = 
											<?php 
											# for child or work mode, block img whose result is suit_none or suit_adult
											if ($mode == 'child'){
												if (strcmp($splitted_res[$i],'suit_none') == 1 or strcmp($splitted_res[$i],'suit_adult') == 1){
													echo "images/sensitive.png";
												}
												else{
													echo "picture/".$splitted_pic[$i];
												}
											}
											elseif ($mode == 'work') {
												if (strcmp($splitted_res[$i],'suit_none') == 1){
													echo "images/sensitive.png";
												}
												else{
													echo "picture/".$splitted_pic[$i];
												}
											}
											else{
												echo "picture/".$splitted_pic[$i];
											}
											?>
										/>
									</p>
								</div>
								<?php
								// echo "mode: ".$mode."<br>";
								// echo "Filter Result: ".$splitted_res[$i]."<br>";
								// if ($splitted_res[$i] == 'suit_none'){
								// 	echo 'SUIT_NONE<br>';
								// }
								// if (strcmp($splitted_res[$i],'suit_none') == 1){
								// 	echo 'SUIT_NONE<br>';
								// }
								// if ($mode == "child"){
								// 	if (strcmp($splitted_res[$i],'suit_none') == 1 or strcmp($splitted_res[$i],'suit_adult') == 1){
								// 		echo "sensitive<br>";
								// 	}
								// 	else{
								// 		echo "safe<br>";
								// 	}
								// }
								// elseif ($mode == "work") {
								// 	if (strcmp($splitted_res[$i],'suit_none') == 1){
								// 		echo "sensitive<br>";
								// 	}
								// 	else{
								// 		echo "safe<br>";
								// 	}
								// }
								// else{
								// 	echo "safe<br>";
								// }
							}
							echo "<br>";
					?>
				</div>
				<div class = 'margin'>
				</div>
				<?php
				}
			}
		}
	}
	?>
	</div>
</body>
</html>