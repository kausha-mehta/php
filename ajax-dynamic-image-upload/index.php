<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Basic Ajax and PHP tutorial</title>
        <script type="text/javascript" src="Ajaxfileupload-jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="ajaxupload.3.5.js" ></script>
        <link rel="stylesheet" type="text/css" href="Ajaxfile-upload.css" />
        <script type="text/javascript" >
            $(function() {
                var btnUpload = $('#me');
                var mestatus = $('#mestatus');
                var files = $('#files');
                new AjaxUpload(btnUpload, {
                    action: 'uploadPhoto.php',
                    name: 'upload',
                    onSubmit: function(file, ext) {
                        if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                            // extension is not allowed 
                            mestatus.text('Only JPG, PNG or GIF files are allowed');
                            return false;
                        }
                        mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
                    },
                    onComplete: function(file, response) {
                        //On completion clear the status
                        mestatus.text('Photo Uploaded Sucessfully!');
                        //On completion clear the status
                        files.html('');
                        //Add uploaded file to list
                        if (response !== "error") {
                            $('<li></li>').appendTo('#files').html('<img src="' + response + '" alt="" /><br />').addClass('success');
                        } else {
                            $('<li></li>').appendTo('#files').text(file).addClass('error');
                        }
                    }
                });

            });
        </script>

    </head>

    <body>
        <div style="text-align:center;">
            <div style="display:none;"><img src="ajax-loader.gif"  /></div>
            <h1 style="color:#CCC;">PHP Ajax image Dynamic upload.<a href="http://www.webinfopedia.com/upload-image-using-PHP-ajax.html" style="color:#EEDDCA; text-decoration:none; font-size:18px;">http://www.webinfopedia.com/upload-image-using-PHP-ajax.html</a></h1>
        </div>
        <div class="maindiv">
            <div class="innerbg">
                <div style="margin:0px 10px; font-weight:bold; color:#FFF; font-size:16px;">PHP Ajax image Dynamic upload</div>
                <div id="flash"></div>
                <div id="ajaxresult"></div>
                <div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Profile Photo</span></span></div><span id="mestatus" ></span>
                <div id="files">
                    <li class="success">
                    </li>
                </div>
            </div>
        </div>
    </body>
</html>
