
<br><br>
<div ng-controller="PageSearchCtrl">
<form ng-submit="app.reqLite('/messages/?q='+pagesearch)">
 <div class="row">
    <div class="large-8 large-centered columns">
      <div class="row collapse">
        <div class="small-10 columns">
        <input type="text" ng-model="pagesearch"  placeholder="Search Posts" >
        </div>
        <div class="small-2 columns">
          <input type="submit" value="Go" class="button postfix">
        </div>
      </div>
    </div>
  </div>
</form>
</div>
<br><br><br>
<div class="rows">
	<div class="small-6 columns">
		<input type="submit" class="button expand large secondary" value="General Body Manifestos">
	</div>
	<div class="small-6 columns">
		<input type="submit" class="button expand large  secondary" value="Hostel Body Manifestos">
	</div>
</div>

<div class="small-12 columns">
<br><br>
	<div class="small-12 medium-8 medium-centered columns">
		<a class="button expand large" href="<?=APP_URL?>/#/elections/manifesto_form">Click here to Upload Manifesto</a>
	</div>
</div>