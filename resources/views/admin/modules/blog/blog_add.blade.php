@extends('admin.layouts.app')

@section('title')
Blog Management
@endsection

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
.blog-editor-wrapper,
.blog-editor-wrapper textarea,
.mce-tinymce,
.mce-container,
.mce-edit-area,
.mce-edit-area iframe {
    width: 100% !important;
    max-width: 100% !important;
}

.blog-image-preview {
    display: none;
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 1px solid #ddd;
    padding: 4px;
    border-radius: 4px;
}

.remove-image-btn {
    display: none;
    margin-top: 6px;
}

label.error {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}

.backend-error {
    color: #e74c3c;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
.post-image-label {
    display: block;
    margin-bottom: 6px;
}

.label-title {
    display: block;
}

.label-hint {
    display: block;
    font-size: 12px;
}


</style>
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')
<div class="content">
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left page-title">Add Blog</h1>
            <div class="rm05 backclass">
                <a href="{{ route('blog.list') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">

        <form id="frm" enctype="multipart/form-data">
            @csrf

            <div class="panel-heading rm02 rm04">

                <!-- ROW 1 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>User Type *</label>
                        <select name="user_type" class="form-control">
                            <option value="">Select type</option>
                            <option value="admin">Admin</option>
                            <option value="author">Author</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>User Name</label>
                        <input type="text" name="user_name" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Display Order</label>
                        <input type="number" name="display_order" class="form-control">
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Post Title *</label>
                        <input type="text" name="post_title" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>SEO Page Title *</label>
                        <input type="text" name="seo_page_title" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Status *</label>
                        <select name="status" class="form-control">
                            <option value="">Select status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 3 -->
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>SEO Keywords *</label>
                        <input type="text" name="seo_keyword" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>SEO Description *</label>
                        <input type="text" name="seo_description" class="form-control">
                    </div>
                </div>

                <!-- ROW 4 -->
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="post-image-label">
                            <span class="label-title">Post Image *</span>
                            <span class="text-muted label-hint">
                                (Recommended size: 900 × 420 px)
                            </span>
                        </label>
                        <input type="file" name="post_image" id="post_image"
                               class="form-control"
                               accept="image/*"
                               onchange="previewBlogImage(this)">
                        <button type="button"
                                class="btn btn-danger btn-sm remove-image-btn"
                                onclick="removeBlogImage()">
                            Remove Image
                        </button>
                    </div>

                    <div class="form-group col-md-6">
                        <img id="blog_preview" class="blog-image-preview">
                    </div>
                </div>

                <!-- ROW 5 -->
                <div class="row">
                    <div class="form-group col-md-12 blog-editor-wrapper">
                        <label>Post Content *</label>
                        <textarea name="post_content" class="desc form-control"></textarea>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="row">
                    <div class="col-md-12 faqbtn rm05">
                        <button type="button" class="btn btn-primary w-md" id="submitBtn">
                            Add Blog
                        </button>
                    </div>
                </div>

            </div>
        </form>
        <div id="successMessage" class="alert alert-success" style="display:none;"></div>
    </div>
    </div>
    </div>

</div>
</div>
@endsection

@section('footer')
@include('admin.includes.footer')
@endsection

@section('script')
@include('admin.includes.script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<script>
$(document).ready(function () {

    tinymce.init({
        selector: "textarea.desc",
        height: 380
    });

    $.validator.setDefaults({
        ignore: ":hidden:not(.desc)"
    });

    $('#frm').validate({
        rules: {
            user_type: "required",
            post_title: "required",
            seo_page_title: { required: true, maxlength: 60 },
            status: "required",
            seo_keyword: { required: true, maxlength: 250 },
            seo_description: { required: true, maxlength: 160 },
            post_image: { required: true, extension: "jpg|jpeg|png|webp" },
            post_content: "required"
        },
        messages: {
            seo_page_title: {
                maxlength: "SEO Page Title cannot exceed 60 characters"
            },
            seo_keyword: {
                maxlength: "SEO Keywords cannot exceed 250 characters"
            },
            seo_description: {
                maxlength: "SEO Description cannot exceed 160 characters"
            }
        }
    });

    $("#submitBtn").on("click", function () {

        tinymce.triggerSave();

        if (!$('#frm').valid()) {
            return;
        }

        // remove previous backend errors
        $(".backend-error").remove();

        let btn = $(this);
        btn.prop("disabled", true).html(
            `<span class="spinner-border spinner-border-sm"></span> Saving...`
        );

        fetch("{{ route('blog.added') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById("frm"))
        })
        .then(res => res.json())
        .then(data => {

            if (data.success) {
                $("#successMessage").text(data.message).fadeIn();
                setTimeout(function () {
                    $("#successMessage").fadeOut();
                }, 3000);
                $('#frm')[0].reset();
                tinymce.get().forEach(ed => ed.setContent(""));
                removeBlogImage();

            } else if (data.errors) {

                // display backend validation errors
                $.each(data.errors, function (field, messages) {
                    let input = $('[name="' + field + '"]');
                    if (input.length) {
                        input.after(
                            `<label class="error backend-error">${messages[0]}</label>`
                        );
                    }
                });

                // scroll to first error
                $('html, body').animate({
                    scrollTop: $('.backend-error:first').offset().top - 100
                }, 400);
            }

        })
        .catch(() => alert("Something went wrong"))
        .finally(() => {
            btn.prop("disabled", false).text("Add Blog");
        });
    });
});

/* IMAGE PREVIEW */
function previewBlogImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e => {
            $('#blog_preview').attr('src', e.target.result).show();
            $('.remove-image-btn').show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeBlogImage() {
    $('#post_image').val('');
    $('#blog_preview').hide().attr('src', '');
    $('.remove-image-btn').hide();
}
</script>
@endsection
