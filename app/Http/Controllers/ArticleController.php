<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Article;

class ArticleController extends APIController
{
    // Name of resource 
    private $resource = 'article';

    /**
     * index
     *
     * Display a listing of the resource.
     * 
     * @param   \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::all();
        return new ArticleCollection($articles);
    }

    /**
     * show 
     * 
     * Display the specified resource
     * 
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        try
        {
            $article = Article::where('id', $id)->firstOrFail();
            return new ArticleResource($article);
        }
        catch(Exception $e)
        {
            return $this->responseServerError('Error fetching '.$this->resource);
        }
    }
    
    /**
     * store
     * 
     * Store a newly created resource in the database.
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get the current user
        if(! $user = auth()->user())
        {
            return $this->responseUnauthorized();
        }

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required'
        ]);

        if($validator->fails())
        {
            return $this->responseUnprocessable($validator->errors());
        }

        try
        {
            $article = Article::create([
                'user_id' => $user->id,
                'title' => request('title'),
                'body' => request('body')
            ]);
            return $this->responseResourceCreated($article->id, $this->resource.' created.');
        }
        catch(Exception $e)
        {
            return $this->responseServerError('Error creating '.$this->resource); 
        }
    }


    /**
     * update
     *
     * Update the specified resource in the database.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(! $user = auth()->user())
        {
            return $this->responseUnauthorized();
        }

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required'
        ]);
        if($validator->fails())
        {
            return $this->responseUnprocessable($validator->errors());
        }

        try
        {
            $article = Article::where('id', $id)->firstOrFail();
            // User can only edit their own articles
            if($article->user_id === $user->id)
            {
                $article->title = request('title');    
                $article->body = request('body');
                $article->save();
                return $this->responseResourceUpdated($id, $this->resource.' updated.');
            }
            return $this->responseUnauthorized();
        }
        catch(Exception $e)
        {
            return $this->responseServerError('Error updating '.$this->resource);   
        }
    }

   
    /**
     * destroy
     * 
     * Remove the specified resource from the database.
     * 
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(! $user = auth()->user())
        {
            return $this->responseUnauthorized();
        }
        try 
        {
            $article = Article::where('id', $id)->firstOrFail();
            // User can only delete their own articles
            if($article->user_id === $user->id)
            {
                $article->delete();
                return $this->responseResourceDeleted($id, $this->resource.' deleted.');
            }
            return $this->responseUnauthorized();
        }
        catch(Exception $e)
        {
            return $this->responseServerError('Error deleting '.$this->resource);
        }
    }   
}
