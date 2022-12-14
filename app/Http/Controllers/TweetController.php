<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\HashTag;

class TweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['create', 'store', 'edit', 'update', 'destroy']
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tweets = Tweet::all();

        return view('tweet.index', [
            'tweets' => $tweets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tweet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => ['required', 'string', 'max:255'],
            'hash_tags' => ['string', 'max:255']
        ]);
        
        $tweet = new Tweet;
        $tweet->body = $request->input('body');
        $tweet->user_id = $request->user()->id;
        $tweet->save();

        $hash_tag_names = preg_split('/\s+/', $request->input('hash_tags'), -1, PREG_SPLIT_NO_EMPTY);
        $hash_tag_ids = [];
        foreach ($hash_tag_names as $hash_tag_name) 
        {
            $hash_tag = HashTag::firstOrCreate([
                'name' => $hash_tag_name,
            ]);

            $hash_tag_ids[] = $hash_tag->id;
        }

        $tweet->hashTags()->sync($hash_tag_ids);
        
        session()->flash('flash_message', 'ツイートの新規投稿が完了しました！');

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::find($id);

        return view('tweet.show', [
            'tweet' => $tweet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tweet = Tweet::find($id);

        return view('tweet.edit', [
            'tweet' => $tweet,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'body' => ['required', 'string', 'max:255']
        ]);
        
        $tweet = Tweet::find($id);
        $tweet->body = $request->input('body');
        $tweet->save();

        $hash_tag_names = preg_split('/\s+/', $request->input('hash_tags'), -1, PREG_SPLIT_NO_EMPTY);
        $hash_tag_ids = [];
        foreach ($hash_tag_names as $hash_tag_name) 
        {
            $hash_tag = HashTag::firstOrCreate([
                'name' => $hash_tag_name,
            ]);
            
            $hash_tag_ids[] = $hash_tag->id;
        }

        $tweet->hashTags()->sync($hash_tag_ids);

        return redirect()->route('tweets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);
        $tweet->delete();

        return redirect()->route('tweets.index');
    }

    public function showByHashTag($id)
    {
        $hash_tag = HashTag::find($id);
        
        return view('tweet.index', [
            'tweets' => $hash_tag->tweets
        ]);
    }
}
