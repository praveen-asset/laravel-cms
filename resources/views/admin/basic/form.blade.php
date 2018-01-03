@include('admin.partials.errors')

<form role="form" method="post" enctype="multipart/form-data" action="{{ route('company-details') }}">
	{{ csrf_field() }}
	<div class="box-body">

        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
            <label for="company_name" class="control-label col-md-4">Company Name</label>
            
            <div class="col-md-8 form-group">
                <a href="#" class="editable" data-type="text" data-pk="{{ $input['company_name'] }}" data-name="worth" data-url="{{ route('save-company-details', '1') }}" data-placeholder="i.e. Dark Bears" data-title="Enter Company Name" data-value="{{ $input['company_name'] }}"></a>
            </div>
        </div>

        <div class="form-group{{ $errors->has('company_address') ? ' has-error' : '' }}">
            <label for="company_address" class="control-label col-md-4">Company Address</label>
            
            <div class="col-md-8 form-group">
                <a href="#" class="editable" data-type="text" data-pk="{{ $input['company_address'] }}" data-name="worth" data-url="{{ route('save-company-details', '2') }}" data-title="Enter Company Address" data-value="{{ $input['company_address'] }}"></a>
            </div>
        </div>

        <fieldset class="fieldset-phones">
            <legend>Phones</legend>
            <div class="row heading">
                <div class="col-md-4 form-group">
                    <label for="label" class="control-label">Label: </label>
                </div>

                <div class="col-md-4 form-group">
                    <label for="label" class="control-label">Phone: </label>
                </div>

                <div class="col-md-2">
                    <label for="label" class="control-label">Default</label>
                </div>
                <div class="col-md-2">
                    <label for="label" class="control-label">Delete</label>
                </div>
            </div>

            @if (count($phones) > 0)
                @foreach ($phones as $phone)
                    <div class="row fields">
                        <div class="col-md-4 form-group">
                            <a href="#" class="editable" data-type="text" data-pk="{{ $phone['id'] }}" data-name="label" data-url="{{ route('save-company-details', '3') }}" data-title="Enter Phone Label" data-placeholder="i.e. Technical Support" data-value="{{ $phone['label'] }}"></a>
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <div class="form-group">
                                <a href="#" class="editable" data-type="text" data-pk="{{ $phone['id'] }}" data-name="worth" data-url="{{ route('save-company-details', '3') }}" data-title="Enter Phone" data-placeholder="Phone Number" data-value="{{ $phone['value'] }}"></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="radio" class="default" name="default" data-pk="{{ $phone['id'] }}" data-url="{{ route('update-company-details', '3') }}" value="1" @if($phone['default'] == '1') checked @endif >
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-pk="{{ $phone['id'] }}" class="btn btn-danger btn-xs delete" data-url="{{ route('update-company-details', '3') }}" title="@if($phone['default'] == '1') Can't delete default @else Delete @endif" @if($phone['default'] == '1') disabled @endif >X</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row fields">
                    <div class="col-md-4 form-group">
                        <a href="#" class="editable" data-type="text" data-pk="0" data-name="label" data-url="{{ route('save-company-details', '3') }}" data-title="Enter Phone Label" data-placeholder="i.e. Technical Support" data-value=""></a>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <div class="form-group">
                            <a href="#" class="editable" data-type="text" data-pk="0" data-name="worth" data-url="{{ route('save-company-details', '3') }}" data-title="Enter Phone" data-placeholder="Phone Number" data-value=""></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" class="default" name="default" data-pk="0" data-url="{{ route('update-company-details') }}" value="1" checked="checked">
                    </div>
                    <div class="col-md-2">
                        <button type="button" data-pk="0" class="btn btn-danger btn-xs delete" title="Delete">X</button>
                    </div>
                </div>
            @endif

            <button type="button" class="btn btn-info btn-xs add-new">Add new phone</button>
        </fieldset>


        <fieldset class="fieldset-phones">
            <legend>Emails</legend>
            <div class="row heading">
                <div class="col-md-4 form-group">
                    <label for="label" class="control-label">Label: </label>
                </div>

                <div class="col-md-4 form-group">
                    <label for="label" class="control-label">Email: </label>
                </div>

                <div class="col-md-2">
                    <label for="label" class="control-label">Default</label>
                </div>
                <div class="col-md-2">
                    <label for="label" class="control-label">Delete</label>
                </div>
            </div>

            @if (count($emails) > 0)
                @foreach ($emails as $email)
                    <div class="row fields">
                        <div class="col-md-4 form-group">
                            <a href="#" class="editable" data-type="text" data-pk="{{ $email['id'] }}" data-name="label" data-url="{{ route('save-company-details', '4') }}" data-title="Enter Email Label" data-placeholder="i.e. Technical Support" data-value="{{ $email['label'] }}"></a>
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <div class="form-group">
                                <a href="#" class="editable" data-type="text" data-pk="{{ $email['id'] }}" data-name="worth" data-url="{{ route('save-company-details', '4') }}" data-title="Enter Email" data-placeholder="Email" data-value="{{ $email['value'] }}"></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="radio" class="default" name="default" data-pk="{{ $email['id'] }}" data-url="{{ route('update-company-details') }}" value="1" @if($email['default'] == '1') checked @endif >
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-pk="{{ $email['id'] }}" class="btn btn-danger btn-xs delete" data-url="{{ route('update-company-details') }}" title="@if($email['default'] == '1') Can't delete default @else Delete @endif" @if($email['default'] == '1') disabled @endif >X</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row fields">
                    <div class="col-md-4 form-group">
                        <a href="#" class="editable" data-type="text" data-pk="0" data-name="label" data-url="{{ route('save-company-details', '4') }}" data-title="Enter Email Label" data-placeholder="i.e. Technical Support" data-value=""></a>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <div class="form-group">
                            <a href="#" class="editable" data-type="text" data-pk="0" data-name="worth" data-url="{{ route('save-company-details', '4') }}" data-title="Enter Email" data-placeholder="Email" data-value=""></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" class="default" name="default" data-pk="0" data-url="{{ route('update-company-details') }}" value="1" checked="checked">
                    </div>
                    <div class="col-md-2">
                        <button type="button" data-pk="0" class="btn btn-danger btn-xs delete" title="Delete">X</button>
                    </div>
                </div>
            @endif

            <button type="button" class="btn btn-info btn-xs add-new">Add new Email</button>
        </fieldset>
</form>

@section('script')
<script type="text/javascript">
var Page = {
    init: function(){
        
        $(document).on('click', '.add-new', this.addNewRow);
        $(document).on('click', '.default', this.make_default);
        $(document).on('click', '.delete', this.delete);

        Page.initEditable();
    },
    
    addNewRow: function(e){
        e.preventDefault();
        el = $(e.target);

        if(el.closest('fieldset').find('.fields').length >= 5) return;    
        
        el.closest('fieldset')
            .find('.fields:first').clone()
            .find("a.editable").data("value", '').data("pk", '0').text("").end()
            .find('input[name="default"]').prop("checked", false).end()
            .find('.delete').prop("disabled", false).attr('title', 'Delete').end()
            .insertAfter(el.closest('fieldset').find('.fields:last'));

        Page.initEditable();
    },

    initEditable: function(){
        $.fn.editable.defaults.params = function (params) {
            return params;
        };
        $('.editable').editable({
            params: function(params) {
                params._token = '{{ csrf_token() }}';
                params.default = $(this).closest('.fields').find('[name="default"]:checked').val();
                return params;
            },
            success: Page.editableSuccess
        });
    },

    editableSuccess: function(data, config){
        $(this).closest('.fields').find('.editable').editable('option', 'pk', data.id);
        $(this).closest('.fields').find('input,button').data('pk', data.id);
        if(data.default == 1){
            $(this).closest('.fieldset-phones').find('.delete').removeAttr('disabled').attr('title', 'Delete');
            $(this).closest('.fields').find('.delete').prop('disabled', true).attr('title', "Can't delete default");
        }
    },

    make_default: function(e){
        e.preventDefault();
        el = $(e.target);

        $.ajax({
            url: el.data('url'),
            type: 'DELETE',
            data: { pk: el.data('pk'), action: 'make_default', _token: '{{ csrf_token() }}' },
            success: function(result) {
                if(result.status == true){
                    el.prop('checked', true);

                    el.closest('.fieldset-phones').find('.delete').removeAttr('disabled').attr('title', 'Delete');

                    el.closest('.fields').find('.delete').prop('disabled', true).attr('title', "Can't delete default");
                }
            }
        });

    },

    delete: function(e){
        e.preventDefault();
        el = $(e.target);

        $.ajax({
            url: el.data('url'),
            type: 'DELETE',
            data: { pk: el.data('pk'), action: 'delete', _token: '{{ csrf_token() }}' },
            success: function(result) {
                if(result.status == true){
                    el.closest('.fields').remove();

                }
            }
        });

    }
}

Page.init();
</script>
@stop