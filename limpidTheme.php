<?php
/*
  --------------------------------------------------
  limpid CMS Made Simple Theme
  --------------------------------------------------
  Main Theme-File | Table Of Contents
  --------------------------------------------------

   1.  DisplayDocType()
   2.  DisplayHTMLStartTag()
   3.  DisplayHTMLHeader()
   4.  ThemeHeader()
   5.  DisplayTopMenu()
   6.  DisplayMainDivStart()
   7.  renderMenuSection()
   8.  DisplayAllSectionPages()
   9.  DisplaySectionPages()
   X.  Deprecated functions
*/


class limpidTheme extends AdminTheme
{
/*--------------------------------------------------
  1. DisplayDocType()
  -------------------------------------------------- */
  function DisplayDocType() {
    echo '<!doctype html>'."\n";
  }


/*--------------------------------------------------
  2. DisplayHTMLStartTag()
  -------------------------------------------------- */
  function DisplayHTMLStartTag() {
    $tag = '<html lang="en"';
    if (isset($this->cms->nls['direction']) &&
        $this->cms->nls['direction'] == 'rtl')
    {
      $tag .= ' dir="rtl"';
    }
    $tag .= ">\n\n";
    echo $tag;
  }
  

/*--------------------------------------------------
  3. HTML DisplayHTMLHeader()
  -------------------------------------------------- */
  function DisplayHTMLHeader($showielink = false, $addt = '') {
    global $gCms;
    $config =& $gCms->GetConfig();
    ?>
    <head>
      <title><?php echo $this->title ." | ". $this->cms->siteprefs['sitename'] ?></title>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="Generator" content="CMS Made Simple - Copyright (C) 2004-<?php echo date("y"); ?> Ted Kulp. All rights reserved.">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="robots" content="noindex, nofollow">
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

      <link rel="shortcut icon" href="themes/limpid/images/icons/system/favicon.ico">
      <link rel="Bookmark" href="themes/limpid/images/system/icons/favicon.ico">

      <link rel="stylesheet" type="text/css" href="style.php">

      <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="themes/limpid/css/ie8.css" />
      <![endif]-->
      <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="themes/limpid/css/ie7.css" />
      <![endif]-->

      <?php $this->OutputHeaderJavascript(); ?>

      <!--[if lt IE 9]>
      <script type="text/javascript" src="themes/limpid/includes/js/ie-html5shim.js"></script>
      <script type="text/javascript" src="themes/limpid/includes/js/selectivizr.js"></script>
      <script>
      $(document).ready(function(){
        $('.arrowr').replaceWith(' > ');
      }); //$(document).ready 
      </script>
      <![endif]-->
      <!-- THIS IS WHERE HEADER STUFF SHOULD GO -->

      <?php $this->ThemeHeader(); ?>
      <?php echo $addt ?>
      <base href="<?php echo $config['root_url'] . '/' . $config['admin_dir'] . '/'; ?>" />
    </head>

    <?php
  }
  

/*--------------------------------------------------
  4. ThemeHeader()
  -------------------------------------------------- */
	function ThemeHeader(){
	  echo '<script type="text/javascript" src="themes/limpid/includes/js/jquery.dimensions.js"></script>'."\n";
	  echo '<script type="text/javascript" src="themes/limpid/includes/js/jquery.accordion.pack.js"></script>'."\n";
		echo '<script type="text/javascript" src="themes/limpid/includes/standard.js"></script>'."\n";
	}
	

/*--------------------------------------------------
  5. DisplayTopMenu()
  -------------------------------------------------- */
  function DisplayTopMenu() {
    $urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];
    
    echo '<div id="container">';
    echo '<header>';  
    //title
    echo '<span class="title">'.$this->cms->siteprefs['sitename'].' <span class="admin">'.lang('adminsystemtitle').'</span></span>';
    //user
    echo '<span class="user">'.lang('welcome_user').': <span class="username"> '.$this->cms->variables['username'].'</span></span>';
  echo '<div class="nav">';
    //ICON VIEW SITE
    echo '<div id="nav-icons_all">';
      echo '<ul id="nav-icons">"';
        echo "\n\t<li class=\"viewsite-icon\"><a  rel=\"external\" title=\"".lang('viewsite')."\"  href=\"../index.php\">".lang('viewsite')."</a></li>\n";
        //ICON LOGOUT
        echo "\n\t<li class=\"logout-icon\"><a  title=\"".lang('logout')."\"  href=\"logout.php\">".lang('logout')."</a></li>\n";
      echo "</ul>";
    echo "</div>\n";

    //breadcrumbs
    echo '<div class="breadcrumbs"><p class="breadcrumbs">';
    $counter = 0;
    foreach ($this->breadcrumbs as $crumb) {
      if ($counter > 0) {
        echo '<span class="arrowr"> &#9656; </span>';
      }
      if (isset($crumb['url']) &&
          str_replace('&amp;', '&', $crumb['url']) != basename($_SERVER['REQUEST_URI']))
        {
          echo '<a class="breadcrumbs" href="'.$crumb['url'];
          echo '">'.$crumb['title'];
          echo '</a>';
        }
      else
        {
          echo $crumb['title'];
        }
      $counter++;
    }
    echo '</p></div>';
    echo '</div> <!-- end of .nav -->';

    echo '</header>';
  }


/*--------------------------------------------------
  6. DisplayMainDivStart()
  -------------------------------------------------- */
  function DisplayMainDivStart()
  {
  	echo '<div id="content">';
    echo '<div class="spacer"></div>';
    //MENU
    echo '<div class="nav">';
      echo '<ul id="nav-main">';
        foreach ($this->menuItems as $key=>$menuItem) {
          if ($menuItem['parent'] == -1) {
            echo "\n\t\t";
            $this->renderMenuSection($key, 0, -1);
          }
        }
      echo '</ul>';
    echo '</div>';
  }
  
  
/*--------------------------------------------------
  7. renderMenuSection()
  -------------------------------------------------- */
  function renderMenuSection($section, $depth, $maxdepth)
  {
    if ( $maxdepth > 0 && $depth > $maxdepth ) {
      return;
    }
    if ( !$this->menuItems[$section]['show_in_menu'] ) {
      return;
    }
    if ( strlen($this->menuItems[$section]['url']) < 1 ) {
      echo "<li>".$this->menuItems[$section]['title']."</li>";
      return;
    }
    if ( $this->menuItems[$section]['selected'] and $this->HasDisplayableChildren($section) ) {
      echo '<li class="selected parent"><a href="';
    }
    else {
      echo '<li><a href="';
    }
    echo $this->menuItems[$section]['url'];
    echo '"';
    if ( array_key_exists('target', $this->menuItems[$section]) ) {
      echo ' rel="external"';
    }
    $class = array();
    if ( $this->HasDisplayableChildren($section) ) {
      $class[] = 'head';
    }
    if ( $this->menuItems[$section]['selected'] and !($this->HasDisplayableChildren($section)) ) {
      $class[] = 'active';
    }
    if ( isset($this->menuItems[$section]['firstmodule']) ) {
      $class[] = 'first_module';
    }
    else if ( isset($this->menuItems[$section]['module']) ) {
      $class[] = 'module';
    }
    if ( count($class) > 0 ) {
      echo ' class="';
      for( $i=0;$i<count($class);$i++ ) {
        if ( $i > 0 ) {
          echo " ";
        }
        echo $class[$i];
      }
      echo '"';
    }
    echo ">";
    echo $this->menuItems[$section]['title'];
    echo "</a>";
    if ($this->HasDisplayableChildren($section)) {
      echo "<ul>";
      foreach ($this->menuItems[$section]['children'] as $child) {
        $this->renderMenuSection($child, $depth+1, $maxdepth);
      }
      echo "</ul>";
    }
    echo "</li>";
    return;
  }
  
/*--------------------------------------------------
  8. DisplayAllSectionPages()
  -------------------------------------------------- */
  function DisplayAllSectionPages() {
    $count = 0;
    $i = 0;
    $len = count($this->menuItems);
    foreach ($this->menuItems as $thisSection=>$menuItem) {
      $i++;
      if ( $menuItem['parent'] != -1 ) {
        continue;
      }
      if ( !$menuItem['show_in_menu'] ) {
        continue;
      }
      if ( $menuItem['url'] == 'index.php'  || strlen($menuItem['url']) < 1 ) {
        continue;
      }
      $count++;
      if( $count == 1 || $count % 5 == 0 ) {
        echo '<div class="row">';
      }
      echo '<div class="itemmenucontainer">';
        echo '<p class="itemicon">';
        $iconSpec = $thisSection;
        if ( $menuItem['url'] == '../index.php' ) {
          $iconSpec = 'viewsite';
        }
          echo '<a href="'.$menuItem['url'].'">';
          echo $this->DisplayImage('icons/topfiles/'.$iconSpec.'.gif', $iconSpec, '', '', 'itemicon');
          echo '</a>';
        echo '</p>';
        echo "<h3><a class=\"itemlink\" href=\"".$menuItem['url']."\"";
        if (array_key_exists('target', $menuItem)) {
          echo ' rel="external"';        
        }
        echo ">".$menuItem['title']."</a></h3>\n";
        echo '<p class="itemtext">';
        if (isset($menuItem['description']) && strlen($menuItem['description']) > 0) {
          echo '<span class="description">'.$menuItem['description'].'</span>';
        }
        $this->ListSectionPages($thisSection);
        echo '</p>';
      echo '</div>';
      if( ($count != 0 && $count % 4 == 0)) {
        echo '</div><!--/row-->';
      }
    }
    echo '</div><!--/row-->';
  }
  
/*--------------------------------------------------
  9. DisplaySectionPages()
  -------------------------------------------------- */
  function DisplaySectionPages($section) {
      global $gCms;
      if (count($this->menuItems) < 1)
  {
    // menu should be initialized before this gets called.
    // TODO: try to do initialization.
    // Problem: current page selection, url, etc?
    return -1;
  }

      $firstmodule = true;
      foreach ($this->menuItems[$section]['children'] as $thisChild)
  {
    $thisItem = $this->menuItems[$thisChild];
    if (! $thisItem['show_in_menu'] || strlen($thisItem['url']) < 1)
      {
        continue;
      }

    // separate system modules from the rest.
    if( preg_match( '/module=([^&]+)/', $thisItem['url'], $tmp) )
      {
        if( array_search( $tmp[1], $gCms->cmssystemmodules ) === FALSE && $firstmodule == true )
    {
      echo "<hr width=\"90%\"/>";
      $firstmodule = false;
    }
      }

    echo "<div class=\"itemmenucontainer\">\n";
    echo '<div class="itemoverflow">';
    echo '<p class="itemicon">';
    $moduleIcon = false;
    $iconSpec = $thisChild;
    
    // handle module icons
    if (preg_match( '/module=([^&]+)/', $thisItem['url'], $tmp))
      {
        if ($tmp[1] == 'News')
    {
      $iconSpec = 'newsmodule';
    }
        else if ($tmp[1] == 'TinyMCE' || $tmp[1] == 'HTMLArea')
    {
      $iconSpec = 'wysiwyg';
    }
        else
    {
      $imageSpec = dirname($this->cms->config['root_path'] .
               '/modules/' . $tmp[1] . '/images/icon.gif') .'/icon.gif';
      if (file_exists($imageSpec))
        {
          echo '<a href="'.$thisItem['url'].'"><img class="itemicon" src="'.
      $this->cms->config['root_url'] .
      '/modules/' . $tmp[1] . '/images/' .
      '/icon.gif" alt="'.$thisItem['title'].'" /></a>';
          $moduleIcon = true;
        }
      else
        {
          $iconSpec=$this->TopParent($thisChild);
        }
    }
      }
    if (! $moduleIcon)
      {
        if ($thisItem['url'] == '../index.php')
    {
      $iconSpec = 'viewsite';
    }
        echo '<a href="'.$thisItem['url'].'">';
        echo $this->DisplayImage('icons/topfiles/'.$iconSpec.'.gif', ''.$thisItem['title'].'', '', '', 'itemicon');
        echo '</a>';
      }
    echo '</p>';
    echo '<p class="itemtext">';
    echo "<a class=\"itemlink\" href=\"".$thisItem['url']."\"";
    if (array_key_exists('target', $thisItem))
      {
        echo ' rel="external"';
      }
    echo ">".$thisItem['title']."</a><br />\n";
    if (isset($thisItem['description']) && strlen($thisItem['description']) > 0)
      echo $thisItem['description'];
    echo '</p>';
    echo "</div>";
    echo '</div>';      
        }

    }




  /*--------------------------------------------------
    6. DisplayDashboardCallout()
    -------------------------------------------------- */
    function DisplayDashboardCallout($file, $message = '') {
      if ($message == '')
        $message = lang('installdirwarning');

      if (file_exists($file)) {
        echo "<div class=\"DashboardCallout\">\n";
        echo "<div class=\"pageerrorinstalldir\"><p class=\"pageerror\">".$message."</p></div>";
        echo "</div> <!-- end DashboardCallout -->\n";
      }
    }

      function DisplayDashboardPageItem($item="module", $title='', $content = '') {
        switch ($item) {
          case "start" : {
            echo "\n<div class=\"full-content clear-db\">\n";
            break;;
          }
          case "end" : {
            echo "</div><!--full-content clear-db-->\n";
            break;
          }
          case "core" : {
            echo "<div class=\"coredashboardcontent\">\n";
            echo "  <div class=\"dashboardheader-core\">\n";
            echo $title;
            echo "  </div>\n";
            echo "  <div class=\"dashboardcontent-core\">\n";
            echo $content;
            echo "  </div>\n";
            echo "</div>\n";
            break;
          }
          case "module" : {
            echo "<div class=\"moduledashboardcontent\">\n"; 
            echo "  <div class=\"dashboardheader\">\n";
            echo $title;
            echo "  </div>\n";
            echo "  <div class=\"dashboardcontent\">\n";
            echo $content;
            echo "  </div>\n";
            echo "</div>\n";
            break;
          }
        }
      }




  
//from classAdminTheme

/**
     * DoBookmarks
     * Method for displaying admin bookmarks (shortcuts) & help links.
     */
    function ShowShortcuts()
    {
      if (get_preference($this->userid, 'bookmarks')) {
  $urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];
  echo '<div class="itemmenucontainer shortcuts" style="float:left;">';
  echo '<h2>'.lang('bookmarks').'</h2>';
  echo '<p><a href="listbookmarks.php'.$urlext.'">'.lang('managebookmarks').'</a></p>';
  global $gCms;
  $bookops =& $gCms->GetBookmarkOperations();
  $marks = array_reverse($bookops->LoadBookmarks($this->userid));
  $marks = array_reverse($marks);
  if (FALSE == empty($marks))
    {
      echo '<h3 style="margin:0">'.lang('user_created').'</h3>';
      echo '<ul style="margin:0">';
      foreach($marks as $mark)
        {
    echo "<li><a href=\"". $mark->url."\">".$mark->title."</a></li>\n";
        }
      echo "</ul>\n";
    }
  echo '<h3>'.lang('help').'</h3>';
  echo '<ul>';
  echo '<li><a rel="external" href="http://forum.cmsmadesimple.org/">'.lang('forums').'</a></li>';
  echo '<li><a rel="external" href="http://wiki.cmsmadesimple.org/">'.lang('wiki').'</a></li>';
  echo '<li><a rel="external" href="http://dev.cmsmadesimple.org/">'.lang('forge').'</a></li>';
  echo '<li><a rel="external" href="http://cmsmadesimple.org/main/support/IRC">'.lang('irc').'</a></li>';
  echo '<li><a rel="external" href="http://wiki.cmsmadesimple.org/index.php/User_Handbook/Admin_Panel/Extensions/Modules">'.lang('module_help').'</a></li>';
  echo '</ul>';
  echo '</div>';
      }
    }

// DISABLED
  function DisplayRecentPages()  {
    if (get_preference($this->userid, 'recent')) {  
      echo '<div id="navt_recent_pages_c">'."\n";
      $counter = 0;
      foreach($this->recent as $pg) {
        echo "<a href=\"". $pg->url."\">".++$counter.'. '.$pg->title."</a><br />"."\n";
        }
      echo '</div>'."\n";
    }
  }
//end 
  function DisplayBookmarks($marks) {
    if (get_preference($this->userid, 'bookmarks')) { 
      echo '<div id="navt_bookmarks_c">'."\n";
      $counter = 0;
      foreach($marks as $mark) {
        echo "<a href=\"". $mark->url."\">".++$counter.'. '.$mark->title."</a><br />"."\n";
        }
      echo '</div>'."\n";
    }
  }  
  //END bookmarks - RIGHT
  function EndRighthandColumn() {
    echo '</div>'."\n";
    echo '</div>'."\n";
    echo '<div style="clear: both;"></div>'."\n";
    echo '</div>'."\n";
  }
  //END
  
  








 
  
  function ListSectionPages($section) {
    if (! isset($this->menuItems[$section]['children']) || count($this->menuItems[$section]['children']) < 1)
      return;
    if ($this->HasDisplayableChildren($section)) {
      echo '<span class="subitems">'.lang('subitems').':</span>';
      $count = 0;
      foreach($this->menuItems[$section]['children'] as $thisChild) {
        $thisItem = $this->menuItems[$thisChild];
        if (! $thisItem['show_in_menu'] || strlen($thisItem['url']) < 1)
          continue;
        if ($count++ > 0)
          echo '<span class="seperator">,</span> ';
        echo "<a class=\"itemsublink\" href=\"".$thisItem['url'];
        echo "\">".$thisItem['title']."</a>";
      }
    }
  }
  
/*--------------------------------------------------
  8. StartRighthandColumn
  -------------------------------------------------- */ 
  function StartRighthandColumn() {
      //START bookmarks - RIGHT
      echo '<div class="navt_menu">'."\n";
      echo '<div id="navt_display" class="navt_show" onclick="change(\'navt_display\', \'navt_hide\', \'navt_show\'); change(\'navt_container\', \'invisible\', \'visible\');"><span class="arrowt" title=" '.lang('bookmarks').'">&#9650;</span></div>'."\n";
      echo '<div id="navt_container" class="invisible">'."\n";
      echo '<div id="navt_tabs">'."\n";
      if (get_preference($this->userid, 'bookmarks')) {
          echo '<div id="navt_bookmarks">'.lang('bookmarks').'</div>'."\n";
      }
      echo '</div>'."\n";
      echo '<div style="clear: both;"></div>'."\n";
      echo '<div id="navt_content">'."\n";
    
  }

  
/*--------------------------------------------------
  9. DisplayFooter
  -------------------------------------------------- */
  function DisplayFooter() {
    global $CMS_VERSION;
    global $CMS_VERSION_NAME;

      //FOOTER
      echo '<footer>';
        echo '<p>';
          echo '<a rel="external" href="http://www.cmsmadesimple.org">CMS Made Simple</a> '.$CMS_VERSION.' "' . $CMS_VERSION_NAME . '" is free software released under the General Public Licence.';
          echo '</p>';
      echo '</footer>';   
    echo '</div> <!-- end of #container -->';
  }


/*--------------------------------------------------
  X. Deprecated functions
  -------------------------------------------------- */
  function OutputFooterJavascript() {}  
  function DisplayMainDivEnd() {}
}
?>
