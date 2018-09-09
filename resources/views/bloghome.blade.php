@extends('layouts.app')

@section('content')
<div class="container top-center ">

	<?php
		// 有內容
		if(isset($articleData) && !is_null($articleData))
		{
			$wordNum = 100;
			foreach($articleData as $data)
			{
				echo '<div class="shadow-sm p-3 mb-5 bg-white rounded col-md-8">';
				echo '<div class="row">';
				echo 	'<div class = "col-md-6  text-md-left">';
				echo 		'<p class="title">'.$data->title.'</p>';
				echo	'</div>';
				echo 	'<div class = "col-md-6 text-md-right">';
				echo		'<p class="title">'.explode(" ",$data->created_at)[0].'</p>';
				echo	'</div>';
				echo '</div>';
				
				echo '<div class="row">';
				echo 	'<div class="col-md-10 offset-md-1 text-md-left">';
				echo		'<h4 class="article breakWord">'.mb_substr($data->article,0,$wordNum,"utf-8");
				if(strlen($data->article) > $wordNum)
				{
					echo '......';
				}
				echo 		'</h4>';
				echo	'</div>';
				echo '</div>';
				
				echo '<div class="row">';
				echo 	'<div class="col-md-12 text-md-right">';
				echo 		'<a class="btn btn-outline-primary text-primary title" href="/laravel/blog/public/viewPage/'.$authorAddress.'/'.$data->id.'">Read more</a>';
				echo 	'</div>';
				echo '</div>';
				echo '</div>';
				//echo '<br/>';
				//echo '<br/>';
			}
		}
		// 沒內容
		else
		{
			echo '<div class="content flex-center full-height">';
			echo	'<div class="header m-b-md">BLOG</div>';
			echo '</div>';
		}
	?>
</div>
@endsection