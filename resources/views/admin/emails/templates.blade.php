@extends('admin.layouts.layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Template
      </h1>
      <ol class="breadcrumb">
        <li><a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{!! url('admin/email') !!}">Manage Email Templates</a></li>
        <li class="active"> Edit Template</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="box">
                <div class="box-body">  
                    @include('admin.emails.templateForm')
                </div>
            </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    CKEDITOR.replace( 'messageArea',
    {
      language: 'en',
      customConfig : 'config.js',
      toolbar : 'simple',
    });
});
</script>
@endsection
