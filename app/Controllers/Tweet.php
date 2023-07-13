<?php

namespace App\Controllers;

use \App\Models\TweetModel;

class Tweet extends BaseController
{
    
    var $categories;
    var $sess;
    var $curUser;

    var $tweetMdl;
		var $profile;

    public function __construct()
    {
        $this->categories = (new \Config\AdtConfig())->getCategories();
        $this->sess = session();
        $this->curUser = $this->sess->get('currentuser');

        $this->tweetMdl = new TweetModel();
				$userMdl = new \App\Models\UserModel();
        $this->profile = $userMdl->find($this->curUser['userid']);
    }
    
    public function index()
    {       
        $data['categories'] = $this->categories;
        $data['judul'] = 'Tweet Terbaru';
        //data profile dikirim ke view
        $data['profile'] = $this->profile;
        $data['tweets'] = $this->tweetMdl->getLatest();

        return view('tweet_home', $data);
    }

    public function category($category)
    {
        $data['categories'] = $this->categories;
        $data['judul'] = 'Tweet Terbaru';

        $data['profile'] = $this->profile;
        $data['tweets'] = $this->tweetMdl->getByCategory($category);

        return view('tweet_home', $data);
    }

    public function addForm()
    {
        $data['categories'] = $this->categories;
        return view('tweet_add', $data);
    }

    public function editForm($tweet_id)
    {
        $tweet = $this->tweetMdl->find($tweet_id);
        if($tweet->user_id != $this->sess->get('currentuser')['userid']){
            $this->sess->set('edittweet', 'error');
            return redirect()->to('/');
        }
        
        $data['categories'] = $this->categories;
        $data['tweet'] = $tweet;
        return view('edit_tweet', $data);
    }

    public function addTweet()
    {
        $image_path = $this->request->getfile('image_path');
        $newName ='';
        
        if ($image_path->isValid() && !$image_path->hasMoved()) {
            $newName = $image_path -> getRandomName();
            $image_path -> move('uploads',$newName);
        }

        $tweetData = $this->request->getPost();
        $tweetData['image_path']=$newName;
        $this->tweetMdl->newTweet($this->sess->get('currentuser'), $tweetData);
        $this->sess->setFlashdata('addtweet', 'success');
        return redirect()->to('/');
    }

    //delelte tweet
    public function delTweet($tweet_id)
    {
        $result = $this->tweetMdl->delTweet($this->sess->get('currentuser')['userid'], $tweet_id);
        if($result){
            $this->sess->setFlashdata('deltweet', 'success');
        } else {
            $this->sess->setFlashdata('deltweet', 'error');
        }
        return redirect()->to('/');
    }

    public function editTweet()
    {
        $result = $this->tweetMdl->editTweet($this->request->getPost());
        if($result){
            $this->sess->setFlashdata('edittweet', 'success');
        } else {
            $this->sess->setFlashdata('edittweet', 'error');
        }

        return redirect()->to('/');
    }
}