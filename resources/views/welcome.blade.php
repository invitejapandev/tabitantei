<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name=“robots” content=“noindex, nofollow” />
        <title>Tabitantei</title>
        <script>
        (function(d) {
            var config = {
            kitId: 'jzg0kcj',
            scriptTimeout: 3000,
            async: true
            },
            h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
        })(document);
        </script>
        <link rel="icon" href="images/ij_icon.png" sizes="192x192" />
        <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

  <script>
  (function(d) {
    var config = {
      kitId: 'jzg0kcj',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
    </head>
    <body>

        <div class="main_app" id="app">
            {{-- <router-link :to="{ name: 'main.index' }" class="text-sm font-medium">Login</router-link> --}}
            <router-view />
        </div>
        <script>
            window.onload = function() {
                let alertTriggered = false;
                if((document.body.clientWidth<1000 || document.body.clientHeight < 600) && alertTriggered == false){
               alert('This game does not work on small screens. Please adjust the screen size.')
               alertTriggered = true;
           }

                window.addEventListener("resize", function(event) {
        //    alert(document.body.clientWidth + ' wide by ' + document.body.clientHeight+' high')
           if((document.body.clientWidth<1000 || document.body.clientHeight < 600) && alertTriggered == false){
               alert('This game does not work on small screens. Please adjust the screen size.')
               alertTriggered = true;
           }
})

};
    
    
        </script>
        <script src="{{ mix('/js/app.js') }}">
        </script>
    
    </body>
    <link rel="stylesheet" href="https://use.typekit.net/wes6fag.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Covered+By+Your+Grace&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.typekit.net/zic2lsg.css">

    <style>
        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent.woff") format('woff');
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Bold.woff") format('woff');
            font-weight: bold;
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Bold-Italic.woff") format('woff');
            font-weight: bold;
            font-style: italic;
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Italic.woff") format('woff');
            font-style: italic;
        }


        body{
            margin:0;
            /* height: 100vh; */
            /* width: 100vw; */
            /* background: url({{ URL::asset('images/tabitantei_bg.png') }}) no-repeat center center fixed; */
            background-size: cover;
            /* font-family: 'Covered By Your Grace', cursive; */
            font-family: Arial, Helvetica, sans-serif;
        }
        
       


    </style>
</html>
