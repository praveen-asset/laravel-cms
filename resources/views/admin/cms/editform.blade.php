@include('admin.partials.errors')

<form role="form" method="post" enctype="multipart/form-data" class="" action="{{ route('cms.update', encrypt($input['id'])) }}">

	<input type="hidden" name="_method" value="put" />
	{{ csrf_field() }}
	<div class="box-body">

		<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
	        <label for="title" class="control-label required">Title</label>
	        
	        <input id="title" placeholder="Title" type="text" class="form-control" name="title" value="{{ old('title' , $input['title']) }}" maxlength="25">
		  	@if ($errors->has('title'))
			  	<span class="help-block">
					<strong>{{ $errors->first('title') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
	        <label for="slug" class="control-label required">Slug</label>
	        
	        <input id="slug" placeholder="Slug"  type="text" class="form-control" name="slug" value="{{ old('slug' , $input['slug']) }}" maxlength="25" readonly>
		  	@if ($errors->has('slug'))
			  	<span class="help-block">
					<strong>{{ $errors->first('slug') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
	        <label for="content" class="control-label required">Content</label>
	        
            <textarea id="content" name="content" rows="7" class="form-control ckeditor" placeholder="Write your content..">{{ old('content', $input['content']) }}</textarea>

		  	@if ($errors->has('content'))
			  	<span class="help-block">
					<strong>{{ $errors->first('content') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
	        <label for="meta_title" class="control-label">Meta Title</label>
	        
	        <input id="meta_title" placeholder="Meta Title"  type="text" class="form-control" name="meta_title" value="{{ old('meta_title' , $input['meta_title']) }}" maxlength="25">
		  	@if ($errors->has('meta_title'))
			  	<span class="help-block">
					<strong>{{ $errors->first('meta_title') }}</strong>
			  	</span>
		  	@endif
	    </div>

	     <div class="form-group{{ $errors->has('meta_tags') ? ' has-error' : '' }}">
	        <label for="meta_tags" class="control-label">Meta Tags</label>
	        
	        <input id="meta_tags" placeholder="Meta Tags"  type="text" class="form-control" name="meta_tags" value="{{ old('meta_tags' , $input['meta_tags']) }}" maxlength="25">
		  	@if ($errors->has('meta_tags'))
			  	<span class="help-block">
					<strong>{{ $errors->first('meta_tags') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
	        <label for="meta_description" class="control-label">Meta Description</label>
	        
	        <input id="meta_description" placeholder="Meta Description"  type="text" class="form-control" name="meta_description" value="{{ old('meta_description' , $input['meta_description']) }}" maxlength="25">
		  	@if ($errors->has('meta_description'))
			  	<span class="help-block">
					<strong>{{ $errors->first('meta_description') }}</strong>
			  	</span>
		  	@endif
	    </div>
	    @if(1==2)
	    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
	        <label for="status" class="control-label required">Status</label>
        	<select name="status" class="form-control">
				<option value="0" {{ old('status', $input['status']) == 0 ? 'selected' : '' }}>Inactive</option>
				<option value="1" {{ old('status', $input['status']) == 1 ? 'selected' : '' }}>Active</option>
			</select>
	    </div>  
	    @endif  

	</div>

	<div class="box-footer">
		<a href="{{ route('cms.index') }}" class="btn btn-default">Cancel</a>
		<button type="submit" class="btn btn-info pull-right">Save</button>
	</div>

</form>    