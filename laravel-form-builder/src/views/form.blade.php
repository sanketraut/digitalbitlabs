@if(!$withPanel) {!! $formOpen !!} {{ csrf_field() }} @foreach($elementList as $element) @if($element['type'] != 'hidden')
<div class="row">
	<div class="form-group {{$element['class']}}">
		@if($element['type'] == 'text')
		<input type='text' {!! $element[ 'attributes'] !!} /> @elseif($element['type'] == 'dropdown')
		<select {!! $element[ 'attributes'] !!}>
			@foreach($element['options'] as $option)
			<option value="{{$option}}">{{ $option }}</option>
			@endforeach
		</select>
		@elseif($element['type'] == 'radio') @foreach($element['options'] as $option)
		<input type='radio' {!! $element[ 'attributes'] !!} /> {{ $option }} @endforeach @elseif($element['type'] == 'checkbox') @foreach($element['options'] as $option)
		<input type='checkbox' {!! $element[ 'attributes'] !!} /> {{ $option }} @endforeach @elseif($element['type'] == 'textarea')
		<textarea {!! $element[ 'attributes'] !!}>@if(isset($element['text'])){{ $element['text'] }}@endif</textarea> 
		@elseif($element['type'] == 'image')
		<div class="panel panel-default panel-picture text-center">
			<div class="panel-body">
				<div id="uploadphoto">
					<label class="image-label">{{ $element['label'] }}</label>
					<div id="userphoto">
						<i class="fa fa-image"></i>
						<img src="" class="image-view" />
					</div>
				</div>
			</div>
			<div class="panel-footer panel-dark-footer">
				<div class="form-group image-preview">
					<!-- <div class="col-md-12"> -->
					{{ csrf_field() }}
					<label for="upload" class="btn btn-primary">+</label>
					<input type="file" id="upload" class="file-upload__input" name="photo" />
					<!-- </div> -->
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
@else
<input type='hidden' {!! $element[ 'attributes'] !!} /> @endif @endforeach @if($element['type'] == 'submit')
<button {!! $element[ 'attributes'] !!}>{{ $element['label'] }}</button>
@else
<button type="submit" name="submit">Submit</button>
@endif {!! $formClose !!} @elseif($withPanel) {!! $formOpen !!} {{ csrf_field() }}
<div class="panel panel-default">

	<div class="panel-heading">
		@if($panelTitle) {{ $panelTitle }} @else Form @endif
	</div>

	<div class="panel-body">
		@foreach($elementList as $element) @if($element['type'] != 'hidden')
		<div class="row">
			<div class="form-group {{$element['class']}}">
				@if($element['type'] == 'text')
				<input type='text' {!! $element[ 'attributes'] !!} /> @elseif($element['type'] == 'dropdown')
				<select {!! $element[ 'attributes'] !!}>
					@foreach($element['options'] as $option)
					<option value="{{$option}}">{{ $option }}</option>
					@endforeach
				</select>
				@elseif($element['type'] == 'radio') @foreach($element['options'] as $option)
				<input type='radio' {!! $element[ 'attributes'] !!} /> {{ $option }} @endforeach @elseif($element['type'] == 'checkbox') @foreach($element['options'] as $option)
				<input type='checkbox' {!! $element[ 'attributes'] !!} /> {{ $option }} @endforeach @elseif($element['type'] == 'textarea')
				<textarea {!! $element[ 'attributes'] !!}>@if(isset($element['text'])){{ $element['text'] }}@endif</textarea> 
				@elseif($element['type'] == 'image')
				<div class="panel panel-default panel-picture text-center">
					<form class="form-horizontal modal-form" action="{{secure_url('/settings/upload-photo')}}" name="picForm" method="POST" data-clearonsubmit="true"
					 data-modal-title="Crop Picture">
						<div class="panel-body">
							<div id="uploadphoto">
								<label class="image-label">{{ $element['label'] }}</label>
								<div id="userphoto">
									<i class="fa fa-image"></i>
									<img src="" class="image-view" />
								</div>
							</div>
						</div>
						<div class="panel-footer panel-dark-footer">
							<div class="form-group image-preview">
								<!-- <div class="col-md-12"> -->
								{{ csrf_field() }}
								<label for="upload" class="btn btn-primary">+</label>
								<input type="file" id="upload" class="file-upload__input" name="photo" />
								<!-- </div> -->
							</div>
						</div>
					</form>
				</div>
				@endif

			</div>
		</div>
		@else
		<input type="hidden" {!! $element[ 'attributes'] !!}/> @endif @endforeach
	</div>

	<div class="panel-footer">
		@if($element['type'] == 'submit')
		<button {!! $element[ 'attributes'] !!}>{{$element['label']}}</button>
		@else
		<button type="submit" name="submit">{{$element['label']}}</button>
		@endif
	</div>

</div>
{!! $formClose !!} @endif