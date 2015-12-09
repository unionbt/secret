<?php

//这是一个图像操作的基本类，具有图片压缩，等比放大，按宽或高等比裁剪等功能，处理过的图像，在后面加上_s标记;

class makeimg {

  private $img;           //源文件路径
  private $img_w;         //源文件宽
  private $img_h;         //源文件高
  private $make_type;     //文件后缀类型
  private $new_img; //新文件路径
  private $new_w = 200;   //新文件宽
  private $new_h = 200;   //新文件高
  private $cut = '5'; //生成方法，剪切？等比缩放？等高？等宽？
  private $power      = '1';     //是否开启水印
  private $water_img  = '../themes/images/water_make/water_one.png'; //图片水印
  private $text       = "量体裁衣  一种生活的态度"; //文本水印
  private $font_size  = 12;     //水印文字大小
  private $font_color = "*000000";    //水印文字颜色
  private $font       = '方正细圆';          //水印文字字体
  private $pos        = 3;     //水印的位置
  private $pct        = 30;    //水印的透明度
  private $quality    = 10;       //水印的压缩比

  //初始化
  //构造涵数,传入一个数组参数

  function __construct($option = array()) {
    foreach ($option as $key=> $v) {
      $key = strtolower($key);  //将传入的字符串$key的值变成小写，以匹配
      //查看传进来的数组中的下标是否符合涵数参数名，如果有，就赋值，否则不赋值；
      if(!array_key_exists($key, get_class_vars(get_class($this)))) {
        continue;
      }
      $this->set_value($key, $v);
    }
  }

//构造涵数结束
  //添加水印
  function add_water($img) {
    //验证图片
    if(!$this->type($img) || !$this->power) {
      return FALSE;
    }
    //获取源文件信息,创建源文件资源
    $img_info    = $this->img_rel($img);
    $this->img_w = $img_info[1][0];
    $this->img_h = $img_info[1][1];

    //判断用图片还是文字水印
    if($this->water_img) {
      //创建水印图片资源
      $water_img_info = $this->img_rel($this->water_img);
      $water_img_w    = $water_img_info[1][0];
      $water_img_h    = $water_img_info[1][1];
    }
    else {
      //创建文本资源
      $text_info   = imagettfbbox($this->font_size, 0, $this->font, $this->text);
      $water_img_w = $text_info[2] - $text_info[6];
      $water_img_h = $text_info[3] - $text_info[7];
    }

    //确定水印位置
    switch($this->pos) {
      case 1:$x = $y = 25;
        break;
      case 2:$x = ($this->img_w - $water_img_w) / 2;
        $y = 25;
        break;
      case 3:$x = $this->img_w - $water_img_w;
        $y = 25;
        break;
      case 4:$x = 25;
        $y = ($this->img_h - $water_img_h) / 2;
        break;
      case 5:$x = ($this->img_w - $water_img_w) / 2;
        $y = ($this->img_h - $water_img_h) / 2;
        break;
      case 6:$x = $this->img_w - $water_img_w;
        $y = ($this->img_h - $water_img_h) / 2;
        break;
      case 7:$x = 25;
        $y = $this->img_h - $water_img_h;
        break;
      case 8:$x = ($this->img_w - $water_img_w) / 2;
        $y = $this->img_h - $water_img_h;
        break;
      case 9:$x = $this->img_w - $water_img_w;
        $y = $this->img_h - $water_img_h;
        break;
      default :$x = mt_rand(25, $this->img_w - $water_img_w);
        $y = mt_rand(25, $this->img_h - $water_img_h);
        break;
    }
    //制作水印
    if($this->water_img) {
      imagecopymerge($img_info[0], $water_img_info[0], $x, $y, 0, 0, $water_img_w, $water_img_h, $this->pct);
    }
    else {
      imagettftext($img_info[0], $this->font_size, 0, $x, $y, $this->font_color, $this->font, $this->text);
    }

    //保存文件
    $this->new_img = $this->path($img);
    $this->save($img_info[1][2], $img_info[0]);
    imagedestroy($img_info[0]);
    imagedestroy($water_img_info[0]);
    return $this->new_img;
  }

  //缩略处理处理图片的方法
  function thumd_makeing($img) {
    //获得图像信息并打开图片，创建源图片资源
    $img_info    = $this->img_rel($img);
    $this->img_w = $img_info[1][0]; //源图片宽度
    $this->img_h = $img_info[1][1]; //源图片高度
    //设置要处理的图片高宽比
    $this->makeCut($this->img_w, $this->img_h);
    //建立图像资源
    if($img_info[1][2] == '1' || $img_info[1][2] == '3') {
      $img_rel = imagecreate($this->new_w, $this->new_h);
      $color   = imagecolorallocate($img_rel, 0, 0, 0);
    }
    else {
      $img_rel = imagecreatetruecolor($this->new_w, $this->new_h);
    }

    //处理图片,$img_info数组值是调用img_rel涵数中打开的资源地址指针;
    //判断用哪一种涵数方式实现
    if(function_exists("imagecopyresampled")) {
      imagecopyresampled($img_rel, $img_info[0], 0, 0, 0, 0, $this->new_w, $this->new_h, $this->img_w, $this->img_h);
    }
    else {
      imagecopyresized($img_rel, $img_info[0], 0, 0, 0, 0, $this->new_w, $this->new_h, $this->img_w, $this->img_h);
    }
    //如果要保存的文件是gif或是png，则要处理透明层
    if($img_info[1][2] == '1' || $img_info[1][2] == '3') {
      imagecolortransparent($img_rel, $color);
    }

    ////////////////////////
    /////////保存图片////////
    ///////////////////////
    //配设置文件名
    $this->new_img = '_s';
    $this->new_img = $this->path($img);
    $this->save($img_info[1][2], $img_rel);
    //关闭图像资源
    if(isset($img_rel)) {
      imagedestroy($img_rel);
    }
    if(isset($img_info[0])) {
      imagedestroy($img_info[0]);
    }
    return $this->new_img;
  }

//缩略图像结束
  //给参数赋值的私有方法
  private function set_value($key, $v) {
    $this->$key = $v;
  }

//赋值结束
  //判断用户操作的方法,设置高宽比
  private function makeCut() {
    if($this->img_w <= $this->new_w && $this->img_h <= $this->new_h) {
      $this->new_w = $this->img_w;
      $this->new_h = $this->img_h;
    }
    elseif(!empty($this->cut) && $this->cut > 0) {
      switch($this->cut) {
        //宽度不变，高度自增,缩略图的高度等于缩略图的宽除以原图宽乘以原图高，得到的是缩略图的高度
        case '1':$this->new_h = $this->new_w / $this->img_w * $this->img_h;
          break;
        //高度不变，宽度自增，原理同上
        case '2':$this->new_w = $this->new_h / $this->img_h * $this->img_w;
          break;
        //宽度不变，高度按比例裁切
        case '3':$this->img_h = $this->img_w / $this->new_w * $this->new_h;
          break;
        //高度固定，宽度等比裁切
        case '4':$this->img_w = $this->img_h / $this->new_h * $this->new_w;
          break;
        //按比例缩放
        case '5':
          if(($this->img_w / $this->new_w) > ($this->img_h / $this->new_h)) {
            $this->new_h = $this->new_w / $this->img_w * $this->img_h;
          }
          elseif(($this->img_w / $this->new_w) < ($this->img_h / $this->new_h)) {
            $this->new_w = $this->new_h / $this->img_h * $this->img_w;
          }
          else {
            return;
          }break;
      }
    }
  }

  //获取比较文件类型
  private function type($img) {
    //后缀文件名
    $type     = array(".jpg", ".jpeg", ".pjpeg", ".png", ".gif");
    //获得文件后缀名，strrchr是按点取'.'后最后的值
    $img_type = strtolower(strrchr($img, '.'));
    //如果GD库打开，并且文件存在，且文件类型符合条件，则返回
    if(extension_loaded('gd') && file_exists($img) && in_array($img_type, $type)) {
      return $img_type;
    }
    else {
      return FALSE;
    }
  }

  //打开图片，创建源图片资源
  private function img_rel($img) {
    $img_info = getimagesize($img);
    //建立图像资源
    switch($img_info[2]) {
      case 1:
        //echo '打开的是gif图片'.'<br />';
        $made_img = imagecreatefromgif($img);
        break;
      case 2:
        //echo '打开的是jpg图片'.'<br />';
        $made_img = imagecreatefromjpeg($img);
        break;
      case 3:
        //echo '打开的是png图片'.'<br />';
        $made_img = imagecreatefrompng($img);
        break;
    }
    return array($made_img, $img_info);
  }

  //获取新文件名及路径
  private function path($img) {
    //取得传入文件的绝对路径
    $path = explode('.', $img);
    //给文件名加上后标识
    $path[count($path) - 2].=$this->new_img;
    //重新组成新的文件路径
    for ($i = 0; $i < count($path) - 1; $i++) {
      $new_path.=$path[$i].'.';
    }
    //给文件附上文件类型后缀
    $new_path.=$path[$i];
    //返加新路径
    return $new_path;
  }

  //根据文件类型保存图片的方法
  private function save($value, $img_rel = array()) {
    switch($value) {
      //当为1时，保存为gif;
      case 1:imagegif($img_rel, $this->new_img);
        break;
      //当为2时，保存为jpeg
      case 2:imagejpeg($img_rel, $this->new_img);
        break;
      //当为3时，保存为png
      case 3:imagepng($img_rel, $this->new_img);
        break;
    }
  }

}

//类结束   
?>