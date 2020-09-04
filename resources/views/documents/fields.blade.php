<!-- Nev Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nev', 'Nev:') !!}
    {!! Form::text('nev', null, ['class' => 'form-control']) !!}
</div>

<!-- Auto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auto', 'Auto:') !!}
    {!! Form::number('auto', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipus Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipus', 'Tipus:') !!}
    {!! Form::number('tipus', null, ['class' => 'form-control']) !!}
</div>

<!-- Partner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('partner', 'Partner:') !!}
    {!! Form::number('partner', null, ['class' => 'form-control']) !!}
</div>

<!-- Leiras Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('leiras', 'Leiras:') !!}
    {!! Form::textarea('leiras', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('documents.index') !!}" class="btn btn-default">Cancel</a>
</div>
