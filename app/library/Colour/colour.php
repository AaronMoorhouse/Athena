<?php
class Colour {
	
	private $hex;
	
	public function __construct($hex) {
		$this->hex = $hex;
	}
	
	public function getLightness() {
		$colour = str_replace('#', '', $this->hex);
		$r = hexdec(substr($colour, 0, 2));
		$g = hexdec(substr($colour, 2, 2));
		$b = hexdec(substr($colour, 4, 2));
		
		$lightness = sqrt((0.241 * pow($r, 2)) + (0.691 * pow($g, 2)) + (0.068 * pow($b, 2)));
		
		return $lightness;
	}

	public function editTint($mult) {
		$colour = str_replace('#', '', $this->hex);
		$r = hexdec(substr($colour, 0, 2));
		$g = hexdec(substr($colour, 2, 2));
		$b = hexdec(substr($colour, 4, 2));
		
		$x = round(((255 - $r) * $mult) + $r);
		$y = round(((255 - $g) * $mult) + $g);
		$z = round(((255 - $b) * $mult) + $b);
		
		$rgb = "rgb($x,$y,$z)";
		
		return $rgb;
	}

	public function editShade($mult) {
		$colour = str_replace('#', '', $this->hex);
		$r = hexdec(substr($colour, 0, 2));
		$g = hexdec(substr($colour, 2, 2));
		$b = hexdec(substr($colour, 4, 2));
		
		$x = round($r * $mult);
		$y = round($g * $mult);
		$z = round($b * $mult);
		
		$rgb = "rgb($x,$y,$z)";
		
		return $rgb;
	}
}
?>