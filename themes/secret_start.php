<?php

    //初始化程序，并从 app class conf 这四个文件夹中，引入相应的文件
    $dir = array('app','class','conf');
    //开始按文件夹顺序扫描文件
    for ($i = 0; $i < count($dir); $i++) {
        $files = scandir(ROOT . DS . "$dir[$i]");

        //按扫描到的文件，加载程序文件
        for ($n = 0; $n < count($files); $n++) {
            if (strtolower(strrchr($files[$n], '.')) == '.php') {
                include_once $dir[$i] . DS . $files[$n];
            }
        }
    }


    //分析网址，获取传参
    $request = new path();
    $rel = $request->set_path();

    
    //如果网址带有有参数
    if($rel[0]){

        //网址的格式为   /控制器/参数1-参数2-参数3-参数4/控制器/参数1-参数2-参数3-参数4/
        //提取第一个传参，读取控制器名称，并检测其合法性

        //$action 保存为第一个执行的控制器
        $action = array_shift($rel).'_App';

        //如果不是一个正确的控制器，则输出一个1号错误；并返回
        if(class_exists($action)){
            $app = new $action($rel);
            return;
        }else{
            $err = new error_App(1);
            return false;
    }
}

    //加载主页
    new home_App();