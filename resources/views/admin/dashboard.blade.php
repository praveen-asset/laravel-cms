@extends('admin.layouts.layout')

@section('styles')
<style type="text/css">
	span.info-box-number a {
		font-weight: normal;
		font-size: 15px;
	}
	.customheight{
		height: 104px;
	}
</style>
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
			<small><!-- Version 2.0 --></small>
		</h1>
		<ol class="breadcrumb">
			<li class="active"><i class="fa fa-dashboard"></i> Home</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Manage Users</span>
						<span class="info-box-number"><a href="{{ route('user.index') }}">Users List</a></span>
						<span class="info-box-number"><a href="{{ route('user.create') }}"> Add Users</a></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-envelope"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Manage Emails</span>
						<span class="info-box-number"><a href="{{ route('email.index') }}">Email Templates</a></span>

					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green customheight"><i class="fa fa-gears"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Manage CMS</span>
						<span class="info-box-number"><a href="{{ route('cms.index') }}">Cms List</a></span>
						<span class="info-box-number"><a href="{{ route('social') }}"> Social Networks </a></span>
						<span class="info-box-number"><a href="{{ route('company-details') }}"> Company Details </a></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="fa fa-gears"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Manage Inquiry</span>
						<span class="info-box-number"><a href="{{ route('inquiry.index') }}">Inquiries List</a></span>						
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
				
			

		</div>
		<!-- /.row -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection