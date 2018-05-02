<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
	//'配置项'=>'配置值'
	'LANG_SWITCH_ON' => true,   // 开启语言包功能
	'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
	'DEFAULT_LANG' => 'zh', // 默认语言
	'LANG_LIST'        => 'zh,en', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE'     => 'lang', // 默认语言切换变量
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE' => 'Admin',
    'MODULE_DENY_LIST' => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => ';&WtiNr:=E6f{Q1)3s%.^cg@SFvw]l2JaYTy,L+I', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,

    /* 用户相关设置 */
    'USER_MAX_CACHE' => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL' => 3, //URL模式
    'VAR_URL_PARAMS' => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR' => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    /*'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '192.168.0.2', // 服务器地址
    'DB_NAME'   => 'ottest', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_DEBUG'    =>    true,*/
    'DB_PREFIX' => 'ot_', // 数据库表前缀
    'USER_API_PATH' => 'C:\config.php',
    'DATA_BASE' => 'C:\database.php',
    'CONFIG_PATH' => 'C:\configm.php',
    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),
	'PASS_WORD' => '123465',

 	'ALIOSS_CONFIG' => array(
        'KEY_ID' => 'LTAIfKjXA40GZ5du',
        'KEY_SECRET' => 'VVo4UK4Ogfwt7dwEnBAc6g7OXgq1u8',
        'END_POINT' => 'oss-cn-beijing.aliyuncs.com',
        'BUCKET' => 'gm-20180409-test'
     ),
);
