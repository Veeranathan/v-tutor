@section('head')
@include('include.head')
@endsection
<div class="form_box_area">
	<label>Subjects</label>

	<select {{-- multiple --}} name="subject">
		@if(count($unq_sub)>0)
		@foreach($unq_sub as $val2)
		<option value="{{@$val2->id}}"  >{{@$val2->subject}}</option>
		@endforeach
		@else
		<option disabled>No data</option>
		@endif
	</select>
	<label id="subject[]-error" class="error" for="subject[]" style="display: block;"></label>
</div>

<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- 3->26,27,28 --}}
{{-- 29,30 --}}
