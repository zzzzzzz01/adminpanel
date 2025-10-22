<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(120);
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.index')->with([
            'posts'=>$posts, 
            'categories'=>$categories,
            'tags'=>$tags,
        ]);
    }

    public function search(Request $request)
    {
        $data = $request->q;

        if (empty($data)) {
            return redirect()->route('posts.index');
        }

        $posts = Post::where('title_uz','like','%' .$data. '%')
        ->orwhere('title_ru','like','%' .$data. '%')
        ->orwhere('title_en','like','%' .$data. '%')
        ->get();

        if ($posts->isEmpty()) {
            $message = "Sizning so'rovingiz natijasida yangilik topilmadi.";
        } else {
            $message = "Sizning so'rovingiz natijasida " . $posts->count() . " ta yangilik topildi.";
        }

        return view('posts.index', compact('posts', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create')->with([
            'categories'=>Category::all(),
            'tags'=>Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title_uz'=>'required',
            'title_ru'=>'required',
            'title_en'=>'required',
            'content_uz'=>'required',
            'content_ru'=>'required',
            'content_en'=>'required',
            'description_uz'=>'required',
            'description_ru'=>'required',
            'description_en'=>'required',
        ]);

        // dd($request);

        if($request->hasFile('photo')){
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('imagePost', $name, 'public');
        }

        $post = Post::create([
            'user_id'=>auth()->user()->id,
            'category_id'=>$request->category_id,
            'title_uz'=>$request->title_uz,
            'title_ru'=>$request->title_ru,
            'title_en'=>$request->title_en,
            'content_uz'=>$request->content_uz,
            'content_ru'=>$request->content_ru,
            'content_en'=>$request->content_en,
            'description_uz'=>$request->description_uz,
            'description_ru'=>$request->description_ru,
            'description_en'=>$request->description_en,
            'photo'=>$path ?? null,
        ]);

        if(isset($request->tags)){
            foreach($request->tags as $tag){
                $post->tags()->attach($tag);
            }
        }

        $usersToNotify = User::where('id', '!=', auth()->id())->get();
        Notification::send($usersToNotify, new PostCreated($post));

        return redirect()->route('posts.index')->with('createPost', __('words.post.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // $post->increment('views');

        return view('posts.show')->with([
            'post'=>$post,
            'latestPosts'=>Post::latest()->where('id', '!=', $post->id)->take(5)->get(),
            'categories'=>Category::all(),
            'tags'=>Tag::all(),
            'user'=>User::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validation qoidalarini yumshatamiz
        $validated = $request->validate([
            'title_uz' => 'sometimes|string',
            'title_ru' => 'sometimes|string',
            'title_en' => 'sometimes|string',
            'content_uz' => 'sometimes|string',
            'content_ru' => 'sometimes|string',
            'content_en' => 'sometimes|string',
            'description_uz' => 'sometimes|string',
            'description_ru' => 'sometimes|string',
            'description_en' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|exists:tags,id',
        ]);
    
        // Yangilanishlar massivi
        $updateData = [];
        
        // Barcha tekst maydonlari uchun
        $fields = ['title', 'content', 'description'];
        foreach ($fields as $field) {
            foreach (['uz', 'ru', 'en'] as $lang) {
                $key = "{$field}_{$lang}";
                if ($request->has($key)) {
                    $updateData[$key] = $request->$key;
                }
            }
        }
    
        // Kategoriya
        if ($request->has('category_id')) {
            $updateData['category_id'] = $request->category_id;
        }
    
        // Teglar
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }
    
        // Rasm
        if ($request->hasFile('photo')) {
            if ($post->photo) {
                Storage::delete($post->photo);
            }
            $path = $request->file('photo')->store('imagePost', 'public');
            $updateData['photo'] = $path;
        }
    
        // Ma'lumotlarni yangilash
        $post->update($updateData);
    
        return redirect()->route('posts.show', $post->id)->with('success', __('words.post.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(isset($post->photo)){
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('deletePost', __('words.post.delete'));
    }
}
