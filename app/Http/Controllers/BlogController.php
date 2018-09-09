<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class BlogController extends Controller
{
	protected $timestamps = true;
	
	public function __construct()
    {
        //$this->middleware('auth');
		//$this->middleware('guest')->except('logout');
    }

	
	// 顯示文章頁面，沒給ID就顯示最後一篇新PO的
	public function viewPage($authorAddress, $id = -1)
	{
		$commentData = null;
		if($id != -1)
		{
			$postData = DB::table($authorAddress)->where('id' ,'=', $id)->first();
		}
		else
		{
			$postData = DB::table($authorAddress)->orderBy('id','desc')->first();
		}
		
		$commentData = DB::table($authorAddress.'_c')->where('article_id' ,'=', $id)->get();
		
		return view('viewPage', ['postData' => $postData, 'authorAddress' => $authorAddress , 'commentData' => $commentData]);
	}
	
	// PO文
	public function postArticle(Request $request)
	{
		$authorAddress = Auth::user()->name;
		$imageData = null;
		if(!empty($_FILES['CoverImgInput']['tmp_name']))
		{
			$imageData = file_get_contents($_FILES['CoverImgInput']['tmp_name']);
		}

		DB::table($authorAddress)->insert(
			array(
				'title' => $request->Title_str,
				'article' => $request->Article,
				'coverImg'=> $imageData,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			)
		);
		return $this->viewPage($authorAddress);
	}
	
	// 刪文
	public function deleteArticle()
	{
		$authorAddress = $_GET['authorAddress'];
		$id = $_GET['id'];
		DB::table($authorAddress)->where('id' ,'=', $id)->delete();
		
		$HomeController = new HomeController();
		
		header('Location:/laravel/blog/public/home/');
		die;
	}
	
	// 進入修文頁面
	public function modifyArticle()
	{
		$authorAddress = $_GET['authorAddress'];
		$id = $_GET['id'];
		
		$postData = DB::table($authorAddress)->where('id' ,'=', $id)->first();

		return view('postPage', ['postData' => $postData]);
	}
	
	// 送出修文資訊
	public function sentmodifyArticle(Request $request)
	{
		$id = $_GET['id'];
		$authorAddress = Auth::user()->name;
		
		$updateInfo = array('title' => $request->Title_str, 
							'article' => $request->Article,
							'updated_at' => date('Y-m-d H:i:s'));
							
		DB::table($authorAddress)->where('id' ,'=', $id)->update($updateInfo);
		header('Location:/laravel/blog/public/viewPage/'.$authorAddress.'/'.$id);
		die;
	}
	
	// 留言
	public function postComment(Request $request)
	{
		$tableName = $_GET['authorAddress'].'_c';
		$id = $request->id;
		
		//error_log(print_r($request->id));
		
		DB::table($tableName)->insert(
			array(
				'article_id' => $id,
				'name' => $request->commentName_str,
				'comment' => $request->comment_str,
				'created_at' => date('Y-m-d H:i:s')
			)
		);
		//error_log(print_r($request->commentID,true));		
		$commentData = DB::table($tableName)->where('article_id' ,'=', $id)->where('id' , '>' ,$request->commentID-1)->get();
		//error_log(print_r($commentData,true));
		echo json_encode($commentData);
		//return $this->viewPage($_GET['authorAddress'], $id);
	}
	
	// 刪除留言
	public function deleteComment()
	{
		$authorAddress = Auth::user()->name;
		$commentID = $_GET['commentID'];
		$id = $_GET['id'];
		
		DB::table($authorAddress.'_c')->where('id' ,'=', $commentID)->delete();
		
		header('Location:/laravel/blog/public/viewPage/'.$authorAddress.'/'.$id);
		die;
	}
}