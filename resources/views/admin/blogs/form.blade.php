@extends('layouts.admin')
@section('content')
    {{--  <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.min.css">  --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        #editor {
            height: 300px;
        }

        .filepond--credits {
            display: none;
        }
    </style>

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Blogs</h4>

            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered h-100">
                    <div class="card-inner pb-0">
                        <div class="card-head">

                            <h5 class="card-title">Blogs Form</h5>

                            <form id="blogform" class="form-validate" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="0">
                                @if (isset($_GET['membershipclub_id']))
                                    <input type="hidden" name="membershipclub_id" id="membershipclub_id"
                                        value="{{ $_GET['membershipclub_id'] }}">
                                @endif
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label class="form-label" for="title">Title</label>
                                        <div class="form-control-wrap"><input type="text" class="form-control"
                                                id="title" name="title" required>
                                        </div>

                                    </div>


                                    <div class="form-group col-lg-4">
                                        <label class="form-label">Category </label>
                                        <select name="category" id="caegory" class="form-select" required>
                                            {{--  <option value=""></option>  --}}
                                            @foreach ($blogcategories as $blogcategory)
                                                <option value="{{ $blogcategory->id }}">{{ $blogcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="form-label">Status </label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="0">Draft</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Published</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="form-label" for="excerpt">Excerpt</label>
                                        <div class="form-control-wrap">
                                            <textarea name="excerpt" id="excerpt" cols="30" rows="1" class="form-control" maxlength="255" required></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-control-warp">
                                            <div id="toolbar-container">
                                                <span class="ql-formats">
                                                    <select class="ql-font"></select>
                                                    <select class="ql-size"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>
                                                    <button class="ql-strike"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <select class="ql-color"></select>
                                                    <select class="ql-background"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-script" value="sub"></button>
                                                    <button class="ql-script" value="super"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-header" value="1"></button>
                                                    <button class="ql-header" value="2"></button>
                                                    <button class="ql-blockquote"></button>
                                                    <button class="ql-code-block"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                    <button class="ql-indent" value="-1"></button>
                                                    <button class="ql-indent" value="+1"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-direction" value="rtl"></button>
                                                    <select class="ql-align"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-link"></button>
                                                    <button class="ql-image"></button>
                                                    <button class="ql-video"></button>
                                                    <button class="ql-formula"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-clean"></button>
                                                </span>
                                            </div>
                                            <div id="editor">
                                            </div>
                                            <em id="detailserror" class="text-danger"
                                                style="display: none; font-size:10px">This Field is Required </em>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 ">
                                        <label class="form-label" for="thumbnail">Thumbnail</label>
                                        <div class="form-control-wrap">
                                            <input type="file" class="form-control" id="thumbnail" name="filepond"
                                                accept="image/*" data-max-file-size="5MB" data-allow-reorder="true"
                                                data-max-file-size="3MB" data-max-files="3" required />
                                        </div>
                                    </div>
                                    <div class="col-12 my-3 text-end">
                                        <a href="{{ route('blogs') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-warning">Save Information </button>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('extra-script')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js">
    </script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        const inputElement = document.getElementById('thumbnail');
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
        );
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            storeAsFile: true,
        });

        const quill = new Quill('#editor', {
            modules: {
                syntax: true,
                toolbar: '#toolbar-container',
            },
            theme: 'snow',
        });

        document.getElementById('blogform').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Saving...', // Title of the alert
                text: 'Please wait while we process your request.', // Optional text
                allowOutsideClick: false, // Prevent closing by clicking outside
                allowEscapeKey: false,
                showConfirmButton: false,
                // Prevent closing with the escape key
                didOpen: () => {
                    Swal.showLoading(); // Show the loading animation
                }
            });
            document.getElementById('detailserror').style.display = "none";
            const formData = new FormData(this);

            let details = quill.root.innerHTML;
            details = details.trim();
            console.log(formData);
            let id = document.getElementById('id').value;
            if (details == '' || details == '<p><br></p>') {
                document.getElementById('detailserror').style.display = "block";
                return false;
            }
            formData.append('details', details)

            let fecthurl = null;
            if (id <= 0) {
                fetchurl = "{{ url('admin/blog/save') }}"
            } else {
                fetchurl = `{{ url('admin/blog/update') }}/${id}`
            }

            fetch(fetchurl, {
                    method: 'POST',
                    body: formData, // The FormData object
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                            .value, // CSRF token for Laravel
                        'accept': 'application/json'
                    }

                }).then(response => {
                    if (!response.ok) {
                        console.log(response, 'response');
                        Swal.fire(
                            'Error !',
                            response,
                            'error')

                    } else {
                        Swal.fire(
                            'Success !',
                            response,
                            'success'
                        );
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    console.log('Success:', data);
                    if (data.errors) {
                        Swal.fire(
                            'Error !',
                            data.message,
                            'error'
                        );
                    }

                    // Log the server response

                })
                .catch(error => {
                    // console.log(error);
                    // Swal.fire(
                    //     'Error !',
                    //     error,
                    //     'error'
                    // );

                });
        });

        @isset($_GET['id'])
            {
                @php

                    $id = $_GET['id'];

                @endphp
                fetch('{{ url("blog/$id") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json(); // Parses the JSON response into a JavaScript object
                    })
                    .then(data => {
                        document.getElementById('title').value = data.title;
                        quill.root.innerHTML = data.content;
                        document.getElementById('excerpt').value = data.excerpt;
                        document.getElementById('caegory').value = data.blogcategory_id;
                        document.getElementById('status').value = data.status;
                        document.getElementById('id').value = data.id;
                        if (data.thumbnail != null) {
                            imageUrl = window.location.origin + '/'
                            imageUrl += data.thumnnail;

                            pond.addFile(imageUrl).catch(error => {
                                console.error('Error loading image into FilePond:', error);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }
        @endisset
    </script>
@endsection
