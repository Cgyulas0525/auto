<!-- Partner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('partner', 'Partner:') !!}
    {!! Form::select('partner', [" "] + \App\Models\Partner::get()->sortby('nev')->pluck('nev', 'id')->toArray(), $ioaccounts->partner,['class'=>'select2 form-control', 'id' => 'partner']) !!}
    {!! Form::label('tipus', 'Költség típus:') !!}
    {!! Form::select('tipus', [" "] + \App\Models\Cost::get()->sortby('nev')->pluck('nev', 'id')->toArray(), $ioaccounts->tipus,['class'=>'select2 form-control', 'id' => 'tipus']) !!}
</div>

<!-- Datum Field -->
<div class="form-group col-sm-2">
    {!! Form::label('datum', 'Dátum:') !!}
    {!! Form::date('datum',  $ioaccounts->datum, ['class' => 'form-control','id'=>'datum']) !!}
    {!! Form::label('osszeg', 'Összeg:') !!}
    {!! Form::number('osszeg', $ioaccounts->osszeg, ['class' => 'form-control text-right']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('leiras', 'Leírás:') !!}
    {!! Form::textarea('leiras', $ioaccounts->leiras, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Ment', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ioaccounts.index') !!}" class="btn btn-default">Kilép</a>
</div>

@section('scripts')
    <script type="text/javascript">
        $('#datum').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection
