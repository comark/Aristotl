<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'legend'=> array(
        'main' => array(
            'type'=>'select',
            'name'=>'legend',
            'title'=>'Legend',
            'rules'=>array(
                'required'=>true
            ),
            'options'=> array(
              ''=>'Select',              
              'publications' => 'Publications',
              'projects' => 'Projects',
            ),
        ),
    ),
    'publications' => array(
       'name' => 'publications',
       'title' => 'Publications',
       'default' => true, 
    ), /*publications*/

    'projects' => array(
       'name' => 'projects',
       'title' => 'Projects',
       'default' => false,
       'fields' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ),       
            'short_description' => array('type'=>'textarea', 'name'=> 'short_description', 'title'=> 'Short Description',
                             'rules' => array('required'=> 'true')
                ), 
            'long_description' => array('type'=>'textarea', 'name'=> 'long_description', 'title'=> 'Long Description','id' => 'post_content',
                             'rules' => array('required'=> 'true')
                ),
            'image' => array('type'=>'file', 'name'=> 'image', 'title'=> 'Image'),
            'status' => array('type'=>'select', 'name'=>'status', 'title'=> 'Status', 
                           'options' => array(
                               'draft' => 'draft',
                               'publish' => 'publish',
                               'delete' => 'delete',
                           )
                ),           
       ) 
    ), /*team*/     

    

    'default' => array(
        'fields' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ),
            'content' => array('type'=>'textarea', 'name' => 'content', 'title'=>'Content', 'id' => 'post_content',
                             'rules' => array('required' => 'true')
                ),
            'status' => array('type'=>'select', 'name'=>'status', 'title'=> 'Status', 
                           'options' => array(
                               'draft' => 'draft',
                               'publish' => 'publish',
                               'delete' => 'delete',
                           )
                ),
            'image' => array('type'=>'file', 'name'=> 'image', 'title'=> 'Image'),
            'file' => array('type'=>'upload', 'name'=> 'file', 'title'=> 'File'),
            
        )
    )
    
);