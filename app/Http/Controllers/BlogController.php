<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Blog;

use App\Categorie;

use Illuminate\Support\Facades\Input;

class BlogController extends Controller
{

    public function index(){

        $posts=Blog::All();
        $categories=Categorie::All();

        return view("layouts/blog")->with(array(
            "blogs" => $posts,
            "categories" => $categories,
            "auteur" => 'Thomas BONNELYE'
            ));

    }

    public function post_unique($id){

        $post=Blog::find($id);

        return view("layouts/blogpost")->with(array(
            "blog" => $post
        ));

    }

    public function nouveau_blog(){

        $categories=Categorie::pluck('titre_categorie', 'id')->prepend('---');

        return view ('layouts.nouveau')->with(array("categories"=>$categories));

    }

    public function creation_blog(){

        $blog=Blog::create(Input::all());

        return redirect('/blog/'.$blog->id);

    }

    public function edition_post($id){

        $categories=Categorie::pluck('titre_categorie', 'id')->prepend('---');

        $blog=Blog::find($id);

        return view('layouts.edition')->with(array("categories"=>$categories, "blog"=> $blog));

    }

    public function edition_valider(Request $request, $id){

        $blog_a_editer=Blog::find($id);
        $blog_a_editer->update(Input::All());

        return redirect('/blog/'.$blog_a_editer->id)->withSuccess('L\'article ' .$id. ' a bien été édité');

    }

    public function suppression_post($id){

        $blog_a_supprimer=Blog::find($id);
        $blog_a_supprimer->delete(Input::All());

        return redirect('/')->withSuccess('L\'article ' .$id. ' a bien été supprimé');

    }
}
