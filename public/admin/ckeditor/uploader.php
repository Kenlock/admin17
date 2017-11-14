<html>
    <head>
        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" media="screen" href="../elfinder/css/elfinder.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../elfinder/js/elfinder.min.js"></script>
    </head>

    <body>
        <div id = 'elfinder'>

        </div>
    </body>
    <script type="text/javascript" charset="utf-8">
      $().ready(function() {
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;

                return (match && match.length > 1) ? match[1] : '' ;
            }

            $(document).ready(function(){
                 // star elfinder image

                    var urlImage = '../elfinder/php/connector.minimal.php';
                    var funcNum = getUrlParam('CKEditorFuncNum');
                    $('#elfinder').elfinder({
                         url :  urlImage ,
                         uiOptions : {
                             toolbar : [
                                    ['upload' , 'mkdir'],
                            ],
                         },
                         contextmenu : {
                           files  : ['getfile', '|'],
                           navbar : [],
                         },
                         onlyMimes : ["image"],
                         resizable : false , 
                         getFileCallback : function(file) {
                            window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                            window.close();
                        },
                                   
                    }).elfinder('instance');;

                    // 
            });             
      });
  </script>
</html>