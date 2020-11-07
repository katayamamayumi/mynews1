<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profiles;

class ProfileController extends Controller
{
  public function add()
  {
    return view('admin.profile.create');
  }

  public function create(Request $request)
  {
    $this->validate($request, Profiles::$rules);

    $news = new Profiles;
    $form = $request->all();


    unset($form['_token']);

    // データベースに保存する
    $news->fill($form);
    $news->save();

    // admin/     /createにリダイレクトする
    return redirect('admin/profile/create');
  }
  public function index(Request $request)
  {
    $cond_title = $request->cond_title;
    if ($cond_title != '') {
      $posts = Profiles::where('title', $cond_title)->get();
    } else {
      $posts = Profiles::all();
    }
    return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  public function edit(Request $request)
  {
    $news = Profiles::find($request->id);
    if (empty($news)) {
      abort(404);
    }
    return view('admin.profile.edit', ['news_form' => $news]);
  }


  public function update(Request $request)
  {
    $this->validate($request, Profiles::$rules);
    $news = Profiles::find($request->id);
    $news_form = $request->all();

    unset($news_form['imaage']);
    unset($news_form['remove']);
    unset($news_form['_token']);

    $news->fill($news_form)->save();

    return redirect('admin/profile');
  }
  public function delete(Request $request)
  {
    $news = Profiles::find($request->id);
    $news->delete();
    return redirect('admin/profile/');
  }
  //return redirect('admin/profile/edit');
}
