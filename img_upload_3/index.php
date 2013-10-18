<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB" lang="en-GB">
    <head>
        <link href="fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/Ajaxfile-upload.css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
        <script src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="js/Ajaxfileupload-jquery-1.3.2.js" ></script>
        <script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
        <script type="text/javascript">
            /*$(".copd_detail").live('click',function() {
             var copd_id = $(this).attr("rel");
             $.fancybox({
             'type'			: 'ajax',
             'href'			: '../inc/ajax.php',
             'padding'		: 10,
             'transitionIn'	: 'elastic',
             'transitionOut'	: 'elastic',
             'ajax' : {
             type	: "POST",
             data	: 'mode=copd_detail&copd_id='+copd_id
             }
             
             });
             });*/
            jQuery(document).ready(function() {
                $(".profile_pic").live('click', function() {
                    $.fancybox({
                        'type': 'ajax',
                        'href': 'upload_crop.php',
                        'padding': 10,
                        'transitionIn': 'elastic',
                        'transitionOut': 'elastic',
                        'ajax': {
                            type: "POST"
                        }

                    });
                });
                
                var btnUpload = $('#me');
                var mestatus = $('#mestatus');
                var files = $('#files');
                new AjaxUpload(btnUpload, {
                    action: 'upload_image.php',
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
        <div class="innerbg">
            <div style="margin:0px 10px; font-weight:bold; color:#FFF; font-size:16px;">PHP Ajax image Dynamic upload</div>
            <div id="flash"></div>
            <div id="ajaxresult"></div>
            <div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><img src="images/profilephoto.png" /></span></span></div><span id="mestatus" ></span>
            <div id="files">
                <li class="success">
                </li>
            </div>
        </div>
        <!--<a href="javascript:void(0)" id="profile_pic" class="profile_pic" href=""><img src="images/profilephoto.png" /></a>-->
    </body>