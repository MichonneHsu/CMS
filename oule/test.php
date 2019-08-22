<?php

$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect");

$version = $memcache->getVersion();
echo "服务端版本信息: ".$version."<br/>\n";

$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;
$tmp_object->aa=333;

$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
//echo "将数据保存到缓存中（数据10秒后失效）<br/>\n";

$get_result = $memcache->get('key');
echo "从缓存中取到的数据:<br/>\n";

var_dump($get_result);

?>