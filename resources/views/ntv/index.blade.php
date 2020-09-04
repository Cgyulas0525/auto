@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">NTV 495 Számlák</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('ntv.create') !!}"><i class="fa fa-plus-square"></i></a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            <div class="panel-body">
                <form id="search-form" class="form-inline">
                    <button type="submit" class="btn btn-primary pull-right" title="Frissítés" ><i class="fa  fa-filter"></i></button>
                    <div class="form-group text-center">
                        <label for="title">Költség típus:
                        {!! Form::select('ktg', [""] + \App\Models\Cost::get()->sortby('nev')->pluck('nev', 'nev')->toArray(), null,['class'=>'select2 form-control', 'id' => 'ktg', 'style=width:180px']) !!}</label>
                    </div>
                </form>
            </div>
        <div class="box box-primary">
              <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered account-table">
                        <thead>
                            <tr>
                                <th>Autó</th>
                                <th>Partner</th>
                                <th>Költség típus</th>
                                <th>Bizonylat szám</th>
                                <th>Dátum</th>
                                <th>Összeg</th>
                                <th>Leírás</th>
                                <th>Akció</th>
                                <th>Id</th>
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

          var oTable = $('.account-table').DataTable({
              language: {
                  url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Hungarian.json"
              },
              serverSide: true,
              order: [[4, 'desc'], [0, 'asc'], [1, 'asc']],
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

              ajax: "{{ route('ntv.index') }}",
              columns: [
                  {data: 'auto', name: 'auto'},
                  {data: 'partner_nev', name: 'partner'},
                  {data: 'ktg_nev', name: 'ktg_nev'},
                  {data: 'bizszam', name: 'bizszam'},
                  {data: 'datum', render: function (data, type, row) { return data ? moment(data).format('YYYY.MM.DD') : ''; }, sClass: "text-center",name: 'datum'},
                  {data: 'osszeg', render: $.fn.dataTable.render.number( '.', ',', 0), sClass: "text-right", name: 'osszeg'},
                  {data: 'leiras', name: 'leiras'},
                  {data: 'action', sClass: "text-center", name: 'action', orderable: false, searchable: false},
                  {data: 'id', name: 'id', visible: false, orderable: false, searchable: false},
              ],
            });

            $('#search-form').on('submit', function(e) {
                oTable.rows.remove().draw();
                e.preventDefault();
            });

            $('#ktg').on('change',function(){
              var ktg = $('#ktg').val();
              console.log(ktg);
              if (ktg != '0'){
                oTable.column(2).search(ktg).draw();
              }

            });

        });

    </script>
@endsection
