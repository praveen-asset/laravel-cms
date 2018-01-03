@include('admin.partials.errors')
	<form role="form" method="post" enctype="multipart/form-data" class="" action="{{ route('email.update', encrypt($input['id'])) }}">
	<input type="hidden" name="_method" value="put" />
	{{ csrf_field() }}
	<div class="box-body">

		<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
	        <label for="slug" class="control-label">Email Slug</label>
	        
            <input type="text" id="slug" name="slug" class="form-control" value="{{ $input['slug'] }}" readonly="readonly">

		  	@if ($errors->has('slug'))
			  	<span class="help-block">
					<strong>{{ $errors->first('slug') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
	        <label for="subject" class="control-label required">Email Subject</label>
	        
            <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject', $input['subject']) }}">

		  	@if ($errors->has('slug'))
			  	<span class="help-block">
					<strong>{{ $errors->first('slug') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('text_tag') ? ' has-error' : '' }}">
	        <label for="text_tag" class="control-label">Dynamic Variables</label>
	        
            <textarea id="text_tag" name="text_tag" rows="2" class="form-control" placeholder="Shortcuts" readonly="readonly">{{ old('text_tag', $input['text_tag']) }}</textarea>

		  	@if ($errors->has('text_tag'))
			  	<span class="help-block">
					<strong>{{ $errors->first('text_tag') }}</strong>
			  	</span>
		  	@endif
	    </div>

    	<div class="form-group{{ $errors->has('email_body') ? ' has-error' : '' }}">
	        <label for="email_body" class="control-label required">Email body</label>
	        
            <textarea id="email_body" name="email_body" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ old('email_body', $input['email_body']) }}</textarea>

		  	@if ($errors->has('email_body'))
			  	<span class="help-block">
					<strong>{{ $errors->first('email_body') }}</strong>
			  	</span>
		  	@endif
	    </div>

    </div>
	<div class="box-footer">
		<a href="{{ route('email.index') }}" class="btn btn-default">Cancel</a>
		<button type="submit" class="btn btn-info pull-right">Save</button>
	</div>
</form>