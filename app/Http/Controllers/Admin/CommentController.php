<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    public function index()
    {
      return view('admin/comment/index')->withComments(Comment::all());
    }

    public function destroy($id)
    {
      Comment::find($id)->delete();
      return redirect()->back()->withInput()->withErrors('删除成功');
    }

    public function edit($id)
    {
      return view('admin/comment/edit')->withComment(Comment::find($id));
    }

    public function update(Request $request, $id)
    {
      $this->validate($request, [
          // 'id' => 'required',
          'content' => 'required',
          'article_id' => 'required',
          'nickname' => 'required',
          'email' => 'required',
          'website' => 'required',
      ]);
      $comment = comment::find($id);
      $comment->id = $request->get('id');
      $comment->content = $request->get('content');
      $comment->article_id = $request->get('article_id');
      $comment->nickname = $request->get('nickname');
      $comment->email = $request->get('email');
      $comment->website = $request->get('website');
      if ($comment->save()) {
          return redirect('admin/comment');
      } else {
          return redirect()->back()->withInput()->withErrors('更新失败！');
      }
    }
}
