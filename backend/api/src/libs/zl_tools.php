<?php
function imgCreate($str){
	$width=50;
	$height=36;
	$im = imagecreate($width,$height);
	$back=imagecolorallocate($im,  0xFF, 0xFF, 0xFF);
	//模糊点颜色
	$pix  = imagecolorallocate($im, 187, 230, 247);
	 
	//字体色
	$font = imagecolorallocate($im, 41, 163, 238);
	 
	//绘模糊作用的点
	mt_srand();
	for ($i = 0; $i < 1000; $i++) {
	    imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
	}
	 
	//输出字符
	imagestring($im, 5, 7, 5, $str, $font);
	 
	//输出矩形
	imagerectangle($im, 0, 0, $width -1, $height -1, $font);

	return $im;
}