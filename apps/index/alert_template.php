<div ng-show = "status.show"  ng-view class="reveal-animation small-12 column"> 
    <div data-alert="" class="alert-box {{status.cls}}"> 
    	<div class="row">
			<div class="small-3 columns">
			     	<div  class="alertimage ">
      			</div> 
      			</div>
      			<div class="small-9 columns">
      				{{status.text}} 
      				<a  class="close">x</a> 
      			</div>
    	</div> 
    </div>
</div>
