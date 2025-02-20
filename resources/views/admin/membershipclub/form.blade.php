@extends('layouts.admin')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        #editor,
        #goalseditor {
            height: 300px;
        }

        .file-group {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }

        .filepond--root {}

        .nav-link {
            color: #0c0b0b;
        }

        .nav-link.active {
            color: #f4bd0e !important;
        }

        .filepond--credits {
            display: none;
        }
    </style>
    @php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
    @endphp
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Membership Club</h4>

            </div>
        </div>
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <ul class="nav justify-content-start">
                            <li class="nav-item">
                                <a class="nav-link @if ($_GET['step'] == 1) active @endif" aria-current="page"
                                    href="{{ isset($_GET['id']) ? url('admin/membershipclubs/new?step=1&id=' . $_GET['id']) : url('admin/membershipclubs/new?step=1') }}">
                                    Basic Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($_GET['step'] == 2) active @endif
                                @if (!isset($_GET['id'])) disabled @endif"
                                    @if (isset($_GET['id'])) href="{{ url('admin/membershipclubs/new?step=2&id=' . $_GET['id']) }}" @else aria-disabled="true" href="#" @endif>
                                    Further Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($_GET['step'] == 3) active @endif
                                @if (!isset($_GET['id'])) disabled @endif"
                                    @if (isset($_GET['id'])) href="{{ url('admin/membershipclubs/new?step=3&id=' . $_GET['id']) }}" @else aria-disabled="true" href="#" @endif>
                                    Token
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($_GET['step'] == 4) active @endif
                                @if (!isset($_GET['id'])) disabled @endif"
                                    @if (isset($_GET['id'])) href="{{ url('admin/membershipclubs/new?step=4&id=' . $_GET['id']) }}" @else aria-disabled="true" href="#" @endif>
                                    Blogs & News
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($_GET['step'] == 5) active @endif
                                @if (!isset($_GET['id'])) disabled @endif"
                                    @if (isset($_GET['id'])) href="{{ url('admin/membershipclubs/new?step=5&id=' . $_GET['id']) }}" @else aria-disabled="true" href="#" @endif>
                                    Libarary
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        @isset($_GET['step'])
                            @if ($_GET['step'] == 1)
                                <form action="{{ route('membershipclubs.step1') }}" method="post" id="step1"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-label">Title</div>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="title" id="title" required
                                                        class="form-control"
                                                        @isset($membershipclub)
                                            value="{{ $membershipclub->title }}" required
                                            @endisset>
                                                    @if ($errors->has('title'))
                                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-2 ">
                                            <label for="" class="form-label">Price In Ivest Tokens </label>
                                            <div class="form-control-warp">
                                                <input type="text" class="form-control" name="price"
                                                    @isset($membershipclub)
                                            value="{{ $membershipclub->price }}" required
                                            @endisset>
                                                @if ($errors->has('price'))
                                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-4 mb-2 ">
                                            <label for="" class="form-label">Status </label>
                                            <div class="form-control-warp">
                                                <select name="status" id="status" class="form-select">
                                                    <option value="1"
                                                        @isset($membershipclub)
                                        @if ($membershipclub->status == 1)
                                            selected
                                        @endif
                                        @endisset>
                                                        Active</option>
                                                    <option value="0"
                                                        @isset($membershipclub)
                                                    @if ($membershipclub->status == 0) selected @endif
                                                    @endisset>
                                                        In
                                                        Active</option>

                                                </select>
                                                {{--  <input type="text" class="form-control" name="price"  --}}


                                                {{--  >  --}}
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-group">
                                                <label for="overview" class="form-label">Short OverView</label>
                                                <textarea maxlength="255" name="overview" id="overview" required cols="30" rows="2" style="min-height: 50px"
                                                    class="form-control">
                                                    @isset($membershipclub)
                                                        {{ $membershipclub->overview }}
                                                    @endisset
                                                </textarea>
                                                <div id="the-count" class="d-flex justify-content-end">
                                                    <span id="current">0</span>
                                                    <span id="maximum">/ 255</span>
                                                </div>

                                                @if ($errors->has('ovreview'))
                                                    <span class="text-danger">{{ $errors->first('ovreview') }}</span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>

                                                @if ($errors->has('details'))
                                                    <span class="text-danger">{{ $errors->first('details') }}</span>
                                                @endif
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
                                                <div id="editor" onchange="stepdetail()">

                                                </div>
                                            </div>
                                            <textarea name="details" id="details" cols="30" rows="10" style="display: none"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="form-label">Cover</div>
                                                <div class="form-control-wrap">
                                                    <input type="file" name="cover" id="cover" accept="image/*"
                                                        required class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end my-3">
                                            @if (isset($membershipclub))
                                                <input type="hidden" name="id" value="{{ $membershipclub->id }}">
                                            @endif
                                            <a href="{{ url('admin/membershipclubs/') }}" class="btn btn-danger">Cancel</a>

                                            <button type="button" id="step1btn" class="btn btn-warning">Next</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @if ($_GET['step'] == 2 && isset($_GET['id']))
                                <form action="{{ route('membershipclubs.step2') }}" method="post" id="step2">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <div class="form-group">
                                                <textarea name="goals" id="goals" cols="30" rows="10" style="display: none"></textarea>
                                                <textarea name="features" id="features" cols="30" rows="10" style="display: none"></textarea>

                                                <label for="" class="form-label">
                                                    Membership Club Features
                                                </label>
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
                                                        <button class="ql-clean"></button>
                                                    </span>
                                                </div>
                                                <div id="editor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <div class="form-group">
                                                <label for="" class="form-label">
                                                    Membership Club Goals
                                                </label>
                                                <div id="goalstoolbar-container">
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
                                                        <button class="ql-clean"></button>
                                                    </span>
                                                </div>
                                                <div id="goalseditor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2 ">
                                            <label for="" class="form-label">Discord Channel Prefix: </label>
                                            <div class="form-control-warp">

                                                <input name="discordwidget" id="discordwidget" cols="30" rows="5"
                                                    class="form-control"
                                                    @isset($membershipclub)
                                               @if ($membershipclub->discordwidget)
                                        value='{{ $membershipclub->discordwidget }}'
                                         @else
                                        value='{{ $membershipclub->title }}'

                                        @endif
                                                @endisset />

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="" class="form-label text-capitalize">
                                                    Membership Exclusive Video Title
                                                </label>
                                                <div class="form-control-warp">

                                                    <input type="text" name="ytvideotitle" id=""
                                                        class="form-control"
                                                        @isset($membershipclub)
                                        value="{{ $membershipclub->VideoTitle }}"
                                        @endisset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <div class="form-group">
                                                <label for="" class="form-label">Introductory Youtube video Embed
                                                    Code</label>
                                                <div class="form-control-warp">
                                                    <textarea name="ytembed" id="ytembed" cols="30" rows="5" class="form-control"> @isset($membershipclub)
                                                    {{ $membershipclub->publicYTembed }}
                                                    @endisset
                                                </textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-2">
                                            <label for="" class="form-label text-capitalize">
                                                Membership Exclusive Video Embed Code

                                            </label>
                                            <div class="form-control-warp">
                                                <textarea name="ytvideo" id="ytvideo" cols="30" rows="5" class="form-control"> @isset($membershipclub)
                                        {{ $membershipclub->privateYTembed }}
                                            @endisset
                                            </textarea>


                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-12 text-end">
                                        <input type="hidden" name="id" value="{{ $membershipclub->id }}">
                                        <a href="{{ url("admin/membershipclubs/new?step=1&id=$id") }}"
                                            class="btn btn-danger">Back</a>
                                        <button type="button" class="btn btn-warning" id="step2btn">Next</button>
                                    </div>
                                </form>

                                @endif
                            @if ($_GET['step'] == 3 && isset($_GET['id']))
                                <form action="{{ route('membershipclubs.step3') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">
                                                    Token Name
                                                </label>
                                                <div class="form-control-warp">
                                                    <input type="text" name="title" required id=""
                                                        class="form-control"
                                                        @isset($token)
                                            value="{{ $token->name }}"
                                            @endisset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">Token Symbol</label>
                                                <input type="text" name="symbol" required id=""
                                                    class="form-control"
                                                    @isset($token)
                                            value="{{ $token->symbol }}"
                                            @endisset>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Token Icon </label>
                                                <input type="file" name="logo" required id="cover"
                                                    accept="image/*" class="form-control">

                                            </div>
                                        </div>


                                        <div class="col-12 text-end">
                                            <input type="hidden" name="id" value="{{ $membershipclub->id }}">
                                            <a href="{{ url("admin/membershipclubs/new?step=2&id=$id") }}"
                                                class="btn btn-danger">Back</a>
                                            <input type="submit" value="Save" class="btn btn-warning">
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @if ($_GET['step'] == 4 && isset($_GET['id']))
                                <form action="{{ route('membershipclubs.step3') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">


                                        <div class="col-md-6 mb-2">
                                            <div class="form-group row">
                                                <div class=" col-6">
                                                    <label for="" class="form-label">
                                                        List of Membership Club Blogs
                                                    </label>
                                                </div>
                                                <div class=" col-6 text-end">
                                                    {{--  <a href="{{ url("admin/blogs/create?membershipclub_id=$membershipclub->id") }}"
                                                        target="_blank" class="btn btn-warning btn-icon">
                                                        <em class="icon ni ni-plus"></em>
                                                    </a>
                                                      --}}
                                                    <div class="drodown"><a href="#"
                                                            class="dropdown-toggle btn btn-icon btn-warning "
                                                            data-bs-toggle="dropdown" aria-expanded="true"><em
                                                                class="icon ni ni-plus"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end "
                                                            style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 50.4px, 0px);"
                                                            data-popper-placement="bottom-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a target="_blank"
                                                                        href="{{ url("admin/blogs/create?membershipclub_id=$membershipclub->id") }}"><span>Add
                                                                            Blog</span></a></li>
                                                                <li><button class="btn " type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#blogmodel"><span>Add
                                                                            Link</span></button></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list-group my-2">
                                                    @foreach ($blogs as $blog)
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-between">
                                                                <span>
                                                                    {{ $blog->title }}
                                                                </span>
                                                                @if ($blog->type == 'blog')
                                                                    <a href="{{ url("admin/blogs/create?id=$blog->id") }}"
                                                                        target="_blank" class='text-warning'>
                                                                        <em class="icon ni ni-pen"></em>
                                                                    </a>
                                                                @else
                                                                    <button class="btn p-0 m-0 text-warning" type="button"
                                                                        data-bs-toggle="modal" data-bs-target="#blogmodel"
                                                                        onclick="editblogdata({{ $blog }})"> <em
                                                                            class="icon ni ni-pen"></em></button>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group row">
                                                <div class=" col-6">
                                                    <label for="" class="form-label">
                                                        List of Membership Club News
                                                    </label>
                                                </div>
                                                <div class=" col-6 text-end">

                                                    <div class="drodown"><a href="#"
                                                            class="dropdown-toggle btn btn-icon btn-warning "
                                                            data-bs-toggle="dropdown" aria-expanded="true"><em
                                                                class="icon ni ni-plus"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end "
                                                            style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 50.4px, 0px);"
                                                            data-popper-placement="bottom-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a target="_blank"
                                                                        href="{{ url("admin/news/create?membershipclub_id=$membershipclub->id") }}"><span>Add
                                                                            Blog</span></a></li>
                                                                <li><button class="btn " type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#newsmodel"><span>Add
                                                                            Link</span></button></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list-group my-2">
                                                    @foreach ($news as $article)
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-between">
                                                                <span>
                                                                    {{ $article->title }}
                                                                </span>
                                                                @if ($article->type == 'news')
                                                                    <a href="{{ url("admin/news/create?id=$article->id") }}"
                                                                        target="_blank" class='text-warning'>
                                                                        <em class="icon ni ni-pen"></em>
                                                                    </a>
                                                                @else
                                                                    <button class="btn p-0 m-0 text-warning" type="button"
                                                                        data-bs-toggle="modal" data-bs-target="#newsmodel"
                                                                        onclick="editnewsdata({{ $article }})"> <em
                                                                            class="icon ni ni-pen"></em></button>
                                                                @endif


                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <input type="hidden" name="id" value="{{ $membershipclub->id }}">
                                            <a href="{{ url("admin/membershipclubs/new?step=3&id=$id") }}"
                                                class="btn btn-danger">Back</a>
                                            <a href="{{ url("admin/membershipclubs/new?step=5&id=$id") }}"
                                                class="btn btn-warning">Next</a>
                                            {{--  <input type="submit" value="Save" class="btn btn-warning">  --}}
                                        </div>
                                    </div>
                                </form>
                            @endif
                            @if ($_GET['step'] == 5 && isset($_GET['id']))
                                <form action="{{ route('membershipclubs.step5') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="form-label">Add Files </div>
                                                <div class="form-control-wrap">
                                                    <input type="file" name="clubfiles[]" id="files"
                                                        class="form-control" data-allow-Multiple="true"
                                                        data-max-file-size="3MB" data-max-files="10">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="list-group 0">
                                                @foreach ($membershipclubfiles as $file)
                                                    <li class="list-group-item file-group">
                                                        <span>
                                                            {!! getFileIcon($file->file) !!}
                                                            <a href="{{ asset($file->file) }}" download>
                                                                {{ basename($file->name) }}
                                                            </a>
                                                        </span>
                                                        <span>
                                                            <a href="{{ url("admin/membershipclub/file/$file->id") }}"
                                                                class="btn p-0 m-0 text-danger">
                                                                <em class="icon ni ni-trash-alt"></em>
                                                            </a>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="col-12 text-end my-3">
                                            <input type="hidden" name="id" value="{{ $membershipclub->id }}">
                                            <a href="{{ url("admin/membershipclubs/new?step=3&id=$id") }}"
                                                class="btn btn-danger">Back</a>
                                            {{--  <a href="{{ url("admin/membershipclubs/new?step=5&id=$id") }}"
                                        class="btn btn-warning">Next</a>  --}}
                                            <input type="submit" value="Save" class="btn btn-warning">
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endisset
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('models')
    <div class="modal fade" id="blogmodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Blog </h5><a href="#" class="close" data-bs-dismiss="modal"
                        onclick="resetforms()" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="blogform" method="POST"
                        action="{{ url('admin/blog/url/save') }}">
                        @csrf
                        <input type="hidden" name="id" value="0" id="id">
                        <input type="hidden" name="clubid"
                            value="@isset($id)
                        {{ $id }}
                        @endisset"
                            id="clubid">

                        <div class="form-group"><label class="form-label" for="full-name">Title</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="title"
                                    name="title" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="full-name">Url</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="content"
                                    name="url" required></div>
                        </div>




                    </form>
                </div>
                <div class="modal-footer bg-light"><span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn  btn-warning" form="blogform">Save
                                Informations</button>
                        </div>
                    </span></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newsmodel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> News </h5><a href="#" class="close" data-bs-dismiss="modal"
                        onclick="resetforms()" aria-label="Close"><em class="icon ni ni-cross"></em></a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" id="newsform" method="POST"
                        action="{{ url('admin/news/url/save') }}">
                        @csrf

                        <input type="hidden" name="id" value="0" id="id">
                        <input type="hidden" name="clubid"
                            value="@isset($id)
                        {{ $id }}
                        @endisset"
                            id="clubid">

                        <div class="form-group"><label class="form-label" for="full-name">Title</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="title"
                                    name="title" required></div>
                        </div>
                        <div class="form-group"><label class="form-label" for="full-name">Url</label>
                            <div class="form-control-wrap"><input type="text" class="form-control" id="content"
                                    name="url" required></div>
                        </div>




                    </form>
                </div>
                <div class="modal-footer bg-light"><span class="sub-text">
                        <div class="form-group">
                            <button type="submit" class="btn  btn-warning" form="newsform">Save
                                Informations</button>
                        </div>
                    </span></div>
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
        const inputElement = document.getElementById('cover');
        const filesinput = document.getElementById('files');

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
        );
        // Create a FilePond instance
        const pond = FilePond.create(inputElement, {
            storeAsFile: true,
        });
        const files = FilePond.create(filesinput, {
            storeAsFile: true,
        })
        @if (isset($_GET['step']) && ($_GET['step'] == 2 || $_GET['step'] == 1))
            const quilldesc = new Quill('#editor', {
                modules: {
                    syntax: true,
                    toolbar: '#toolbar-container',
                },
                theme: 'snow',
            });
        @endif
        @if (isset($_GET['step']) && $_GET['step'] == 2)
            const quillgoals = new Quill('#goalseditor', {
                modules: {
                    syntax: true,
                    toolbar: '#goalstoolbar-container',
                },
                theme: 'snow',
            });
            quillgoals.root.innerHTML = `{!! $membershipclub->goals !!}`;
            if (document.getElementById('step2btn')) {
                document.getElementById('step2btn').addEventListener('click', function(event) {
                    event.preventDefault();
                    document.getElementById('goals').innerHTML = quilldesc.root.innerHTML;
                    document.getElementById('features').innerHTML = quillgoals.root.innerHTML;

                    document.getElementById('step2').submit();
                })
            }
        @endif


        if (document.getElementById('step1btn')) {
            document.getElementById('step1btn').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('details').innerHTML = quilldesc.root.innerHTML;
                document.getElementById('step1').submit();
            })
        }
        @if (isset($membershipclub) && $_GET['step'] == 1)
            {
                quilldesc.root.innerHTML = `{!! $membershipclub->content !!}`;

                imageUrl = window.location.origin + '/'
                imageUrl += '{{ $membershipclub->img }}';
                {{--  console.log('{{asset('imageUrl')}}');  --}}
                pond.addFile(imageUrl).catch(error => {
                    console.error('Error loading image into FilePond:', error);
                });


            }
        @endif
        @if (isset($token) && $_GET['step'] == 3)
            {


                imageUrl = window.location.origin + '/'
                imageUrl += '{{ $token->logo }}';
                {{--  console.log('{{asset('imageUrl')}}');  --}}
                pond.addFile(imageUrl).catch(error => {
                    console.error('Error loading image into FilePond:', error);
                });


            }
        @endif
        @if (isset($membershipclub) && $_GET['step'] == 2)
            {
                quilldesc.root.innerHTML = `{!! $membershipclub->features !!}`;
                quilldesc.root.innerHTML = `{!! $membershipclub->goals !!}`;



            }
        @endif
        function editblogdata(blogdata) {
            let blogform = document.getElementById('blogform');
            console.log(blogdata)

            blogform.querySelector('#id').value = blogdata.id;
            blogform.querySelector('#title').value = blogdata.title;
            blogform.querySelector('#content').value = blogdata.content;
        }

        function editnewsdata(blogdata) {
            newsform = document.getElementById('newsform');
            newsform.querySelector('#id').value = blogdata.id;
            newsform.querySelector('#title').value = blogdata.title;
            newsform.querySelector('#content').value = blogdata.content;
        }

        function resetforms() {
            document.getElementById('blogform').reset();
            document.getElementById('newsform').reset();

        }
        $('#overview').keyup(function() {

            var characterCount = $(this).val().length,
                current = $('#current'),
                maximum = $('#maximum'),
                theCount = $('#the-count');

            current.text(characterCount);


            /*This isn't entirely necessary, just playin around*/
            if (characterCount < 70) {
                current.css('color', '#666');
            }
            if (characterCount > 70 && characterCount < 90) {
                current.css('color', '#6d5555');
            }
            if (characterCount > 90 && characterCount < 100) {
                current.css('color', '#793535');
            }
            if (characterCount > 100 && characterCount < 120) {
                current.css('color', '#841c1c');
            }
            if (characterCount > 120 && characterCount < 139) {
                current.css('color', '#8f0001');
            }

            if (characterCount >= 140) {
                maximum.css('color', '#8f0001');
                current.css('color', '#8f0001');
                theCount.css('font-weight', 'bold');
            } else {
                maximum.css('color', '#666');
                theCount.css('font-weight', 'normal');
            }


        });
    </script>
@endsection
