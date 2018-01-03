
@if ($paging)
	<ul class="pagination">
		{{-- Previous Page Link --}}
        @if ($paging->prev_page_url)
            <li class="disabled"><span>@lang('pagination.previous')</span></li>
        @else
            <li><a href="{{ $paging->prev_page_url }}" rel="prev">@lang('pagination.previous')</a></li>
        @endif
		

		@for($i=$paging->current_page; $i <= $paging->last_page; $i++)
			@if($paging->current_page == $i)
				<li class="active"><a href="#">{{ $i }}</a></li>
			@else
				<li><a href="{{ Request::url() }}?page={{ $i }}">{{ $i }}</a></li>
			@endif
    	
    	@endfor

	    {{-- Next Page Link --}}
        @if ($paging->next_page_url)
            <li><a href="{{ $paging->next_page_url }}" rel="next">@lang('pagination.next')</a></li>
        @else
            <li class="disabled"><span>@lang('pagination.next')</span></li>
        @endif
	</ul>
@endif
