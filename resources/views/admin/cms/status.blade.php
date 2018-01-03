<select name="status" class="form-control cmsStatus" id={{ encrypt($id) }} >
	<option value="0" {{ old('status', $status) == 0 ? 'selected' : '' }}>Inactive</option>
	<option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Active</option>
</select>


