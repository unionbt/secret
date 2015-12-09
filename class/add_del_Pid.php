<?php
header("content-type:text/html;charset=utf-8");
session_start();

//这是一个增加，删除用户喜欢数，图片，预定，购买等数据库中用户指针的功能类

class add_del {

  //类成员
  //源数组  按’|‘分隔 增或是减信号 返回的类型 增或是减去的值
  private $contacts;  //操作人
  private $str;     //目标信息，目标值 可以是数组，如果是数组，则排列的方法详见不同用法里对数组的取值顺序
  private $where;     //源信息，改动的值
  private $act = array('addimg', 'delimg', 'addlike', 'dellike', 'addyd', 'delyd', 'addbuy', 'delbuy','addprod','delprod','show'); //功能数组
  private $action;       //动作行为信息，add?del?edit?show?所以，传入的值应该有操作人，动作，要操作的值地址及操作的值
  private $sql_link;    //数据据连接标识
  public $rel;          //用于数值暂存和对外访问
      
  function __construct($option = array()) {
    foreach ($option as $key=> $v) {
      $key = strtolower($key);
      if(!array_key_exists($key, $option)) {
        continue;
      }
      $this->$key = $v;
    }
    //判断用户行为
    $this->if_act();
  }

  //根据传入的动作指令，选择执行相应的程序
  function if_act() {
    if(in_array($this->action,$this->act)){
      echo '进入动作判断并成功'; // 调试用，调试完了可删除
      $in = $this->action;
      //根据session设置操作人信息
      $this->contacts=$_SESSION['name'];

      $this->sql_link = new mttop10_mysql(HOST, HOST_USER, HOST_PASS, mttop10);
      //取得用户信息
      $user_info = $this->sql_link->fn_read('vip_user','', "user_name='$this->contacts'");
      $this->$in($this->str,$user_info);
      return TRUE;
    }  else {
      return FALSE;
    }
  }

//判断动作方法结束
  //增加图像
  function addimg($str,$user) {
    //当增加一个图像时，需要增加图片数据库，在vip_user表中的图片字段增加新加入的图片ID指针
    //思路：首先获取一个数据库全局唯一id和图片的pid，然后，向图片数据表in_prod增加一个新的数据行，然后，将新的图片pid增加至$add_where相关的字段中，
    //示例：$upimg=new add_del(array('contacts'=>$user_name,'type'=>$img_type,'img'=>$a,'img_s'=>$b,'size'=>$c,'action'=>'addimg'));
    //$user_name  是根据session取得的值，img_type表示增加的图片是商品？还是个人头像？还是其它？$a表示图片处理后的路径，
    //$b表示缩略图路很，$c表示主图片大小，action=addimg表示需要操作本增加图片的方法
    //开始获取数据库全局id和pid,数据连接将在创建类之前就应完成
    $img_id  = $this->sql_link->fn_select_id('add_img');
    $this->sql_link->fn_inset('img_link','', "$img_id[id],$img_id[pid],'$user[user_pid]','$str[0]','$str[1]','$str[2]',$str[3]");
    $this->sql_link->closemysql($this->sql_link);
    $this->rel = $img_id;
  }
  
  function delimg($tbl,$pid){
    echo 'ok,is del the img';
    $this->sql_link->fn_del_info($tbl,$pid);
  }
  
  function addlike(){
    echo 'add the like';
  }
  
  function dellike(){
    echo 'dellike';
  }

  function addyd(){
    echo 'addyd';
  }
  
  function delyd(){
    echo 'delyd';
  }
  
  function addbuy(){
    echo 'addbuy';
  }
  
  function delbuy(){
    echo 'delbuy';
  }
  
  function addprod($str,$user){
    //增加一个商品信息
    $link = $str[link];
    //获取全局id
    $prod_id = $this->sql_link->fn_select_id('add_prod');
    $this->sql_link->fn_inset('in_prod','',"$prod_id[id],$prod_id[pid],$user[user_pid],$str[phone],'$str[contacts]','$str[where]',"
        . "'$str[pid]','$str[name]','$link','$str[type]','$str[miss]','$str[face]','$str[face_hl]','$str[liliao]','$str[liliao_hl]',"
        . "'$str[ps]',0,0,'$str[dq]','$str[td]','$str[menny]',1,now(),'$str[like]','$str[yd]',0,now(),0,now(),0,now(),0,0,0,0,0,0,0");
    
  }
  
  function delprod(){
    
  }
      
  function show(){
    
  }
}


?>