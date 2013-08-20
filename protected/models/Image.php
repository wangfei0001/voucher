<?php
	/**
	 * 图像处理类
	 *
	 */
	class Image {
		/*用于Resize的纬度*/
		const NONE		= 0;
		const WIDTH  	= 1;
		const HEIGHT 	= 2;
		const AUTO		= 3;
		
		private $sourcePath = '';
		private $attrOrg = array();
		private $attrCur = array();

		private $_leftAlign = array('left', 'center', 'right');
		private $_topAlign = array('top', 'middle', 'bottom');
		private $_createFun = array(IMAGETYPE_GIF		=>	'imagecreatefromgif',
									IMAGETYPE_JPEG		=>	'imagecreatefromjpeg',
									IMAGETYPE_PNG		=>	'imagecreatefrompng',
									IMAGETYPE_WBMP		=>	'imagecreatefromwbmp'
								);
		
		public $quality = 100;
		
		protected $sim = null;			//源图形对象 
		protected $cim = null;			//当前图形对象
		  
		protected $gdInfo = null;
		protected $error = '';
		
		/**
		 * 构造函数
		 *
		 * @param string $imagescr			源文件路径
		 */
		public function __construct($imagescr = '') { 
			if (!function_exists('gd_info')) { 
				throw_exception('Can\'t support GD lib');
			} 
			$this->gdInfo = gd_info();
			if(!empty($imagescr)){
				if(!$this->loadImg($imagescr)){
					throw_exception('Can\'t load image');
				}
			}
		}
		
		/**
		 * 析构函数
		 *
		 */
		function __destruct() { 
//			if($this->sim){
//				@ImageDestroy($this->sim); 
//				$this->sim = null;
//			}
//			if($this->cim){
//				@ImageDestroy($this->cim); 
//				$this->cim = null;
//			}
		} 		
		
		/**
		 * 导入图像文件
		 *
		 * @param string $imagescr		源文件路径
		 * @return boolean
		 */
		public function loadImg($imagescr)
		{
			if(file_exists($imagescr)){
				$size = getimagesize($imagescr);
				if(false !== $size){
					switch($size[2]){ 
						case IMAGETYPE_GIF: 
						case IMAGETYPE_JPEG: 
						case IMAGETYPE_PNG: 
						case IMAGETYPE_WBMP: 
							$this->sim = $this->_createFun[$size[2]]($imagescr); 
							break; 
						default: 
							$this->error = 'Can\'t support';
							return false; 
							break; 
					}
					$this->attrOrg = array(
						//'source'	=>		$imagescr,
						'width'		=>		$size[0],
						'height'	=>		$size[1],
						'type'		=>		$size[2],
						'bits'		=>		$size['bits'],
						'mime'		=>		$size['mime']
					);

					$this->cim = $this->sim;
					$this->attrCur = $this->attrOrg;
					$this->sourcePath = $imagescr;
					return true;
				}
			}
			return false;
		}
	 
		/**
		 * 保存图片
		 *
		 * @param string $imagedst		保存路径，如果没有设置，则覆盖源文件
		 * @return boolean
		 */
		public function save($imagedst='')
		{
			if(empty($this->sourcePath)){
				throw_exception('Please load image first');
				return false;
			}
			if(empty($imagedst)) $imagedst = $this->sourcePath;
                        $path = pathinfo($imagedst);
                        $dir = $path['dirname'];
                        if(!file_exists($dir)) mkdir($dir,777);
                        
                        return $this->_drawImage($imagedst);		
		}
		
		public function convert($format = 'jpg')
		{
			switch(strtolower($format)){
				case 'gif': $format = IMAGETYPE_GIF; break;
				case 'png': $format = IMAGETYPE_PNG; break;
				case 'jpeg':
				case 'jpg':
				default:
					$format = IMAGETYPE_JPEG; 
					break;
			}
			
			$this->attrCur['type'] = $format;
		}
		
		/**
		 * 在浏览器上显示图片
		 *
		 * @return boolean
		 */
		public function render()
		{
			if(empty($this->sourcePath)){
				throw_exception('Please load image first');
				return false;
			}
			header ("Content-type: " . $this->attrCur['mime']);
			return $this->_drawImage();
		}
		
		public function water($water, $alpha = 80, $x=null, $y=null)
		{
			$wInfo = getimagesize($water);
			if(false !== $wInfo){
				switch($wInfo[2]){
					case IMAGETYPE_GIF: 
					case IMAGETYPE_JPEG: 
					case IMAGETYPE_PNG: 
					case IMAGETYPE_WBMP: 
						$this->sim = $this->_createFun[$wInfo[2]]($imagescr); 
						break;
					default:
						$this->error = 'Can\'t support';
						return false;
						break;								
				}
				$imgWater = $this->_createFun[$wInfo[2]]($water);
				if($this->attrCur['width'] < $wInfo[0] || $this->attrCur['height'] < $wInfo[1]){
					$this->error = 'Water image is too large';
					return false;
				}
				imagealphablending($imgWater, true);
				if(empty($x) || $x > ($this->attrCur['width'] - $wInfo[0])){
					$x = $this->attrCur['width'] - $wInfo[0];
				}
				if(empty($y) || $y > ($this->attrCur['height'] - $wInfo[1])){
					$y = $this->attrCur['height'] - $wInfo[1];
				}
				return imagecopymerge($this->cim, $imgWater, $x, $y, 0, 0, $wInfo[0],$wInfo[1],$alpha);
			}
			return false;
		}
		
		/**
		 * 输出内存图片到文件或浏览器
		 *
		 * @param string $savePath		保存路径
		 * @return boolean
		 */
		private function _drawImage($savePath = null)
		{
			$result = false;
			switch($this->attrCur['type']){ 
				case IMAGETYPE_GIF: 
					$result = @imagegif($this->cim, $savePath); 
					break; 
				case IMAGETYPE_JPEG: 		
					$result = @imagejpeg($this->cim, $savePath, $this->quality); 
					break; 
				case IMAGETYPE_PNG: 
					$result = @imagepng($this->cim, $savePath); 
					break; 
				case IMAGETYPE_WBMP: 
					$result = @imagewbmp($this->cim, $savePath); 
					break; 
			}	
			return $result;
		}
		
		/**
		 * 旋转图片
		 *
		 * @param int $degrees			旋转角度
		 * @param array $bgColor		旋转后填充背景色
		 * @return object
		 */
		public function rotate($degrees, $bgColor=array(0,0,0))
		{
			if($degrees > 0 && $degrees <= 180){
				return $this->_rotate($degrees, $bgColor);
			}
			return false;
		}
		
		/**
		 * 裁剪图片
		 *
		 * @param int $width				宽度
		 * @param int $height				高度
		 * @param string $left				水平对齐方式		
		 * @param string $top				垂直对齐方式
		 * @return boolean
		 */
		public function crop($width, $height, $left='center', $top='middle')
		{
			if(is_string($left)){
				if(!in_array($left, $this->_leftAlign)) $left='center';
			}
			if(is_string($top)){
				if(!in_array($top, $this->_topAlign)) $top='middle';
			}
			if($width > 0 && $height > 0){
				return $this->_crop($width, $height, $left, $top);
			}
			return false;
		}
		
		/**
		 * 重新调整图片大小
		 *
		 * @param int $width			宽度
		 * @param int $height			高度
		 * @param int $dimension		调整大小的纬度 HEIGHT, WIDTH, AUTO, NONE
		 * @return object		
		 */
		public function resize($width, $height, $dimension = self::AUTO)
		{
			if($width > 0 && $height > 0 && ($dimension >= self::NONE && $dimension <= self::AUTO)){
				return $this->_resize($width, $height, $dimension);
			}
			return false;
		}
		
		/**
		 * 调整图片画布大小
		 *
		 * @param int 			$width
		 * @param int 			$height
		 * @param int 			$left		画面在画布的横坐标
		 * @param int 			$top		画面在画布的纵坐标
		 * @return boolean
		 */			
		public function extend($width, $height, $left='center', $top = 'middle')
		{
			if(is_string($left)){
				if(!in_array($left, $this->_leftAlign)) $left='center';
			}
			if(is_string($top)){
				if(!in_array($top, $this->_topAlign)) $top='middle';
			}
			if($width > 0 && $height > 0){
				return $this->_extend($width, $height, $left, $top);
			}
			return false;
		}
		
	
		
		/**
		 * 获取变量值
		 *
		 * @param string $name		变量名称
		 */
		public function __get($name)
		{
			
			
		}
		
		/**
		 * 设置变量值
		 *
		 * @param string $name		变量名称
		 * @param mixed $value		变量值
		 */
		public function __set($name, $value)
		{
			
			
		}
		
		/**
		 * 旋转图片
		 *
		 * @param int 		$degrees
		 * @param array 	$bgColor
		 * @return boolean
		 */
		private function _rotate($degrees, $bgColor)
		{
			$this->cim = imagerotate($this->cim, $degrees, imagecolorallocate($this->cim, $bgColor['R'], $bgColor['G'], $bgColor['B']),0);
			$this->attrCur['width'] = imagesx($this->cim);
			$this->attrCur['height'] = imagesy($this->cim);
			
			return true;
		}
		
		/**
		 * 剪切图片
		 *
		 * @param int 			$width
		 * @param int 			$height
		 * @param string 		$left
		 * @param string 		$top
		 * @return boolean
		 */
		private function _crop($width, $height, $left, $top)
		{			
			if($width > $this->attrCur['width']) $width = $this->attrCur['width'];
			if($height > $this->attrCur['height']) $height = $this->attrCur['height'];
			
			if(is_string($left)){
				if($left == 'left'){
					$x = 0;
				}else if($left == 'right'){
					$x = $this->attrCur['width'] - $width;
				}else{
					$x = ($this->attrCur['width'] - $width) / 2;
				}
			}else{
				$x = $left;
			}
			if(is_string($top)){
				if($top == 'top'){
					$y = 0;
				}else if($top == 'bottom'){
					$y = $this->attrCur['height'] - $height;
				}else{
					$y = ($this->attrCur['height'] - $height) / 2;
				}
			}else{
				$y = $top;
			}
			
			$tmpim = imagecreatetruecolor($width, $height);
			//真彩色转换成调色板
/*			imagetruecolortopalette($this->cim, false, 256); 
			$palsize = ImageColorsTotal($this->cim); 
			for ($i = 0; $i<$palsize; $i++) { 
				$colors = ImageColorsForIndex($this->cim, $i); 
				ImageColorAllocate($tmpim, $colors['red'], $colors['green'], $colors['blue']); 
			} */			
			if(true === $result = imagecopyresampled($tmpim, $this->cim, 0, 0, $x, $y, $width, $height, $width, $height)){
				if($this->cim){ 
					@ImageDestroy($this->cim); 
				}
				$this->cim = $tmpim;
				$this->attrCur['width'] = $width;
				$this->attrCur['height'] = $height;
				return true;
			}
			return false;			
		}

		/**
		 * 调整图片画布大小
		 *
		 * @param int 			$width
		 * @param int 			$height
		 * @param int 			$x		画面在画布的横坐标
		 * @param int 			$y		画面在画布的纵坐标
		 * @return boolean
		 */		
		private function _extend($width, $height, $dstx, $dsty)
		{
			if($dstx == 'center'){
				$offsetX = abs(($width - $this->attrCur['width'])/2);
			}else if($dstx == 'right'){
				$offsetX = abs($width - $this->attrCur['width']);
			}else if($dstx == 'left'){
				$offsetX = 0;
			}
			
			if($dsty == 'middle'){
				$offsetY = abs(($height - $this->attrCur['height'])/2);
			}else if($dsty == 'bottom'){
				$offsetY = abs($height - $this->attrCur['height']);
			}else if($dsty == 'top'){
				$offsetY = 0;
			}
			
			if($width > $this->attrCur['width']){
				$srcx = 0;
				$srcw = $this->attrCur['width'];
				$dstx = is_numeric($dstx)?$dstx:$offsetX;
			}else{
				$srcx = $offsetX; 
				$srcw = $width;
				$dstx = is_numeric($dstx)?$dstx:0;
			}
			
			
			if($height > $this->attrCur['height']){
				$srcy = 0;
				$srch = $this->attrCur['height'];
				$dsty = is_numeric($dsty)?$dsty:$offsetY;
			}else{
				$srcy = $offsetY; 
				$srch = $height;
				$dsty = is_numeric($dsty)?$dsty:0;
			}			
			
			
			$tmpim = imagecreatetruecolor($width, $height);
            $white = imagecolorallocate($tmpim, 255, 255, 255);
            imagefill($tmpim, 0, 0, $white);
			if(true === $result = imagecopyresampled($tmpim, $this->cim, $dstx, $dsty, $srcx,$srcy,$srcw, $srch, $srcw, $srch)){
				if($this->cim){ 
					@ImageDestroy($this->cim); 
				}
				$this->cim = $tmpim;
				$this->attrCur['width'] = $width;
				$this->attrCur['height'] = $height;
				return true;
			}
			return false;										
		
		}
		
		/**
		 * 调整图片大小
		 *
		 * @param int 			$width
		 * @param int 			$height
		 * @param int 			$dimension		纬度
		 * @return boolean
		 */
		private function _resize($width, $height, $dimension)
		{
			$ratio_org = $this->attrCur['width'] / $this->attrCur['height'];
			
			switch ($dimension){
				case self::AUTO :
					$ratio_cur = $width / $height;
					if($ratio_org > $ratio_cur){
						$widthto = $width;
						$heightto = $widthto / $ratio_org;
					}else{
						$heightto = $height;
						$widthto = $height * $ratio_org;
					}
					break;
				case self::NONE :
					$widthto = $width;
					$heightto = $height;
					break;
				case self::HEIGHT :
					$widthto = $ratio_org * $height;
					$heightto = $height;
					break;
				case self::WIDTH :
					$heightto = $width / $ratio_org;
					$widthto = $width;
					break;
			}

			$tmpim = imagecreatetruecolor($widthto, $heightto);
//			//真彩色转换成调色板
//			imagetruecolortopalette($this->cim, false, 256); 
//			$palsize = ImageColorsTotal($this->cim); 
//			for ($i = 0; $i<$palsize; $i++) { 
//				$colors = ImageColorsForIndex($this->cim, $i); 
//				ImageColorAllocate($tmpim, $colors['red'], $colors['green'], $colors['blue']); 
//			}
			$result = imagecopyresampled($tmpim, $this->cim, 0, 0, 0, 0, $widthto, $heightto, $this->attrCur['width'], $this->attrCur['height']); 							
			if(true === $result){

				if($this->cim){
					@ImageDestroy($this->cim);
				}
				$this->cim = $tmpim;
				$this->attrCur['width'] = $widthto;
				$this->attrCur['height'] = $heightto;
				return true;
			}
			return false;
		}
	 	
		/**
		 * 当前位图信息
		 *
		 * @return array
		 */
		public function getInfo()
		{
			return $this->attrCur;
		}
	} 
?>