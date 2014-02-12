@section('head')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Form::hidden('id'); }}

	<div class="col-sm-6">

		{{ Form::label('category_id', trans('validation.attributes.category_id'), array('class' => 'control-label')) }}
		{{ Form::text('category_id', null, array('class' => 'form-control')) }}

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				<div class="form-group">
					{{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
					{{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'input-lg form-control')) }}
				</div>
				<div class="form-group @if($errors->has($lang.'.slug'))has-error@endif">
					{{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
					{{ Form::text($lang.'[slug]', $model->$lang->slug, array('class' => 'form-control')) }}
					@if($errors->has($lang.'.slug'))
					<span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
					@endif
				</div>
				<div class="form-group">
					<label class="checkbox">
						{{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
					</label>
				</div>
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">
	@include('files.admin._list', array('files' => $model->files))
	</div>

</div>