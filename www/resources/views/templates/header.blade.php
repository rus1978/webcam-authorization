<!doctype html>
<html lang="en" class="h-100">
<head>
    <title>{{ $title }} | Курсовая работа по ИИ Бондарь Р.В.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/app.css?<?=time()?>" rel="stylesheet">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/app.js?<?=time()?>"></script>
    <script type="text/javascript">
        var SETTINGS = {
        	'pageName' : '{{$pageName}}'
        }
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			}
		});
    </script>
</head>
<body class="d-flex h-100 text-center text-white bg-dark">

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">КР Бондарь Р.В.</h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link
                    @if ($pageName == 'home') active
                    @endif" href="/">Главная</a>
                <a class="nav-link
                    @if ($pageName == 'account') active
                    @endif" href="/account">Личный кабинет</a>
            </nav>
        </div>
    </header>