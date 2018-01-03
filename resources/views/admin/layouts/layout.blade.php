<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$page_title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('admintheme/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admintheme/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admintheme/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admintheme/dist/css/skins/_all-skins.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}">
  <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
  
  <!-- Bootstrap3 Editable -->
  <link rel="stylesheet" href="{{ asset('library/bootstrap3-editable/css/bootstrap-editable.css') }}">
  @yield('styles')

  <script>
        window.classified = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        window.site_url = '{!! url("/") !!}';
        window.admin_url = '{!! url("/admin") !!}';
    </script>

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admintheme/dist/css/custom.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  
  <!-- admin header -->
  @include('admin.partials.adminheader')

  <!-- admin sidebar -->
  @include('admin.partials.adminsidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <!-- footer -->
  @include('admin.partials.adminfooter')  

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('admintheme/dist/js/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('admintheme/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('admintheme/plugins/datatables/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('admintheme/plugins/datatables/dataTables.bootstrap.min.js') }}">
</script>
<!-- AdminLTE App -->
<script src="{{ asset('admintheme/dist/js/app.min.js') }}"></script>
<script src="{{ asset('admintheme/dist/js/application.js') }}"></script>
<script src="{{ asset('js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admintheme/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkYcFk5rZMvW2Sf0JnCZm9YGvG-Zwgb2U&libraries=places" ></script>
<script src="{{ asset('js/jquery.geocomplete.js') }}"></script>


<!-- Bootstrap3 Editable -->
<script src="{{ asset('library/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
@yield('script')

<script type="text/javascript">
  $(function () {
    $(document).on('click','.del', function () {
        var id = $(this).attr('id');
        var id_array = id.split('_');
        var msg=$(this).attr('data-msg');

        var url = "{{ url('admin') }}" + "/" + id_array[0] + "/" + id_array[1] ;

        if (confirm((msg)?msg:'Do you really want to delete ??')){
          $.ajax({
              url: url,
              type: 'DELETE',
              data: {
                '_token': '{{ csrf_token() }}'
              },
              success: function (res) 
              {
                console.log(res);

                if (res.status === 'success') 
                {
                    window.location.href = "<?php echo url('/admin') ?>" + "/" + id_array[0];
                }
                if (res.status === 'failed') 
                {
                    alert('Something went wrong,.');
                } 
              },
              error: function (data) {
                  return false;
              }
          });
        }
    });
  });

  $("#phone").intlTelInput({
      separateDialCode: true,
      nationalMode: true,
      formatOnDisplay: true,
      utilsScript: "{{ asset('js/utils.js') }}"
  });

  var phonenum = $("#phone").val();
  var ccode    = $("#co-code").val();
  var val = ccode+''+phonenum;
  if(phonenum==""){
      val = '1';
  }

  $("#phone").intlTelInput("setNumber", '+'+val);

  $("#phone").on("countrychange", function(e, countryData) {
      document.getElementById("co-code").value = countryData.dialCode;
      $("#iso2").val(countryData.ivalso2);
  });

  $(function(){
      $("#city_state_country").geocomplete(
          {
              types: ['(cities)'],
              details: ".geo-details", 
              detailsAttribute: "data-geo"
          }
      ).bind("geocode:result", function(event, result){
        console.log(result);
          document.getElementById("google_place_id").value = result.place_id;
          document.getElementById("google_id").value = result.id;
      });
  });

  $( function() {
    $( "#datepicker" ).datepicker(
      { 
        dateFormat: '{{ env("DATE_FORMAT_JS", "mm/dd/yy")}}',
        yearRange: "{{ date('Y') - 100 }}:{{ date('Y') - 10 }}",
        changeMonth: true,
        changeYear: true,
        maxDate:"-10y"
      }
    );
  });
</script>

</body>
</html>
