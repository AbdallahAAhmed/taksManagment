<!--begin::Notifications-->
@if (Auth::check() && auth()->user()->role == 'employee')
<div class="dropdown">
	<!--begin::Toggle-->
	<div class="topbar-item"  data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
		<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
			@if ($myTasks->count() > 0)
				<a href="">
					<i class="fas fa-envelope fa-lg"></i>
					<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
					</span>
				</a>
				@else
				<a href="">
					<i class="fas fa-envelope fa-lg"></i>
				</a>
			@endif
			<span class="pulse-ring"></span>
		</div>
	</div>
	<!--end::Toggle-->
	<!--begin::Dropdown-->
	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg" style="">
		<form>
			<!--begin::Header-->
			<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top"
				style="background-image: url(/assets/media/misc/bg-1.jpg)">
				<!--begin::Title-->
				<h4 class="d-flex flex-center rounded-top">
					<span class="text-white">لديك مهمات جديدة غير مكتملة</span>
					<span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">{{$myTasks->count()}} جديدة</span>
				</h4>
				<!--end::Title-->
				<!--begin::Tabs-->
				<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8"
					role="tablist">
					<li class="nav-item">
						<a class="nav-link active show" data-toggle="tab"
							href="#topbar_notifications_notifications">تنبيه</a>
					</li>
				</ul>
				<!--end::Tabs-->
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="tab-content">
				<!--begin::Tabpane-->
				<div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
					<!--begin::Scroll-->
					<div class="scroll pr-7 mr-n7 ps" data-scroll="true" data-height="300" data-mobile-height="200"
						style="height: 300px; overflow: hidden;">
						<!--begin::Item-->
						@foreach ($myTasks as $item)
						<div class="d-flex align-items-center mb-6">
							<!--begin::Symbol-->
							<div class="symbol symbol-40 symbol-light-primary mr-5">
								<span class="symbol-label">
									<span class="svg-icon svg-icon-primary svg-icon-2x">
										<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Chat4.svg--><svg
											xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
											viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path
													d="M21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L5,18 C3.34314575,18 2,16.6568542 2,15 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 Z M6.16794971,10.5547002 C7.67758127,12.8191475 9.64566871,14 12,14 C14.3543313,14 16.3224187,12.8191475 17.8320503,10.5547002 C18.1384028,10.0951715 18.0142289,9.47430216 17.5547002,9.16794971 C17.0951715,8.86159725 16.4743022,8.98577112 16.1679497,9.4452998 C15.0109146,11.1808525 13.6456687,12 12,12 C10.3543313,12 8.9890854,11.1808525 7.83205029,9.4452998 C7.52569784,8.98577112 6.90482849,8.86159725 6.4452998,9.16794971 C5.98577112,9.47430216 5.86159725,10.0951715 6.16794971,10.5547002 Z"
													fill="#000000" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</span>
							</div>
							<div class="d-flex flex-column font-weight-bold">
								<a href="{{ route('tasks.show',['id' => $item->id]) }}" class="text-dark text-hover-primary mb-1 font-size-lg">{{ $item->task_name }}</a>
								<span class="text-muted">{!! Str::limit($item->task_description,40) !!}</span>
							</div>
						</div>
						@endforeach
						<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
							<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
						</div>
						<div class="ps__rail-y" style="top: 0px; right: 0px;">
							<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
						</div>
					</div>
					<!--end::Scroll-->

					<!--end::Action-->
				</div>
				<!--end::Tabpane-->
			</div>
			<!--end::Content-->
		</form>
	</div>
	<!--end::Dropdown-->
</div>
@endif

<!--end::Notifications-->

<!--begin::User-->
<div class="topbar-item">
	<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
		<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
		<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ auth()->user()->username
			}}</span>
		<span class="symbol symbol-35 symbol-light-success">
			<span class="symbol-label font-size-h5 font-weight-bold">{{substr(auth()->user()->username, 0, 1)}}</span>
		</span>
	</div>
</div>
<!--end::User-->

