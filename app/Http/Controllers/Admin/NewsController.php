<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{

  public function add()
  {
    return view('admin.news.create');
  }
  public function create(Request $request)
  {
    //validationを行う
    $this->varlidate($request, News::$rules);
    $this->varlidate($request, Profiles::$rules);

    $news = new News;
    $news = new Profiles;
    $form = $request->all();

    // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
    if (isset($form['image'])) {
      $path = $request->file('image')->store('public/image');
      $news->image_path = basename($path);
    } else {
      $news->image_path = null;
    }
    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    // フォームから送信されてきたimageを削除する
    unset($form['image']);

    // データベースに保存する
    $news->fill($form);
    $news->save();

    // admin/     /createにリダイレクトする
    return redirect('admin/news/create');
    return redirect('admin/profile/create');
  }
}
