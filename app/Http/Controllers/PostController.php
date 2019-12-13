<?php

namespace App\Http\Controllers;

use App\Post;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {
	use ApiResponser;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Return post list
	 *
	 * @return Illuminate\Http\Response
	 */
	public function index() {
        //$posts = DB::table('posts')->get();
        //$posts = Post::withTrashed()->get(); trae todos los registros de la base de datos con los que tambien han sido eliminados 
        //$posts = Post::onlyTrashed()->get(); trae unicamente los registros que han sido eliminados
        $posts = Post::all();

		return $this->successResponse($posts);
	}

	/**
	 * Create an instance of post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$rules = [
			'name' => 'required|min:5|max:255',
			'author' => 'required|min:5|max:255',
			'description' => 'required|min:5|max:255',
		];

		$this->validate($request, $rules);
		
		$post = Post::create($request->all());

		return $this->successResponse($post, Response::HTTP_CREATED);
	}

	/**
	 * return an specific post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function show($id) {
		$post = Post::active()->get();
		
		return $this->successResponse($post);
	}

	/**
	 * update the information of an existing post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$rules = [
			'name' => 'min:5|max:255',
			'author' => 'min:5|max:255',
			'description' => 'min:5|max:255',
		];

		$this->validate($request, $rules);
		
		$post = Post::findOrFail($id);

		$post->fill($request->all());

		if ($post->isClean()) {
			return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$post->save();

		return $this->successResponse($post);
	}

	/**
	 * delete an existing post
	 *
	 * @return Illuminate\Http\Response
	 */
	public function destroy($id) {
		$post = Post::findOrFail($id);

		$post->delete();

		return $this->successResponse($post);
	}

}
