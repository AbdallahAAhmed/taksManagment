	{{-- <link href="{{asset('assets/plugins/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" /> --}}
	{{-- <link href="{{ asset('assets/plugins/datatable/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
	{{-- <link href="{{ asset('assets/plugins/datatable/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}


	{{-- <style>
		.dataTables_wrapper .dataTables_info {
			float: right;
		}

		.dataTable th,
		.dataTables_wrapper .dataTable td {

			color: black !important;
			font-size: 13px !important;
		}


	</style> --}}


	<base href="">
	<meta charset="utf-8" />
	{{-- <title>@yield('bar_title')</title> --}}
	<meta name="description" content="Updates and statistics" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Vendors Styles(used by this page)-->
	<link href="{{ asset('backend_assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css') }}" rel="stylesheet"
		type="text/css" />
	<link rel="stylesheet" href="{{asset('backend_assets/css/bootstrap-timepicker.min.rtl.css')}}">
	<!--end::Page Vendors Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{ asset('backend_assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend_assets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('backend_assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="{{ asset('backend_assets/css/themes/layout/header/base/light.rtl.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('backend_assets/css/themes/layout/header/menu/light.rtl.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('backend_assets/css/themes/layout/brand/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend_assets/css/themes/layout/aside/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link href="{{ asset('backend_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend_assets/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
		type="text/css" />
	
	<link href="{{ asset('backend_assets/plugins/nprogress-master/nprogress.css') }}" rel="stylesheet" type="text/css" />
	
	<link rel="shortcut icon" href="{{ asset('backend_assets/media/logos/favicon.ico') }}" />
	<link href="{{ asset('backend_assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet"
		type="text/css" />
	<link rel="stylesheet" href="{{asset('backend_assets/css/sweetalert.css')}}">
	<link rel="stylesheet" href="{{asset("backend_assets/css/jquery-date-picker.css")}}">
	<link rel="stylesheet" href="{{asset("backend_assets/css/custom.css")}}">
	
	<style>
		.dt-buttons {
			float: left !important;
			margin-bottom: 10px;
		}
	
		td {
			text-align: center !important;
		}
	</style>
	
	<style>
		select {
			text-align-last: center !important;
			padding-bottom: 3px !important;
		}
	
		.select2-search__field {
			outline: none !important;
	
		}
	
		.select2-container--default .select2-search--dropdown .select2-search__field {
			border: 1px solid #5897fb !important;
		}
	
		.dt-buttons {
			margin-top: 5px !important;
		}
	</style>
	
	<style>
		select {
			text-align-last: center !important;
			padding-bottom: 3px !important;
		}
	
		.select2-search__field {
			outline: none !important;
	
		}
	
		#select2-active-container {
			padding-top: 4px !important;
		}
	
		.select2-container--default .select2-search--dropdown .select2-search__field {
			border: 1px solid #5897fb !important;
		}
	
		.dt-buttons {
			margin-top: 5px !important;
		}
	</style>
	
	</head>
	
	<style>
		body {
	
			direction: rtl;
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
	
	<style>
		.thumb {
			width: 180px;
			border-radius: 40px;
		}
	</style>
	
	<style>
		table.bb td,
		th {
			text-align: center;
		}
	
		.container-box {
			position: absolute;
			top: 0px;
			left: -1px;
	
			width: 100%;
			height: 100%;
			background-color: #000000db;
			z-index: 100;
			background: rgba(0, 0, 0, 0.4);
		}
	
		body {
			overflow-x: hidden;
		}
	
		.lds-ellipsis {
			display: inline-block;
			position: relative;
			width: 80px;
			height: 80px;
		}
	
		.lds-ellipsis div {
			position: absolute;
			top: 33px;
			width: 13px;
			height: 13px;
			border-radius: 50%;
			background: #fff;
			animation-timing-function: cubic-bezier(0, 1, 1, 0);
		}
	
		.lds-ellipsis div:nth-child(1) {
			left: 8px;
			animation: lds-ellipsis1 0.6s infinite;
		}
	
		.lds-ellipsis div:nth-child(2) {
			left: 8px;
			animation: lds-ellipsis2 0.6s infinite;
		}
	
		.lds-ellipsis div:nth-child(3) {
			left: 32px;
			animation: lds-ellipsis2 0.6s infinite;
		}
	
		.lds-ellipsis div:nth-child(4) {
			left: 56px;
			animation: lds-ellipsis3 0.6s infinite;
		}
	
		@keyframes lds-ellipsis1 {
			0% {
				transform: scale(0);
			}
	
			100% {
				transform: scale(1);
			}
		}
	
		@keyframes lds-ellipsis3 {
			0% {
				transform: scale(1);
			}
	
			100% {
				transform: scale(0);
			}
		}
	
		@keyframes lds-ellipsis2 {
			0% {
				transform: translate(0, 0);
			}
	
			100% {
				transform: translate(24px, 0);
			}
		}
	</style>
	
	@stack('css')