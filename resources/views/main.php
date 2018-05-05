<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Protoapp</title>

    <link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="css/desktop.css" />

    <!-- GC -->
 	<!-- LIBS -->
 	<script type="text/javascript" src="adapter/ext/ext-base.js"></script>
 	<!-- ENDLIBS -->

    <script type="text/javascript" src="ext-all-debug.js"></script>

    <!-- DESKTOP -->
    <script type="text/javascript" src="js/StartMenu.js"></script>
    <script type="text/javascript" src="js/TaskBar.js"></script>
    <script type="text/javascript" src="js/Desktop.js"></script>
    <script type="text/javascript" src="js/App.js"></script>
    <script type="text/javascript" src="js/Module.js"></script>
    <script type="text/javascript" src="struts/strut.js"></script>
</head>
<body scroll="no">


<div id="x-desktop">
    <dl id="x-shortcuts">

        <!--
        <dt id="grid-win-shortcut">
            <a href="#"><img src="images/s.gif" />
            <div>Grid Window</div></a>
        </dt>
        <dt id="acc-win-shortcut">
            <a href="#"><img src="images/s.gif" />
            <div>Accordion Window</div></a>
        </dt>

        <dt id="synch-win-shortcut">
            <a href="#"><img src="images/s.gif" />
            <div>Sync Data</div></a>
        </dt>

        <dt id="dashboards-win-shortcut">
            <a href="#"><img src="images/s.gif" />
            <div>Dashboard</div></a>
        </dt>
        -->

    </dl>
</div>


<div id="ux-taskbar">
	<div id="ux-taskbar-start"></div>
	<div id="ux-taskbuttons-panel"></div>
	<div class="x-clear"></div>
</div>


<div id="loginModal" class="modal">
  <div class="modal-content animate">   
    <div class="imgcontainer">
      <img src="images/user.png" alt="Avatar" class="avatar">
    </div>
    <div class="container">
        <input type="text"  placeholder="Username" name="uname" required>
        <input type="password" placeholder="Password" name="psw" required>
        <button type="submit" id="loginBtn">Login</button>
    </div>
  </div>
</div>

<script type="text/javascript" src="struts/strut.js"></script>



</body>
</html>
