<?php
	/*
	file:imageTool.class.php
	作用: 获取图片大小类型 制作缩略图 制作验证码
	*/
	defined('ACCESS') || exit('ACCESS Denied');

	class ImageTool {
		/**
		*分析图片信息
		*@param  String $image 图片路径
		*@return array() 图片信息
		**/
		public function imageInfo($image){
			//判断图片是否存在
			if(!file_exists($image)){
				return false;
			}
			//获取图片信息
			$imgInfo = getimagesize($image);
			if( $imgInfo == false){
				return false;
			}

			$img['width'] = $imgInfo[0];
			$img['height'] = $imgInfo[1];
			$img['type'] = substr($imgInfo['mime'] , strpos($imgInfo['mime'], '/') + 1);
			return $img;
		}

		/**
		*加水印
		*@param  
		*@param  
		*@return 
		**/
		//protected ......

		/**
		*缩略图
		*@param String $dst 原图路径
		*@param String $save 缩略图保存路径
		*@param int $width 
		*@param int $height
		*@return bool
		**/
		public function thumb($dst , $save=NULL , $width=200, $height=200){
			//判断图片是否存在
			$imgInfo = self::imageInfo($dst);
			if($imgInfo == false){
				return false;
			}
			//print_r($imgInfo);

			//计算缩放比例
			$proportion_w = $width / $imgInfo['width'] ;
			$proportion_h = $height / $imgInfo['height'] ;
			$proportion = min($proportion_w , $proportion_h);
			

			$new_width = (int)$imgInfo['width'] * $proportion;
			$new_height = (int)$imgInfo['height'] * $proportion;


			//原始图画布
			$dfunc = 'imagecreatefrom'.$imgInfo['type'];
			$sim = $dfunc($dst);

			//白色背景缩略画布
			$dim = imagecreatetruecolor($width, $height);
			$bg = imagecolorallocate($dim, 255, 255, 255);
			imagefill($dim, 0, 0, $bg);

			//填充缩略画布
			$startX = ((int)($width - $new_width) / 2);
			$startY = ((int)($height - $new_height) / 2);
			imagecopyresampled($dim , $sim , $startX, $startY, 0, 0, $new_width, $new_height, $imgInfo['width'], $imgInfo['height']);

			//保存图片
			if(!$save){
				$save = $dst;
				unlink($dst);
			}

			$createfunc = 'image' . $imgInfo['type'];
			$createfunc($dim , $save);

			imagedestroy($dim);
			imagedestroy($sim);

			return true;
		}

		//验证码类
	    public function captcha($width=50,$height=25) {
            //造画布
            $image = imagecreatetruecolor($width,$height) ;
           
            //造背影色
            $gray = imagecolorallocate($image, 200, 200, 200);
           
            //填充背景
            imagefill($image, 0, 0, $gray);
           
            //造随机字体颜色
            $color = imagecolorallocate($image, mt_rand(0, 125), mt_rand(0, 125), mt_rand(0, 125)) ;
            //造随机线条颜色
            $color1 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
            $color2 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
            $color3 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
           
            //在画布上画线
            imageline($image, mt_rand(0, 50), mt_rand(0, 25), mt_rand(0, 50), mt_rand(0, 25), $color1) ;
            imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color2) ;
            imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color3) ;
           
            //在画布上写字
            $text = substr(str_shuffle('ABCDEFGHIJKMNPRSTUVWXYZabcdefghijkmnprstuvwxyz23456789'), 0,4) ;
            imagestring($image, 5, 7, 5, $text, $color) ;
           
            //显示、销毁
            header('content-type: image/jpeg');
            imagejpeg($image);
            imagedestroy($image);
    }
}

	
	//echo ImageTool::thumb('./01.png' , './a.png' , 100 ,100)?'ok1':'fail';
	

?>