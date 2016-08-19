<?php
namespace app\api\controller;
//use think\Controller;
use app\api\model\Blog;
class Blogs extends Base
{
    public function blogs()
    {
        $page = $this->page(Blog::count(), $this->params->page, $this->params->size);
        $blogs = Blog::order('create_time', 'desc')->limit($page['offset'], $page['limit'])->select();
        foreach($blogs as $blog)
        {
            $blog->user;
        }
        return json([
            'blogs' => $blogs,
            'page' => $page
        ]);
    }
    
    public function blog()
    {
        //$id = $this->get_blog_id;
        $blog = Blog::get($this->params->id);
        $blog->user;
        return json(['blog' => $blog]);
    }
    public function blog_delete($id)
    {
        if (!$this->is_admin()) {
            return json(['error'=>'非法操作']);
        }
        $result = Blog::destroy($id);
        if ($result) {
            return json(['success'=>'删除成功']);
        } else {
            return json(['error'=>'删除失败']);
        }
    }
    public function blog_save()
    {
        if (request()->isPost()) {
        if ($this->user === '') {
            return json(['error'=>'非法操作']);
        }
        if($this->params->id != 'new' and Blog::get($this->params->id)->user_id != $this->user->id) {
            return json(['error'=>'非法操作']);
        };
        if ($this->params->id=='new')
        {
            $blog = new Blog;
            $blog->data([
                'content' => $this->params->content,
                'title' => $this->params->title,
                'user_id' => $this->user->id,
            ]);
            $result = $blog->save();
            if ($result) {
                $blog_id = $result;
            } else {
                return json(['error'=> '保存失败']);
            }
        } else {
            $blog = Blog::get($this->params->id);
            $blog->content = $this->params->content;
            $blog->title = $this->params->title;
            $result = $blog->save();
            if ($result) {
                $blog_id = $this->params->id;
            } else {
                return json(['error'=> '保存失败']);
            }
        }
        return json(['success'=>'保存成功','blog_id'=>$blog_id]);
        }
    }
    
}
