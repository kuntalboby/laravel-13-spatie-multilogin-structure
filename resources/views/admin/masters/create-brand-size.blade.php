@section('title', 'Generate CSV Size Chart')
<x-admin.inner>
        @php
$params['title'] = 'Generate CSV Size Chart';
        @endphp
        <x-admin.breadcrumb :params="$params" />
        <section class="content">
            <div class="container-fluid">
                
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div>
                            @if (session('message'))
                                <div class="alertBox">
                                    <p class="text-center text text-{{session('response')}}">{{session('message')}}</p>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- general form elements -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Generate CSV Size Chart</h3>
                                <div class="card-tools">

                                    <a href="{{route('admin.masters.brand.sizes', $brand->randomid)}}" class="btn btn-light">
                                        Back
                                    </a>

                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.masters.store.brand.size', $brand->randomid)}}" 
                                method="post"
                                id="sizeCsvForm">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="brand_slug" value="{{$brand->randomid}}">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="category_id">Category *</label>
                                                <select class="form-control" 
                                                name="category_id" id="category_id" required>
                                                    <option value="0">Choose Category</option>
                                                    @foreach ($allcategory as $category)
                                                        <option value="{{ $category->randomid }}">
                                                                {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="target_age">Target Age *</label>
                                                <select class="form-control" name="target_age" id="target_age" required>
                                                    <option value="0">Choose Target Age</option>
                                                    <option value="A">For Adult</option>
                                                    <option value="K">For Kids</option>                                        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_type">Product Type *</label>
                                                <select class="form-control" name="product_type" 
                                                    id="product_type" required>
                                                    <option value="0">Choose Type</option>
                                                    <option value="T">Top Wear</option>
                                                    <option value="B">Bottom Wear</option>
                                                    <option value="S">Shoes</option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="gender_id">Gender *</label>
                                                <select class="form-control" name="gender_id" 
                                                    id="gender_id" required>
                                                    <option value="0">Choose Gender</option>
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender->id }}">
                                                            {{ $gender->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="">&nbsp;</label>
                                                <span class="form-control border-0 p-0 float-right">
                                                    <button type="submit" 
                                                    class="btn btn-warning">Get Excel</button>
                                                </span>
                                              </div>
                                          </div>      
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                        {{-- Upload File Form --}}
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Upload CSV File</h3>
                             </div>
                             <Form 
                              action="{{ route('admin.masters.upload.brand.sizes', $brand->randomid) }}"
                                method="POST"
                                enctype="multipart/form-data">
                             <div class="card-body">
                               
                                @csrf
                                {{-- @method('PUT') --}}
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="excel_file">Choose Excel File*</label>
                                        <input type="file" class="form-control-file" 
                                        id="excel_file" name="excel_file" accept=".xlsx" required />    
                                    </div>
                                </div>
                                
                             </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                            </Form>
                        </div>        

                        {{-- end --}}


                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    <script>
        document.getElementById('sizeCsvForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = this;
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = 'Generating...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form), // includes _token automatically
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json', // so Laravel returns JSON errors, not a redirect
                    },
                });

                // Validation or server error
                if (!response.ok) {
                    let message = 'Something went wrong. Please try again.';
                    try {
                        const data = await response.json();
                        if (data.errors) {
                            message = Object.values(data.errors).flat().join('\n');
                        } else if (data.message) {
                            message = data.message;
                        }
                    } catch (_) { }
                    alert(message);
                    return;
                }

                // Get filename from the header (fallback if missing)
                let filename = 'brand_sizes.csv';
                const disposition = response.headers.get('Content-Disposition');
                if (disposition) {
                    const match = disposition.match(/filename="?([^"]+)"?/);
                    if (match) filename = match[1];
                }

                // Download the blob
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

            } catch (error) {
                console.error(error);
                alert('Network error. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    </script>
</x-admin.inner>