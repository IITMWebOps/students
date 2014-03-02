<ul class='right'>
  <li class='has-dropdown not-click ng-hide' ng-show= "user.login">
    <a>{{user.displayName | capitalize}}</a>
    <ul class='dropdown'>
      <li><a href='#/user' >Profile</a></li>
      <li><a href='#/user/edit' >Edit Profile</a></li>
	  </ul>
	</li>
	<li class='has-form ng-hide' ng-hide= "user.login"><a ng-click="app.reqLite('/user/login')"  class='button'>Sign In</a></li>
  <li class='has-form ng-hide' ng-show= "user.login"><a ng-click="app.reqLite('/user/logout')" class='button '>Sign Out</a></li>
</ul>
