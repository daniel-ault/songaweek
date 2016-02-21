<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <title>Bootstrap 3, from LayoutIt!</title>

   <meta name="description" content="Source code generated using layoutit.com">
   <meta name="author" content="LayoutIt!">
	
   <link href="/css/bootstrap.min.css" rel="stylesheet">
<!--	<link href="http://dragonflycave.com/styles/scyther-style.css" rel="stylesheet">
-->
	<link href="/css/style.css" rel="stylesheet">

	<!--<link rel="stylesheet" href="//55b558c7-site.gandi.ws/_css/site_69711_1_11.css">-->
	<link href="/css/songaweek.css" rel="stylesheet"> 

	<?php include 'php_utils.php'?>
	



    
            <style
            class="js-webfont"
            data-woff-cache="//55b558c7-resources.gandi.ws/3e64db8/seven/fonts/lato.woff.json"
            data-ttf-cache="//55b558c7-resources.gandi.ws/3e64db8/seven/fonts/lato.ttf.json"
            data-fallback-stylesheet="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin"
            data-name="lato"
        ></style>
    <script>
(function () {
    var fontCollections,
        fontsToCache,
        fallback = 1;

    function loadFontsAsynchronously() {
        if (!fallback) {
            return;
        }

        for (var i = 0, j = fontCollections.length; i < j; ++i) {
            var link = document.createElement('link'),
                head = document.getElementsByTagName('head')[0];
            link.rel = 'stylesheet';
            link.href = fontCollections[i].getAttribute('data-fallback-stylesheet');
            head.appendChild(link);
        }
    }

    function loadFontsFromStorage() {
        var localKey = 'published',
            format = window.localStorage.getItem('bk.webfonts.format'),
            collection,
            cachedFont;

        if (!format) {
            return;
        }

        for (var i = 0, j = fontCollections.length; i < j; ++i) {
            collection = fontCollections[i];
            cacheKey = 'bk.webfonts.' + localKey + '.' + format + '.' + collection.getAttribute('data-name');
            cachedFont = window.localStorage.getItem(cacheKey);
            if (!cachedFont) {
                continue;
            }
            collection.innerHTML = cachedFont;
            collection.setAttribute('data-cache-full', 'data-cache-full');
        }
    }

    if (!'querySelectorAll' in window) {
        return;
    }

    fontCollections = document.head.querySelectorAll('.js-webfont');
    if (!'localStorage' in window || !'addEventListener' in window) {
        loadFontsAsynchronously();
        return;
    }

    loadFontsFromStorage();
}());
</script>

</head>
