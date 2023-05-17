<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" method="POST">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <input type="hidden" id="id-field" />
                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Title</label>
                        <input type="text" name='title' id="customername-field" class="form-control" placeholder="Enter Title" required />
                        <div class="invalid-feedback">Please enter a name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="permisson-fields" class="form-label">Permissions</label>
                        @php
                            $permissions = \App\Models\Permission::all(['id','code', 'title', 'group']);
                            $permissions = $permissions->groupBy('group');
                        @endphp
                        <div class="row">
                        @foreach($permissions as $group => $values)
                            <div class="col-lg-4 col-sm-6">
                                <h5>{{ $group }}</h5>
                                @foreach($values as $permission)
                                    <div class="form-check form-switch">
                                        <label for="{{ $permission->code }}" class="form-label">{{ $permission->title }}</label>
                                        <input name="permissions[]"
                                               class="form-check-input"
                                               type="checkbox"
                                               role="switch"
                                               id="{{ $permission->code }}"
                                               value="{{$permission->id}}"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add Role</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>