<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $ssb->pageTitle(); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
        <meta name="description" content="<?= $ssb->siteDescription(); ?>">
        <link href='http://fonts.googleapis.com/css?family=Roboto:900|Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="author" href="humans.txt">

        <?php 
            $utils->addStyle($ssb->themename);
            $utils->addStyles();

            if($ssb->isEnabled('googleanalytics'))
            {
        ?>
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', '<?= $ssb->googleanalytics ?>']);
                _gaq.push(['_trackPageview']);

                (function() {
                  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();

              </script>
        <?php } ?>

        
    </head>
    <body>