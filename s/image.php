<?php

class Image{
	
	public function build($string, $width, $height, $r, $g, $b){
		
		$target["w"] = $width;
		$target["h"] = $height;

		//
		
		$originalImage = imagecreatefromstring($string);
		$original["w"] = imagesx($originalImage);
		$original["h"] = imagesy($originalImage);
		
		//
		
		$key = ($original["w"] > $original["h"]) ? "w" : "h";
		
		if($target[$key] - $original[$key] == 0) $key = ($original["w"] > $original["h"]) ? "h" : "w";

		$dif = round(abs($target[$key] - $original[$key]) / $original[$key], 2);

		//

		if($original["w"] > $target["w"] || $original["h"] > $target["h"]){
	
			if($key == "w"){ $w = $target["w"]; } else{ $w = intval($original["w"] - ($original["w"] * $dif)); }
			if($key == "h"){ $h = $target["h"]; } else{ $h = intval($original["h"] - ($original["h"] * $dif)); }
		}
		elseif($original["w"] < $target["w"] && $original["h"] < $target["h"]){
	
			if($key == "w"){ $w = $target["w"]; } else{ $w = intval($original["w"] + ($target[$key] * $dif)); }
			if($key == "h"){ $h = $target["h"]; } else{ $h = intval($original["h"] + ($target[$key] * $dif)); }
		}
		else{
	
			$w = $original["w"];
			$h = $original["h"];
		}

		imagecopyresampled($sized = imagecreatetruecolor($w, $h), $originalImage, 0, 0, 0, 0, $w, $h, $original["w"], $original["h"]);

		//

		if(($w == $target["w"] && $h == $target["h"])) $final = $sized;
		else{

			if($w == $target["w"]){
				$x = 0; // don't joke 
				$y = round(abs($target["h"] - $h) / 2);
			}
			if($h == $target["h"]){
				$y = 0; // with it
				$x = round(abs($target["w"] - $w) / 2);
			}
	
			$final = imagecreatetruecolor($target["w"], $target["h"]);
			$bg  = imagecolorallocate($final, $r, $g, $b);
			imagefill($final, 0, 0, $bg);
	
			//
	
			imagecopy($final, $sized, $x, $y, 0, 0, $w, $h);
		}
		
		return $final;
	}
	
	//
	
	public function burn($image){
		
		while(true){
			
			$tmpName = $this->generateName();
			$physPath = sprintf("%s%s.%s", IMG_D, $tmpName, IMG_EX);
			
			if(!file_exists($physPath)) break;
		}
		
		//
		
		switch(IMG_EX){
			case "webp":
				imagewebp($image, $physPath);
				break;
			case "png":
				imagepng($image, $physPath);
				break;
			case "jpeg":
				imagejpeg($image, $physPath);
				break;
			case "gif":
				imagegif($image, $physPath);
				break;
		}
		
		//
		
		return $tmpName;
	}
	
	//
	
	private function generateName(){
		
		$str = "zaq1ZAQxsw2XSWcde3CDEvfr4VFRbgt5BGTnhy6NHYmju7MJUki8KIlo9LOp0P";
		$out = "";
		
		while(strlen($out) != 4) $out .= $str[rand(0, strlen($str) - 1)];
		
		return $out;
	}
}