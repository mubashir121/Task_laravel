@extends('master')
@section('content')

@push('link')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endpush

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            Data Tables with Filters
          </div>
          <div class="col-sm-6"> 
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Main content -->
    <!-- references list start -->
    <section class="app-reference-list">
    <div class="container">
        <!-- list and filter start -->
        <div class="card-datatable table-responsive pt-0">
            <table class="reference-list-table table">
                <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Category</th>
                    <th>webiste</th>
                    <th>Object Type Code</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
      </div>
    </section>
    <!-- references list ends -->
    <!-- /.content -->
</div>    

@push('script')

{{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>

 <script>
        $(function () {
            var dtreferenceTable = $('.reference-list-table'),
                select = $('.select2')

            var assetPath = '../../../app-assets/',
                referenceView = 'app-reference-view-account.html'

            if ($('body').attr('data-framework') === 'laravel') {
                assetPath = $('body').attr('data-asset-path')
                referenceView = assetPath + 'references'
            }

            select.each(function () {
                var $this = $(this)
                $this.wrap('<div class="position-relative"></div>')
                $this.select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent()
                })
            })

            // references List datatable
            if (dtreferenceTable.length) {
                dtreferenceTable.DataTable({
                    'processing': true,
                    'serverSide': true,
                    ajax: {
                        url:'{{ route('indexdata') }}',
                        type: "GET",
                        data: function (d) {
                            d.country = $(document).find('#reference_country_filter').length ? $(document).find('#reference_country_filter').val() : '';
                            d.category = $(document).find('#reference_category_filter').length ? $(document).find('#reference_category_filter').val() : '';
                            d.objekt_type = $(document).find('#reference_objekt_type_filter').length ? $(document).find('#reference_objekt_type_filter').val() : '';
                        },
                        error: function(response){
                            $.each(response.responseJSON.errors,function(index,value ){
                                toastr.error(value);
                            })
                        }
                    }, // JSON file to add data
                    columns: [
                        // columns according to JSON
                        { data: '', searchable: false },
                        { data: 'name' },
                        { data: 'city' },
                        { data: 'category'},
                        { data: 'website'},
                        { data: 'objekt_type_code'},
                        { data: 'action', orderable: false, searchable: false }
                    ],
                    columnDefs: [
                        {
                            // For Responsive
                            className: 'control',
                            orderable: false,
                            responsivePriority: 2,
                            targets: 0,
                            render: function (data, type, full, meta) {
                                return ''
                            }
                        }
                    ],
                    dom:
                        '<"d-flex justify-content-between align-items-center header-actions row mt-75"' +
                        '<"col-sm-12 col-lg-9 d-flex justify-content-center justify-content-lg-start" <"search-filter me-2"f> <"reference_categories mt-1 me-2"> <"reference_countries mt-1 me-2"> <"reference_object_types mt-1 me-2"> >' +
                        '<"col-sm-12 col-lg-3 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"B>>' +
                        '>t' +
                        '<"d-flex justify-content-between mx-2 row mb-1"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    language: {
                        search: '',
                        searchPlaceholder: '{{ __('Search') }}',
                        paginate: {
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        },
                        emptyTable: "{{ __('No data available in table') }}",
                        info: "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_  {{ __('results') }}",
                        zeroRecords: "{{ __('No records found') }}",
                        infoFiltered: "({{ __('filtered') }} {{ __('from') }} _MAX_ {{ __('total') }} {{ __('records') }})",
                        infoEmpty: "{{ __('Showing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_  {{ __('results') }}",
                    },
                    // Buttons with Dropdown
                    buttons: [
                        {
                            text: '<i class="fa fa-plus" style="padding-right: 10px;"></i> {{ __('Add Reference') }}',
                            className: 'add-new btn btn-primary',
                            action: function ( e, dt, button, config ) {
                                window.location = '{{ route('indexdata') }}';
                            }
                        }
                    ],
                    // For responsive popup
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    var data = row.data()
                                    return 'Details of ' + data['full_name']
                                }
                            }),
                            type: 'column',
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.columnIndex !== 5 // ? Do not show row in modal popup if title is blank (for check box)
                                        ? '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex + '">' +
                                        '<td>' + col.title + ':' + '</td> ' + '<td>' + col.data + '</td>' + '</tr>'
                                        : ''
                                }).join('')
                                return data ? $('<table class="table">').append('<tbody>' + data + '</tbody>') : false
                            }
                        }
                    },
                    initComplete: function () {
                        // Adding role filter once table initialized
                        @php $typeSelect = "<select id='reference_objekt_type_filter' class='form-select text-capitalize mb-md-0 mb-2'><option value=''>" . __('All Object Types') . "</option>"; @endphp
                        @foreach($objektTypes as $code => $type)
                        @php $typeSelect .= "<option value='$code'>" . __(''.$type) . "</option>"; @endphp
                        @endforeach
                        @php $typeSelect .= "</select>"; @endphp
                        $("{!!  $typeSelect  !!}").appendTo('.reference_object_types').on("change", function (){
                            $(".reference-list-table").DataTable().draw(true);
                        });

                        @php $categorySelect = "<select id='reference_category_filter' class='form-select text-capitalize mb-md-0 mb-2'><option value=''>" . __('All Categories') . "</option>"; @endphp
                        @foreach($objektCategories as $code => $type)
                        @php $categorySelect .= "<option value='$code'>" . __(''.$type) . "</option>"; @endphp
                        @endforeach
                        @php $categorySelect .= "</select>"; @endphp
                        $("{!!  $categorySelect  !!}").appendTo('.reference_categories').on("change", function (){
                            $(".reference-list-table").DataTable().draw(true);
                        });

                    }
                });
            }

        });
    </script>
@endpush

@endsection