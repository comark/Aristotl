<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Icta_Home_Controller extends Icta_Base_Controller{

    private $title = 'Home';
    private $sect = array();
    
    public function __construct() {
        parent::__construct();
    }
    
    public function action_index() {
       $this->sect['title'] = $this->title;
       $this->sect['menu_active'] = 'home';
       
       $sections = array('slider','latestblogs','teams','tabs');
       $secti = '';
       foreach($sections as $sect){
           $secti.= $this->_home_sect($sect);
       }
       $this->sect['content'] = View::make('icta::tpls.homecontent')->with('data',$secti);       
       return IctaL\Helper::make_structure($this->sect);       
    }
    
    public function action_404() {
       $this->sect['title'] = $this->title;
       $this->sect['menu_active'] = '404';
       $this->sect['content'] = View::make('icta::tpls.404');       
       return IctaL\Helper::make_structure($this->sect);       
    }  
    
    public function action_pages($page=null){
     $data = array();
      if($page==null){
        return Redirect::to('/');
      }
      ContentL\Helper::get_page_exist($page);
      $pages = ContentL\Helper::get_allactive();
      foreach ($pages as $p ) {
        if ($p->guid == $page) {
          $this->sect['menu_active'] = $p->guid;
          $this->sect['title'] = $p->title;
          
     
          $content = '';
          if (($p->template!='') || ($p->template !=null)) {
            $data['content'] = $p->content;
            $content = View::make('icta::customtpls.'.$p->template)->with('data',$data);     
          } else {
             if ($p->image) {
                $data['image'] = URL::base().'/'.$p->image;
              }
            $data['content'] = $p->content;
            $content = View::make('icta::pagetpls.default')->with('data',$data);
          }
          $sidebar = IctaL\Helper::make_sidebar();   
          
          $this->sect['content'] = View::make('icta::tpls.page')
                                              ->with('title',$p->title)
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return IctaL\Helper::make_structure($this->sect);         
    }
   }
   
   return Redirect::to('xadmin/pages/notfound');
  }
  
  public function action_contact(){
          Asset::container('last')->add('contact-css', 'icta/js/form/sky-forms2.css');
          Asset::container('last')->add('form-js', 'icta/js/form/jquery.form.min.js');
          Asset::container('last')->add('validate-js', 'icta/js/form/jquery.validate.min.js');
          Asset::container('last')->add('send-js', 'icta/js/universal/send.js');
          
          $this->sect['menu_active'] = 'Contact';
          $this->sect['title'] = 'Contact'; 
          $content = View::make('icta::pagetpls.contact');
          $widgets = array('contacts','sidelinks');
          $sidebar = IctaL\Helper::make_sidebar($widgets);  
          $this->sect['content'] = View::make('icta::tpls.page')
                                              ->with('title','Contact')
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return IctaL\Helper::make_structure($this->sect);          
   }
  
   public function action_blog($guid){
      $posts = ContentM\ContentPost::posts_active()->get();
      
      $active_post = null;
      if($posts) {
          foreach ( $posts as $post ){
            
              if ($post->guid == $guid) {
                  $active_post = $post;
              }
          }
      }
  
      //return;
      if ($active_post) {
           $this->sect['menu_active'] = 'News';
          $this->sect['title'] = 'News'; 
          $content = View::make('icta::pagetpls.singlepost')->with('data', $active_post);
          
          $sidebar = IctaL\Helper::make_sidebar();  
          $this->sect['content'] = View::make('icta::tpls.page')
                                              ->with('title','News')
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return IctaL\Helper::make_structure($this->sect);                
      } else {
          return Redirect::to('xadmin/pages/notfound');  
      }
  }
   /***********************************************/
   
   private function _home_sect($sect){
      $block = '';
      if($sect == 'slider') {
         $block.= View::make('icta::homesections.'.$sect);
      } else if ($sect == 'latestblogs'){
         $latest_blogs = null; $latest_projects = null;
         $blogs = ContentM\ContentPost::posts_active()->get();
         
         if ($blogs) {
          $latest_blogs = array_slice($blogs, 0, 2);
         } 
         $projects = ICTACustomM\Ictacustom::posts_active_type('projects');
         if ($projects) {
            $latest_projects = array_slice($projects, 0, 2);            
         }         
         $block.= View::make('icta::homesections.'.$sect)
                  ->with('latest',$latest_blogs)
                  ->with('projects', $latest_projects);
      } else if ($sect== 'teams') {
         $latest_team = null;
         $team = ICTACustomM\Ictacustom::posts_active_type('team');
         if ($team) {
          $latest_team = array_slice($team, 0, 4);
         }          
         $block.= View::make('icta::homesections.'.$sect)
                      ->with('team',$latest_team); 
                       
      } else if ($sect == 'tabs'){
         $block.= View::make('icta::homesections.'.$sect); 
      }
      
      return $block;
   }
   
 
}