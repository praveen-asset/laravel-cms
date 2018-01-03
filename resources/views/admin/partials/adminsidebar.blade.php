<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  	<!-- sidebar menu: : style can be found in sidebar.less -->
	  	<ul class="sidebar-menu">
			<li class="{{ Request::is('admin/dashboard') || Request::is('admin') ? 'active' : '' }}">
		  		<a href="{!! url('admin/dashboard'); !!}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					<span class="pull-right-container">
					</span>
		  		</a>
			</li>

			<li class="treeview {{ Request::is('admin/user') || Request::is('admin/user/*') ? 'active' : '' }}">
		  		<a href="{!! url('admin/user'); !!}">
					<i class="fa fa-user"></i>
					<span>Manage Users</span>
					<span class="pull-right-container">
			  		<i class="fa fa-angle-left pull-right"></i>
					</span>
		  		</a>
		  		<ul class="treeview-menu">
					<li class="{{ Request::is('admin/user') ? 'active' : '' }}">
						<a href="{{ route('user.index') }}"><i class="fa fa-list"></i>Users</a>
					</li>
					
		  		</ul>
			</li>

			<li class="treeview {{ Request::is('admin/email') || Request::is('admin/email/*') ? 'active' : '' }}">
		  		<a href="#">
					<i class="fa fa-envelope"></i>
					<span>Manage Emails</span>
					<span class="pull-right-container">
			  		<i class="fa fa-angle-left pull-right"></i>
					</span>
		  		</a>
		  		<ul class="treeview-menu">
		  			<li class="{{ Request::is('admin/email') ? 'active' : '' }}">
						<a href="{{ route('email.index') }}"><i class="fa fa-list"></i>Email Templates</a>
					</li>
		  		</ul>
			</li>

			<li class="treeview {{ Request::is('admin/cms') || Request::is('admin/social') || Request::is('admin/social/*') ||  Request::is('admin/company-details') || Request::is('admin/cms/*') ? 'active' : '' }}">
		  		<a href="#">
					<i class="fa fa-gears"></i>
					<span>Manage CMS</span>
					<span class="pull-right-container">
			  		<i class="fa fa-angle-left pull-right"></i>
					</span>
		  		</a>
		  		<ul class="treeview-menu">
		  			<li class="{{ Request::is('admin/cms') ? 'active' : '' }}">
						<a href="{{ route('cms.index') }}"><i class="fa fa-list"></i>List</a>
					</li>

					<li class="{{ Request::is('admin/social') ? 'active' : '' }}">
						<a href="{{ route('social') }}"><i class="fa fa-list"></i>Social Networks</a>
					</li>

					<li class="{{ Request::is('admin/company-details') ? 'active' : '' }}">
						<a href="{{ route('company-details') }}"><i class="fa fa-list"></i>Company Details</a>
					</li>
		  		</ul>
			</li>


			<li class="treeview {{ Request::is('admin/inquiry') || Request::is('admin/inquiry/*') ? 'active' : '' }}">
		  		<a href="#">
					<i class="fa fa-gears"></i>
					<span>Manage Inquiry</span>
					<span class="pull-right-container">
			  		<i class="fa fa-angle-left pull-right"></i>
					</span>
		  		</a>
		  		<ul class="treeview-menu">
		  			<li class="{{ Request::is('admin/inquiry') ? 'active' : '' }}">
						<a href="{{ route('inquiry.index') }}"><i class="fa fa-list"></i>Inquiries</a>
					</li>
		  		</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
  </aside>