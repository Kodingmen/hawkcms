<div class="modal fade" id="showUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Update Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>

            <form class="tablelist-form" autocomplete="off" method="POST" action="{{ $route }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id-field" />
                    <div class="mb-3">
                        <label for="title-field" class="form-label">Title</label>
                        <input type="text" name='title' id="title-field"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Title"
                               value="{{ $item->title }}"
                               required
                               />
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>