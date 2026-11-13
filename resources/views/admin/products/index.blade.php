<x-admin.inner>
    @php
$params['title'] = 'All Products';
    @endphp
    <x-admin.breadcrumb :params="$params" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
    
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                            <div class="card-tools">
                                <a href="{{route('admin.masters.products.create')}}" class="btn btn-primary text text-light">
                                    <i class="fas fa-plus"></i> Create
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="productsTable" class="table table-bordered table-hover w-100">
                                <thead>
                                    <tr>
                                        <th width="60">Image</th>
                                        <th>Name</th>
                                        <th>Sizes</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th width="90">Status</th>
                                        <th width="170">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    
                </div>
    
    
            </div>
    
        </div>
        </div><!-- /.container-fluid -->
    </section>

@push('cssLinks')
    <link rel="stylesheet" href="{{asset('adminassets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminassets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminassets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush    
@push('scripts')
    <script>
        $(function () {
            const table = $('#productsTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: {{ config('app.pagination_count') }},
                lengthChange: false,
                searchDelay: 400,
                order: [[1, 'asc']],
                language: {
                    search: '',
                    searchPlaceholder: 'Search name, brand or category...',
                    zeroRecords: 'No products match your search',
                },
                ajax: "{{ route('admin.masters.products.index') }}",
                columns: [
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'products.name' },
                    { data: 'sizes', orderable: false },
                    { data: 'category', orderable: true },
                    { data: 'brand', orderable: true },
                    { data: 'status', name: 'products.status' },
                    { data: 'action', orderable: false, searchable: false },
                ],
            });

            // delete with confirmation
            $('#productsTable').on('click', '.btn-delete', function () {
                if (!confirm('Delete this product?')) return;

                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: res => {
                        alert(res.message);
                        table.draw(false); // reload, stay on the current page
                    },
                    error: () => alert('Could not delete. Please try again.'),
                });
            });
        });
    </script>
    <script src="{{asset('adminassets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{asset('adminassets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endpush
</x-admin.inner>