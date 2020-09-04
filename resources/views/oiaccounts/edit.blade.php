@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Kimenő számlák
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ioaccounts, ['route' => ['oiaccounts.update', $ioaccounts->id], 'method' => 'patch']) !!}

                        @include('oiaccounts.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
