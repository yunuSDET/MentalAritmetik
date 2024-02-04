<?php
include 'sessionManager.php';
checkUserSession();
?>


<?php
include 'navbar.php';
?>


<html lang="en"><head>
    <meta charset="utf-8">
    <title>Soroban Abaküsü</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="./abacus.js"></script>
    <script type="text/javascript">
        
      function run() {
        var abacus = new Abacus("myAbacus", 0);
        abacus.init();
      }
    </script>
  <style type="text/css">iframe#teal-job-tracker-iframe-stable {
    min-width: 380px !important;
    width: 380px !important;
    min-height: 100vh !important;
    height: 100vh !important;
  }

  @media print {
    #teal-job-tracker-root-stable, #teal-job-tracker-companion-root-stable {
      display: none !important;
    }
  }</style><style type="text/css">/* Copyright 2014-present Evernote Corporation. All rights reserved. */
@keyframes caretBlink {
    from { opacity: 1.0; }
    to { opacity: 0.0; }
}

@keyframes rotateSpinner {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}

#text-tool-caret {
    animation-name: caretBlink;  
    animation-iteration-count: infinite;  
    animation-timing-function: cubic-bezier(1.0,0,0,1.0);
    animation-duration: 1s; 
}

#en-markup-loading-spinner {
    position: absolute;
    top: calc(50% - 16px);
    left: calc(50% - 16px);
    width: 32px;
    height: 32px;
}

#en-markup-loading-spinner img {
    position: relative;
    top: 0px;
    left: 0px;
    animation-name: rotateSpinner;
    animation-duration: 0.6s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
</style><style type="text/css">/* Copyright 2014-present Evernote Corporation. All rights reserved. */
.skitchToastBoxContainer {
    position: absolute;
    width: 100%;
    text-align: center;
    top: 30px;
    -webkit-user-select: none;
    -moz-user-select: none;
    pointer-events: none;
}

.skitchToastBox {
    width: 200px;
    height: 16px;
    padding: 12px;
    background-color: rgba(47, 55, 61, 0.95);
    border-radius: 4px;
    color: white;
    cursor: default;
    font-size: 10pt;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.32);
    font-family: 'Soleil', Helvetica, Arial, sans-serif;
    border: 2px rgba(255, 255, 255, 0.38) solid;
}

.lang-zh-cn .skitchToastBox {
    font-family: '微软雅黑', 'Microsoft YaHei', SimSun,
        '&#x30E1;&#x30A4;&#x30EA;&#x30AA;', Meiryo, 'MS PGothic', 'Soleil',
        Helvetica, Arial, sans-serif;
}

.lang-ja-jp .skitchToastBox {
    font-family: '&#x30E1;&#x30A4;&#x30EA;&#x30AA;', Meiryo, 'MS PGothic',
        '微软雅黑', 'Microsoft YaHei', SimSun, 'Soleil', Helvetica, Arial,
        sans-serif;
}

.skitchToast {
    padding-left: 20px;
    padding-right: 20px;
    display: inline-block;
    height: 10px;
    color: #f1f5f8;
    text-align: center;
}

.skitchVisible {
    /* Don't remove this class it's a hack used by the Evernote Clipper */
}
</style><style type="text/css">/* Copyright 2014-present Evernote Corporation. All rights reserved. */

@font-face {
	font-family: 'Soleil';
 
	font-weight: normal;
	font-style: normal;
}
</style><style type="text/css">/* Copyright 2019-present Evernote Corporation. All rights reserved. */

#en-markup-disabled {
    position: fixed;
    z-index: 9999;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    cursor: default;
    -webkit-user-select: none;
}

#en-markup-alert-container {
    position: absolute;
    z-index: 9999;
    width: 450px;
    left: calc(50% - 225px);
    top: calc(50% - 85px);
    background-color: white;
    box-shadow: 0 2px 7px 1px rgba(0,0,0,0.35);
    -webkit-user-select: none;
}

#en-markup-alert-container .cell-1 {
    position: relative;
    height: 110px;
    width: 105px;
    float: left;
    text-align: center;

    background-position: 65% 50%;
    background-repeat: no-repeat;
}

#en-markup-alert-container .cell-2 {
    position: relative;
    float: left;
    width: 345px;
    margin-top: 29px;
    margin-bottom: 20px;
}

#en-markup-alert-container .cell-2 .cell-2-title {
    margin-bottom: 5px;
    padding-right: 30px;
    font-size: 12pt;
    font-family: Tahoma, Arial;
}

#en-markup-alert-container .cell-2 .cell-2-message {
    padding-right: 30px;
    font-size: 9.5pt;
    font-family: Tahoma, Arial;
}

#en-markup-alert-container .cell-3 {
    position: relative;
    width: 450px;
    height: 60px;
    float: left;
    background-color: rgb(240,240,240);
}

#en-markup-alert-container .cell-3 button {
    position: absolute;
    top: 12px;
    right: 15px;
    width: 110px;
    height: 36px;
}

#en-markup-alert-container .cell-3 button.alt-button {
    position: absolute;
    top: 12px;
    right: 140px;
    width: 110px;
    height: 36px;
}

h1 {
            text-align: center;
        }

</style><style>@font-face{font-family:"rbicon";src:url(chrome-extension://dipiagiiohfljcicegpgffpbnjmgjcnf/fonts/rbicon.woff2) format("woff2");font-weight:normal;font-style:normal}</style></head>


  <body onload="run();">
 
        <h1 class="text-center">Soroban Abaküsü</h1>
  
   <div class="container">

    <div class="row">

        <div class="col-sm-10">
            <div id="myAbacus"> <canvas id="myAbacus_Abacus" width="100" height="340"></canvas></div>
        </div>

    </div>
   </div>

 
       <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  

<div hidden="" class="ubey-RecordingScreen-count-down ubey-RecordingScreen-count-down-container">
    <style>
        .ubey-RecordingScreen-count-down-container {
            position: fixed;
            height: 100vh;
            width: 100vw;
            top: 0;
            left: 0;
            z-index: 9999999999999;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .ubey-RecordingScreen-count-down-content {
            position: absolute;
            display: flex;
            top: 50%;
            left: 50%;
            justify-content: center;
            align-items: center;
            color: white;
            height: 15em;
            width: 15em;
            transform: translate(-50%, -100%);
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
        }

        #ubey-RecordingScreen-count-count {
            font-size: 14em;
            transform: translateY(-2%);
        }
    </style>
    <div class="ubey-RecordingScreen-count-down-content">
        <span id="ubey-RecordingScreen-count-count"></span>
    </div>
</div>

<div class="container">
    <div class="row">
   




<div class="col-sm-9">
<div id="teal-job-tracker-root-stable" style="z-index: 2147483647;"><iframe id="teal-job-tracker-iframe-stable" srcdoc="<!DOCTYPE html><html><head></head><body><div class=&quot;frame-root&quot;></div></body></html>" style="background: rgb(255, 255, 255) !important; width: 380px !important; height: 100vh !important; position: fixed !important; inset: 0px -380px auto auto !important; z-index: 2147483647 !important; border: 0px !important; box-shadow: rgba(0, 0, 0, 0.25) 0px 0px 16px -3px !important; transition: right 0.25s ease-in-out 0s !important; transform: none !important;"></iframe></div><div id="rememberry__extension__root" style="all: unset;"></div><div id="teal-job-tracker-companion-root-stable" style="display: block; z-index: 2147483646; bottom: 58px; right: 0px; position: fixed; height: 60px; width: auto;"></div>
</div>



</div>
</div>


</body></html>