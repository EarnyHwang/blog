<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		$tableName = $data['name'];
		// 檢查是否已註冊，沒有的話開一張他的文章列表
		$hasTable = Schema::hasTable($tableName);
		
		if($hasTable == False)
		{	
			DB::statement('CREATE TABLE '. $tableName .'(
							id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							title VARCHAR(256) NOT NULL,
							article LONGTEXT NOT NULL,
							coverImg LONGBLOB,
							created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
							updated_at TIMESTAMP NULL
							) CHARACTER SET=utf8');
							
			$tableName = $tableName.'_c';
			
			DB::statement('CREATE TABLE '. $tableName .'(
							id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							article_id INT UNSIGNED,
							comment LONGTEXT NOT NULL,
							name VARCHAR(256),
							created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
							) CHARACTER SET=utf8');
		}
		
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
