<!-- Partner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auto', 'Autó:') !!}
    {!! Form::select('auto', \App\Models\Car::where('id', '=', '4')->pluck('rendszam', 'id')->toArray(), null,['style' => 'cursor: not-allowed','class'=>'select form-control', 'readonly' => 'true', 'id' => 'auto']) !!}
    {!! Form::label('partner', 'Partner:') !!}
    {!! Form::select('partner', [" "] + \App\Models\Partner::get()->sortby('nev')->pluck('nev', 'id')->toArray(), null,['class'=>'select2 form-control', 'id' => 'partner']) !!}
    {!! Form::label('tipus', 'Költség típus:') !!}
    {!! Form::select('tipus', [" "] + \App\Models\Cost::get()->sortby('nev')->pluck('nev', 'id')->toArray(), null,['class'=>'select2 form-control', 'id' => 'tipus']) !!}
    {!! Form::label('bizszam', 'Bizonylat szám:') !!}
    {!! Form::text('bizszam', null, ['class' => 'form-control']) !!}
</div>


<!-- Datum Field -->
<div class="form-group col-sm-2">
    {!! Form::label('datum', 'Dátum:') !!}
    {!! Form::date('datum', \Carbon\Carbon::now(), ['class' => 'form-control','id'=>'datum']) !!}
    {!! Form::label('osszeg', 'Összeg:') !!}
    {!! Form::number('osszeg', null, ['class' => 'form-control text-right']) !!}
</div>

<!-- Osszeg Field -->
<div class="form-group col-sm-12">
    {!! Form::label('leiras', 'Leírás:') !!}
    {!! Form::textarea('leiras', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Ment', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('rxe.index') !!}" class="btn btn-default">Kilép</a>
</div>

@section('scripts')
    <script type="text/javascript">
        $('#datum').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection
