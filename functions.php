<?php
function array_arrangement_by_column($array, $column) {
	$newarr = [];
	foreach($array as $arr) {
		$newarr[$arr[$column]] = $arr;
	}
	return $newarr;
}

function generate_post($post) {
	extract($post);
	$pt = "---\n";
	$pt.="layout:  " . ($type == 'post' ? 'post' : 'page') . "\n";
	$pt.="id:  $cid\n";
	$pt.="title:  \"$title\"\n";
	$pt.="slug:  \"$slug\"\n";
	if($type == 'post') {
		$pt.="categories:  \"$categories\"\n";
		$pt.="tags:  \"$tags\"\n";
		$pt.="permalink:  \"/archives/:slug.html\"\n";
		$pt.="author:  \"$author\"\n";
	}
		$pt.="date:  ".date("Y-m-d H:i:s", $created) . "\n";
	$pt.="---\n\n\n\n";
	$pt.=$text;
	$dest_file = $type == 'post' ? __DIR__.DIRECTORY_SEPARATOR."jekyll".DIRECTORY_SEPARATOR."_posts".DIRECTORY_SEPARATOR.date("Y-m-d", $created)."-$slug.md" : __DIR__.DIRECTORY_SEPARATOR."jekyll".DIRECTORY_SEPARATOR."$slug.html";
	file_put_contents($dest_file, $pt);
echo "$cid done\r\n";
}


