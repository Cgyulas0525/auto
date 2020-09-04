@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Dokumentumok</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('documents.create') !!}"><i class="fa fa-plus-square"></i></a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="panel-body">
            <form id="search-form" class="form-inline">
                <div class="form-group text-center">
                    <label for="title">Autó:</label>
                    {!! Form::select('auto', [""] + \App\Models\Car::get()->sortby('rendszam')->pluck('rendszam', 'rendszam')->toArray(), 'null',['class'=>'select2 form-control', 'id' => 'auto', 'style=width:180px']) !!}
                    <label for="title">Típus:</label>
                    {!! Form::select('tipus', [""] + \App\Models\Doctype::get()->sortby('nev')->pluck('nev', 'nev')->toArray(), null,['class'=>'select2 form-control', 'id' => 'tipus', 'style=width:180px']) !!}
                    <label for="title">Partner:</label>
                    {!! Form::select('partner', [""] + \App\Models\Partner::get()->sortby('nev')->pluck('nev', 'nev')->toArray(), null,['class'=>'select2 form-control', 'id' => 'partner', 'style=width:180px']) !!}
                    <button type="submit" class="btn btn-primary" title="Szűrés" ><i class="fa  fa-filter"></i></button>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-body">
              <div class="table-responsive">
                  <table class="table table-striped table-bordered doc-table">
                      <thead>
                          <tr>
                              <th>Név</th>
                              <th>Autó</th>
                              <th>Típus</th>
                              <th>Partner</th>
                              <th>Leírás</th>
                              <th>Akció</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script type="text/javascript">
        $(function () {

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          var oTable = $('.doc-table').DataTable({
              language: {
                  url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Hungarian.json"
              },
              serverSide: true,
              order: [[0, 'asc']],
              lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Mind"]],
              dom: 'B<"clear">lfrtip',
              buttons: [
                        {
                          extend:    'copyHtml5',
                          text:      '<i class="fa fa-files-o"></i>',
                          titleAttr: 'Másolás',
                           exportOptions: {
                               columns: [ ':visible' ]
                           },
                        },

                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-code-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            text:      '<i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        }
                    ],

              ajax: "{{ route('documents.index') }}",
              columns: [
                  {data: 'nev', name: 'nev'},
                  {data: 'rendszam', name: 'rendszam'},
                  {data: 'tipus', name: 'tipus'},
                  {data: 'partner', name: 'partner'},
                  {data: 'leiras', name: 'leiras'},
                  {data: 'action', sClass: "text-center", name: 'action', orderable: false, searchable: false},
              ],
            });

            $('#search-form').on('submit', function(e) {
                var auto = $('#auto').val();
                var tipus = $('#tipus').val();
                var partner = $('#partner').val();
                if (auto != '0'){
                    if (tipus != '0'){
                        if (partner != '0'){
                            oTable.column(1).search(auto).column(2).search(tipus).column(3).search(partner).draw();
                        }else{
                            oTable.column(1).search(auto).column(2).search(tipus).draw();
                        }
                    }else{
                        if (partner != '0'){
                            oTable.column(1).search(auto).column(3).search(partner).draw();
                        }else{
                            oTable.column(1).search(auto).draw();
                        }
                    }
                }else{
                    if (tipus != '0'){
                        if (partner != '0'){
                            oTable.column(2).search(tipus).column(3).search(partner).draw();
                        }else{
                            oTable.column(2).search(tipus).draw();
                        }
                    }else{
                        oTable.rows.remove().draw();
                    }
                }
                e.preventDefault();
            });

        });
    </script>
@endsection
