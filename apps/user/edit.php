<form>
<br><br>
<div class="small-12 columns">
	<div class="rows">
	<div class="small-12 medium-8 columns">
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Nickname</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" placeholder="{{user.displayName | capitalize}}">
    		</div>
  		</div>	
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Blood Group</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" placeholder="{{user.bgroup | capitalize}}">
    		</div>
  		</div>	
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Phone No.</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" placeholder="{{user.contact | capitalize}}">
    		</div>
  		</div>
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Email ID</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" placeholder="{{user.email}}">
    		</div>
  		</div>	  		
  		<div class="rows">
  			<div class="small-6 columns">
  				<div class="row collapse">
    				<div class="small-3 columns">
      				<span class="prefix">Room</span>
    				</div>
   				<div class="small-9 columns">
     			 		<input type="text" class="" placeholder="{{user.room | capitalize}}">
    				</div>
  				</div>	
  			</div>
  			<div class="small-6 columns">
  				<div class="row collapse">
    				<div class="small-3 columns">
      				<span class="prefix">Hostel</span>
    				</div>
   				<div class="small-9 columns">
     			 		<input type="text" class="" placeholder="{{user.hostel | capitalize}}">
    				</div>
  				</div>	
  			</div>	
  		</div>	
	</div>
	<div class="small-12 medium-4 columns">
			<a class="th radius" >
  				<img id="profile-pic" src="../../../spapp/assets/images/alert_images/yash.jpg">
			</a>
	</div>
	</div> 
</div>
<div>
	<hr>
	 <input type="submit"  class="button " value="Save Changes" >
</div>
</form>