<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use App\Models\Coin;
use App\Models\CoinVote;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class CoinController extends Controller
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
        return Inertia::render('Coin/Show', [
			'keyword' => $request->input('keyword'),
            'coins' => Coin::where('name', 'like', '%' . $request->input('keyword') . '%')
							->orderByDesc('updated_at')
							->paginate(10)
							->through(fn ($coin) => [
								'id' => $coin->id,
								'name' => $coin->name,
								'symbol' => $coin->symbol,
								'price' => $coin->price,
								'yesterday' => $coin->yesterday,
								'capital' => $coin->capital,
								'launched_at' => $coin->launched_at,
								'user_id' => $coin->user_id,
								'votes' => $coin->votes,
								'logo_path' => $coin->logo_path,
								'logo_url' => $coin->logo_url,
								'created_at' => $coin->created_at,
							]),
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
		$coin = Coin::find($id);

		$coin->load('votes');

        return Inertia::render('Coin/Detail', [
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
        return Inertia::render('Coin/Create', [
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
		// $coin = Coin::find($id);
		//
        // return Inertia::render('Coin/Edit', [
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

		$coin = new Coin;

		$coin->name = $validator->validated()['name'];
		$coin->symbol = $validator->validated()['symbol'];
		$coin->price = $validator->validated()['price'];
		$coin->yesterday = $validator->validated()['yesterday'];
		$coin->description = $validator->validated()['description'];
		$coin->capital = $validator->validated()['capital'];
		$coin->launched_at = $validator->validated()['launched_at'];

		$coin->user_id = $request->user()->getAuthIdentifier();

		if ($request->hasFile('photo')) {
			$coin->logo_path = 'storage/coin/' . basename(
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
		// $coin = Coin::find($id);
		//
		// $coin->name = $validator->validated()['name'];
		// $coin->symbol = $validator->validated()['symbol'];
		// $coin->price = $validator->validated()['price'];
		// $coin->yesterday = $validator->validated()['yesterday'];
		// $coin->capital = $validator->validated()['capital'];
		// $coin->launched_at = $validator->validated()['launched_at'];
		//
		// if ($request->hasFile('photo')) {
		// 	$coin->logo_path = 'storage/coin/' . basename(
		// 		$request->file('photo')->store('public/coin')
		// 	);
		// }
		//
		// $coin->save();
		//
		// return Inertia::render('Coin/Edit', [
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
		// $coin = Coin::destroy($id);

		return Redirect::route('dashboard');
    }

	/**
     * Vote coin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function vote(Request $request, $id)
    {
		CoinVote::firstOrCreate([
			'coin_id' => $id,
			'user_id' => $request->user()->getAuthIdentifier(),
			'ip_address' => $request->ip,
			'user_agent' => $request->user_agent,
		]);

		if (Route::currentRouteName('coin.detail', $id)) {
			return Redirect::route('coin.detail', $id);
		} else {
			return Redirect::route('dashboard');
		}
    }
}
