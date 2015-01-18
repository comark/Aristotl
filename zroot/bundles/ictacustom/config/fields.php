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
              'reports'     => 'Reports',
              'bills'       => 'Bills',
              'publicsector' => 'Public Sector Hearing and Policies',
              'resources'=>'Resources',
              'tenders' => 'Tenders',
              'downloads' => 'Downloads',
              'gallery' => 'Gallery',
              'careers' => 'Careers',
              'services' => 'Services',
              'team'     => 'Team',
              'projects' => 'Projects',
              'slideshow' => 'Slideshow',
              'events' => 'Events',
              'press' => 'Press Releases',
              'speeches' => 'Speeches',
            ),
        ),
    ),
    'publications' => array(
       'name' => 'publications',
       'title' => 'Publications',
       'default' => true, 
    ), /*resources*/
    'reports' => array(
       'name' => 'reports',
       'title' => 'Reports',
       'default' => true, 
    ), /*resources*/ 
    'bills' => array(
       'name' => 'bills',
       'title' => 'Bills',
       'default' => true, 
    ), /*resources*/  
    'publicsector' => array(
       'name' => 'publicsector',
       'title' => 'Public Sector Hearing and Policies',
       'default' => true, 
    ), /*resources*/     
    'resources' => array(
       'name' => 'resources',
       'title' => 'Resources',
       'default' => true, 
    ), /*resources*/
    'tenders' => array(
       'name' => 'tenders',
       'title' => 'Tenders',
       'default' => true,
    ), /*tenders*/ 
    'downloads' => array(
       'name' => 'downloads',
       'title' => 'Downloads',
       'default' => true,
    ), /*downloads*/
    'gallery' => array(
       'name' => 'gallery',
       'title' => 'Gallery',
       'default' => true,
    ), /*gallery*/  
    'careers' => array(
       'name' => 'careers',
       'title' => 'Careers',
       'default' => true,
    ), /*tenders*/   
    'services' => array(
       'name' => 'services',
       'title' => 'Services',
       'default' => true,
    ), /*tenders*/  
    'press' => array(
       'name' => 'press',
       'title' => 'Press Releases',
       'default' => true,
    ), /*press*/ 
    'speeches' => array(
       'name' => 'speeches',
       'title' => 'Speeches',
       'default' => true,
    ), /*tenders*/    
    'team' => array(
       'name' => 'team',
       'title' => 'Team',
       'default' => false,
       'fields' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Name',
                             'rules' => array('required'=> 'true')
                ),       
            'position' => array('type'=>'text', 'name'=> 'position', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ), 
            'order' => array('type'=>'text', 'name'=> 'order', 'title'=> 'Order',
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
    
    'slideshow' => array(
       'name' => 'slideshow',
       'title' => 'Slideshow',
       'default' => false,
       'fields' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ),   
            'description' => array('type'=>'text', 'name'=> 'description', 'title'=> 'Description',
                             'rules' => array('required'=> 'true')
                ),
            'link' => array('type'=>'text', 'name'=> 'link', 'title'=> 'Link',
                ),           
            'image' => array('type'=>'file', 'name'=> 'image', 'title'=> 'Image'),
            'order' => array('type'=>'text', 'name'=> 'order', 'title'=> 'Order'),
            'status' => array('type'=>'select', 'name'=>'status', 'title'=> 'Status', 
                           'options' => array(
                               'draft' => 'draft',
                               'publish' => 'publish',
                               'delete' => 'delete',
                           )
                ),           
       ) 
    ), /*slideshow*/
    
    'events' => array(
       'name' => 'events',
       'title' => 'Events',
       'default' => false,
       'fields' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ),   
            'time' => array('type'=>'text', 'name'=> 'time', 'title'=> 'Time',
                             'rules' => array('required'=> 'true')
                ),           
            'description' => array('type'=>'textarea', 'name'=> 'description', 'title'=> 'Description',
                             
                ),
            'venue' => array('type'=>'textarea', 'name'=> 'venue', 'title'=> 'Venue',
                             
                ),           
            'image' => array('type'=>'file', 'name'=> 'image', 'title'=> 'Image'),
            'order' => array('type'=>'text', 'name'=> 'order', 'title'=> 'Order'),
            'status' => array('type'=>'select', 'name'=>'status', 'title'=> 'Status', 
                           'options' => array(
                               'draft' => 'draft',
                               'publish' => 'publish',
                               'delete' => 'delete',
                           )
                ),           
       ) 
    ), /*slideshow*/    
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