   <!--
<h2 class="ng-binding" style="margin-top:-48px; margin-left:25px; position:fixed;"> Students Portal</h2> -->
        <div class="large-3 medium-4 small-12 columns" id="">
        <div class="">
    		<div class="leftColumn">
            
            	
        	<ul class="side-nav">
        
            	<li><form>
    			<!--  <label>Search Documentation</label> -->
    			<input tabindex="1" id="" type="search" placeholder="Search Students Portal" ng-model="StudentSearch.search" ng-change = "app.request({location: '/search?q='+StudentSearch.search, progress: false, alert: false, method: 'POST', changeURL: true })" autocomplete="off">
  			</form></li>
				<li class="heading">Trending</li>  				
  				<li><a href="<?=APP_URL?>/#/elections"><i class="fa fa-list-ul"></i> | Elections 2014</a></li>  			
  				<br>	
  				<li class="heading">Shortcuts</li>
  				<li><a href="http://students.iitm.ac.in/"><i class="fa fa-windows"></i> | Landing Page</a></li>
  				<li><a href="#"><i class="fa fa-envelope"></i> | Messages</a></li>
  				<li><a href="#/student_search"><i class="fa fa-search"></i> | Students Search</a></li>
				<li><a href="http://students.iitm.ac.in/swiki/"><i class="fa fa-comments"></i> | Swiki</a></li>  				
  				<br>
  				<li class="heading">Mess Operations</li>  				
  				<li><a href="#/mess_registration"><i class="fa fa-cutlery"></i> | Mess Registration</a></li>
  				<li><a href="#/mess_rating"><i class="fa fa-star-half-o"></i> | Mess Rating</a></li>
			</ul>
    
    	
        	</div>
        	</div>
        </div>

