@extends('layouts.app')

@section('content')	
<div class="container top-center">
    <div class="row title justify-content-center">
		<div class="card border-light" style="width: 50rem">
			<?php
			
			$isAuth = Auth::check() && $authorAddress == Auth::user()->name;
			$isAuthJ = 0;
			if(!is_null($postData->coverImg))
			{
				echo '<img class="card-img-top" src="data:image/jpg; base64, '.base64_encode($postData->coverImg).'" alt="Card image cap"/>';				
			}
			echo '<div class="card-body">';
			echo 	'<div class="row links">';
			echo 		'<h2 class="card-title col-md-8 text-md-left text-body article" id = "Title_str" name = "Title_str">'.$postData->title.'</h2>';
			echo		'<div class="col-md-4 text-md-right links">';
			echo 			'<a href="/laravel/blog/public/'.$authorAddress.'">'. $authorAddress .'</a>';
			echo		'</div>';
			echo	'</div>';
			echo 	'<h5 class="col-md-12 card-text text-body text-md-left article">'.$postData->article.'</h5>';

			$updated_at = explode(" ",$postData->updated_at);
			echo 	'<h6 class="text-md-right text-body article">'.$updated_at[0].'</h6>';

			if($isAuth)
			{	
			echo 	'</br>';
			echo	'<div class = "text-md-right row">';
			echo		'<div class="col-md-1 offset-md-9">';
			echo 			'<a class = "btn btn-outline-danger text-danger title" href=" '.route('deleteArticle',['authorAddress' => $authorAddress, 'id' => $postData->id ]).'">Delete</a>';
			echo		'</div>';
			echo		'<div class="col-md-2">';
			echo 			'<a class = "btn btn-outline-primary text-primary title" href=" '.route('modifyArticle',['authorAddress' => $authorAddress, 'id' => $postData->id ]).'">Modify</a>';
			echo		'</div>';
			echo 	'</div>';
			$isAuthJ = 1;
			}
			//echo '</div>';
			?>
		</div>

<!--發表評論區-->

<!--form method="POST" action="{{ route('deleteComment' , ['authorAddress' => $authorAddress , 'id' => $postData->id])}}"  enctype="multipart/form-data"-->
<!--form id = "commentForm" action="" method="POST"-->
		<hr/>
		<div class="form-group row title">
			<label class="col-md-2 col-form-label offset-md-1 text-md-right"  for="comment_str">Comment</label>
			<div class="col-md-8">
				<textarea class="input_title col-form-label form-control article" id="comment_str" name="comment_str" rows="10" cols="15" style="vertical-align: top"></textarea>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-md-2 col-form-label offset-md-1 text-md-right" for="commentName_str">Name</label>
			<div class="col-md-8">
				<input class="input_title form-control article" type="text" id="commentName_str" name="commentName_str" size="40" style=" vertical-align:top"></input>
			</div>
		</div>
		
		<!--div class="form-group row">
			<div class="col-md-12 text-md-right">
				<button class="btn btn-outline-success title" type="submit">Post Comment</button>
			</div>
		</div-->
		<div id="comment">
		</div>
	<!--/form-->
	</div>
</div>
<script type="text/babel">

	var commentData = null;
	var fackId = -1;
	class ShowComment extends React.Component{
				
		constructor(props) {
			super(props);
			commentData = <?php 
			if(is_null($commentData))
			{
				$commentData = array();
			}
			//error_log(print_r($commentData, TRUE));
			echo $commentData;
			?>;
			this.state = ({commentDataList : commentData});
		}
		
		update()
		{
			var date = new Date();
			var dateFormat = new Intl.DateTimeFormat('en-US',
			{year: 'numeric',
			 month: 'numeric',
			 day: 'numeric',
			 hour: 'numeric',
			 minute: 'numeric',
			 second: 'numeric'
			});
			
			var newId = 0;
			if(commentData.length !=0)
			{
				//console.log(commentData[commentData.length-1]['id']);
				//console.log(commentData['0']['id']);
				newId = commentData[commentData.length-1]['id']+1;
			}
			
			//console.log(dateFormat.format(date));
			//console.log(commentData.length-1);
			// var newCommentData = [{
			// id : newId,
			// article_id: <?php echo $postData->id?>,
			// comment: document.getElementById('comment_str').value,
			// name:document.getElementById('commentName_str').value, 
			// created_at: dateFormat.format(date) }];
			
			// commentData = [...commentData,...newCommentData];
			//fackId--;
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$.ajax({
				url:"{{route('postComment', ['authorAddress' => $authorAddress, 'id' => $postData->id])}}",       // 要傳送的頁面
				method: 'POST',               // 使用 POST 方法傳送請求
				dataType: 'json',             // 回傳資料會是 json 格式
				//data: $('commentForm').serialize(),  // 將表單資料用打包起來送出去
//				data: {"commentName_str": newCommentData[0]['name'] , 
//					   "comment_str": newCommentData[0]['comment'], 
				data: {"commentName_str": document.getElementById('commentName_str').value , 
					   "comment_str": document.getElementById('comment_str').value, 
					   "authorAddress": "<?php echo $authorAddress?>",
					   "id": "<?php echo $postData->id?>",
					   "commentID":newId},
				success: function(newCommentData){			//成功以後會執行這個方法
					//console.log('OK?');
					//console.log(postData[0]['comment']);
					
					for(var i=0; i < newCommentData.length;i++)
					{	
						//console.log(newCommentData[i]);
						
						var newElement = [{
						id : newCommentData[i]['id'],
						article_id: newCommentData[i]['article_id'],
						comment: newCommentData[i]['comment'],
						name: newCommentData[i]['name'], 
						created_at: newCommentData[i]['created_at'] }];

						commentData = [...commentData,...newElement]
					}
					
					this.setState({commentDataList : commentData});
					
					
					//this.forceUpdate();
				}.bind(this)
			});	

	
		}
		
		handleClick()
		{
			this.update();
		}
		
		render(){
			
			var isAuth = <?php echo $isAuthJ?>;
			var articleID = <?php echo $postData->id?>;
			var commentItems = null;
			
			if(isAuth)
			{
				commentItems = commentData.map((d) => 
				<div class = "text-body article shadow-sm p-3 mb-5 bg-white rounded " key = {d.id}>
					<div class = "row">
						<div class="col-md-5 offset-md-1 text-md-left">
							<h6 class="article inline">{d.name}:</h6>
							<label></label>
						</div>
						<div class="col-md-5 text-md-right col-form-label">
							<a class="btn btn-outline-danger text-danger title inline" href= {"../../viewPage_d?commentID=" + d.id +"&id=" + articleID}>Delete</a>	
						</div>
					</div>
					<h6 class = "col-md-9 offset-md-2 text-md-left article"> {d.comment} </h6>
					<p class = "col-md-10 offset-md-1 text-md-right"> {d.created_at.split(' ')[0]}</p>
				</div>
				);
			}
			else
			{
				commentItems = commentData.map((d) => 
				<div class = "text-body article shadow-sm p-3 mb-5 bg-white rounded " key = {d.id}>
					<h6 class="article col-md-5 offset-md-1 text-md-left">{d.name}:</h6>
					<h6 class = "col-md-9 offset-md-2 text-md-left article"> {d.comment} </h6>
					<p class = "text-md-right col-md-10 offset-md-1"> {d.created_at.split(' ')[0]}</p>
				</div>
				);
			}
			
			document.getElementById('comment_str').value = document.getElementById('commentName_str').value = "";

			return(
				<div class="form-group ">
					<div class="row">
						<div class="col-md-11 text-md-right">
							<button class="btn btn-outline-success title" type="submit" onClick={(e) => this.handleClick(e)}>Post Comment</button>
						</div>
					</div>
					<br/>
					<hr/>
					{commentItems}

				</div>
			);
		}
	}
	
	ReactDOM.render(
		<ShowComment/> , document.getElementById('comment')
	);
  
</script>
					<!--div class="col-md-12 text-md-right">
						<button class="btn btn-outline-success title" type="submit" onClick={(e) => this.handleClick(e)}>Post Comment</button>
					</div-->
<!--
			if(isAuth)
			{
				commentItems = commentData.map((d) => 
				<div key = {d.id}>
				<p> {d.comment} </p>
				<p> {d.name} {d.created_at.split(' ')[0]} </p>
				<a href= {"../../viewPage_d?commentID=" + d.id +"&ID=" + articleID}>DELETE</a>						
				</div>
				);
			}
			else
			{
				commentItems = commentData.map((d) => 
				<div key = {d.id}>
				<p> {d.comment} </p>
				<p> {d.name}{d.created_at.split(' ')[0]}</p>
				</div>
				);
			}
-->
@endsection