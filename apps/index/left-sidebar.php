   <!--
<h2 class="ng-binding" style="margin-top:-48px; margin-left:25px; position:fixed;"> Students Portal</h2> -->
        <div class="large-3 medium-4 small-12 columns" id="">
        <div class="">
    		<div class="leftColumn">
            
            	
        	<ul class="side-nav">
        
            	<li><form>
    			<!--  <label>Search Documentation</label> -->
    			<input tabindex="1" id="" type="search" placeholder="Search | Eg: Yash" ng-model="StudentSearch.search" ng-change = "app.request({location: '/search?q='+StudentSearch.search, progress: false, alert: false, method: 'POST', changeURL: true })" ng-focus = "app.request({location: '/search?q='+StudentSearch.search, progress: false, alert: false, method: 'POST', changeURL: true })" autocomplete="off">
  			</form></li>
				<li class="heading">Trending</li>  				
  				<li><a href="#">Elections 2014</a></li>  			
  				<br>	
  				<li class="heading">Shortcuts</li>
  				<li><a href="http://students.iitm.ac.in/">Landing Page</a></li>
  				<li><a href="#">Messages</a></li>
  				<li><a href="#">Students Search</a></li>
				<li><a href="http://students.iitm.ac.in/swiki/">Swiki</a></li>  				
  				<br>
  				<li class="heading">Mess Operations</li>  				
  				<li><a href="#">Mess Registration</a></li>
  				<li><a href="#">Mess Rating</a></li>
			</ul>
    
    	
        	</div>
        	</div>
        </div>

