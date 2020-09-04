@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            NES 893 Számlák
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($account, ['route' => ['nes.update', $account->id], 'method' => 'patch']) !!}

                        @include('nes.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
