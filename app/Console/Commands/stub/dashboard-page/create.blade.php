@extends("layouts.master")
@section("content")
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="project-title-input">Title</label>
                        <input type="text" class="form-control" id="cms-title-input" placeholder="Enter title" name="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Content</label>
                        <div>
                            <textarea class="form-control" name="short_content">
                            </textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea id="ckeditor-classic" name="content">
                        </textarea>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <!-- end card -->
            <div class="text-end mb-4">
                <button type="submit" class="btn btn-success w-sm">Create</button>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Visibility</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-privacy-status-input" class="form-label">Visibility</label>
                        <select class="form-select" data-choices data-choices-search-false id="choices-privacy-status-input" name="visibility">
                            <option value="1" selected>Show</option>
                            <option value="0">Hidden</option>
                        </select>
                    </div>
                    <div>
                        <label for="indexContent" class="form-label">Index</label>
                        <input type="number" min="1" name="index" class="form-control" id="indexContent" value="1">
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection

@section("css")
    <link href="{{ asset("assets/libs/dropzone/dropzone.css") }}" rel="stylesheet" type="text/css" />

@endsection
@section("script")
    <script src="{{asset("assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js")}}"></script>
    <script src="{{asset("assets/libs/dropzone/dropzone-min.js")}}"></script>
    <script src="{{asset("assets/js/pages/project-create.init.js")}}"></script>
@endsection