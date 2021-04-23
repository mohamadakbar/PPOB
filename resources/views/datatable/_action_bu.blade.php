{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => 'form-inline js-confirm', 'data-confirm' => $confirm_message] ) !!}
<a href="{{ $edit_url }}" class="btn btn-success btn-sm">Edit</a>&nbsp;&nbsp;{!! Form::submit('Delete', ['class'=>'btn btn-xs btn-danger btn-sm']) !!}
{!! Form::close()!!}
