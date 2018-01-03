<select name="status" class="form-control userStatus" id={{ encrypt($id)}} >

	@if($status==0)
		<option value="0" {{ old('status', $status) == 0 ? 'selected' : '' }} >Pending</option>
	@endif
	<option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Active</option>
	<option value="2" {{ old('status', $status) == 2 ? 'selected' : '' }}>Inactive</option>
	<option value="3" {{ old('status', $status) == 3 ? 'selected' : '' }}>Blocked</option>

</select>


