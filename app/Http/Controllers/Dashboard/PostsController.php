<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\WebsiteCategory;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:posts-read')->only('index', 'show');
        $this->middleware('permission:posts-create')->only('create', 'store');
        $this->middleware('permission:posts-update')->only('edit', 'update');
        $this->middleware('permission:posts-delete|posts-trash')->only('destroy', 'trashed');
        $this->middleware('permission:posts-restore')->only('restore');
    }

    public function index()
    {


        $posts = Post::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = WebsiteCategory::all();
        return view('dashboard.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => "required|string|max:255|unique:posts",
            'name_en' => "required|string|max:255|unique:posts",
            'category_id' => "required|string",
            'image' => "required|image",
            'sort_order' => "nullable|string",
            'images' => "nullable|array",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",
        ]);


        if ($request->hasFile('image')) {
            $media_id = saveMedia('image', $request['image'], 'posts');
        }

        $post = Post::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'website_category_id' => $request['category_id'],
            'sort_order' => $request['sort_order'],
            'media_id' => isset($media_id) ? $media_id : null,
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'seo_meta_tag' => $request['seo_meta_tag'],
            'seo_desc' => $request['seo_desc'],
        ]);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'products');
                PostImage::create([
                    'post_id' => $post->id,
                    'media_id' => $media_id,
                ]);
            }
        }

        alertSuccess('post created successfully', 'تم إضافة المنشور بنجاح');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        $post = Post::findOrFail($post);
        $categories = WebsiteCategory::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name_ar' => "required|string|max:255|unique:posts,name_ar," . $post->id,
            'name_en' => "required|string|max:255|unique:posts,name_en," . $post->id,
            'category_id' => "required|string",
            'image' => "nullable|image",
            'sort_order' => "nullable|string",
            'images' => "nullable|array",
            'description_ar' => "nullable|string",
            'description_en' => "nullable|string",
            'seo_meta_tag' => "nullable|string",
            'seo_desc' => "nullable|string",
        ]);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $media_id = saveMedia('image', $file, 'posts');
                PostImage::create([
                    'post_id' => $post->id,
                    'media_id' => $media_id,
                ]);
            }
        }

        if ($request->hasFile('image')) {
            if ($post->media_id != null) {
                deleteImage($post->media_id);
            }
            $media_id = saveMedia('image', $request['image'], 'posts');
            $post->update([
                'media_id' => $media_id,
            ]);
        }

        $post->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'website_category_id' => $request['category_id'],
            'sort_order' => $request['sort_order'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'seo_meta_tag' => $request['seo_meta_tag'],
            'seo_desc' => $request['seo_desc'],
        ]);

        alertSuccess('post updated successfully', 'تم تعديل المنشور بنجاح');
        return redirect()->route('posts.index');
    }

    public function deleteMedia(Request $request)
    {

        $request->validate([
            'media_id' => "required|integer",
            'image_id' => "required|integer",
        ]);

        deleteImage($request->media_id);
        $image = PostImage::findOrFail($request->image_id);
        $image->delete();

        return 1;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        $post = Post::withTrashed()->where('id', $post)->first();
        if ($post->trashed() && auth()->user()->hasPermission('posts-delete')) {
            $post->forceDelete();
            alertSuccess('post deleted successfully', 'تم حذف المنشور بنجاح');
            return redirect()->route('posts.trashed');
        } elseif (!$post->trashed() && auth()->user()->hasPermission('posts-trash') && checPostForTrash($post)) {
            $post->delete();
            alertSuccess('post trashed successfully', 'تم حذف المنشور مؤقتا');
            return redirect()->route('posts.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the post cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المنشور لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.posts.index', ['posts' => $posts]);
    }

    public function restore($post, Request $request)
    {
        $post = Post::withTrashed()->where('id', $post)->first()->restore();
        alertSuccess('post restored successfully', 'تم استعادة المنشور بنجاح');
        return redirect()->route('posts.index');
    }
}
