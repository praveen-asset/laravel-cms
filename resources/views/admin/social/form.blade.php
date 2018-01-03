@include('admin.partials.errors')

<form role="form" method="post" enctype="multipart/form-data" action="{{ route('social') }}">
	{{ csrf_field() }}
	<div class="box-body">
        @foreach ($social_options as $social)
    		<div class="form-group {{ $errors->has($social['slug'].'_url') ? ' has-error' : '' }}">
    	        <div class="col-md-2">
                    <input class="fancy" type="checkbox" name="show_{{ $social['slug'] }}" value="1" @if(old('show_'.$social['slug'], $social['show'])=="1") checked @endif />
                </div>

                <label for="{{ $social['slug'] }}" class="control-label col-md-4">{{ $social['title'] }}</label>
    	        
                <div class="form-group col-md-6">
                    <input id="{{ $social['slug'] }}_url" placeholder="http://www.example.com" type="text" class="form-control" name="{{ $social['slug'] }}_url" value="{{ old($social['slug'].'_url', $social['url']) }}" maxlength="250" >
        		  	@if ($errors->has($social['slug'].'_url'))
        			  	<span class="help-block">
        					<strong>{{ $errors->first($social['slug'].'_url') }}</strong>
        			  	</span>
        		  	@endif
                </div>
    	    </div>
        @endforeach

        <div class="clearfix"></div>
        
		<div class="box-footer">
			<button type="submit" class="btn btn-info pull-right">Update</button>
		</div>
</form>