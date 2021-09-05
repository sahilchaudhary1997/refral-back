<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ResizeImage(Auth::guard('admin')->user()->image_id,44,44)}}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{Auth::guard('admin')->user()->name}}</span>
                    <span class="text-secondary text-small">{{Auth::guard('admin')->user()->adminRole->name}}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
         @permission('dashboard-list')
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminHome')}}">
                <span class="menu-title">Dashboard</span>
                <!--<i class="mdi mdi-home menu-icon"></i>-->
            </a>
        </li>
        @endpermission
		<li class="nav-item">
            <a class="nav-link" href="{{route('adminDashboardNotification')}}">
                <span class="menu-title">Webniar Notification</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminNotificationsCreate')}}">
                <span class="menu-title">Notification</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminAdvisoryNotification')}}">
                <span class="menu-title">Advisory Notification</span>                
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminModuleType')}}">
                <span class="menu-title">Module Type</span>
                <!--<i class="mdi mdi-view-module menu-icon"></i>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminLevel')}}">
                <span class="menu-title">Level</span>
                <!--<i class="mdi mdi-graph menu-icon"></i>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminCategory')}}">
                <span class="menu-title">Categories</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminMarkets')}}">
                <span class="menu-title">Markets</span>
                <!--<i class="mdi mdi-chart-areaspline menu-icon"></i>-->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminCourses')}}">
                <span class="menu-title">Courses</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>
		<li class="nav-item">
            <a class="nav-link" href="{{route('adminCourseVideos')}}">
                <span class="menu-title">Course Videos</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>
		<li class="nav-item">
            <a class="nav-link" href="{{route('adminPages')}}">
                <span class="menu-title">CMS Pages</span>
                <!--<i class="mdi mdi-phone menu-icon"></i>-->
            </a>
        </li>		
		<li class="nav-item">
            <a class="nav-link" href="{{route('usersManager')}}">
                <span class="menu-title">Users</span>
            </a>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminLocationCity')}}">
                <span class="menu-title">Location (City)</span>
                <i class="mdi mdi-phone menu-icon"></i>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminGender')}}">
                <span class="menu-title">Genders</span>
                <i class="mdi mdi-phone menu-icon"></i>
            </a>
        </li>
       
        
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminColor')}}">
                <span class="menu-title">Colors</span>
                <i class="mdi mdi-phone menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminCondition')}}">
                <span class="menu-title">Conditions</span>
                <i class="mdi mdi-phone menu-icon"></i>
            </a>
        </li>
       
        @permission('contact_leads-list')
        <li class="nav-item">
            <a class="nav-link" href="{{route('adminContactLeads')}}">
                <span class="menu-title">Contact Leads</span>
                <i class="mdi mdi-phone menu-icon"></i>
            </a>
        </li>
        @endpermission
        -->
		@if(ManagePermission('admin_users-list') || ManagePermission('admin_roles-list') || ManagePermission('access_rights-list'))
		<li class="nav-item">
		  <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
				<span class="menu-title">Admin Users</span>
				<i class="menu-arrow"></i>
				<i class="mdi mdi-account-network menu-icon"></i>
		  </a>
		  <div class="collapse" id="ui-basic">
				<ul class="nav flex-column sub-menu">
				  @permission('admin_roles-list')
						<li class="nav-item"> <a class="nav-link" href="{{route('adminRoleManager')}}">Manage Roles</a></li>
				  @endpermission
				  @permission('admin_users-list')
						<li class="nav-item"> <a class="nav-link" href="{{route('adminUserManager')}}">Manage Users</a></li>
				  @endpermission
				  @permission('access_rights-list')
						<li class="nav-item"> <a class="nav-link" href="{{route('adminAccessRights')}}">Access Rights</a></li>
				  @endpermission
				</ul>
		  </div>
		</li>
		@endif
		@if(ManagePermission('general_settings-list'))
			<li class="nav-item">
			  <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
					<span class="menu-title">Settings & More</span>
					<i class="menu-arrow"></i>
					<i class="mdi mdi-settings menu-icon"></i>
			  </a>
			  <div class="collapse" id="ui-basic">
					<ul class="nav flex-column sub-menu">
					  @permission('general_settings-list')
							<li class="nav-item"> <a class="nav-link" href="{{route('adminGeneralSettings')}}">General Settings</a></li>
					  @endpermission
					</ul>
			  </div>
			</li>
		@endif

    </ul>
</nav>
<!-- partial -->