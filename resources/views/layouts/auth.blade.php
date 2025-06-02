
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ $title }}</title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="{{ asset('icon/pavicon.png') }}" />
    @include('layouts._partials.head')
    @yield('style')

	</head>

	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center vh-100 d-flex justify-content-center align-items-center">
    <div id="kt_app_root" class="container">
			<style>body { background-image: url('{{ asset('assets/media/auth/bg10.jpeg') }}'); } [data-bs-theme="dark"] body { background-image: url('{{ asset('assets/media/auth/bg10-dark.jpeg') }}'); }</style>
			<div class="d-flex flex-column flex-lg-row  justify-content-center">
				
				@yield('content')

			</div>
		</div>
		
    @include('layouts._partials.alert')
    @include('layouts._partials.foot')
    <!--begin::Vendors Javascript(used for this page only)-->
    @yield('script')
	</body>
</html>