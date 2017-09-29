<?php 
function ElementaryCellularAutomata($rule, $seed){
	$seed = str_split($seed); /* Split $seed string into array */
    $seed_length = count($seed); /* How long is the seed array */
    $new_seed = "";
	
	if(strlen($rule) < 8){ /* If rule is dec */
			$rule = sprintf('%08b', $rule); /* Convert rule to bin */
	}$rule = str_split($rule); /* Split the binary value of $rule as a string into an array */

	/* For each value in the seed */
    for($i = 0; $i < $seed_length; $i++){
		$left = $center = $right = null; /* set all positions to null */

		/* $left */
		/* If this is the first element in the array */
		/* Wrap around and set $left to last element in array */
		/* Otherwise $left = the element to the left of $center */
		if($i == 0) {$left = $seed[$seed_length - 1];}
		else{$left = $seed[$i - 1];}
		
		/* $center */
		/* Set $center to the current position */
		$center = $seed[$i];
		
		/* $right */
		/* If this is the last element in the array */
		/* Wrap around and set $right to first element in array */
		/* Otherwise $right = the element to the right of $center */
		if($i + 1 >= $seed_length) {$right = $seed[0];}
		else{$right = $seed[$i + 1];}
		
        // Apply Rule ///////////////////////////////////////////////////////////
		if($left == 1 && $center == 1 && $right == 1){$new_seed .= $rule[0];}
		elseif($left == 1 && $center == 1 && $right == 0){$new_seed .= $rule[1];}
		elseif($left == 1 && $center == 0 && $right == 1){$new_seed .= $rule[2];}
		elseif($left == 1 && $center == 0 && $right == 0){$new_seed .= $rule[3];}
		elseif($left == 0 && $center == 1 && $right == 1){$new_seed .= $rule[4];}
		elseif($left == 0 && $center == 1 && $right == 0){$new_seed .= $rule[5];}
		elseif($left == 0 && $center == 0 && $right == 1){$new_seed .= $rule[6];}
		elseif($left == 0 && $center == 0 && $right == 0){$new_seed .= $rule[7];}
		/////////////////////////////////////////////////////////////////////////
    }

	/* Return the new seed which was created by applying the rule set */
    return $new_seed; 
}


// Image Size Setting //////////////////////
$full_size = pow(2, 10) + 1; // 1025
////////////////////////////////////////////

////////////////////////////////////////////

// Create 10 images
for($i = 0; $i <= 10; $i++){
    $cellular_automata = imagecreatetruecolor($full_size, $full_size); /* New Image */

    /* Create random seed */
	$seed = "";
	for($j = 0; $j <= $full_size; $j++){ $seed .= mt_rand(0, 1); }
	
	$current_seed = str_split($seed); /* Split the $seed string into an array */
	
	/* For each value in the current_seed array */
	foreach($current_seed as $col=>$value){
		if($value == 1){ 
		    imagesetpixel($cellular_automata, $col, 0, imagecolorallocate($cellular_automata, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255))); /* Set Pixel */
		}
	}

	/* For each row & column pixel in the image */
	$rule = mt_rand(1, 30); // $i
	for($row = 1; $row <= $full_size; $row++){
		$seed = ElementaryCellularAutomata($rule, $seed); /* Compute the new $seed */
		$current_seed = str_split($seed); /* Split the $seed string into an array */
		
		/* For each value in the current_seed array */
		foreach($current_seed as $col=>$value){
			if($value == 1){ 
				imagesetpixel($cellular_automata, $col, $row, imagecolorallocate($cellular_automata, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255))); /* Set Pixel */
			}
		}
	}

	/* Randomly turn image to negative (Reverses all colors of the image) */
	if(mt_rand(0,1) == 1){
	    imagefilter($cellular_automata, IMG_FILTER_NEGATE);
	}
	imagepng($cellular_automata, mt_rand(1651516, 65116532) . ".png"); /* Output Image with random name */
	
	imagedestroy($cellular_automata);/* Free memory */
}
echo PHP_EOL . "Program Complete!" . PHP_EOL;
///////////////////////////////////////////////////////
