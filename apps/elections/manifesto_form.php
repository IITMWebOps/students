<br><br>  
<div class="small-12 large-8 large-centered columns">
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Category</span>
    		</div>
   		<div class="small-9 large-10 columns">       
       		<select>       
          		<option value="gbe">General Body Elections</option>
          		<option value="hbe">Hostel Body Elections</option>
        		</select>
         </div>
  		</div>
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Post</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
       		<select >
			 		<option value="null"></option>	          
          		<option value="gbe">General Secretary</option>
          	<option value="hbe">Hostel Affairs Secretary</option>
        		</select>
         </div>
  		</div>	
		 	
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Manifesto</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
       		<input type="file" ng-file-select="onFileSelect($files)" class="button secondary upload-input">
         </div>
  		</div>
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Write Up</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
       		<input type="file" ng-file-select="onFileSelect($files)" class="button secondary upload-input">
         </div>
  		</div>
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Image</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
       		<input type="file" ng-file-select="onFileSelect($files)" class="button secondary upload-input">
         </div>
  		</div>	
</div>
<hr>
<div class="small-12 columns">
	<div class="small-6 medium-4 columns">
		<input type="submit"  class="button expand" value="Save Changes" >
	</div>
	<div class="small-6 medium-4 columns">
		<a href="#/elections/" class="button expand secondary">Cancel</a>
	</div>
</div>