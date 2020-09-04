@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bejövő számlák
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ioaccounts, ['route' => ['ioaccounts.update', $ioaccounts->id], 'method' => 'patch']) !!}

                        @include('ioaccounts.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
