<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Treasury_Home_Controller extends Treasury_Base_Controller{

    private $title = 'Home';
    private $sect = array();
    
    public function __construct() {
        parent::__construct();
    }
    
    public function action_index() {
       $this->sect['title'] = $this->title;
       $this->sect['menu_active'] = 'home';
       
       $sections = array('slider','about','docs','teams');
      // $sections = array('');
       $secti = '';
       foreach($sections as $sect){
           $secti.= $this->_home_sect($sect);
       }
       $this->sect['content'] = View::make('treasury::tpls.homecontent')->with('data',$secti);       
       return TreasuryL\Helper::make_structure($this->sect);       
    }
    
    public function action_404() {
       $this->sect['title'] = $this->title;
       $this->sect['menu_active'] = '404';
       $this->sect['content'] = View::make('treasury::tpls.404');       
       return TreasuryL\Helper::make_structure($this->sect);       
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
            $content = View::make('treasury::customtpls.'.$p->template)->with('data',$data);     
          } else {
             if ($p->image) {
                $data['image'] = URL::base().'/'.$p->image;
              }
            $data['content'] = $p->content;
            $content = View::make('treasury::pagetpls.default')->with('data',$data);
          }
          $sidebar = TreasuryL\Helper::make_sidebar();   
          
          $this->sect['content'] = View::make('treasury::tpls.page')
                                              ->with('title',$p->title)
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return TreasuryL\Helper::make_structure($this->sect);         
    }
   }
   
   return Redirect::to('xadmin/pages/notfound');
  }
  
  public function action_contact(){
          
          $this->sect['menu_active'] = 'Contact';
          $this->sect['title'] = 'Contact'; 
          $content = View::make('treasury::pagetpls.contact');
          $widgets = array('contacts','sidelinks');
          $sidebar = TreasuryL\Helper::make_sidebar($widgets);  
          $this->sect['content'] = View::make('treasury::tpls.page')
                                              ->with('title','Contact')
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return TreasuryL\Helper::make_structure($this->sect);          
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
          $content = View::make('treasury::singletpls.singlepost')->with('data', $active_post);
          
          $sidebar = TreasuryL\Helper::make_sidebar();  
          $this->sect['content'] = View::make('treasury::tpls.page')
                                              ->with('title','News')
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return TreasuryL\Helper::make_structure($this->sect);                
      } else {
          return Redirect::to('xadmin/pages/notfound');  
      }
  }
  
    public function action_customsingle($type,$guid){
      $posts = ICTACustomM\Ictacustom::posts_active_type($type);     
      $active_post = null;
      if($posts) {
          foreach ( $posts as $post ){            
              if ($post->guid == $type.'/'.$guid) {
                  $active_post = $post;
              }
          }
      }
      if ($active_post) {
          $this->sect['title'] = Config::get('ictacustom::fields.'.$type.'.title');
          //$content = View::make('treasury::singletpls.single'.$type)->with('data', $active_post);
		  $content = View::make('treasury::listtpls.resources')->with('data', $active_post);
          
          $sidebar = TreasuryL\Helper::make_sidebar();  
          $this->sect['content'] = View::make('treasury::tpls.page')
                                              ->with('title',$this->sect['title'])
                                              ->with('center', $content)
                                              ->with('sidebar',$sidebar);          
          return TreasuryL\Helper::make_structure($this->sect);                
      } else {
          return Redirect::to('xadmin/pages/notfound');  
      }
  }  
  
   /***********************************************/
   
   private function _home_sect($sect){
      $block = '';
      if($sect == 'slider') {
         $block.= View::make('treasury::homesections.'.$sect);
      } else if ($sect== 'teams') {
         $latest_team = null;
         $team = ICTACustomM\Ictacustom::posts_active_type('team');
         if ($team) {
          $latest_team = array_slice($team, 0, 4);
         }          
         $block.= View::make('treasury::homesections.'.$sect)
                      ->with('team',$latest_team); 
                       
      } else if ($sect == 'tabs'){
         $block.= View::make('treasury::homesections.'.$sect); 
      } else if ($sect == 'about'){
         $block.= View::make('treasury::homesections.'.$sect); 
      } else if ($sect == 'docs'){
         $block.= View::make('treasury::homesections.'.$sect); 
      }
	  
      
      return $block;
   }
   
 
}