?php
return array(
  'APP_DEBUG' => false, //开启调试模式
	'APP_FILE_CASE' => true,   // 是否检查文件的大小写 对Windows平台有效
	'URL_CASE_INSENSITIVE' =>true,
	'DEFAULT_THEME' => 'default',	// 默认模板主题名称
	// 定义数据库连接信息
	'DB_TYPE'=>'mysql',// 指定数据库是mysql
	'DB_HOST'=>'127.0.0.1', // 数据库名
	'DB_NAME'=>'piapiapai', // 数据库名
	'DB_USER'=>'root',
	'DB_PWD'=>'111111', //您的数据库连接密码
	'DB_PREFIX'=>'p_',//数据表前缀
	'DB_CHARSET'=>	'utf8',
	'TMPL_CACHE_ON' => false, //关闭缓存
	'TMPL_L_DELIM'=>'{',
	'TMPL_R_DELIM'=> '}',
	'COOKIE_EXPIRE'=> 43200,    // Coodie有效期
	'COOKIE_H_EXPIRE'=> 0,
	'PAGE_ROLLPAGE'=> 10,
	'URL_ROUTER_ON'=> false,		
	'DEFAULT_MODULE' =>	'Home',
    'SESSION_AUTO_START'=>true,
    'APP_AUTOLOAD_PATH'=>'@.TagLib,@.ORG',
    'TOKEN_ON'  => false,

    'SHOW_PAGE_TRACE'=>false,
    
    'URL_MODEL' => '1'
);

?> 