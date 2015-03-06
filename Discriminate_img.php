<?PHP
class Discriminate_img {
	var $left = 0, $right = 0, $top = 0, $bottom = 0,$img_file = null;
	var $xmin = 0, $xmax = 200, $ymin = 0, $ymax = 8, $img_height, $img_width;
	//img_file：圖檔名 
	public function __construct($img_name = null){
		$this->img_file = $img_name;
		$this->img_size();
	}
	//設定x，y 軸最大最小值
	public function SetBorder($xmin = 0,$xmax = 10,$ymin = 0,$ymax = 1){
		$this->xmin = $xmin;
		$this->xmax = $xmax;
		$this->ymin = $ymin;
		$this->ymax = $ymax;
	}
	//設定邊界值
	protected function img_size(){
		$img_size = getimagesize($this->img_file);
		$this->right = $img_size[0];
		$this->bottom = $img_size[1];
		
	}
	//座標轉換  回傳圖形座標
	public function ChangeY($y = 0){
		return round(($this->bottom - $y) / ($this->bottom / $this->ymax),3);
	}
	public function ChangeX($x = 0){
		return round($x / ($this->right / $this->xmax),3);
	}
	
	//座標轉換  回傳像素座標
	public function ScreenX($theRealX = 0){ 
		return(round(($theRealX-$this->xmin)/($this->xmax-$this->xmin)*($this->right-$this->left)+$this->left));
  	}

  	public function ScreenY($theRealY = 0){ 
		return(round(($this->ymax-$theRealY)/($this->ymax-$this->ymin)*($this->bottom-$this->top)+$this->top));
  	}
	
	/*
	用顏色來辨識 y值
	x_int：對應y軸的x值(像素座標)
	r_color,g_color,b_color 三原色 判定點的顏色
	回傳像素座標
	*/
	public function check_color_point($x_int = 0,$r_color = 255,$g_color = 255,$b_color = 255){
		$y = null;
		$file_n = explode ('.',$this->img_file);
		if($file_n[1] == 'jpg')
			$im = imagecreatefromjpeg($this->img_file);
		elseif($file_n[1] == 'png')
			$im = imagecreatefrompng($this->img_file);
		for($i=0;$i<$this->bottom;$i++){
			$rgb = imagecolorat($im, $x_int, $i);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			if($r < $r_color and $g < $g_color and $b < $b_color){
				$y = $i;
				break;
			}
		}
		return $y;
	}
}

?>
