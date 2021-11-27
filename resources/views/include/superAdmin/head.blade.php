<!--begin::Head-->

<head>
	<base href="">
	<meta charset="utf-8" />
	<title>TMS - @yield("page_title")</title>
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<!-- select2 -->

	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- end select2 -->
	<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />

	<link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/nprogress-master/nprogress.css" rel="stylesheet" type="text/css" />
	<link href="/fonts/cairo/cairo.css" rel="stylesheet" type="text/css">
<link href="{{ asset('backend_assets/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">

	<style>
		select {
			text-align-last: center !important;
			padding-bottom: 3px !important;
		}
		.select2-search__field{
			outline: none!important;

		}
		.select2-container--default .select2-search--dropdown .select2-search__field{
			border: 1px solid #5897fb!important;
		}
		.dt-buttons{
			margin-top:5px !important;
		}
		.select2-selection__arrow{
			padding-top: 9px !important;
			padding-right: 5px !important;
		}
		.select2-selection__rendered{
			padding-top: 1px !important;
		}
	</style>




</head>

<style>
	body {

		direction: ltr;
		font-family: 'Cairo', sans-serif;
	}

	.btn-group-xs>.btn,
	.btn-xs {
		padding: .25rem .4rem;
		font-size: .875rem;
		line-height: .5;
		border-radius: .2rem;
	}

	.select2 {

		text-align: center;
	}

	.text-muted {

		color: #4d4d96 !important;
	}


	table.bb td,
	th {
		text-align: center;
		font-size: 14px !important;

	}

	#tblAjax_length {
		float: right !important;
		}


</style>

@yield('css')
<!--end::Head-->
