<?php
namespace app\api\controller;
//use think\Controller;
use app\api\model\Blog;
use app\api\model\Comment;
class Comments extends Base
{
    
    public function comments()
    {
        $page_index = $this->params->page;
        if ($this->params->id == '') {
            $count = Comment::count();
            $page = $this->page($count, $page_index, $this->params->size);
            $page['top'] = '#';
            $comments = Comment::order('create_time', 'desc')->limit($page['offset'], $page['limit'])->select();
        } else {
            $count = Comment::where('blog_id', $this->params->id)->count();
            $page = $this->page($count, $page_index, $this->params->size);
            $page['top'] = '#comment_top';
            $comments = Comment::where('blog_id', $this->params->id)->order('create_time', 'desc')->limit($page['offset'], $page['limit'])->select();
        }
        //$comments = Comment::order('create_time', 'desc')->limit($page['offset'], $page['limit'])->select();
        foreach($comments as $comment)
        {
            $comment->user;
        }
        //$page['top'] = '#comment_top';
        return json([
            'comments' => $comments,
            'page' => $page
        ]);
    }
    public function comment_save()
    {
        if (request()->isPost()) {
        if ($this->user === '') {
            return json(['error'=>'非法操作']);
        }
        $comment = new Comment;
        $comment->data([
            'content' => $this->params->content,
            'blog_id' => $this->params->id,
            'user_id' => $this->user->id,
        ]);
        $result = $comment->save();
        if ($result) {
            $comment = Comment::get($result);
            $comment->user;
            return json(['success'=>'评论成功', 'comment'=>[$comment]]);
        } else {
            return json(['error'=>'评论失败']);
        }
        }
    }
    public function comment_delete($id)
    {
        if (!$this->is_admin()) {
            return json(['error'=>'非法操作']);
        }
        $result = Comment::destroy($id);
        if ($result) {
            return json(['success'=>'删除成功']);
        } else {
            return json(['error'=>'删除失败']);
        }
    }
}
