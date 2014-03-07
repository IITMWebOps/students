   <!--
<h2 class="ng-binding" style="margin-top:-48px; margin-left:25px; position:fixed;"> Students Portal</h2> -->
        <div class="large-3 medium-4 small-12 columns" id="">
        <div class="">
    		<div class="leftColumn">
            
            	
        	<ul class="side-nav">
        
            	<li><form>
    			<!--  <label>Search Documentation</label> -->
    			<input tabindex="1" id="" type="search" placeholder="Search for Students | Eg: Yash" ng-model="StudentSearch.search" ng-change = "app.request({location: '/student_search?search='+StudentSearch.search, progress: false, alert: false, method: 'POST', changeURL: true })" ng-focus = "app.request({location: '/student_search?search='+StudentSearch.search, progress: false, alert: false, method: 'POST', changeURL: true })" autocomplete="off">
  			</form></li>
  				<li class="heading">Shortcuts</li>
  				<li><a href="#">Home</a></li>
  				<li><a href="http://students.iitm.ac.in/">Landing Page</a></li>
  				<li><a href="http://students2.iitm.ac.in/">Mess Registration</a></li>
  				<li><a href="http://students.iitm.ac.in/swiki/">Swiki</a></li>
  				<li><a href="#">Notices</a></li>
  				<li class="heading">Trending</li>  				
  				<li><a href="#">Elections 2014</a></li>
			</ul>
    
    	
        	</div>
        	</div>
        </div>

