<?php

namespace App\Http\Controllers\Admin\Modules\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.modules.blog.blog_list');
    }

    /* ===========================
       BLOG LIST
    ============================ */
    public function blog_list(Request $request)
    {
     // DataTables parameters
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        // Base query
        $query = Blog::query();

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // Total records (without filters)
        $recordsTotal = Blog::count();

        // Total records (with filters)
        $recordsFiltered = $query->count();

        // Fetch paginated data
        $blogs = $query
            ->orderBy('updated_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

         // Prepare response data
        $data = [];

        foreach ($blogs as $blog) {
            $data[] = [
                'id'           => $blog->id,
                'post_title'   => $blog->post_title,
                'post_content' => strip_tags(Str::limit($blog->post_content, 120)),

                'post_image' => $blog->post_image
                    ? asset('storage/blog_pics_app/' . $blog->post_image)
                    : null,

                'user_type' => ucfirst($blog->user_type),
                'user_name' => $blog->user_name,

                'status' => $blog->status,

                'updated_at' => $blog->updated_at
                    ? $blog->updated_at->format('d-m-Y')
                    : '',

                // Action URLs
                'view_url' => route('view.blog', $blog->id),
                'delete_url' => route('del.blog', $blog->id),

                'status_toggle_url' => $blog->status === 'published'
                    ? route('inactive.blog', $blog->id)
                    : route('active.blog', $blog->id),
            ];
        }

        // DataTables JSON response
        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }
    /* ===========================
       ADD PAGE
    ============================ */
    public function blog_add_page()
    {
        return view('admin.modules.blog.blog_add');
    }

    /* ===========================
       INSERT
    ============================ */
    public function blog_ins(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'      => 'required',
            'post_content'    => 'required',
            'user_type'       => 'required',
            'seo_keyword'     => 'required',
            'seo_description' => 'required',
            'seo_page_title'  => 'required',
            'status'          => 'required',
            'post_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $imageName = null;

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = time() . '-' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move('storage/blog_pics_app/', $imageName);
        }

        $blog = new Blog();
        $blog->seo_keyword     = $request->seo_keyword;
        $blog->seo_description = $request->seo_description;
        $blog->seo_page_title  = $request->seo_page_title;
        $blog->post_title      = $request->post_title;
        $blog->post_content    = $request->post_content;
        $blog->slug            = Str::slug($request->post_title);
        $blog->post_image      = $imageName;
        $blog->user_type       = $request->user_type;
        $blog->user_name       = $request->user_name;
        $blog->display_order   = $request->display_order ?? 0;
        $blog->status          = $request->status ?? 'draft';
        $blog->save();

        return response()->json([
            'success' => true,
            'message' => 'Blog added successfully'
        ]);
    }


    /* ===========================
       DELETE (SOFT DELETE)
    ============================ */
    public function blog_del($id)
    {
          $blog = Blog::find($id);

        if (!$blog) {
            return back()->with('error', 'This blog id does not exist');
        }

        // delete image from server
        $imagePath = 'storage/blog_pics_app/' . $blog->post_image;
        if ($blog->post_image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $blog->delete();

        return back()->with('success', 'Blog removed successfully');
    }

    /* ===========================
       ACTIVATE
    ============================ */
    public function blog_active($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return back()->with('error', 'This blog id does not exist');
        }

        $blog->update(['status' => 'published']);

        return back()->with('success', 'Blog successfully activated');
    }

    /* ===========================
       INACTIVE
    ============================ */
    public function blog_inactive($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return back()->with('error', 'This blog id does not exist');
        }

        $blog->update(['status' => 'draft']);

        return back()->with('success', 'Blog successfully deactivated');
    }

    /* ===========================
       VIEW
    ============================ */
    public function blog_view($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return back()->with('error', 'This blog id does not exist');
        }

        $data['blog'] = $blog;
        return view('admin.modules.blog.blog_view')->with($data);
    }


    /* ===========================
       UPDATE
    ============================ */
    public function blog_update(Request $request)
    {
        // validate inputs
        $validator = Validator::make($request->all(), [
            'post_title'      => 'required',
            'post_content'    => 'required',
            'user_type'       => 'required',
            'seo_keyword'     => 'required',
            'seo_description' => 'required',
            'seo_page_title'  => 'required',
            'status'          => 'required',
            'post_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $blog = Blog::find($request->blog_id);

        if (!$blog) {
            return response()->json([
                'success' => false,
                'errors' => ['blog_id' => ['Blog not found']]
            ], 404);
        }

        $imageName = $blog->post_image;

        if ($request->hasFile('post_image')) {

            // delete old image if exists
            $oldImage = 'storage/blog_pics_app/' . $blog->post_image;
            if ($blog->post_image && file_exists($oldImage)) {
                unlink($oldImage);
             }
            // upload new image
            $image = $request->file('post_image');
            $imageName = time() . '-' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move('storage/blog_pics_app/', $imageName);
            }

        $blogSlug = Str::slug($request->post_title);

        $blog->update([
            'seo_keyword'     => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'seo_page_title'  => $request->seo_page_title,
            'post_title'      => $request->post_title,
            'post_content'    => $request->post_content,
            'post_image'      => $imageName,
            'user_type'       => $request->user_type,
            'user_name'       => $request->user_name,
            'display_order'   => $request->display_order ?? 0,
            'status'          => $request->status,
            'slug'            => $blogSlug,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully'
        ]);
    }


}
