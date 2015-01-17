<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array (
  'site_title' => 'The National Treasury',
  'admin_url'  => 'xadmin/',  
  'admin_register' => true,
  'super_perms' => array(
                    'is_admin'   => 1, 
                    'superuser'   => 1,
                    'is_user' => 1
                 ),
  'all_groups' => array ('backend_superuser', 'backend_admin','frontend_user')
);