<?php

//引入添加水印的配置文件，当文件准备上传之前，添加水印
  include 'thumd.class.php';

//这是一个文件上传操作的类
//功能：1、指定上传路径
//     2、限定上传的文件类型为txt,jpg,png,gif
//     3、限制文件大小
//     4、使用限机文件名
//header("content-type:text/html;charset=utf-8");
  class fileupload {

    //初始化
    private $defaultpath = '../db/user/';  //存储文件的默认路径
    private $filepath;        //根据用户名设置的路径
    private $filetype = array('jpg', 'jpeg', 'pjpeg', 'gif', 'png', 'txt', 'rtf');  //允许上传的文件类型
    private $maxsize = 1000000; //文件大小
    private $setname = true;    //随机文件名
    private $upfilename;      //上传的源文件名
    private $tmpfilename;     //临时文件名
    private $upfiletype;      //上传的文件类型
    private $foldertype;      //存放的文件夹分类是哪里？img?text？
    private $upfilesize;      //上传的文件大小
    private $newfilename;     //新文件名
    private $newpath;         //新路径
    private $err_num = 0;     //错误信号
    private $err_sms;         //错误信息
    private $type;            //设置文件类型状态，决定返回什么信息
    private $new_file_info;   //返回的暂存值

    //构造涵数,传入一个数组参数

    function __construct($option = array()) {
      foreach ($option as $key=> $v) {
        //将传入的字符串$key的值变成小写，以匹配
        $key = strtolower($key);
        //查看传进来的数组中的下标是否符合涵数参数名，如果有，就赋值，否则不赋值；
        if(!array_key_exists($key, get_class_vars(get_class($this)))) {
          continue;
        }
        $this->set_value($key, $v);
      }
    }

    //给参数赋值的私有方法
    private function set_value($key, $v) {
      $this->$key = $v;
    }

    //检查路径是否合法
    private function checkfilepath() {
      //设置文件路径，新的文件存储路径等于默认的文件路径+用户名+类型
      $this->newpath = $this->defaultpath.$this->filepath.'/'.$this->foldertype;
      //如果用户路径为空
      if(empty($this->newpath)) {
        //返回路径错误
        $this->err_num = '-5';
        return FALSE;
      } else if(!file_exists($this->newpath) || !is_writable($this->newpath)) {
        //如果指定了路径或路径不存在，则创建目录;通常有多级目录情况发生，需要调用创建目录的涵数create_folders;
        if(!self::create_folders($this->newpath)) {
          $this->err_num = '-4';
          return FALSE;
        }
        return TRUE;
      }
      return TRUE;
    }

    //检查文件类型
    private function checkfiletype() {
      //检查文件类型，遍历类型变量数组
      foreach ($this->filetype as $key=> $v) {
        //如果找到，判断是哪一个
        if($this->upfiletype == $v) {
          //如果找到的值下标小于5，即为图像类，将文件存入文件图片中
          if($key < 5) {
            $this->foldertype = 'img';
            $this->type = TRUE;
          } else {
            //否则是文档类，存入文档路径中
            $this->type = FALSE;
            $this->foldertype = 'txt';
          }
          return TRUE;
        }
      }
      //如果没有找到，则返回文件类型为假，原调涵数会返回错误信息；
      $this->err_num = '2';
      return FALSE;
    }

//检查文件结束
    //检查文件大小
    private function checkfilesize() {
      //如果上传的文件大小大于设置的允许上传的文件大小，则返回错误信息；此时要注意php.ini中的最高限值；upload_max_size的值;
      if($this->upfilesize > $this->maxsize) {
        $this->err_num = '2';
        return FALSE;
      } else {
        return TRUE;
      }
    }

//检查文件大小结束
    //检查是否随机文件名
    private function checksetname() {
      //如果随机文件名信号为真
      if($this->setname) {
        //新的文件名等于时间+100-999内的随机数;
        date_default_timezone_set('PRC');
        $this->newfilename = date("YmdHms").rand(100, 999);
        //给文件按原类型加后缀名;注意要加点
        $this->newfilename = $this->newfilename.'.'.$this->upfiletype;
        //返回含有类型的新文件名
        return $this->newfilename;
      } else {
        //否则随机文件名信号为假，则上传的文件名等于新文件名
        $this->newfilename = $this->upfilename;
        //返回新文件名
        return $this->newfilename;
      }
    }

//文件名设置结束
    //设置获取到的源文件信息
    private function setfiles($name = '', $tmp_name = '', $filesize = '', $err = 0) {
      //如果上传的文件过程发生错误信息，则返回错误，程序不向下执行
      $this->set_value("err_num", $err);
      if($this->err_num) {
        return FALSE;
      }
      //赋值文件名
      $this->set_value("upfilename", $name);
      //赋值临时文件名
      $this->set_value('tmpfilename', $tmp_name);
      //将文件名按'.'分隔，形成一个数组形式的存储，数组最后一个下标即为文件的类型，文件后缀名;
      $strtype = explode('.', $name);
      //取得上传的文件类型，即后缀名
      $this->set_value("upfiletype", strtolower($strtype[count($strtype) - 1]));
      //取得文件大小
      $this->set_value('upfilesize', $filesize);
      //如果赋值都成功，返回真;
      return TRUE;
    }

//读取文件信息结束
    //建立文件夹
    public static function create_folders($dir) {
      return is_dir($dir) or ( self::create_folders(dirname($dir)) and mkdir($dir, 0755));
    }

    ////////////////////////////
    //////////功能开始///////////
    ///////////////////////////
    //用于上传一个文件,主要的文件上传方法
    function upload($file) {
      $name = $_FILES[$file]['name'];
      $tmp_name = $_FILES[$file]['tmp_name'];
      $filesize = $_FILES[$file]['size'];
      $err = $_FILES[$file]['error'];
      $create_info = TRUE;  //状态控制信息
      
      //判断是否是多文件上传
      if(is_array($name)) {
        //如果是多文件，则错误信息也是数组形式的
        $errs = array();
        //判断数组有多长，进行for循环遍历，看看有没有错误
        for ($i = 0; $i < count($name); $i++) {
          //检查文件名，临时文件名，文件大小，和错误，如有有错误，则将错误信息保存到错误数组里，并返回false
          if($this->setfiles($name[$i], $tmp_name[$i], $filesize[$i], $err[$i])) {
            //检验图片类型，后缀名
            $this->checkfiletype();
            //检验图片大小和路径如果有错误就返回错误信息，没有则返回往层，并向下执行
            if(!$this->checkfilesize() || !$this->checkfilepath()) {
              //保存错误信息
              $errs[] = $this->upload_err();
              $create_info = FALSE;
            }
          } else {
            $err[] = $this->upload_err();
            return FALSE;
          }
          if(!$create_info) {
            $this->setfiles();
          }
        }//for循环遍历结束
        if($create_info) {
          for ($i = 0; $i < count($name); $i++) {
            if($this->setFiles($name[$i], $tmp_name[$i], $filesize[$i], $err[$i])) {
              $this->checksetname();
              $this->checkfilepath();
              if(!$copy = $this->copy_file()) {
                $errs[] = $this->upload_err();
                return FALSE;
              } else {
                
              }
            }
          }
          //返回一个保存有图片信息的二维数组信息
          return $this->new_file_info;
        }
        $this->err_sms = $errs;
        return $create_info;
      }
      //下面是单个文件上传的方法步骤
      else {
        if($this->setfiles($name, $tmp_name, $filesize, $err)) {
          if($this->checkfilesize() && $this->checkfiletype()) {
            $this->checkfilepath();
            $this->checksetname();
            if($this->copy_file()) {
              return $this->new_file_info;
            } else {
              $create_info = false;
            }
          } else {
            $create_info = false;
          }
        } else {
          $create_info = false;
        }
        if(!$create_info)
          $this->err_sms = $this->getError();
        return $create_info;
      }
    }

    function copy_file() {
      if(!$this->err_num) {
        //设置路径
        //检查文件路径最后有没有'/'，如果有，则先删除，再添加'/'，如果没有，则直接添加'/';
        $copypath = rtrim($this->newpath, '/').'/';
        //给文件路径加上文件名，形成完整的路径,存储路径为$this->filepath
        $copypath.= $this->newfilename;
        //复制文件--------开始上传动作
        if(@move_uploaded_file($this->tmpfilename, $copypath)) {
          //判断文件类型，如果文件类类型是图片，需要加水印关且创建缩略图，返回文件路径及文件大小
          if($this->type) {
            $water = new makeimg();
            $img_water = $water->add_water($copypath);
            $img_filer = $water->thumd_makeing($copypath);
            $this->new_file_info[] = array($img_water, $img_filer, $this->upfilesize);
            return TRUE;
          } else {
            $this->new_file_info[] = array($this->newpath, $this->upfilesize);
            return TRUE;
          }
        } else {
          $this->err_num = '-3';
          return FALSE;
        }
      } else {
        return FALSE;
      }
    }

    //用于获取上传后的文件名
    function get_filename() {
      return $this->newfilename;
    }

    //提取错误信息
    function get_err() {
      return $this->err_sms;
    }

    //当出现错误信息时
    function upload_err() {
      $str = "上传文件<font color='red'>{$this->upfilename}</font>时出错：";
      switch($this->err_num) {
        case 4: $str .= "没有文件被上传";
          break;
        case 3: $str .= "文件只被部分上传";
          break;
        case 2: $str .= "上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值";
          break;
        case 1: $str .= "上传文件超过了php.ini 中upload_max_filesize选项的值";
          break;
        case -1: $str .= "末充许的类型";
          break;
        case -2: $str .= "文件过大，上传文件不能超过{$this->maxsize}个字节";
          break;
        case -3: $str .= "上传失败";
          break;
        case -4: $str .= "建立存放上传文件目录失败，请重新指定上传目录";
          break;
        case -5: $str .= "必须指定上传文件的路径";
          break;
        default: $str .= "末知错误";
      }
      return $str.'<br>';
    }

  }

?>