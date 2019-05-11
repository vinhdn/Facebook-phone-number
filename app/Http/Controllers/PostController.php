<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePostFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Phone;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $post;
    private $phone;

    public function __construct(Post $post, Phone $phone)
    {
        $this->post = $post;
        $this->phone = $phone;

        $this->middleware('auth')
                    ->except([
                        'index', 'show', 'phone'
                    ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->with('user')->latest()->paginate();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdatePostFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePostFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = kebab_case($request->title);
            $extension = $request->image->extension();
            $nameImage = "{$name}.$extension";
            $data['image'] = $nameImage;

            $upload = $request->image->storeAs('posts', $nameImage);

            if (!$upload)
                return redirect()
                            ->back()
                            ->with('errors', ['Falha no Upload'])
                            ->withInput();
        }

        $post = $request->user()
                            ->posts()
                            ->create($data);

        return redirect()
                    ->route('posts.index')
                    ->withSuccess('Cadastro realizado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$post = $this->post->find($id))
            return redirect()->back();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$post = $this->post->find($id))
            return redirect()->back();

        return view('posts.edit', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function phone($phone)
    {
        if(!$phone) {
            return ['status' => 0];
        }
        if (!$post = $this->phone->find($phone))
            return ['status' => 0];

        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdatePostFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePostFormRequest $request, $id)
    {
        if (!$post = $this->post->find($id))
            return redirect()->back();

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Remove image if exists
            if ($post->image) {
                if (Storage::exists("posts/{$post->image}"))
                    Storage::delete("posts/{$post->image}");
            }
            
            $name = kebab_case($request->title);
            $extension = $request->image->extension();
            $nameImage = "{$name}.$extension";
            $data['image'] = $nameImage;

            $upload = $request->image->storeAs('posts', $nameImage);

            if (!$upload)
                return redirect()
                            ->back()
                            ->with('errors', ['Falha no Upload'])
                            ->withInput();
        }

        $post->update($data);

        return redirect()
                    ->route('posts.index')
                    ->withSuccess('Post atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$post = $this->post->find($id))
            return redirect()->back();

        $post->delete();

        return redirect()
                    ->route('posts.index')
                    ->withSuccess('Post deletado com sucesso!');
    }
}
