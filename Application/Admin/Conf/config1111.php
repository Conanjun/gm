<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.thinkphp.cn>
// +----------------------------------------------------------------------

/**
 * 前台配置文件
 * 所有除开系统级别的前台配置
 */
return array(
    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX' => 'onethink_', // 缓存前缀
    'DATA_CACHE_TYPE' => 'File', // 数据缓存类型

	'CKPATH' => './ckfinder/userfiles/images/',
    /* 文件上传相关配置 */
    'DOWNLOAD_UPLOAD' => array(
        'mimes' => '', //允许上传的文件MiMe类型
        'maxSize' => 500 * 1024 * 1024, //上传的文件大小限制 (0-不做限制)
        'exts' => '', //允许上传的文件后缀 jpg,gif,png,jpeg,bmp,icon,zip,rar,tar,gz,7z,doc,docx,txt,xml,ppt,pdf,xls,xlsx,pptx,log,pdm,avi,rmvb,mp4,mp3,ogg,wps
        'autoSub' => true, //自动子目录保存文件
        'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => '../Uploads/Download/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '', //文件保存后缀，空则使用原后缀
        'replace' => false, //存在同名是否覆盖
        'hash' => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //下载模型上传配置（文件上传类配置）

    /* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
        'mimes' => '', //允许上传的文件MiMe类型
        'maxSize' => 2 * 1024 * 1024, //上传的文件大小限制 (0-不做限制)
        'exts' => 'jpg,gif,png,jpeg,bmp', //允许上传的文件后缀
        'autoSub' => true, //自动子目录保存文件
        'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => '../Uploads/Picture/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '', //文件保存后缀，空则使用原后缀
        'replace' => false, //存在同名是否覆盖
        'hash' => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    'PICTURE_UPLOAD_DRIVER' => 'local',
    //本地上传文件驱动配置
    'UPLOAD_LOCAL_CONFIG' => array(),
    'UPLOAD_BCS_CONFIG' => array(
        'AccessKey' => '',
        'SecretKey' => '',
        'bucket' => '',
        'rename' => false
    ),
    'UPLOAD_QINIU_CONFIG' => array(
        'accessKey' => '__ODsglZwwjRJNZHAu7vtcEf-zgIxdQAY-QqVrZD',
        'secrectKey' => 'Z9-RahGtXhKeTUYy9WCnLbQ98ZuZ_paiaoBjByKv',
        'bucket' => 'onethinktest',
        'domain' => 'onethinktest.u.qiniudn.com',
        'timeout' => 3600,
    ),


    /* 编辑器图片上传相关配置 */
    'EDITOR_UPLOAD' => array(
        'mimes' => '', //允许上传的文件MiMe类型
        'maxSize' => 2 * 1024 * 1024, //上传的文件大小限制 (0-不做限制)
        'exts' => 'jpg,gif,png,jpeg', //允许上传的文件后缀
        'autoSub' => true, //自动子目录保存文件
        'subName' => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => '../Uploads/Editor/', //保存根路径
        'savePath' => '', //保存路径
        'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt' => '', //文件保存后缀，空则使用原后缀
        'replace' => false, //存在同名是否覆盖
        'hash' => true, //是否生成hash编码
        'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ),

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/static',
        '__ADDONS__' => __ROOT__  . MODULE_NAME . '/Addons',
        '__IMG__' => __ROOT__  . MODULE_NAME . '/images',
        '__CSS__' => __ROOT__  . MODULE_NAME . '/css',
        '__JS__' => __ROOT__  . MODULE_NAME . '/js',
        '__THEME__' => __ROOT__ . MODULE_NAME . '/theme',
        '__JSNEW__' => __ROOT__  . MODULE_NAME . '/jsnew',
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'onethink_admin', //session前缀
    'COOKIE_PREFIX' => 'onethink_admin_', // Cookie前缀 避免冲突
    'VAR_SESSION_ID' => 'session_id',    //修复uploadify插件无法传递session_id的bug

    /* 后台错误页面模板 */
    'TMPL_ACTION_ERROR' => MODULE_PATH . 'View/Public/error.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => MODULE_PATH . 'View/Public/success.html', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE' => MODULE_PATH . 'View/Public/exception.html',// 异常页面的模板文件
    'TMPL_AUTH_FILE' => MODULE_PATH . 'View/Public/auth.html',// 异常页面的模板文件
    /*URL模式*/
    /*'URL_MODEL'             =>  1,                            // 为了兼容性更好而设置成1 如果确认服务器开启了mod_rewrite 请设置为 2
    'URL_CASE_INSENSITIVE'  =>  false,                        // 区分url大小写
    'URL_HTML_SUFFIX' =>'',*/
    
    //打印web模板地址
    'REVIEW_PRINT_URL' => 'http://27.223.89.54:7002/index.php?s=/Admin/Other/view1/id/',
    'OFFER_PRINT_URL' => 'http://27.223.89.54:7002/index.php?s=/Admin/Other/printpage/id/',
    'E_PRINT_URL' => 'http://27.223.89.54:7002/index.php?s=/Admin/Other/eprintpage/id/',

    //扫码登录相关
    'RCODE_SUC_URL' => 'http://27.223.89.54:7002/index.php?s=/Admin/Public/rcodelogin/',
    'DXY_RCODE_URL' => 'https://simuat.dxy.cn/japi/sso/login/scan/data?callback=login_call_back&appId=1690837270&service=',
    'DXY_CHECK_URL' => 'https://simuat.dxy.cn/japi/sso/scan/check/',
    'DXY_TICKET_URL' => 'https://simuat.dxy.cn/japi/open/sso/scan/validate',
    'DXY_RCODE_APPID' => '1690837270',
    'DXY_RCODE_KEY' => 'elhauOCTfw1iWJARWAqOSF8cY9Mq4fRlyRJUUsHql1tKAZ6nHxTHMY42XlpmvjL5KmqdNDhu6pyyu4N4OXvbbuja4mWMCTzlfj8QtOzchals8IFAL9wCpzvBRXQb5zFP',
    
    //验证用户
    'DXY_S_URL' => 'https://simuat.dxy.cn/japi/open/qiye/message/conditions/autocomplete',
    'DXY_S_APPID' => '1902020386',
    'DXY_S_KEY' => 'XpmgECytVNVgbJ3IDAkHS7UJAQQHqMZ4BHbhXCqbvCUpjqsWuFRaZQ4uZwDcRdtkEcpgJUNDf539gyvdWjerH4uHwfFTPx5cIY0YDkMnp1HhlYKzwyrjqHqvwC2tdPQN',
    
    //自动添加用户初始化密码
    'INI_PWD' => 'dxy160@$^',
    
    //jodconverter路径
    'JOBPATH' => 'C:\jodconverter-2.2.2\lib\jodconverter-cli-2.2.2.jar', ///opt/jodconverter-2.2.2/lib/jodconverter-cli-2.2.2.jar
    
    // OA系统
    'DXY_OA_APPID' => '1921234318',
    'DXY_OA_KEY' => 'hQxRutD2nrrFxAJIhmsZwSIoHJmr6YVxyk8vYXbt9S3EcLaXlYGTkcVisvxjwkCjL4VnNzF8tHPAI5YqPzGqMSksiVDlfIZuSHGApEKbkWo9YBphk8mjZ2SqNbRsyvE2',
    'DXY_OA_URL' => 'https://oaqa.dxy.net/dxyoa/do/add-cost', // 目前是测试地址   
    'DXY_OA_COST_TYPES_URL' => 'https://oaqa.dxy.net/dxyoa/do/cost-types',  // 获取费用类型信息
    'DXY_OA_COST_SUB_URL' => 'https://oaqa.dxy.net/dxyoa/do/cost-subtypes', // 获取费用类型二级分类信息
    
    // CRM
    'DXY_CRM_APPID' => '1973533032',
    'DXY_CRM_KEY' => 'UfL54PXgp2HqpioJMWURfqxDKdJo61c7E7N7v0ERliVaEcH6FFcTmlmx7G3WI7lqHPpW5bomPhdCA4eKCEK2xAERSl7IXc19ETia0rx81gcJz9EIE9Mhoive8LMNXFNF',
    'DXY_CRM_URL_OPPORTUNITY' => 'https://ecrmtest.dxy.net/api/api_opportunity.php',
    'DXY_CRM_URL_OFFER' => 'https://ecrmtest.dxy.net/api/api_offer.php',
    'DXY_CRM_URL_CONTRACT' => 'https://ecrmtest.dxy.net/api/api_contract.php',
    'PDF_PATH' => 'http://127.0.0.1:8090',
);
