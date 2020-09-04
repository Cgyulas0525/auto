@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Autók</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('cars.create') !!}"><i class="fa fa-plus-square"></i></a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
              <div class="table-responsive">
                  <table class="table table-striped table-bordered car-table">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Rendszám</th>
                              <th>Típus</th>
                              <th>Alvazszám</th>
                              <th>Motorszám</th>
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

          var oTable = $('.car-table').DataTable({
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

              ajax: "{{ route('cars.index') }}",
              columns: [
                  {data: 'kep', name: 'kep',
                     render: function(data, type, full, meta){
                      return "<img src={{ URL::to('/') }}/public/img/" + data + " width='70' />";
                     },
                     orderable: false
                    },
                  {data: 'rendszam', name: 'rendszam'},
                  {data: 'tipus', name: 'tipus'},
                  {data: 'alvazszam', name: 'alvazszam'},
                  {data: 'motorszam', name: 'motorszam'},
                  {data: 'action', sClass: "text-center", name: 'action', orderable: false, searchable: false},
              ],
            });

        });
    </script>
@endsection
