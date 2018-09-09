@extends('layouts.app')

@section('content')	

<div class="container top-center form-group">
	<?php
		echo '<form method="POST" action="';
		// 如果有餵文章進來表示是修文
		if(!empty($postData))
		{
			echo route('sentmodifyArticle', ['id' => $postData->id]);
		}
		// 不然就是PO文
		else
		{
			echo route('postArticle');
		}
		echo '"  enctype="multipart/form-data">';
	?>
	<!--form method="POST" action="{{ route('postArticle')}}"  enctype="multipart/form-data"-->
	@csrf

		<!--上傳圖片-->
		<div class = "row">

			<label class="col-md-1 text-md-right col-form-label title" for="Cover">Cover</label>

			<?php
			if(!empty($postData))
			{
				// 修文，已經有圖
				echo '<div class = "col-md-10 col-form-label">';
				echo 	'<img class="card-img-top" src="data:image/jpg; base64, '.base64_encode($postData->coverImg).'" alt="Card image cap"></img>';
				echo '</div>';
			}
			else
			{	
				// 新文章
				
				echo '<div class = "col-md-5 text-md-left col-form-label">';
				echo 	'<label for="CoverImgInput" class="custom-file-upload title btn-outline-success btn col-form-label">Upload</label>';
				echo 	'<input class = "hiddenInput" id="CoverImgInput" type="file"  name="CoverImgInput" targetID="CoverImg" accept="image/gif, image/jpeg, image/png" onchange="readURL(this)"/>';
				echo '</div>';
				echo '</div>';
				echo '<div class="row">';
				echo 	'<div class = "col-md-10 offset-md-1  text-md-left">';
				echo 		'<img class="card-img-top" id="CoverImg" name="CoverImg" src="">';
				echo 	'</div>';
				echo	'<br/>';
			}
			?>
		</div>
		<br/>
		<!--輸入標題-->
		<div class = "row">
			<label class="col-md-1 text-md-right col-form-label title" for="Title">Title</label>
			<div class="col-md-5">
			<?php
				echo '<input class="form-control article text-md-left" type="text" id="Title_str" name="Title_str" ';
				if(!empty($postData))
				{
					echo ' value = "'.$postData->title.'"';
				}
				echo '></input>';
			?>
			</div>
		</div>
		<!--文字內容-->
		<br/>
		<div class = "row">
			<label class="col-md-1 text-md-right col-form-label title" for="Article">Article</label>
			<div class="col-md-8">
				<textarea class="input_title text-md-left article form-control" id="Article" name="Article" rows="15" cols="40" style="vertical-align: top"><?php
					if(!empty($postData))
					{
						echo $postData->article;
					}
				?></textarea>
			</div>
		</div>
		<br/>
		<div class="form-group row">
			<div class="col-md-9 text-md-right">
				<button class="btn btn-outline-success title" type="submit" >
					{{ __('Post') }}
				</button>
			</div>
		</div>

		<script type="text/babel">

			function readURL(input){

				if(input.files && input.files[0]){
					
					var imageTagID = input.getAttribute("targetID");
					var reader = new FileReader();

					reader.onload = function (e) {
					   var img = document.getElementById(imageTagID);
					   img.setAttribute("src", e.target.result)
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			
			// function getValueByID(input_id)
			// {
				// var element = document.getElementById(input_id);
				// return element.value;
			// }
			
			// function display_alert()
			// {
				// alert("I am an alert box!!")
			// }

		</script>
	</form>
</div>	
@endsection
