@foreach ($networks as $network)
	<a href="{{ prep_url($network['social_link']) }}" target="_blank"><i class="fa {{ !empty($network['fa_icon_class']) ? $network['fa_icon_class'] : $network['social_type'] }} fa-4" aria-hidden="true"></i></a>
@endforeach