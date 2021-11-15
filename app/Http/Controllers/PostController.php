<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\PostVote;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class PostController extends Controller
{
	private $rules = [
		'name' => ['required'],
		'symbol' => ['required'],
		'description' => ['required'],
		'price' => ['required', 'numeric'],
		'yesterday' => ['required', 'numeric'],
		'capital' => ['required', 'integer'],
		'photo' => ['max:8192', 'mimes:webp,svg+xml,png,jpeg,gif'],
		'launched_at' => ['nullable', 'date'],
	];

    /**
     * Show the coins screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        return Inertia::render('Post/Show', [
			'image' => Storage::url('static/soon.svg'),
			'keyword' => $request->input('keyword'),
            // 'posts' => Post::where('name', 'like', '%' . $request->input('keyword') . '%')
			// 				->orderByDesc('updated_at')
			// 				->paginate(10)
			// 				->through(fn ($coin) => [
			// 					'id' => $coin->id,
			// 					'article' => $coin->article,
			// 					'user_id' => $coin->user_id,
			// 					'featured_photo_path' => $coin->featured_photo_path,
			// 					'featured_photo_url' => $coin->featured_photo_url,
			// 					'created_at' => $coin->created_at,
							// ]),
        ]);
    }

	/**
     * Show the detailed coin screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function detailView(Request $request, $id)
    {
		$coin = Post::find($id);

		$coin->load('votes');

        return Inertia::render('Post/Detail', [
            'coin' => $coin,
        ]);
    }

	/**
     * Add new coins screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function createView(Request $request)
    {
        return Inertia::render('Post/Create', [
            'prefill' => $request,
        ]);
    }

	/**
     * Edit coins screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function editView(Request $request, $id)
    {
		// $coin = Post::find($id);
		//
        // return Inertia::render('Post/Edit', [
        //     'coin' => $coin,
        // ]);
    }

	/**
     * Add new coin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
		$validator = Validator::make($request->all(), $this->rules);

		$coin = new Post;

		$coin->name = $validator->validated()['name'];
		$coin->symbol = $validator->validated()['symbol'];
		$coin->price = $validator->validated()['price'];
		$coin->yesterday = $validator->validated()['yesterday'];
		$coin->description = $validator->validated()['description'];
		$coin->capital = $validator->validated()['capital'];
		$coin->launched_at = $validator->validated()['launched_at'];

		$coin->user_id = $request->user()->getAuthIdentifier();

		if ($request->hasFile('photo')) {
			$coin->featured_photo_path = 'storage/coin/' . basename(
				$request->file('photo')->store('public/coin')
			);
		}

		$coin->save();

		return Redirect::route('dashboard');
    }

	/**
     * Edit coin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request, $id)
    {
		// $validator = Validator::make($request->all(), $this->rules);
		//
		// $coin = Post::find($id);
		//
		// $coin->name = $validator->validated()['name'];
		// $coin->symbol = $validator->validated()['symbol'];
		// $coin->price = $validator->validated()['price'];
		// $coin->yesterday = $validator->validated()['yesterday'];
		// $coin->capital = $validator->validated()['capital'];
		// $coin->launched_at = $validator->validated()['launched_at'];
		//
		// if ($request->hasFile('photo')) {
		// 	$coin->featured_photo_path = 'storage/coin/' . basename(
		// 		$request->file('photo')->store('public/coin')
		// 	);
		// }
		//
		// $coin->save();
		//
		// return Inertia::render('Post/Edit', [
		// 	'coin' => $coin,
		// ]);
    }

	/**
     * Destroy coins data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function destroy(Request $request, $id)
    {
		// $coin = Post::destroy($id);

		return Redirect::route('dashboard');
    }
}
