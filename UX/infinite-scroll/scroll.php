<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
//die(debug($this->request->params));
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
	<?php if (isset($_GET['reset'])): ?>
		sessionStorage.removeItem('owcache');
		window.location.replace("/");
	<? endif; ?>
	</script>
	
	<?php echo $this->Html->charset(); ?>
	<title>
		Outdoorsmen World :
		<?php echo $title_for_layout; ?>
	</title>
	    <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
<?php
  if ($this->request->params['controller'] == 'listing_images' && $this->request->params['action'] == 'add') {
    echo $this->Html->script('addListingImage.ajax');
    echo $this->Html->script('addListingImage.exif');
    echo $this->Html->script('addListingImage.canvas');
  }

  if ($this->request->params['controller'] == 'fflDealers') {
		echo $this->Html->script('https://maps.googleapis.com/maps/api/js?sensor=false');
		echo $this->Html->script('gmap');
    if($this->request->params['action'] == 'search') {
      echo $this->Html->script('geolocation');
    }
	}
	
	echo $this->Html->meta('icon');
	echo $this->Html->meta('description',
		"Outdoor Classifieds, No Fees, World's Largest Free Outdoor Classifieds,
		Buy, Sell, and Trade your Outdoor Gear for Free. Mobile and Tablet
		Friendly, Individuals and Dealers Welcome. Firearms for sale. Buy Guns,
		Sell Guns, Trade Guns. No Memberships Required."
	);
  echo $this->Html->css('normalize');
  echo $this->Html->css('foundation');
  echo $this->Html->css('feed');
  echo $this->Html->css('pin');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
  echo $this->Html->script('vendor/custom.modernizr');
?>
</head>
<? if ($this->request->params['controller'] == 'fflDealers' && isset($fflDealer['FflDealer']['lat'])): ?>
<body  onload="initialize('<?= $fflDealer['FflDealer']['lat'].'\',\''.$fflDealer['FflDealer']['lng'] ?>');">
<? else: ?>
<body>
<? endif; ?>

  <!-- Header and Nav -->
    <!-- Navigation -->
	<div id="menubar" class="fixed">
        <nav class="top-bar nav drop-shadow">
            <ul class="title-area">
				<!-- Title Area -->
				<li class="name">
					<a href="/?reset">
						<img class="left" src="/img/ow_logo_small.png" width="<? echo ($isMobile === true ? '40':'45'); ?>" alt="OutdoorsmenWorld.com" />
						<? if ($isMobile === true) : ?>
							<h6 style="line-height:40px;color:white;text-shadow: 3px 3px 4px gray;">&nbsp;Outdoorsmen World</h6>
						<? else : ?>
							<h2 class="show-for-medium-up" style="color:white;text-shadow: 3px 3px 4px gray;">&nbsp;Outdoorsmen World</h2>
						<? endif; ?>
					</a>
				</li>
				<li class="toggle-topbar menu-icon">
					<a href="#"><span class="margin-right-10"> <span class="hidden">Menu</span>&nbsp;</span></a>
				</li>
            </ul> <!-- /title-area -->
         
            <section class="top-bar-section">
              <!-- Right Nav Section -->
              <ul class="right">
                <li class="divider"></li>
                <li>
                    <?= 
                        $this->Html->link(
							__('Sell'), 
							array('controller' => 'listings', 'action' => 'add'), 
							array('class' => 'listing-button')
                         ); 
                    ?>
                </li>
                <li class="divider"></li>
                <li><a href="#" data-reveal-id="advSearch">Search</a></li>
                <li class="divider"></li>
                <li>
				<?php
					if ($loggedIn == '1') {
						$pieces = explode("@", AuthComponent::user('email'));
						echo '<a href="/users/logout" class="all-button">Logout ('.$pieces[0].')</a>';
					} else {
						echo '<a href="/users/add" class="all-button">Sign Up</a>';
					}
                ?>
				</li>
				
				<?= $login = ($loggedIn != '1') ? '<li class="divider"></li><li><a class="all-button" href="#" data-reveal-id="revLogin">Login</a></li><li class="divider"></li>' : ''; ?>

				<? // Nav for Mobile Browsers ?>
				<?	if ($isMobile === true) : ?>
					<?php
						echo '<li><label><strong>Categories</strong></label></li>';
						$d = $this->requestAction('/categories/index/menu');
						echo $this->element('menu_categories', array('menuCategories' => $d));
					?>
						<li><label>Company</label></li>
						<li><a href="/tos">Terms of Service</a></li>
						<li><a href="/privacy">Privacy Policy</a></li>
						<li><a href="/advertise">Advertise</a></li>
						<li><label>Social</label></li>
						<li><a href="https://www.facebook.com/outdoorsmenworld">Facebook</a></li>
						<li><a href="https://twitter.com/OutdoorsmenW">Twitter</a></li>
					<? if($loggedIn == '1'): ?>
						<? if(AuthComponent::user('role') === 'admin'): ?>
							<li class="divider"></li>
							<li><label>Admin Tools</label></li>
							<li><a href="/ads/index">View Ads</a></li>
							<li><a href="/ads/add">Create an Ad</a></li>
							<li><a href="/users">List all Users</a></li>
						<? endif; ?>	
					<li class="divider"></li>
					<li><label>Account Tools</label></li>
					<? if (AuthComponent::user('role') === 'temp') : ?>
							<li><a href="/users/add">Upgrade to Full Member</a></li>
						<? else: ?>
						<li>
							<a href="/users/view/<?= AuthComponent::user('id');?>">My Account</a>
						</li>
						<li>
							<a href="/users/edit/<?= AuthComponent::user('id');?>">Edit Account</a>
						</li>
						<? endif; ?>
					<? $pieces = explode("@", AuthComponent::user('email')); ?>
					<li class="divider"></li>
					<li><a href="/users/logout">Logout <?= $pieces[0]; ?> &rarr;</a></li>
					<? endif; ?>
					
				<? else:  // NAV FOR NON-MOBILE ?>
					<li class="has-dropdown">
					  <a href="#" class="all-button">More...</a>
					  <ul class="dropdown">
						<li><label>Browse</label></li>
						<li>
							<?=
								$this->Html->link(
									__('Categories'), 
									array('controller' => 'categories', 'action' => 'index'), 
									array('class' => '')
								);
							?>
						</li>
						<li>
							<a href="#" data-reveal-id="advSearch">Search</a>
						</li>
						
						
						<? if($loggedIn == '1'): ?>
							<? if(AuthComponent::user('role') === 'admin'): ?>
								<li class="divider"></li>
								<li><label>Admin Tools</label></li>
								<li><a href="/ads/">View Ads</a></li>
								<li><a href="/ads/add">Create an Ad</a></li>
								<li><a href="/users">List Users</a></li>
							<? endif; ?>	
						<li class="divider"></li>
						<li><label>Account Tools</label></li>
						<? if (AuthComponent::user('role') === 'temp') : ?>
							<li><a href="/users/add">Upgrade to Full Member</a></li>
						<? else: ?>
						<li>
							<a href="/users/view/<?= AuthComponent::user('id');?>">My Account</a>
						</li>
						<li>
							<a href="/users/edit/<?= AuthComponent::user('id');?>">Edit Account</a>
						</li>
						<? endif; ?>
						<? $pieces = explode("@", AuthComponent::user('email')); ?>
						<li class="divider"></li>
						<li><a href="/users/logout">Logout <?= $pieces[0]; ?> &rarr;</a></li>
						<? endif; ?>
						<li class="divider"></li>


						<li><label>Company</label></li>
						<li><a href="/tos">Terms of Service</a></li>
						<li><a href="/privacy">Privacy Policy</a></li>
						<li><a href="/advertise">Advertise</a></li>
						<li><label>Social</label></li>
						<li><a href="https://www.facebook.com/outdoorsmenworld">Facebook</a></li>
						<li><a href="https://twitter.com/OutdoorsmenW">Twitter</a></li>
					  </ul> <!-- end dropdown content -->
					</li><!-- end has-dropdown -->
				<? endif; ?>
                
                


              </ul><!-- end nav right -->
                
            </section> <!-- end section -->
        </nav>
          <!-- End Top Bar -->
	</div>
	<!-- end fixed nav -->
	
	<div class="row full-width">
	<div class="large-12 columns">
	  <div class="panel text-center">
		
		<h4 class="subheader">Buy-Sell-Trade anything Outdoors for FREE 24/7 - No Memberships Required</h4>
	  </div>
	</div>
	</div>

	<!-- End Header and Nav -->


    <!-- End Navigation -->
<!-- div class="row full-width" -->
    <!-- Nav Sidebar -->
    <!-- Main Feed -->
    <!-- This has been source ordered to come first in the markup (and on small devices) but to be to the right of the nav on larger screens -->
	<div class="large-12 small-12 columns">
		<? if ($this->request->params['controller'] === 'categories' && $this->request->params['action'] === 'view') : ?>
			<div class="columns">
				<?= $this->Form->create('Browse', array('url' => '/categories/view', 'type' => 'get')); ?>
				<?= $this->element('subcategories', array('id' => $this->request->pass[0])); ?>
				<?= $this->Form->end(); ?>
			</div>
		<? endif; ?>
        
        <? if(
         ((strcmp($this->request->params['controller'],'listings') != 0) || (strcmp($this->request->params['action'],'index') != 0)) &&
         ((strcmp($this->request->params['controller'],'pages') != 0))
        ): ?> 
		<ul class="breadcrumbs large-10 small-10 large-centered small-centered columns">
            <li><?= $this->Html->getCrumbs("&nbsp;&nbsp;/&nbsp;&nbsp;", 'Home'); ?></li>
            
        </ul>
        <? endif; ?>
		<?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
		
	</div>
	<div id="advSearch" class="reveal-modal medium">
			<?= $this->element('advanced_search'); ?>
			<a class="close-reveal-modal">&#215;</a>
		</div>
    <!-- This is source ordered to be pulled to the left on larger screens -->
    <? if($loggedIn != '1' && $this->request->params['controller'] == 'listings'): ?>
	
	<?= $this->element('modal_verify_email'); ?>
	
	<? endif; ?>
	<?= $this->element('modal_login'); ?>
	<?= $this->element('modal_loading'); ?>
    <!-- Right Sidebar -->
    <!-- On small devices this column is hidden -->
    
<!-- /div -->
<div id="ending" class="large button expand disabled alert" style="display:none;">no more listings available</div>
  <!-- Footer -->

  <footer class="row" <?= ($isMobile === true ? 'style="padding-bottom: 45px;""' : ''); ?>>
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-4 columns">
          <p>&copy;2013 Outdoorsmen World, Inc.</p>
        </div>
        <div class="large-8 columns">
          <ul class="inline-list right">
            <li><a href="/tos">Terms of Service</a></li>
            <li><a href="/privacy">Privacy Policy</a></li>
            <li><a href="/advertise">Advertise</a></li>
            <li><a href="mailto:contact@outdoorsmenworld.com">Contact Us</a></li>
            <li><a href="https://www.facebook.com/outdoorsmenworld" target="_blank"><img src="/img/facebook.png" alt="Outdoorsmen World Facebook Page" width="24" /></a></li>
            <li><a href="https://twitter.com/OutdoorsmenW" target="_blank"><img src="/img/twitter.png" alt="Outdoorsmen World Twitter feed" width="24"/></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  
  
<? if (
  !(strtolower($this->request->params['controller']) === 'listings' && strtolower($this->request->params['action']) === 'add') &&
  !(strtolower($this->request->params['controller']) === 'listing_images' && strtolower($this->request->params['action']) === 'add') &&
  ($isMobile === true)
): ?>
	<!-- Medium ad -->
	<?php echo $this->element('ad_medium'); ?>
    
	<!-- Small ad -->
	<?php echo $this->element('ad_small'); ?>
<? endif; ?>
<?php
  //echo $this->element('sql_dump');
  echo $this->Html->script('vendor/jquery');
  echo $this->Html->script('jquery.wookmark.min');
  echo $this->Html->script('jquery.imagesloaded');
  echo $this->Html->script('jquery.blockUI');
  echo $this->Html->script('foundation.min');
  if ($this->request->params['controller'] == 'listing_images' && $this->request->params['action'] == 'add') {
    echo $this->Html->script('addListingImage');
  }
  
  if ($this->request->params['controller'] == 'ads' && $this->request->params['action'] == 'add') {
    echo $this->Html->script('advertNotice');
  }
  if ($this->request->params['controller'] == 'listings') {
    echo $this->Html->script('addListing');
  }
?>
<script>
  $(document).foundation();
  $('#ending').hide();
  $('#loadmore').hide();
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42865334-1', 'outdoorsmenworld.com');
  ga('send', 'pageview');

</script>
<?php if($isMobile === true): ?>
<script type="text/javascript">
    $("input, textarea").live("focus", function(e) {
      $("#menubar").hide();
      $("#smallad").hide();
    });

    $("input, textarea").live("blur", function(e) {
      $("#menubar").show();
      $("#smallad").show();
    });
</script>
<? endif; ?>
<?php
 $pass_zero = "";
  if (isset($this->request->pass[0])) { $pass_zero = $this->request->pass[0]; }

  $cakephp_action = $this->request->params['controller']."/".$this->request->params['action'];
  $cakephp_saction = $this->request->params['controller'].$this->request->params['action'];
  $ajax_action = array(
	"pages/display" => array("listings/search","keyword=&category=0&listingType=100&zip=&radius="),
	"listings/index" => array("listings/search","keyword=&category=0&listingType=100&zip=&radius="),
	"categories/view" => array("listings/search","keyword=&category={$pass_zero}&listingType=100&zip=&radius="),
	"listing_types/view" => array("listing/search","keyword=&category=0&listingType={$pass_zero}&zip=&radius="),
	"listings/search" => array("listings/search")
  );

  if(array_key_exists($cakephp_action,$ajax_action)):
?>
<script type="text/javascript">
	var page = 0;
	var scroll = 0;
	var okay = true;
	var end = false;

	var functionShowLoader = function() {
		$.blockUI({ message: "<p style='color:white;'>Loading</p><img src='/img/loader2.gif'/>",css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff'
		} });
	}

	var functionApplyLayout = function() {
		var handler = $('#tiles li');
		var options = {
            align: 'center',
			autoResize: true, // This will auto-update the layout when the browser window is resized.
			container: $('#main'), // Optional, used for some extra CSS styling
			offset: 9, // Optional, the distance between grid items
			itemWidth: 0 // Optional, the width of a grid item
			};
		$('#tiles').imagesLoaded(function() {
			if (handler.wookmarkInstance) {
				handler.wookmarkInstance.clear();
			}
			handler = $('#tiles li');
			handler.wookmark(options);
			$.unblockUI();
			if (scroll > 0) { $(window).scrollTop(scroll); }
			okay = true;
		});
	};

	var functionLoadListings = function() {
		if (!end) {
			functionShowLoader();
			page++;
			
			var request = $.get("/<?php echo $ajax_action[$cakephp_action][0]; ?>/page:" + page + "/?<?php if (isset($ajax_action[$cakephp_action][1])) { echo $ajax_action[$cakephp_action][1]; } else { foreach ($_GET as $key => $value) echo $key."=".$value."&"; } ?>");
			
			request.done(function(result) {
				if (result.indexOf("Error") != -1) {
					end = true;
					$.unblockUI();
					$('#ending').show();
				} else {
					$('#tiles').append(result);
					functionApplyLayout();
				}
			});
			
			request.fail(function() {
				end = true;
				$.unblockUI();
				$('#ending').show();
			});
			
		}
	};

	var functionOnScroll = function(event) {
		scroll = $(window).scrollTop();
		var winHeight = window.innerHeight ? window.innerHeight : $(window).height(); // iphone fix
		if ($(window).scrollTop() + winHeight > $(document).height() - 100) {
			if (okay) {
				okay = false;
				functionLoadListings();
			}
		}
	};

	<?php if (!isset($_GET['reset'])): ?>
	$(window).on('pagehide', function() {
		var storage = [];

		storage[0] = $('#tiles').html();
		storage[1] = page;
		storage[2] = $(window).scrollTop();
		storage[3] = "<?php echo "{$cakephp_saction}{$pass_zero}"; ?>";

		sessionStorage.setItem("owcache" , JSON.stringify(storage));
	});
	<? endif; ?>


	$( document ).ready(function() {
		<? if(!$isMobile): ?>
		if (document.getElementById("visit").value == "0") {
			sessionStorage.removeItem('owcache');
			$('#tiles').html("");
			functionLoadListings();
		} else <? endif; ?>if  (sessionStorage.owcache) {
			functionShowLoader();
			var storage = JSON.parse(sessionStorage.owcache);
			
			if(storage[3] == "<?php echo "{$cakephp_saction}{$pass_zero}"; ?>") {
				$('#tiles').html(storage[0]);
				page = storage[1];
				scroll = storage[2];
				sessionStorage.removeItem('owcache');
				functionApplyLayout();
			} else {
				scroll = 1;
				$('#tiles').html("");
				functionLoadListings();
			}
		} else {
			$('#tiles').html("");
			functionLoadListings();
		}
		<? if(!$isMobile): ?>
		document.getElementById("visit").value = "1";
		<? endif; ?>
		$(window).on('scroll', functionOnScroll);
	});
</script>
<? endif; ?>
<? if(!$isMobile): ?>
<input type="hidden" name="visit" id="visit" value="0" />
<? endif; ?>
</body>
</html>
