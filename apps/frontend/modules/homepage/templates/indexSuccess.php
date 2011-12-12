<?php use_stylesheet('homePage.css') ?>
<?php use_javascript('homePage.js') ?>

  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>    
  
<form>
<input id="hi_username" type="hidden" value="<?php echo $username ?>"/>  
<input id="hi_id" type="hidden" value="<?php echo $id ?>"/>  
<div id="header">
    <div id="logoContainer">
        <div id="name">Wishlist</div>
    </div>
    <div id="linksContainer">
        <div id="profileLinks">            
             <ul id="linkList">              
              <li id="mainProfileLink">
                  <div id="userPicture"></div>
                  <div id="userName" ><a id="userNameLink" href="#">andrea</a></div>                  
              </li>  
              <li><a href="#">Settings</a></li>
              <li><a href="#">Friends</a></li>              
              <li><a href="#">Logout</a></li>
            </ul>
            <p style="height:157px;" id="menuCheat"></p>
        </div>   
    </div>
</div>

<div id="accordion">
	<h3><a href="#">Section 1</a></h3>
	<div>
		<p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
	</div>
	<h3><a href="#">Section 2</a></h3>
	<div>
		<p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
	</div>
	<h3><a href="#">Section 3</a></h3>
	<div>
		<p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
		<ul>
			<li>List item one</li>
			<li>List item two</li>
			<li>List item three</li>
		</ul>
	</div>
	<h3><a href="#">Section 4</a></h3>
	<div>
		<p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
	</div>
</div>


<div id="wishlistComponent">
    <div><h1>My Wishlist</h1></div>
    <?php include_component('wishlist', 'showWishlist', array('wishlistuser_id' => $id)); ?>
</div>
<div id="newsComponent">news updates</div>
<div id="footer">footer</div>
</form>