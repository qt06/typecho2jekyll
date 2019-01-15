<?php
/**
* 用于将 typecho 的数据转换成 jekyll 支持的格式
* @author: 杨永全
* @website: http://www.qt06.com/
* @email: qt06.com@gmail.com
* @date: 2019-01-11
*
*/

//要求 php 版本 至少在 5.4
if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	exit('your php version is too lower.');
}

include 'functions.php';
include 'Medoo.php';
$dbconf = include 'db_conf.php';
use Medoo\Medoo;
$db = new Medoo($dbconf);

echo "begin\r\n";
$metas = $db->select('metas','*',[]);
$metas = array_arrangement_by_column($metas, 'mid');
$contents = $db->select('contents', '*', []);
foreach($contents as $ct) {
	$categories = [];
	$tags = [];
	$rs = $db->select('relationships', '*', ['cid'=>$ct['cid']]);
	foreach($rs as $r) {
		if($metas[$r['mid']]['type'] == 'category') {
			$categories[] = $metas[$r['mid']]['name'];
		}
		if($metas[$r['mid']]['type'] == 'tag') {
			$tags[] = $metas[$r['mid']]['name'];
		}
	}
	$ct['categories'] = empty($categories) ? '' : implode(', ', $categories);
	$ct['tags'] = empty($tags) ? '' : implode(', ', $tags);
	$author = $db->get('users', '*', ['uid'=>$ct['authorId']]);
	$ct['author'] = $author['screenName'];
	$ct['text'] = str_replace('<!--markdown-->', '', $ct['text']);
	generate_post($ct);
}
echo 'all done.';
