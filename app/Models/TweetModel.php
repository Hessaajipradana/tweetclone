<?php

namespace App\Models;

use App\Entities\Tweet;
use CodeIgniter\Model;

class TweetModel extends Model
{
    protected $table = 'tweets';
    protected $allowedFields = [
        'user_id', 'content', 'category', 'image_path'
    ];

    protected $returnType = \App\Entities\Tweet::class;
    public $rules = [
        'image_path' => 'upload[image_path]|max_size[image_path,1024]|is_image[image_path]',
        'content' => 'required',
        'category' => 'required'
    ];

    public function newTweet($curUser, $post)
    {
        $tweet = new Tweet();
        $tweet->user_id = $curUser['userid'];
        $tweet->content = $post['content'];
        $tweet->category = $post['category'];
        if (!empty($post['image_path'])) {
            $tweet -> image_path = $post['image_path'];
        }
        $this->save($tweet);
    }

    //DISINI MERUBAH PROFIL
    public function getLatest()
    {
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at , profile_image,image_path')
                    ->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');
        return $query->findAll();
    }

    public function getByCategory($category)
    {
        $query = $this->select('tweets.id, user_id, username, fullname, content, category, created_at, profile_image')
                    ->where('category', $category)->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = tweets.user_id');
        return $query->findAll();
    }

    //fungsi edit tweet
    public function editTweet($post)
    {
        $tweet = $this->find($post['id']);
        if($tweet){
            $tweet->content = $post['content'];
            $tweet->category = $post['category'];
            $this->save($tweet);
            return true;
        } else {
            return false;
        }
    }

    //fungsi delete
    public function delTweet($user_id, $tweet_id)
    {
        $tweet = $this->find($tweet_id);
        if($tweet){
            if($user_id == $tweet->user_id){
                $this->delete($tweet->id, true);
                return true;
            } else {
                return false;
            }
        }
    }
}