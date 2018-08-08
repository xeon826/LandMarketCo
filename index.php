<?php

	include_once('mysql.php');

	$mysql = new MySQL('localhost', 'root', 'Gdadg13531', 'lmc');
        // $this->sql = new mysqli('localhost', 'root', 'Gdadg13531', 'ivm');
	// get all posts
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
</head>
<body>
	<h1>hello</h1>
	<h1>hello</h1>
	<h1>hello</h1>
	<h1>hello</h1>
	<h1>hello</h1>
	<?php
	echo 'hello';
	try{
		$posts = $mysql->get('realtors');
		// print_r($posts);
		echo $mysql->num_rows; // number of rows returned
	}catch(Exception $e){
		echo 'Caught exception: ', $e->getMessage();
	}

	// get all post titles and authors
	try{
		$posts = $mysql->get('realtors', array('first', 'last'));
		// or
		$posts = $mysql->get('realtors', 'first,last');
		print_r($posts);
		echo $mysql->last_query(); // the raw query that was ran
	}catch(Exception $e){
		echo 'Caught exception: ', $e->getMessage();
	}

	// get one post
	try{
		$post = $mysql->limit(1)->get('realtors');
		print_r($post);
	}catch(Exception $e){
		echo 'Caught exception: ', $e->getMessage();
	}

	// get post with an id of 1
	try{
		// $post = $mysql->where('id', 1)->get('realtors');
		// or
		$post = $mysql->where(array('id', 1))->get('realtors');
		print_r($post);
	}catch(Exception $e){
		echo 'Caught exception: ', $e->getMessage();
	}

	// // get all posts by the author of "John Doe"
	// try{
	// 	$posts = $mysql->where(array('last' => 'John Doe'))->get('realtors');
	// 	print_r($posts);
	// }catch(Exception $e){
	// 	echo 'Caught exception: ', $e->getMessage();
	// }
	//
	// // insert post
	// try{
	// 	$mysql->insert('realtors', array('first' => 'New Title', 'middle' => 'post content', 'last' => 'Matthew Loberg'));
	// 	echo $mysql->insert_id(); // id of newly inserted post
	// }catch(Exception $e){
	// 	echo 'Caught exception: ', $e->getMessage();
	// }
	//
	// // update post 1
	// try{
	// 	$mysql->where('id', 1)->update('realtors', array('first' => 'New Title'));
	// }catch(Exception $e){
	// 	echo 'Caught exception: ', $e->getMessage();
	// }
	//
	// // delete post 1
	// try{
	// 	$mysql->where('id', 1)->delete('realtors');
	// }catch(Exception $e){
	// 	echo 'Caught exception: ', $e->getMessage();
	// }
	?>
</body>
</html>
