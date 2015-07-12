<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Super Simple Blog by Sam Jacobs - thischarmingsam.co.uk">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= (isset($pageTitle)) ? $pageTitle . ' | ' : ''; ?>Super Simple Blog</title>
        <link href='http://fonts.googleapis.com/css?family=Roboto:900|Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="author" href="humans.txt">

        <?php 
            $utils->addStyle('admin.min',false,true);
            $utils->addStyles();
        ?>
    </head>
    <body>
     <nav class="nav">
      <ul class="nav__list">
        <li class="nav__listitem">
          <a class="nav__link" href="/" target="_blank">Go to blog</a>
        </li>
        <li class="nav__listitem">
          <a class="nav__link" href="?logout">Logout</a>
        </li>
      </ul>
      <a class="nav__link nav__link--logo" href="/admin">Super Simple Blog - Admin</a>
    </nav>