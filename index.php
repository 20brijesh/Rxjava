<?php

require_once "Encryption.php";
require_once "config.php";

$agent = $_SERVER["HTTP_USER_AGENT"];
$webapp_version = "0.0.1";
$devicetype = "mobile";
$data_Arr = array();
$isGame = false;
$refercode = 0;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (array_key_exists("q", $_GET)) {
        $data_Arr['callbackcomponent'] = $_GET['q'];
        $isGame = true;
        if (array_key_exists("r", $_GET)) {
            $refercode = $_GET['r'];
        }
        if ( array_key_exists("d" , $_GET) ) {
            $data_Arr['data'] = $_GET['d'];
        }
    }
}

function isMobileDevice()
{
    $aMobileUA = array(
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    );
    foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
        if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
            $devicetype = "mobile";
            return "M";
        }
    }
    $devicetype = "desktop";
    return "D";
}

$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
    $devicetype = 'mobile';
} else {
    $devicetype = 'desktop';
}

//echo ($devicetype);
$browser_ = "";

if (preg_match('/MSIE (\d+\.\d+);/', $agent)) {
    $browser_ = "internet explorer";
} else if (preg_match('/Chrome[\/\s](\d+\.\d+)/', $agent)) {
    $browser_ = "chrome";
} else if (preg_match('/CriOS[\/\s](\d+\.\d+)/', $agent)) {
    $browser_ = "chrome";
} else if (preg_match('/Edge\/\d+/', $agent)) {
    $browser_ = "edge";
} else if (preg_match('/Firefox[\/\s](\d+\.\d+)/', $agent)) {
    $browser_ = "firefox";
} else if (preg_match('/OPR[\/\s](\d+\.\d+)/', $agent)) {
    $browser_ = "opera";
} else if (preg_match('/Safari[\/\s](\d+\.\d+)/', $agent)) {
    $browser_ = "safari";
}

$payArr = array();
if (array_key_exists("component", $_POST)) {

    $data = $_POST["component"];

    $walletBalance = "0";

    $json_data = Encryption::AESDecrypt(trim($data));

    $data_Arr = json_decode($json_data, true);
    $_POST["component"] = $data_Arr;
    $payArr = json_encode($_POST);
    // ************************Getting wallet balance*************************
    // check if any action available, if found check for payment type to get balance.

    if (array_key_exists("action", $data_Arr)) {

        $mobile_number[Encryption::AESEncrypt("mobileno")] = Encryption::AESEncrypt($data_Arr["phone"]);

        $wallet_json = Config::fetchResponse("GETBALANCE", $mobile_number, "PAYMENT");
        $wallet_bal_Enc = json_decode($wallet_json, true);

        $wallet_bal_ = Config::AESDecrypt($wallet_bal_Enc);
        if (strtolower($wallet_bal_["status"]) == "success") {
            $walletBalance = $wallet_bal_["balance"];
        } else {
            exit("Some problem occured");
        }
    }

}

unset($_POST);
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128056756-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-128056756-1');
    </script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128056756-1"></script>
<script>

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128056756-1');
</script>


    <script src="app.thirdparty/clevertap.js?<?=$webapp_version?>"></script>
    <script type="text/javascript">
        var clevertap = { event: [], profile: [], account: [], onUserLogin: [], notifications: [], privacy: [] };
        // replace with the CLEVERTAP_ACCOUNT_ID with the actual ACCOUNT ID value from your Dashboard -> Settings page
        // console.log(CleverTap.getCTAppID());
        CleverTap.setPlatform("<?=strtoupper($devicetype) . "-WEB"?>");
        clevertap.account.push({ "id": CleverTap.getCTAppID() });
        clevertap.privacy.push({ optOut: false }); //set the flag to true, if the user of the device opts out of sharing their data
        clevertap.privacy.push({ useIP: false }); //set the flag to true, if the user agrees to share their IP data
        (function () {
            var wzrk = document.createElement('script');
            wzrk.type = 'text/javascript';
            wzrk.async = true;
            wzrk.src = ('https:' == document.location.protocol ? 'https://d2r1yp2w7bby2u.cloudfront.net' : 'http://static.clevertap.com') + '/js/a.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wzrk, s);
        })();
        // event without properties

        //   CleverTap.notificationPopup();
        clevertap.notifications.push({
            "titleText": 'Would you like to receive Push Notifications?',
            "bodyText": 'We promise to only send you relevant content and give you updates',
            "okButtonText": 'Sign me up!',
            "rejectButtonText": 'No thanks',
            "okButtonColor": '#f28046',
            "askAgainTimeInSeconds": 5,
            "serviceWorkerPath": "service-worker.js"
        });


    </script>
    <script type="text/javascript">
        var fromdeeplink = <?=(($isGame) ? 1 : 0)?>;
        var rfrcode = "<?=($refercode)?>";
        var landing_page = "<?=(array_key_exists('callbackcomponent', $data_Arr)) ? $data_Arr['callbackcomponent'] : 'component_home';?>";
        var payRespArr =  <?=($payArr)?>;
        var walletBalance = "<?=($walletBalance)?>";
        var brow = "<?=($browser_);?>";
        var webapp_version = "<?=($webapp_version);?>";
        var devicetype = "<?=($devicetype);?>";
    </script>
    <?php unset($data_Arr["callbackcomponent"]);?>
    <!-- meta tags -->
    <!-- <meta content="width=device-width", initial-scale=1.0, maximum-scale=1.0, user-scalable=0 name="viewport" /> -->
    <!-- <meta name="viewport" content="width=device-width" /> -->
    <!-- <meta name="mobile-web-app-capable" content="yes"> -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=320, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="theme-color" content="#2bcbba" />
    <title>Lucky Khel</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- link tags -->
    <LINK REL="ICON" rel="manifest" HREF="<?=($devicetype);?>/app.static/img/icon/site.png?<?php echo $webapp_version; ?>">
    <!-- <link rel="manifest" href="manifest.json"> -->
    <link rel="manifest" href="manifest.webmanifest?<?php echo $webapp_version; ?>">
    <link rel="apple-touch-icon" sizes="128x128" href="site144.png?<?php echo $webapp_version; ?>">
    <!-- <link rel="stylesheet" href="mobile/app.static/fontawesome-free-5.1.1-web/css/fontawesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/noppa/text-security/master/dist/text-security.css">

    <!-- script tags -->
    <!-- <script src="mobile/app.static/js/jquery-3.3.1.slim.min.js"></script> -->
    <script src="mobile/app.static/js/jquery-3.3.1.min.js"></script>
    <script src="mobile/app.static/bootstrap/js/popper.min.js"></script>
    <script src="mobile/app.static/bootstrap/js/bootstrap.min.js"></script>
    <!--Css Links  -->
    <!-- Scripts -->
    <script>
        function detectmob() {
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}
    devicetype=detectmob();
         $(document).ready(()=>{
        $("body").append($("#<?php echo $devicetype; ?>").html())
        $("body").append($("#common").html());
    });
    </script>
    <script>
        var a = ['Q3Ry', 'anNvbg==', 'cHJvdG90eXBl', 'dmVyaWZ5anNvbg==', 'TDBjayBpdCB1cCBzYWYz']; (function (c, d) { var e = function (f) { while (--f) { c['push'](c['shift']()); } }; e(++d); }(a, 0xc4)); var b = function (c, d) { c = c - 0x0; var e = a[c]; if (b['RzEjMm'] === undefined) { (function () { var f = function () { var g; try { g = Function('return\x20(function()\x20' + '{}.constructor(\x22return\x20this\x22)(\x20)' + ');')(); } catch (h) { g = window; } return g; }; var i = f(); var j = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='; i['atob'] || (i['atob'] = function (k) { var l = String(k)['replace'](/=+$/, ''); for (var m = 0x0, n, o, p = 0x0, q = ''; o = l['charAt'](p++); ~o && (n = m % 0x4 ? n * 0x40 + o : o, m++ % 0x4) ? q += String['fromCharCode'](0xff & n >> (-0x2 * m & 0x6)) : 0x0) { o = j['indexOf'](o); } return q; }); }()); b['fcowFL'] = function (r) { var s = atob(r); var t = []; for (var u = 0x0, v = s['length']; u < v; u++) { t += '%' + ('00' + s['charCodeAt'](u)['toString'](0x10))['slice'](-0x2); } return decodeURIComponent(t); }; b['QacVkY'] = {}; b['RzEjMm'] = !![]; } var w = b['QacVkY'][c]; if (w === undefined) { e = b['fcowFL'](e); b['QacVkY'][c] = e; } else { e = w; } return e; }; function JSON_(c) { this[b('0x0')] = c; } JSON_[b('0x1')][b('0x2')] = function () { var d = b('0x3'); return Aes[b('0x4')]['encrypt'](this[b('0x0')], d, 0x100); }; function validateJSON(e) { var f = new JSON_(e); console['log'](f); return f[b('0x2')](); }
    </script>

    <link rel="stylesheet" href="mobile/app.static/css/introjs-rtl.css">
    <script src='mobile/app.static/js/intro.min.js'></script>

    <LINK REL="ICON" rel="manifest" HREF="<?php echo $devicetype; ?>/app.static/img/icon/site.png?<?php echo $webapp_version; ?>">
    <link rel="stylesheet" href="<?php echo $devicetype; ?>/app.static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $devicetype; ?>/app.static/css/core.css?<?php echo $webapp_version; ?>">

    <script src="<?php echo $devicetype; ?>/app.static/js/core.js?<?php echo $webapp_version; ?>"></script>
    <script src="<?php echo $devicetype; ?>/app.static/js/card.js?<?php echo $webapp_version; ?>"></script>
    <script src="<?php echo $devicetype; ?>/app.static/js/lml.js?<?php echo $webapp_version; ?>"></script>
    <script src="<?php echo $devicetype; ?>/app.static/js/coretimer.js?<?php echo $webapp_version; ?>"></script>
    <script src="<?php echo $devicetype; ?>/app.static/js/webcomponents-lite.js?<?php echo $webapp_version; ?>"></script>
    <script src="<?php echo $devicetype; ?>/app.static/js/aes.js?<?php echo $webapp_version; ?>">/* AES JavaScript implementation */</script>
    <script src="<?php echo $devicetype; ?>/app.static/js/aes-ctr.js?<?php echo $webapp_version; ?>">/* AES Counter Mode implementation */</script>
    <script src="<?php echo $devicetype; ?>/app.static/js/base64.js?<?php echo $webapp_version; ?>">/* Base64 encoding */</script>
    <script src="<?php echo $devicetype; ?>/app.static/js/utf8.js?<?php echo $webapp_version; ?>">/* UTF-8 encoding */</script>
    <script src="<?php echo $devicetype; ?>/app.static/js/koopid-embed.js?<?php echo $webapp_version; ?>"></script>
	<link rel="stylesheet" href="<?php echo $devicetype; ?>/app.static/css/koopid.css?<?php echo $webapp_version; ?>" />
    <script src="compress.js?<?php echo $webapp_version; ?>">/* Compress Image */</script>
    <script>
    		kpde.server = "https://positiveedge.app.koopid.io";
        // if ("<?=isMobileDevice();?>" == "D" && !detectmob()) {
        //     landing_page = "underconstruction";
        // }

    </script>

    <link rel="stylesheet" href="<?php echo $devicetype; ?>/app.static/css/introjs.min.css?<?php echo $webapp_version; ?>">
    <style type="text/css" media="print">
        .no-print {
            display: none;
        }

        .printwithoutbg {
            background-image: none !important;
        }

        #viewAllTickets {
            display: inline-flex;
        }
        #kpd_chat {
			width: 480px !important;
		}
    </style>

    <!-- library files for bootstrap date picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"/>
    <!-- library files ends here -->
</head>

<body provider-email="phanik@positiveedge.net" style="font-family:bariol-reg" ondragstart="return false;" ondrop="return false;">
<span class="header">
<img src="desktop/app.static/img/chatedge/chatbot-ow.png"
style="height:64px; position:fixed; cursor:pointer; z-index:1;
bottom: 10px; left: 10px;" id="kpd_koopidtag"
data-kpdembedded="true"
data-kpdproactive="false" data-kpdproactivetimer="0"
data-kpdguest="true" data-kpdtag="ChatWithBotLuckyKhel"
data-kpdparams="&username=guest&password=guest&autoconfig=true&
splashscreen=false&hide=header-phone&hide=header-menu&
hide=header-tags&hide=header-person"
title="Luckykhel Bot" class="klogo" />
</span>
<div id="feedback" style="display:none;background-color:#f2f6ff;position:absolute;top:0;left:0;z-index:11;height:100%;padding:0 3% 0 3%;width:100%;">
    <div class="row" style="margin:0px">
        <img id="fclose" src="app.static/img/close.png" alt="close button" style="width:30px;height:30px;margin-top:3%;">
    </div>  
    <div class="row" style="margin:0px">
        <h3 style="color:#212529;margin-top:10%">Send Feedback</h3>
        <p style="color:#6f6f6f">Please let us know how to make this app better for you!</p>
    </div>
    <div class="row">
        <textarea placeholder="Write Your Feedback" name="txtarea" id="txtarea" cols="30" rows="7" style="width: 100%;padding: 2%;margin-left: 4%;border: none;box-shadow: 2px 2px 13px 0px grey;"></textarea>
    </div>
    <div class="row" style="margin:0px;text-align:center;">
        <button class="btn" style="background: deeppink;color: white;font-weight: 600;width: 45%;border-radius: 28px;letter-spacing: 1px;margin-top: 15%;margin-left: 26%;">Submit</button>
    </div>
</div>
<!-- //rating modal -->

<div id="rating" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:58%">
      <div class="modal-body text-center">
        <p style="margin-bottom:0px;">Please rate your experience with us</p>
        <img class="star" id="s1" src="app.static/img/stard" alt="star" width="40px" height="40px">
        <img class="star" id="s2"  src="app.static/img/stard" alt="star" width="40px" height="40px">
        <img class="star" id="s3"  src="app.static/img/stard" alt="star" width="40px" height="40px">
        <img class="star" id="s4"  src="app.static/img/stard" alt="star" width="40px" height="40px">  
        <img class="star" id="s5"  src="app.static/img/stard" alt="star" width="40px" height="40px">
    </div>
    </div>

  </div>
</div>
    <template id="desktop">
        <!-- header start -->
        <div id="header" style="width:100%;position:fixed;top:0;z-index:10">
            <div id="menu-open-bg-wrapper" style="width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.623); display: none;position: fixed;z-index: 2;"></div>

            <div class="row smallheader" style="margin:0;background-color:#21A0A3;padding-top:6px;">
                <div class="col-md-2 col-sm-2 col-2" id='hamburgermenu' style="padding:0px;">
                    <div id="openMenu">
                        <img src="<?=($devicetype);?>/app.static/img/index/menuIcon.png" data-step="1" data-intro="Navigation around the Game"
                            data-position='right' id="openMenu2" style="margin-top: 15px;height:25px;width: 25px;margin-left:10px;" />
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-8 marquee" style="padding:0px;">
                    <!-- <marquee scrollamount="3" style="float:left;margin-top:10px;"> -->
                        <p>Supported only in participating states. Read FAQs to learn more.</p>
                    <!-- </marquee> -->
                </div>
                <div class="col-md-2 col-sm-2 col-2" style="padding:0px;">
                    <div class="dropdown drop-margin">
                        <div class="cart-with-notification">
                            <!--<a href="#">-->
                            <!-- <span class="notify-badge" id="ticket-batch" visibility="hidden">0</span> -->
                        <span class="notify-badge">0</span>
                            <img class="cart-img dropbtn" id="cart-nav" src="<?php echo $devicetype; ?>/app.static/img/icon/cart.png" style="width:65px;z-index:1;margin-top:-9px;">
                          <!--</a>-->
                        </div>
                        <div class="dropdown-content" style="width:35%;left:64%;">
                            <div class="header" id="cartdiv" style="background:white;padding-top:0px;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mySidenav" class="sidenav no-print" style="background-color: #361E63;overflow-y:auto;">

                <div id="homemenu" class="col-12 col-sm-12 dropdown tabactive">
                    <button class="dropbtn" onclick='loadComponent("component_home"); activeTab("homemenu");' style="font-size:20px;">Home</button>
                </div>
                <div id="gamemenu" class="col-12 col-sm-12 dropdown drop-margin">
                    <button class="dropbtn">Lotto</button>
                    <div class="dropdown-content" id="dropdown-home" style="max-width: 650px;overflow-y:auto;max-height:60%;height:fit-content;">
                        <div class="row" style="flex-wrap:nowrap;">
                            <div class="col-1 col-sm-1 col-md-1 header">
                            </div>
                            <div class="col-lg-12 col-md-11 col-11 col-sm-11" id="lottery_megamenugl" style="">
                            </div>
                        </div>
                    </div>
                    <!-- for game screen -->
                </div>
                <div class="col-12 col-md-12 dropdown drop-margin" id="signin-reg" style="color:white" onclick="loadComponent('registration');activeTab();">
                    <button class="dropbtn">Sign-in/Register</button>
                </div>
                <div class="col-12 dropdown " id="myprofile_mob">
                    <div class="row">
                        <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick="loadComponent('component_myprofile');activeTab();">
                            <button class="dropbtn">My Profile</button>
                        </div>
                        <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick="loadComponent('myticket');activeTab();">
                            <button class="dropbtn">My Tickets</button>
                        </div>
                        <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick="loadComponent('wallet');activeTab();">
                            <button class="dropbtn">My Wallet</button>
                        </div>
                    </div>
                </div>
                <div id='resmenu' class="col-12 col-sm-12  dropdown drop-margin">
                    <button class="dropbtn">Results</button>
                    <div class="dropdown-content" style="max-width: 650px;overflow-y:auto;max-height:60%;height:fit-content;">
                        <div class="row" style="flex-wrap:nowrap;">
                            <div class="col-1 col-sm-1 col-md-1 header">
                            </div>
                            <div class="col-lg-12 col-md-11 col-11 col-sm-11" id="lottery_megamenurl" style="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 dropdown drop-margin" id="odmenu">
                    <button class="dropbtn">Offers & Discount</button>
                    <div class="dropdown-content" style="overflow-y:auto;max-height:60%;height:fit-content;">
                        <div class="row" style="flex-wrap:nowrap;">
                            <div class="col-1 col-sm-1 col-md-1 header">
                            </div>
                            <div class="col-md-11 col-11 col-sm-11" style="">
                                <div class="row" style="margin-left:0px;margin-right:0px; ">
                                    <div class="col-12 col-md-12" id="component_offerdiscount" style="display:none;"
                                        onclick="loadComponent('offerdiscount');activeTab('odmenu')">
                                        <a href="#" style="padding-top:5px;padding-bottom:5px;">Offers & Discount</a>
                                    </div>
                                    <div class="col-12 col-md-12" id='component_referafriend' style="display:none"
                                        onclick="loadComponent('referafriend');activeTab('odmenu')">
                                        <a href="#" style="padding-top:5px;padding-bottom:5px;">Refer a Friend</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id='winnermenu' class="col-12 col-md-12 dropdown drop-margin">
                    <button class="dropbtn" onclick='loadComponent("allwinners");activeTab("winnermenu")'>Winners</button>
                </div>

                <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick="loadComponent('faq');activeTab();">
                    <button class="dropbtn">FAQ's</button>
                </div>
                <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick='loadComponent("helpandsupport");activeTab();'>
                    <button class="dropbtn">Help & Support</button>
                </div>

                <div class="col-12 col-md-12 dropdown drop-margin" style="color:white" onclick="logout();" id="logoutBtn">
                    <button class="dropbtn">Log Out</button>
                </div>

            </div>


            <div class="row largeheader" style="margin:0;background-color:#21A0A3;padding-top:6px;">
                <div class="col-lg-1 col-md-1 col-1">
                </div>
                <div class="col-lg-8 col-md-8 col-8" style="border-right:1px solid black;margin-top:-10px;display: inherit;"
                    onclick="loadComponent('faq');activeTab();">
                    <marquee scrollamount="3" style="float:left;margin-top:10px;cursor:pointer;">
                    Supported only in participating states. Read FAQs to learn more.
                    </marquee>
                    <div align="right" style="float:right;margin-top:10px;cursor:pointer;">FAQs</div>
                </div>
                <div class="col-lg-3 col-md-3 col-3" id="component_helpandsupport" style="" onclick='loadComponent("helpandsupport");activeTab();'>
                    <label style="cursor:pointer;">Help & Support</label>
                </div>
            </div>

            <div class="row largeheader" style="margin:0;background-color: #361E63;">
               <!-- <div class="col-lg-1 col-md-1 col-1"></div>-->

                <div class="col-lg-2 col-md-2 col-2" style="padding-left:0px;padding-right:0px;">
                    <img class="site-img" src="<?php echo $devicetype; ?>/app.static/img/icon/site.png" style="height:55px;width:50px;padding-top:5px;padding-bottom:5px;">
                    <img class="luckyKhel_name-img" onclick="loadComponent('component_home')" src="<?php echo $devicetype; ?>/app.static/img/index/luckyKhel_name.png"
                        style="width:90px;cursor:pointer;margin-left:3%;">
                </div>
                <div class="col-lg-1 col-md-1 col-1 sign-in-col" id="firstblankdiv">
                </div>
                <div class="col-lg-5 col-md-5 col-5 navbar bottom-nav" style="padding:0px;position:relative;margin-top:0 !important;display: -webkit-box;">

                    <div id="homemenu" class="dropdown tabactive">
                        <button class="dropbtn" onclick='loadComponent("component_home"); activeTab("homemenu");' style="cursor:pointer;">Home</button>
                    </div>
                    <div id="gamemenu" class="dropdown drop-margin">
                        <button class="dropbtn" onclick="">Lotto Games</button>
                        <div class="dropdown-content" id="dropdown-home" style="max-width: 750px;">
                            <div class="header">
                            </div>
                            <div class="row" style="padding:10px;">
                                <div class="col-lg-12 col-md-12 col-12" id="lottery_megamenugl" style="padding-right:0px;">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id='resmenu' class="dropdown drop-margin">
                        <button class="dropbtn">Results</button>
                        <div class="dropdown-content" style="max-width: 750px;">
                            <div class="header">
                            </div>
                            <div class="row" style="padding:10px;">
                                <div class="col-lg-12 col-md-12 col-12" id="lottery_megamenurl" style="padding-right:0px;">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown drop-margin" id="odmenu">
                        <button class="dropbtn">Offers & Discount</button>
                        <div class="dropdown-content" style="left:0%;width:100%;">
                            <div class="header" style="padding-top:0px;">

                                <div class="row" style="margin-left:0px;margin-right:0px; ">
                                    <div class="col-3 col-md-3 col-lg-3"></div>
                                    <div class="col-3 col-lg-3 col-md-3" id="component_offerdiscount" style="text-align:right"
                                        onclick="loadComponent('offerdiscount');activeTab('odmenu')">
                                        <a href="#" style="padding-top:5px;padding-bottom:5px;cursor:pointer;">Offers & Discount</a>
                                    </div>
                                    <div class="col-3 col-lg-3 col-md-3" id='component_referafriend' onclick="loadComponent('referafriend');activeTab('odmenu')">
                                        <a href="#" style="padding-top:5px;padding-bottom:5px;cursor:pointer;">Refer a Friend</a>
                                    </div>
                                    <div class="col-3 col-md-3 col-lg-3"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id='winnermenu' class="dropdown drop-margin">
                        <button class="dropbtn" onclick='loadComponent("allwinners");activeTab("winnermenu")' style="cursor:pointer;">Winners</button>

                    </div>
                </div>


                <div class="col-lg-1 col-md-1 col-1 sign-in-col" id="blankdiv">
                </div>
                <div class="col-lg-2 col-md-2 col-2 sign-in-col" id="login-header" style="color: white;padding: 0px 0px 0px 4%;margin-top: 11px;display:none;">
                    <div class="sign-in-row row " style="border:1px solid deeppink;border-radius:25px;" onclick="loadComponent('registration')">
                        <div class="col-lg-6 col-md-6 col-6" style="border-right: 1px solid deeppink;padding:0px;text-align:center;cursor:pointer;">Sign-in</div>
                        <div class="col-lg-6 col-md-6 col-6" style="padding:0px;text-align:center;cursor:pointer;">Register</div>
                    </div>
                </div>

                <div class="col-lg-1 sign-in-cart" id="sign-in-cart">
                    <div class="dropdown drop-margin">
                         <div class="cart-with-notification">
                            <!--<a href="#">-->
                                <!-- <span class="notify-badge" id="ticket-batch" visibility="hidden">0</span> -->
                                <img class="cart-img dropbtn" id="cart-nav" src="<?php echo $devicetype; ?>/app.static/img/icon/cart.png" style="width:65px;z-index:1;margin-top:-9px;">
                         <!--</a>-->
                        </div>
                        <span class="notify-badge">1</span>
                        <div class="dropdown-content" style="width:35%;left:64%;">
                            <div class="header" id="cartdiv" style="background:white;padding-top:0px;">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-5 col-md-5 col-5" style="margin-left:38px;display:none" id="loggedin-header">
                    <div id="promenu" class="dropdown drop-margin">
                        <button class="dropbtn" style="color:#C8A052;cursor:pointer;" onclick="loadComponent('component_myprofile');activeTab('promenu')">My Profile</button>
                        <div class="dropdown-content">
                        </div>
                    </div>
                    <div id="mtmenu" class="dropdown drop-margin">
                        <button class="dropbtn" style="color:#C8A052;cursor:pointer;" onclick="loadComponent('myticket');activeTab('mtmenu')">My Tickets <span id="ticket-batch" class="myTicketBatch" visibility="hidden">0</span></button>
                        <div class="dropdown-content">
                        </div>
                    </div>
                    <div id="walmenu" class="dropdown drop-margin">
                        <button class="dropbtn" style="color:#C8A052;" onclick="loadComponent('wallet');activeTab('walmenu')">My Wallet</button>
                        <div class="dropdown-content wallet_dropdown" style="width:20%;">
                            <div class="header">
                                <div class="row" style="margin-left:0px;border-bottom:1px solid gray;padding-top:5px;padding-bottom:5px;"
                                    onclick="loadComponent('wallet')">
                                    <div class="col-7" style="padding-left:8px;padding-right:0px;cursor:pointer;font-size:21px;">
                                        Wallet Balance
                                    </div>
                                    <div class="col-5" style="padding-left:5px;padding-right:0px;font-weight:bold;cursor:pointer;font-size:21px;">
                                        Rs.
                                        <Span id="walletUserBal" style="cursor:pointer;"> </Span>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:0px;border-bottom:1px solid gray;padding-top:5px;padding-bottom:5px;cursor:pointer;"
                                    onclick="loadComponent('addmoney')">
                                    <label style="color:white;font-size:30px;padding-left:8px;cursor:pointer;">+</label>
                                    <label style="padding-left:15px;cursor:pointer;padding-top:10px;font-size:21px;">Add Money
                                    </label>
                                </div>
                                <div class="row" style="margin-left:0px;padding-top:5px;padding-bottom:5px;cursor:pointer;" onclick="loadComponent('withdrawmoney')">
                                    <label style="color:white;font-size:30px;padding-left:8px;cursor:pointer;">-</label>
                                    <label style="padding-left:15px;cursor:pointer;padding-top:10px;font-size:21px;">Withdraw Money
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown drop-margin">
                        <div class="cart-with-notification">
                            <!--<a href="#">-->
                                <span class="notify-badge" id="ticket-batch" visibility="hidden">0</span>
                                <img class="cart-img dropbtn" id="cart-nav" src="<?php echo $devicetype; ?>/app.static/img/icon/cart.png" style="width:65px;z-index:0;margin-top:-9px;">
                            <!--</a>-->
                        </div>
                        <div class="dropdown-content cart-div" style="width:35%;">
                            <div class="header" id="cartdiv" style="background:white;padding-top:0px;">

                            </div>
                        </div>
                    </div>
                    <div   style="color: white;padding: 0px 0px 0px 4%;margin-top: 11px;">
                        <div class="sign-in-row row " style="" onclick="logout();">
                            <div class="col-lg-6 col-md-6 col-6" style="text-align:left;padding:0px;text-align:right;"><img id='profileimage' src="<?php echo $devicetype; ?>/app.static/img/dummy.png" height="30" width="30" style="border-radius: 50%;  margin-left: 20px;cursor:pointer;"
                            alt="NOTLOGEDIN">
                            </div>
                        <div class="col-lg-6 col-md-6 col-6" style="padding:0px;text-align:left;font-size:13px;    padding-top: 5px;padding-left: 4px;cursor:pointer;">Log Out</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row" id="gameheaderbar" style="display:none;background: deeppink;padding-top: 5px;padding-bottom: 5px;text-align:center;margin-left:0px;">
                <!-- <div class="col-lg-2 col-md-1 col-1" style="padding-left:0px;padding-right:0px;"></div> -->
                <div class="col-lg-12 col-md-12 col-12" style="padding-left:0px;padding-right:0px;">
                    <div class="row">
                        <div class="col-12 col-xs-12 col-md-7 col-lg-7" style="padding-left:0px;padding-right:0px;">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-3" id="" style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;cursor:pointer;" onclick="takeme('#addnewticket');showme('#addnewticket')">Add
                                        New Ticket</a>
                                </div>
                                <div class="col-md-3 col-lg-3 col-3" style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;white-space: nowrap;cursor:pointer;" onclick="takeme('#howToPlay');showme('#howToPlay')">How to Play</a>
                                </div>
                                <div class="col-md-3 col-lg-3 col-3" onclick="takeme('#prizeScheme');showme('#prizeScheme')"
                                    style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;cursor:pointer;">Prize Structure</a>
                                </div>
                                <div class="col-md-3 col-lg-3 col-3" onclick="takeme('#pastresult');showme('#pastresult')"
                                    style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;cursor:pointer;">All Past Result</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-md-5 col-lg-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-4" style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;cursor:pointer;">Claim Winnings</a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-4" onclick="loadComponent('faq');" style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:white;cursor:pointer;">FAQ's</a>
                                </div>
                                <div class="col-md-4 col-lg-4 col-4" onclick="downloadapp()" style="padding-left:0px;padding-right:0px;">
                                    <a href="#" style="color:#FFA765;cursor:pointer;">Download App</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-2 col-md-1 col-1" style="padding-left:0px;padding-right:0px;"></div> -->
            </div>

            <div class="row" id="gameheadercircle" style="max-height: 60px;">
                <div class="col-md-4 col-lg-4 col-4" id="gameheader">
                    <img id='gameimage' class="img-fluid" src="<?php echo $devicetype; ?>/app.static/img/index/luckyKhel_name.png" style="max-width: inherit;max-height: -webkit-fill-available;min-width:100px;margin-left:35px;">
                </div>
                <div class="col-md-4 col-lg-4 col-4 text-center" style="white-space:nowrap;">
                    <div class="circle-text" style="width: inherit;position: absolute;left: 0;margin-top: 10px;">
                        <div class="col-12" style="padding:0px;">
                            <label class="winlabel" style="font-size:25px;color:#3E235C;margin: -4px;">Win</label>
                        </div>
                        <div class="col-12" style="padding:0px;">
                            <label class="winprizelabel" id="header-gamewinningamt" style="font-size:25px;font-weight:bold;color:#3E235C;"></label>
                        </div>
                    </div>
                    <img id='circleimage' class="img-fluid" src="<?php echo $devicetype; ?>/app.static/img/Win-semi-circle.png" style="max-height: 90px;">

                </div>

                <div class="col-md-4 col-lg-4 col-4 text-center" id="gameheaderdraw" style="white-space: nowrap;
        padding: 0px;margin-top:10px;">
                    <label style="color:#465355;margin-bottom: 0rem;"> Next draw </label>
                    <div class=" game-timer" style="color: #D55456;font-weight: bold;">
                    </div>
                </div>
            </div>

        </div>
        </div>
        <div id="body" style="margin-top: 174.391px;margin-bottom:5%">

        </div>

        </div>
        <footer style="padding-top:6%;background-size:cover;background-image:url(<?php echo $devicetype; ?>/app.static/img/Footer-BG.png); margin-top:5%;">

            <div class="row" style="margin-left:0px;margin-right:0px;position:relative;bottom:0px;overflow-x: hidden;">
                <div class="col-12" style="">
                    <div class="row" style="position: inherit;">
                        <div class="col-lg-6 col-md-6col-sm-6 col-6 footer-details" style="color:white;">
                            <div class="row" style="float:right;white-space:nowrap;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 " style="font-weight:bold;font-size:30px;">
                                    <div class="row">
                                        <div class="col-2"></div><div class="col-8" style="margin-bottom:15px;">Lotto Games</div></div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6" style=" ">
                                    <label class="game-name-bottom" onclick="loadComponent('game_28')">Bonus Ball</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_18')">Power Ball</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_191')">Mega 5</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_61')">Thursday Lotto</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_192')">Dream 5</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6" style="">
                                    <label class="game-name-bottom" onclick="loadComponent('game_62')">Saturday Lotto</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_9')">Keno</label>
                                    <br>  
                                    <label class="game-name-bottom" onclick="loadComponent('game_5')">Magic Lotto</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_30')">Lucky Four</label>
                                    <br>
                                    <label class="game-name-bottom" onclick="loadComponent('game_95')">Lotto Bunch</label>                                 
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 footer-details text-center" style="color:white; max-height: 200px;">
                            <label style="font-weight:bold;font-size:30px;margin-bottom:0px;margin-bottom:15px;"> About Us</label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="padding:0px;">
                                <label class="game-name-bottom" onclick="loadComponent('allresult_5')">Results</label>
                                <br>
                                <label class="game-name-bottom" onclick="loadComponent('offerdiscount')">Offers &
                                    Discount</label>
                                <br>
                                <label class="game-name-bottom">Winner's</label>
                                <br>
                                <label class="game-name-bottom" onclick="loadComponent('aboutus')">About Us</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 footer-details" style="color:white;white-space:nowrap;padding:0px; max-height: 200px;">
                            <label style="font-weight:bold;font-size:30px;margin-bottom:0px;margin-bottom:15px;"> Suppport</label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="padding:0px;">
                                <label class="game-name-bottom" onclick="loadComponent('helpandsupport')">Help &
                                    Support</label>
                                <br>
                                <label class="game-name-bottom" onclick="loadComponent('faq')">FAQ</label>
                                <br>
                                <label class="game-name-bottom" onclick="loadComponent('terms')">Terms and Conditions</label>
                                <br>
                                <label class="game-name-bottom">Privacy Policy</label>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <img src="<?php echo $devicetype; ?>/app.static/img/Footer-BG.png" style="position: absolute; bottom: 0;height:30% !important;width:100%;"> -->
            <!-- </div> -->
        </footer>

    </template>

<template id="mobile">

    <div class="modal fade" id="notification" role="dialog">
        <div class="modal-dialog">

            <!-- Notification content-->
            <div class="modal-content">
                <div class="modal-header">
                    <img src="site.png" style="width: 37px;" />
                    <h4 id="notification_title" class="modal-title">Modal Header</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="notification_body" class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
            </div>

        </div>
    </div>


    <blackdrop></blackdrop>
    <div id="internetstatus" style="display:none;z-index: 1101;text-align: center;color:white;"></div>

    <div class="wrapper printwithoutbg">
        <div id=header class="no-print">
            <img id='homeiconn' onclick="loadComponent('component_home')" src="<?php echo $devicetype; ?>/app.static/img/index/home-ticket-icon.png" style="width: 28px; height: 28px;top: 85%; position: absolute;top: 25px;right: 20px;z-index: 20;">

            <!-- Home Header -->
            <div id="homeheader">
                <!-- Components will be added here in page-content -->
                <div id="menu-open-bg-wrapper" style="width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.623); display: none;position: fixed;z-index: 2;"></div>
                <div class="row" style="padding-top:10px;margin-left:0px;margin-right:0px;">
                    <div class="col-2" id='hamburgermenu'>
                        <div id="openMenu">
                            <img src="<?php echo $devicetype; ?>/app.static/img/index/menuIcon1.png" data-step="1" data-intro="Navigation around the Game" data-position='right'
                                id="openMenu2" style="margin-top: 10px;width: 40px;" />
                        </div>
                    </div>
                    <div class="col-6" style="margin-left:-6px;">
                        <img id='pageimage' src="<?php echo $devicetype; ?>/app.static/img/index/luckyKhel_name.png" style="width:76px; height: 27px;margin-top: 15px;">
                    </div>
                    <div class="col-1"></div>
                    <div class="col-1" style="padding-left: 0px;">
                        <img id='myTickets' data-step="2" data-intro="Cart to hold all your Tickets" data-position='bottom' onclick="loadComponent('myticket')"
                            src="<?php echo $devicetype; ?>/app.static/img/index/ticketLogo.png" style="width:28px; height: 28px;margin-top: 15px;">
                        <div class="badge" id="ticket-batch" style="background: #E85B56;color: #fff;border-radius:50%;position: relative;top: -38px;right: -21px;z-index: 1;font-size:9px;padding: 3px 3px;">
                        0</div>
                    </div>
                    <div class="col-1">
                        <div>
                            <img id="howtoplayvid" data-step="3" data-intro="How to play videos" data-position='top' onclick="loadComponent('howtoplay')"
                                src="<?php echo $devicetype; ?>/app.static/img/info.png" style="width:28px; height: 28px;top:85%;position:absolute;top: 15px;">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Game Header -->
            <div id="gameheader" style="display:none;">
                <!-- Components will be added here in page-content -->
                <div id="menu-open-bg-wrapper" style="width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.623); display: none;position: fixed;z-index: 1;"></div>
                 <div class="row" style="margin-left:0px;margin-right:0px;">
                    <!-- <div class=""> -->
                    <!--div id="openMenu">
                                         <img src="<?php echo $devicetype; ?>/app.static/img/index/gameIcon.png" id="openMenu2" style="margin-top: 15px;height:25px;width: 25px;margin-left:10px;"
                                         />
                                     </div-->
                    <!-- </div> -->
                    <div class="col-6" style="margin-left:-6px;">
                        <img id='gameimage' src="<?php echo $devicetype; ?>/app.static/img/index/luckyKhel_name.png" style="width:76px; height: 27px;margin-top: 15px;">
                    </div>
                    <div class="col-1"></div>
                    <div class="col-1">
                        <!--img id='userProfile' src="<?php echo $devicetype; ?>/app.static/img/index/profileLogo.png" style="width:25px; height: 25px;margin-left:75%;margin-top: 15px;"-->
                    </div>
                    <div class="col-1"></div>
                    <div class="col-2" style="text-align: right;">
                        <!--  <img onclick="loadComponent('component_home')" src="<?php echo $devicetype; ?>/app.static/img/index/home-ticket-icon.png"
                                style="width: 30px; height: 30px;top: 85%; position: absolute;top: 19px;">-->
                    </div>
                </div>
            </div>
        </div>
        <!-- ================ menu side nav =================================-->
        <div id="mySidenav" class="sidenav no-print">
            <div class="ulogin">
                <div class="row" height="50" style="white-space: nowrap;">
                    <img id='profileimage' src="<?php echo $devicetype; ?>/app.static/img/dummy.png" height="42" width="42" style="border-radius: 50%;
                                     margin-left: 20px;" alt="NOTLOGEDIN">
                </div>
                <div id="login" onclick="loadComponent('registration','component_home');closeSideMenu()">
                    <label style="left: 25px;position: absolute;top: 50px; white-space: nowrap;">Log in / Register
                        <!-- <i class="fa fa-arrow-right"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/others/forward-icon-icon.png" style="width:18px;">
                </div>
                <div id="menuProfile" class="row" style="white-space:nowrap">
                    <div class="col-7 col-sm-7 col-md-7" style="padding-right: 3px !important;">
                        <div class="row" style="margin-top:16px;">
                            <label id="menuUserName" style="margin-left: 23px; font-size:18px;" fullname=""></label>
                            </label>
                        </div>
                        <div class="row">
                            <span id="menuUserNumber" style="margin-left: 26px;margin-top: -8px;font-size: 14px;"></span>
                        </div>
                    </div>
                    <div class="col-5 col-sm-5 col-md-5" style="padding-right: 3px !important; text-align:right;margin-top:19px;">
                        <div class="row" style="margin-top: 5px; white-space: nowrap;margin-left:10px">
                            <span style="font-size:11px; ">Wallet Balance</span>
                        </div>
                        <div class="row" style="margin-top: -6px;white-space: nowrap;margin-left:10px">
                            <img src="<?php echo $devicetype; ?>/app.static/img/icon/others/addmoney-wallet.png" style="height:33px;margin-left:-8px;"
                                onclick="directAddMoney=true;closeSideMenu();loadComponent('payment');">
                            <span id="menuUserBal" class="bigger menuUserBal" style="font-size:22px;" onclick="directAddMoney=true;closeSideMenu();loadComponent('payment');"></span>


                        </div>
                    </div>
                </div>
            </div>

            <ul class="navbar-nav" style="white-space: nowrap;">
                <!-- <br> -->
                <li class="nav-item" id="component_home" onclick='loadComponent("component_home");closeSideMenu();selectMenu("home")'>
                    <a class="nav-link" href="#">
                        <!-- <span class='glyphicon glyphicon-home'></span> -->
                        <!-- <i class='fa fa-home'></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/blue/home-icon.png" id="home" class="menuiconimg" />
                        <span id="home-text" style="color:#0055FF" class="textsidemenu"> Home</span>
                    </a>
                </li>

                <span class="sidemenuheading">Profile</span>
                <li class="nav-item" id="component_wallet" style="display:none" onclick='loadComponent("wallet");closeSideMenu();selectMenu("wallet")'>
                    <a class="nav-link" href="#">
                        <!-- <i class='fa fa-credit-card'></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/wallet-icon.png" id="wallet" class="menuiconimg" />
                        <span id="wallet-text" class="textsidemenu"> My Wallet</span>
                    </a>
                </li>
                <li class="nav-item" id="component_tickets" onclick='loadComponent("myticket");closeSideMenu();selectMenu("ticket")' style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-ticket"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/ticket-icon.png" id="ticket" class="menuiconimg" />

                        <span id="ticket-text" class="textsidemenu"> My Ticket</span>
                    </a>
                </li>
                <li class="nav-item" id="component_myprofile" onclick="loadComponent('component_myprofile');closeSideMenu();selectMenu('profile')"
                    style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-user"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/profile-icon.png" id="profile" class="menuiconimg" />

                        <span id="profile-text" class="textsidemenu"> My Profile</span>
                    </a>
                </li>
                <li class="nav-item" id="component_otherrechargeoption" style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-user"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/rechargeoption-icon.png" id="rechargeoption" class="menuiconimg"
                        />

                        <span id="rechargeoption-text" class="textsidemenu"> Other Recharge Options</span>
                    </a>
                </li>
                <span class="sidemenuheading">Promotions</span>
                <li class="nav-item" id="component_offerdiscount" style="display:none" onclick='loadComponent("offerdiscount");closeSideMenu();selectMenu("discount")'>
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-certificate"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/discount-icon.png" id="discount" class="menuiconimg" />
                        <span id="discount-text" class="textsidemenu"> Offers &amp; Discount</span>
                    </a>
                </li>
                <li class="nav-item" id='component_referafriend' style="display:none" onclick='loadComponent("referafriend");closeSideMenu();selectMenu("refer-friend")'>
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-users"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/refer-friend-icon.png" id="refer-friend" class="menuiconimg"
                        />

                        <span id="refer-friend-text" class="textsidemenu"> Refer a friend</span>
                    </a>
                </li>

                <span class="sidemenuheading">LuckyKhel</span>
                <li class="nav-item" id="component_aboutus" style="display:none" onclick='loadComponent("aboutus");closeSideMenu();selectMenu("about")'>
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-certificate"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/about-icon.png" id="about" class="menuiconimg" />
                        <span id="about-text" class="textsidemenu"> About us</span>
                    </a>
                </li>
                <li class="nav-item" id="component_helpandsupport" style="display:none" onclick='loadComponent("helpandsupport");closeSideMenu();selectMenu("help")'>
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-question-circle-o"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/help-icon.png" id="help" class="menuiconimg" />
                        <span id="help-text" class="textsidemenu"> Help & Support</span>
                    </a>
                </li>
                <li class="nav-item" id="component_allresult" style="" onclick='loadComponent("allresult_5");closeSideMenu();selectMenu("allresult")'>
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-question-circle-o"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/allresult-icon.png" id="allresult" class="menuiconimg"/>
                        <span id="allresult-text" class="textsidemenu"> Results</span>
                    </a>
                </li>
                <li class="nav-item" id="downloadapp" style="display:none" onclick='loadComponent("download");closeSideMenu();selectMenu("download");'>
                    <a class="nav-link" id="downloadluckykhel" href="#">
                        <img id="download" src="<?php echo $devicetype; ?>/app.static/img/icon/grey/download-icon.png" class="menuiconimg" />
                        <span id="download-text" class="textsidemenu"> Download App</span>
                    </a>
                </li>

                <li class="nav-item" id="component_faq" style="display:none" onclick="loadComponent('faq');closeSideMenu();selectMenu('faqs')">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-question-circle-o"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/faqs-icon.png" id="faqs" class="menuiconimg" />

                        <span id="faqs-text" class="textsidemenu"> FAQs</span>
                    </a>
                </li>
                <li class="nav-item" id="component_terms" onclick="loadComponent('terms');closeSideMenu();selectMenu('term')" style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-sign-out"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/term-icon.png" id="term" class="menuiconimg" />

                        <span id="term-text" class="textsidemenu"> Terms</span>
                    </a>
                </li>
                <li class="nav-item" id="component_prizeclaimforms" onclick="loadComponent('prizeclaimforms');closeSideMenu();selectMenu('prizeclaimforms')"
                    style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-server" id="prizeclaimforms"  class="menuiconimg"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/prizeclaimforms-icon.png" id="prizeclaimforms" class="menuiconimg"
                        />

                        <span id="prizeclaimforms-text" class="textsidemenu"> Prize Claim Forms</span>
                    </a>
                </li>
                <li class="nav-item" id="logout" onclick="logout();closeSideMenu();selectMenu('log_out')" style="display:none">
                    <a class="nav-link" href="#">
                        <!-- <i class="fa fa-sign-out"></i> -->
                        <img src="<?php echo $devicetype; ?>/app.static/img/icon/grey/log_out-icon.png" id="log_out" class="menuiconimg" />

                        <span id="logout-text" onclick="logout();closeSideMenu();selectMenu('log_out')" class="textsidemenu">
                            Logout</span>
                    </a>
                </li>
                <div id="chat1" style="display:none">
                    <a class="nav-link" href="#">
                        <i class="fa fa-commenting-o"></i>
                        <span> Chat with us
                            <small>Coming Soon</small>
                        </span>
                        <!-- <div style="color: white;margin-left: 32px;margin-top: -7px;font-size: 10px;">10:00AM to 9:00PM</div> -->
                    </a>

                </div>

            </ul>

        </div>
        <!-- head -->
        <div id="body"></div>
        <div id="footer" data-step="4" data-intro="Cart to hold all your Tickets" data-position='top' class="no-print"></div>
    </div>
    <div id="snackbar" class="no-print"></div>
    <!-- // change on live -->
    <!-- <div id="ifUserOnChrome" style="z-index:5000;border:5px solid gainsboro;width: 100%;height:100%;font-size: 14px;position: fixed;top: 0px;overflow: auto;background-color: wheat;display:none">
        <h4>Location Access Denied!!</h4>
        <b>
            <ul id="ifUserOnChromeShortcut" style="list-style-type:square;word-break: normal;">
                <li>Open Chrome Browser</li>
                <hr>
                <li>Goto :
                    <span style="font-size:10px;">http://www.luckykhel.com</span>
                    <button onclick="window.open('http://www.luckykhel.com');">Open Now</button>
                </li>
                <hr>
            </ul>
            <ol style="word-break: normal;">
                <li>Click on the green lock icon on the top left of the address bar
                    <img src="<?php echo $devicetype; ?>/app.static/img/chrome/1.png" alt="settings" style="width:80%;">
                </li>
                <hr>
                <li>Click on site settings
                    <img src="<?php echo $devicetype; ?>/app.static/img/chrome/2.png" alt="settings" style="width:80%;">
                </li>
                <hr>
                <li>Click on "location access"
                    <img src="<?php echo $devicetype; ?>/app.static/img/chrome/3.png" alt="settings" style="width:80%;">
                </li>
                <li>Set Location Permission to "ALLOW"
                    <img src="<?php echo $devicetype; ?>/app.static/img/chrome/4.png" alt="settings" style="width:80%;">
                </li>
                <hr>
                <li>try again
                </li>
                <hr>
            </ol>
        </b>
        <button class="pinkb" onclick="loadComponent('component_home');" style="width:100%;">Go Back To Home</button>
    </div>

    <div id="ifUserOnSafari" style="z-index:5000;border:5px solid gainsboro;width: 100%;height:100%;font-size: 14px;position: fixed;top: 0px;overflow: auto;background-color: wheat;display:none">
        <h4>Location Access Denied!!</h4>
        <b>
            <ol style="word-break: normal;">
                <li>Goto "Settings" from app menu</li>
                <li>Click on "Privacy" in settings
                    <img src="<?=($devicetype);?>/app.static/img/safari/1.png" alt="settings" style="width:80%;">
                </li>
                <li>Click on "location services"
                    <img src="<?=($devicetype);?>/app.static/img/safari/2.png" alt="settings" style="width:80%;">
                </li>
                <li>Click on "safari websites"
                    <img src="<?=($devicetype);?>/app.static/img/safari/3.png" alt="settings" style="width:80%;">
                </li>
                <li>Click on "while using the app"
                    <img src="<?=($devicetype);?>/app.static/img/safari/4.png" alt="settings" style="width:80%;">
                </li>
                <li>try again</li>
            </ol>
        </b>
        <button class="pinkb" onclick="loadComponent('component_home');" style="width:100%;">Go Back To Home</button>
    </div> -->
    <div id="popup-a2hs-ios" class="no-print">
        <div class="popup-close-icon">&times;</div>
        <div class="row">
            <div class="col-4">
                <img src="site.png" alt="luckykhel logo">
            </div>
            <div class="col-8">
                <h4>Add Our App?</h4>
                <p>Tap below to add an icon to your home screen for quick access!</p>
            </div>
        </div>
    </div>
</template>
<template id=common>
    <div id="custom_backdrop" style="width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.623);position: fixed;top: 0;z-index:11;"></div>
        <div id="custom_keyboard" class="text-center custkeyB card">
            <!-- keyboard header starts -->
            <div class="row custRow">
                <div class="col-8">
                    Select Series and Numbers
                </div>
                <div class="col-4">
                    <button class="hollowpink float-left" onclick="playEasyQuickPick();">Quick Pick</button>
                    <button type="button" class="close float-right" onclick="closeKeyBoard();">&times;</button>
                </div>
            </div>
            <!-- keyboard header ends -->
            <!-- keyboard selected input start -->
            <div class="row custRow">
                <input type="text" id="customKeyBoardInput" readonly style="width:90%; margin: auto; border: none; background-color: lightblue; color:royalblue; font-size: 15px;font-size: 25px;letter-spacing: 10px;"
                    maxlength="7">
            </div>
            <!-- keyboard selected input start -->
            <!-- keyboard keys start -->
            <div class="container">
                <button id="ckbdNum_1" class="customKeyBButton btnNumb">1</button>
                <button id="ckbdNum_2" class="customKeyBButton btnNumb">2</button>
                <button id="ckbdNum_3" class="customKeyBButton btnNumb">3</button>
                <button id="ckbdNum_4" class="customKeyBButton btnNumb">4</button>
                <button id="ckbdNum_5" class="customKeyBButton btnNumb">5</button>
                <button id="ckbdNum_6" class="customKeyBButton btnNumb">6</button>
                <button id="ckbdNum_7" class="customKeyBButton btnNumb">7</button>
                <button id="ckbdNum_8" class="customKeyBButton btnNumb">8</button>
                <button id="ckbdNum_9" class="customKeyBButton btnNumb">9</button>
                <button id="ckbdNum_0" class="customKeyBButton btnNumb">0</button>
                <div class="row custRow"></div>
                <button id="Q" class="customKeyBButton btnAlpha">Q</button>
                <button id="W" class="customKeyBButton btnAlpha">W</button>
                <button id="E" class="customKeyBButton btnAlpha">E</button>
                <button id="R" class="customKeyBButton btnAlpha">R</button>
                <button id="T" class="customKeyBButton btnAlpha">T</button>
                <button id="Y" class="customKeyBButton btnAlpha">Y</button>
                <button id="U" class="customKeyBButton btnAlpha">U</button>
                <button id="I" class="customKeyBButton btnAlpha">I</button>
                <button id="O" class="customKeyBButton btnAlpha">O</button>
                <button id="P" class="customKeyBButton btnAlpha">P</button>
                <div class="row custRow"></div>
                <button id="A" class="customKeyBButton btnAlpha">A</button>
                <button id="S" class="customKeyBButton btnAlpha">S</button>
                <button id="D" class="customKeyBButton btnAlpha">D</button>
                <button id="F" class="customKeyBButton btnAlpha">F</button>
                <button id="G" class="customKeyBButton btnAlpha">G</button>
                <button id="H" class="customKeyBButton btnAlpha">H</button>
                <button id="J" class="customKeyBButton btnAlpha">J</button>
                <button id="K" class="customKeyBButton btnAlpha">K</button>
                <button id="L" class="customKeyBButton btnAlpha">L</button>
                <div class="row custRow"></div>
                <button id="Z" class="customKeyBButton btnAlpha">Z</button>
                <button id="X" class="customKeyBButton btnAlpha">X</button>
                <button id="C" class="customKeyBButton btnAlpha">C</button>
                <button id="V" class="customKeyBButton btnAlpha">V</button>
                <button id="B" class="customKeyBButton btnAlpha">B</button>
                <button id="N" class="customKeyBButton btnAlpha">N</button>
                <button id="M" class="customKeyBButton btnAlpha">M</button>
                <button id="erase" style="margin-left: 12px;margin-right: -55px; width:9.5%;padding: 1px;border: 1px solid grey;border-radius: 5px;background-color: lightgrey;color: black;">⌫</button>
                <div class="row custRow"></div>
                <div class="row custRow">
                    <button id="custKeySubmit" class="pinkb" style="width:90%;margin:auto;">SUBMIT</button>
                </div>
            </div>
            <!-- keyboard keys ends -->
        </div>
        <div id="custom_modal" class="text-center custkeyB card" style="/*top:65px;height: fit-content;*/display:none;font-size: medium;width:95%;left:2.5%;">
            <div class="custom-modal-content">
                <div id="custom-modal-header" class="modal-header">


                </div>
                <div id="custom-modal-body" class="modal-body">
                    Modal body..
                </div>

            </div>
        </div>
        <div id="preloaderMask">
            <div id="preloader">
                <div class="svg-loader">
                    <svg width="90" height="90" fill="white">
                        <circle cx="15" cy="15" r="15" fill="#ea2289" />
                        <circle cx="15" cy="75" r="15" fill="#ea2289" />

                        <circle cx="75" cy="15" r="15" fill="#4fbabe" />
                        <circle cx="75" cy="75" r="15" fill="#4fbabe" />
                        <circle cx="45" cy="45" r="35" stroke="black" stroke-width="0" fill=rgba(30,100,255,0.34)>
                            <animate attributeName="r" begin="0s" dur="1s" repeatCount="indefinite" from="30" to="40"></animate>
                        </circle>
                        <circle cx="45" cy="45" r="30" stroke="black" stroke-width="0" fill='white'>
                        </circle>
                        <circle cx="45" cy="45" r="35" stroke="black" stroke-width="0" fill=rgba(30,100,255,0.34)>
                            <animate attributeName="r" begin="0s" dur="1s" repeatCount="indefinite" from="40" to="30"></animate>
                        </circle>
                        <circle cx="45" cy="45" r="30" stroke="black" stroke-width="0" fill='white'>
                        </circle>
                        <circle cx="15" cy="45" r="15" fill="#f6cd04" />
                        <circle cx="45" cy="15" r="15" fill="#f6cd04" />
                        <circle cx="45" cy="75" r="15" fill="#f6cd04" />
                        <circle cx="75" cy="45" r="15" fill="#f6cd04" />
                        <circle cx="45" cy="45" r="15" fill="#4fbabe" />

                    </svg>
                </div>
                <svg height="50" width="250" style="position:  absolute;bottom:5px;left: 22px;">
                    <text x="-1" y="35" fill="grey" font-family="bariol-reg" font-size="44">lucky</text>
                    <text x="86.5" y="35" font-weight="bold" fill="grey" font-family="bariol-reg" font-size="44">khel</text>
                </svg>
            </div>
            <img onclick="loadComponent('component_home')" src="<?php echo $devicetype; ?>/app.static/img/index/home-ticket-icon.png" style="width: 30px;height: 30px;top: 15px;position: absolute;right: 15px;">
        </div>
        <div id="internetstatus" style="display:none;z-index: 1101;text-align: center;color:white;"></div>
        <div id="snackbar" class="no-print"></div>
    </template>
</body>

</html>
