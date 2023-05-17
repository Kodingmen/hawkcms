@extends("layouts.master")
@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <h5 class="card-title mb-0">@lang('admin.menu.'.$entity.'.title')</h5>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="d-flex flex-wrap align-items-start justify-content-end gap-2">
                                <button type="button"
                                        class="btn btn-success add-btn"
                                        data-bs-toggle="modal"
                                        id="create-btn"
                                        data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> {{ __("admin::pages.btn.add") }}</button>

{{--                                <a href="{{ route('dashboard.'.$entity.'.create') }}" type="button"--}}
{{--                                        class="btn btn-success add-btn"--}}
{{--                                        id="create-btn"--}}
{{--                                        ><i class="ri-add-line align-bottom me-1"></i> Add New Content</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <button class="btn btn-soft-danger"
                                    id="remove-actions"
                                    onclick="deleteMultiple()"
                                    style="display: block;">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex gap-2">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search for name or email ..." id="custom-input-search">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                                <button class="btn btn-success" id="custom-btn-submit"><i class="ri-equalizer-line align-bottom me-1" ></i> Search</button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
                <div class="card-body p-4">
                    {{ $datatables->html() }}
                </div>
            </div>
        </div>
    </div>
    @include("dashboard.pages.$entity.modal.create")
    <div id="updateContentEdit"></div>
@endsection
@section("script")
    {{ $datatables->includeScript() }}

    <script>
        function singleDelete(id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                cancelButtonClass: 'btn btn-danger w-xs mt-2',
                confirmButtonText: "Yes, delete it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then(function (result) {
                if (result.value) {
                    try {
                        axios.delete('{{route("dashboard.".$entity.".delete")}}', {
                            data: {
                                ids: id
                            }
                        }).then(function (response) {
                            if(response.data.success){
                                location.reload();
                            }
                        })
                    } catch (error) {
                        console.log(error)
                    }
                }
            });
        }
        function showEditModal(id){
            try {
                axios.get('{{request()->url()}}/edit/'+id, {
                    data: {
                        id: id
                    }
                }).then(function (response) {
                    console.log(response.data);
                    document.getElementById('updateContentEdit').innerHTML = response.data;
                    console.log(response.data, document.getElementById('updateContentEdit'));
                    let myModal = new bootstrap.Modal(document.getElementById('showUpdateModal'), {
                        keyboard: false
                    });
                    myModal.show();
                })
            } catch (error) {
                console.log(error)
            }

        }
        function deleteMultiple() {
            ids_array = [];
            var items = document.getElementsByName('chk_child');
            for (i = 0; i < items.length; i++) {
                if (items[i].checked == true) {
                    ids_array.push(items[i].value);
                }
            }

            if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
                singleDelete(ids_array);
            } else {
                Swal.fire({
                    title: 'Please select at least one checkbox',
                    confirmButtonClass: 'btn btn-info',
                    buttonsStyling: false,
                    showCloseButton: true
                });
            }
        }
    </script>
@endsection

@push("css")
    {{ $datatables->includeStyles() }}
@endpush
@push("js")
    {{ $datatables->script() }}
@endpush

