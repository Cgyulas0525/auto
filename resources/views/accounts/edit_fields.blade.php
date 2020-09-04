<!-- Partner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auto', 'Autó:') !!}
    {!! Form::select('auto', [" "] + \App\Models\Car::get()->sortby('rendszam')->pluck('rendszam', 'id')->toArray(), $account->auto,['class'=>'select2 form-control', 'id' => 'auto']) !!}
    {!! Form::label('partner', 'Partner:') !!}
    {!! Form::select('partner', [" "] + \App\Models\Partner::get()->sortby('nev')->pluck('nev', 'id')->toArray(), $account->partner,['class'=>'select2 form-control', 'id' => 'partner']) !!}
    {!! Form::label('tipus', 'Költség típus:') !!}
    {!! Form::select('tipus', [" "] + \App\Models\Cost::get()->sortby('nev')->pluck('nev', 'id')->toArray(), $account->tipus,['class'=>'select2 form-control', 'id' => 'tipus']) !!}
    {!! Form::label('bizszam', 'Bizonylat szám:') !!}
    {!! Form::text('bizszam', null, ['class' => 'form-control']) !!}
</div>


<!-- Datum Field -->
<div class="form-group col-sm-2">
    {!! Form::label('datum', 'Dátum:') !!}
    {!! Form::date('datum', $account->datum, ['class' => 'form-control','id'=>'datum']) !!}
    {!! Form::label('osszeg', 'Összeg:') !!}
    {!! Form::number('osszeg', $account->osszeg, ['class' => 'form-control text-right']) !!}
</div>

<!-- Osszeg Field -->
<div class="form-group col-sm-12">
    {!! Form::label('leiras', 'Leírás:') !!}
    {!! Form::textarea('leiras', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Ment', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('accounts.index') !!}" class="btn btn-default">Kilép</a>
</div>

@section('scripts')
    <script type="text/javascript">
        $('#datum').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection
