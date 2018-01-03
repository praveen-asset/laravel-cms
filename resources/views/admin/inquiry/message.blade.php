<a href="javascript:void(0);" data-toggle="modal" data-target="#model-{{ $unique }}" title="Click to full view">@if(strlen($message) > 30) {{ substr($message, 0, 30) }}... @else {{ $message }} @endif</a>

<!-- Modal -->
<div class="modal fade" id="model-{{ $unique }}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inquiry - {{ $INQ_ID }}</h4>
            </div>
            <div class="modal-body popup-model">
                <div class="row">
			        <label class="control-label col-md-3">Name:</label>
		            <div class="col-md-9">{{ $name }}</div>
			    </div>

			    <div class="row">
			        <label class="control-label col-md-3">Email:</label>
		            <div class="col-md-9"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
			    </div>

			    <div class="row">
			        <label class="control-label col-md-3">Phone:</label>
		            <div class="col-md-9"><a href="tel:{{ $phone }}">{{ $phone }}</a></div>
			    </div>

			    <div class="row">
			        <label class="control-label col-md-3">Subject:</label>
		            <div class="col-md-9">{{ $subject }}</div>
			    </div>

			    <div class="row">
			        <label class="control-label col-md-3">Message:</label>
		            <div class="col-md-9">{{ $message }}</div>
			    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>