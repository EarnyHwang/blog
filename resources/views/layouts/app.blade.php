<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BLOG') }}</title>

    <!-- Scripts -->
    <script src ="{{ asset('js/app.js') }}" defer></script>
	<script src = "https://unpkg.com/react@16/umd/react.development.js"></script>
	<script src = "https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
	<script src = "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <!--link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"-->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
	<style>
		html, body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Raleway', sans-serif;
			font-weight: 100;
			height: 100vh;
			margin: 0;
		}

		.full-height {
			height: 100vh;
		}

		.flex-center {
			align-items: center;
			display: flex;
			justify-content: center;
		}

		.position-ref {
			position: relative;
		}

		.top-center {
			position: absolute;
			top: 50px;
		}
		
		.top-left {
			position: absolute;
			left: 10px;
			top: 18px;
		}
		
		.top-right {
			position: absolute;
			right: 10px;
			top: 18px;
		}
		
		.article{
			white-space: pre-line;
			letter-spacing: .15rem;
			font-weight: 600;
		}

		.content {
			text-align: center;
		}

		.header {
			font-size: 84px;
		}

		.links > a {
			color: #636b6f;
			padding: 0 25px;
			font-size: 14px;
			font-weight: 600;
			letter-spacing: .1rem;
			text-decoration: none;
			text-transform: uppercase;
		}
		
		.title{
			font-size: 12px;
			font-weight: 600;
			letter-spacing: .05rem;
			text-decoration: none;
		}

		.m-b-md {
			margin-bottom: 30px;
		}
		
		.inline
		{
			display: inline;
		}
		
		.hiddenInput
		{
			position: fixed;
			right: 100%;
			bottom: 100%;
		}
		
		.custom-file-upload {
			display: inline-block;
			padding: 6px 12px;
			cursor: pointer;
		}
		
		.breakWord{
			word-break: break-word;
		}
		
	</style>
</head>
<body>
    <div class="position-ref flex-center full-height" id="app">
		<div  class="container">

			<div class="top-left links flex-center">
				<a href="{{ url('/') }}">
					{{ config('app.name', 'Laravel') }}
				</a>
			</div>	
            <div class="top-right links flex-center">
				@auth
					<a href="{{ url('/postPage') }}">Post</a>
					<!-- 登出 -->
					<a href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
					</form>
					<?php
						echo '<label class="title">'.Auth::user()->name.'</label>';
					?>
				@else
					<a href="{{ route('login') }}">Login</a>
					<a href="{{ route('register') }}">Register</a>
				@endauth

            </div>

		<div class="content">
			<main class="py-4">
				@yield('content')
			</main>
		</div>
    </div>
</body>
</html>
