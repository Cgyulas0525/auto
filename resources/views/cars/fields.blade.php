<!-- Rendszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rendszam', 'Rendszám:') !!}
    {!! Form::text('rendszam', null, ['class' => 'form-control']) !!}
</div>

<!-- Tipus Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipus', 'Típus:') !!}
    {!! Form::text('tipus', null, ['class' => 'form-control']) !!}
</div>

<!-- Motorszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('motorszam', 'Motorszám:') !!}
    {!! Form::text('motorszam', null, ['class' => 'form-control']) !!}
</div>

<!-- Alvazszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alvazszam', 'Alvázszám:') !!}
    {!! Form::text('alvazszam', null, ['class' => 'form-control']) !!}
</div>

<!-- Alvazszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('karbantarto', 'Karbantartó URL:') !!}
    {!! Form::text('karbantarto', null, ['class' => 'form-control']) !!}
</div>
<!-- Alvazszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hatter', 'Háttér szin:') !!}
    {!! Form::text('hatter', null, ['class' => 'form-control']) !!}
</div>
<!-- Alvazszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kep', 'Kép:') !!}
    {!! Form::text('kep', null, ['class' => 'form-control']) !!}
</div>
<!-- Alvazszam Field -->
<div class="form-group col-sm-6">
    {!! Form::label('felhasznalo', 'Felhasználó:') !!}
    {!! Form::select('felhasznalo', [" "] + \App\Models\User::get()->sortby('name')->pluck('name', 'id')->toArray(), null,['class'=>'select2 form-control', 'id' => 'felhasznalo']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Ment', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cars.index') !!}" class="btn btn-default">Kilép</a>
</div>
