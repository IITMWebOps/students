/**
 * Application Js - Angular Js File
 **/

/**
 * Defining Module named app
 **/

/**
 * if logged in
 *    returns Userdata = { login: true, username: 'Roll NUmber', fullname: 'Name', displayName: 'nick || fullname',room: 'room', hostel: 'hostel', contact: 'contact number', email:'email'  }
 * else
 *    returns Userdata = {login: false, displayName: 'student'}
 **/
app.service('UserData',function($http, AppData) {
  var userdata = {};

  userdata.user = {};
  userdata.user.login = false;
  userdata.user.displayName = 'student';
  userdata.request = function(){
      $http.get(AppData.protocol + AppData.host+ AppData.separator + AppData.path + '/user/userdata')
        .then(function(result){
          userdata.user = result.data;
      });
  };
  return userdata;
});
/**
 * Filter to captilize the first letter
 **/

app.filter('capitalize', function() {
  return function(input, scope ) {
    return input.substring(0,1).toUpperCase()+input.substring(1);
  }
});

/**
 * GetResponse factory -- Makes ajax calls
 **/

app.factory('GetResponse', function($http, $location, $q, $rootScope, $timeout, ngProgress, AppData, PageData, $compile ){
  var getresponse = {};

  getresponse.history = [];
  getresponse.status = {};
  getresponse.compile = {};

/**
 * Request Funtion
**/

  getresponse.request = function(Args){
      Args.target = Args.hasOwnProperty('target') ? Args.target : 'view';
      if( Args.target == 'view' ){
// Adding URL To history
        if ( this.history[0] != Args.location )
          this.history.splice(0,0,Args.location);
// Changing URl On request
          $location.url(Args.location);
          Args.progress = Args.hasOwnProperty('progress') ? Args.progress : true;
      }
      Args.progress = Args.hasOwnProperty('progress') ? Args.progress : false;
// Making Ajax Request Sub request
      ngProgress.set(0);
      if( Args.progress ) ngProgress.start();
      this.ajaxrequest(Args).then(function(response){
// On success call || Assigning data and target to compile object        
          if( response.data.trim() ){
            random_str = Args.target + Math.floor((Math.random()*100)+1)
            getresponse.compile.target = Args.target;
            getresponse.compile.data = '<script> function '+random_str+'($scope){}</script><div ng-controller=\''+random_str+'\'>'+response.data+'</div>';
            getresponse.broadcastMe();
          }
          if(response.status == '200' && response.location != null ){
              getresponse.request({ location: response.location , method:'POST'});
          }
            console.log(response);
          if ( response.alert ){
            alert.text = response.alert;
            alert.time = AppData.alertTime;
            getresponse.status = alert;
          }
          if( Args.target == 'view' )
            PageData.title = response.title || (Args.location.match(/\/[a-zA-Z0-9]+[a-zA-Z0-9/]/)[0]).replace(/\//g,"");

      },
      function(reason){
// Deleting URL from History On error
          getresponse.history.splice(0,1);
// Alert function call
          getresponse.statusAction(reason.status, Args.alert, Args.alertAdv );
      });
  };

/**
 * End Of Request Function
**/

// Function to broad cast compile
  getresponse.broadcastMe = function () {
    $rootScope.$broadcast('compile');
  }

// Ajaxrequest Function
  getresponse.ajaxrequest = function(Args){

// Making Promise
    var deferred = $q.defer();
// Defining All variobles
    var location = Args.hasOwnProperty('location') ?  Args.location : "";
    var method =Args.hasOwnProperty('method') ?  Args.method : 'POST';
    var object = Args.hasOwnProperty('object') ? Args.object : '';
    var cache = Args.cache || 'false';
    var path = Args.hasOwnProperty('path') ? Args.path : AppData.path;
    var alert = Args.alert || 'false';
    var changeURL = Args.changeURL || 'false';
    var alertAdv = Args.alertAdv || 'false';
    if( Args.title ) PageData.title = Args.title;
    if ( object != '' && method == 'GET' ){
      location = location+"?";
      angular.forEach(object, function( value, key ){
        location = location+key+"="+value+"&";
      });
      location = location.substring(0, location.length-1);
        if ( changeURL ) $location.url(location);
    }
    location = AppData.protocol + AppData.host+ AppData.separator + path + location;
    if ( !cache ) $httpDefaultCache.remove(location);
// Http request
    $http({method: method, url: location, cache: cache, data: object })
    	.success(function (data, status, headers, config) {
        if( Args.progress ) ngProgress.complete();
        $timeout(function(){
          deferred.resolve( { data: data, status: status, headers:headers, location:headers('Location'), title:headers('Title'), alert:headers('Alert') } );
        }, 800 );
		  })
			.error(function (data, status,headers, config) {
        if( Args.progress ) ngProgress.reset();
        $timeout(function(){
          deferred.reject({ data: data, status: status, headers:headers});
        }, 800 );
      })
// Return promise
      return deferred.promise;
  };

// Alert Box Funtion
  getresponse.statusAction = function(code, alert, alertAdv){
      statusSTD = getresponse.statuscode(code);

      angular.forEach(alertAdv, function(obj, index ){
          if( obj.code == code ){
              statusSTD.text = obj.text || statusSTD.text;
              statusSTD.cls = obj.cls || statusSTD.cls;
              statusSTD.time = obj.time || statusSTD.time;
          }
      });
      getresponse.status = statusSTD;
  }


  getresponse.statuscode = function(code){
                      switch (code) {
                        case 200: text = 'Succesfully completed'; cls = 'success'; break;
                        case 203: text = 'Non-Authoritative Information'; cls = 'warning'; break;
                        case 304: text = 'Not Modified'; cls='info'; break;
                        case 305: text = 'Use Proxy'; cls='info'; break;
                        case 401: text = 'Invalid Username or Password'; cls='error'; break;
                        case 403: text = 'Permission Denied'; cls='error'; break;
                        case 404: text = 'PageNot Found'; cls='error'; break;
                        case 407: text = 'Proxy Authentication Required'; cls='info'; break;
                        case 408: text = 'Request Time-out'; cls='info'; break;
                        case 500: text = 'Internal Server Error'; cls='error'; break;
                        default: text = ''; cls='';
                      }
                    return {code: code, text: text, cls: cls, time: '4000' };
  }
  return getresponse;

});


/**
 *
 * Defining Application Controller
 *
 **/


app.controller("AppCtrl", function($rootScope,$scope,$compile,$location,$filter,UserData,GetResponse,AppData,PageData) {

// Making Initial Call for userdata  
  UserData.request();

  var appctrl = this;

// Watching Location  
  $rootScope.$watch(
    function(){ 
      return $location.url();
    }, 
    function(){
      if( !$location.url() || $location.url() == '/'){
        $location.url(AppData.defaultPage);
        return true;
      }
      if( GetResponse.history[0] != $location.url() ){
          GetResponse.request({
            location: $location.url()
          });
      }
  });

// Compiling the response  

  $scope.$on('compile',function(){
    appctrl.data = GetResponse.compile.data;
    var myEl = angular.element( document.querySelector( '#'+GetResponse.compile.target) );
    myEl.html(GetResponse.compile.data);
    $compile(myEl.contents())($scope);
  });

  appctrl.user = function(){
    return UserData.user;
  }


  appctrl.title = function(){
    return PageData.title;
  }
  
  appctrl.fulltitle = function(){
    return "Students Portal | "+ $filter('capitalize')(PageData.title);
  }

/* Example call:
 * appctrl.request({
 *    location: '/example/exp',     // Loads http://students.iitm.ac.in/[AppData.path]/#/example/exp
 *    method: 'POST',                // Default: GET method
 *    object: 'user',                // Passes user object via method
 *    cache: 'true',                 // Default: False
 *    path: 'xyz',                   // Default: AppData.path || Line 4
 *    title: 'MyTitle',              // Default: 'example' in '#/example/exp'
 *    target: 'ElementId',           // Default: 'view'
 *    progress: true,                // Default: if(ElementId = view):true else: false endif;
 *    alert: true                    // Default: if( http response status == 401 xor 404 ) true;
 *    alertAdv: false                // Example: {0: { code: '404',text: 'Not Found',cls:'warning',time:'500'},
 *                                                1: { code: '401',text: 'Invalid user',cls:'info',time:'500'}}
 * 
 *});
*/
  appctrl.request = function(Args){
    GetResponse.request(Args);
  }

  appctrl.reqLite = function(location){
    GetResponse.request({ location: location, cache: false, method: 'POST' });
  }

  return appctrl;
});


app.directive('userStatus', function($timeout, UserData, AppData){
  return{
    restrict: "E",
    templateUrl: AppData.protocol + AppData.host+ AppData.separator + AppData.path + '/index/header_user_status',
    replace: true,
    link: function($scope){
      $scope.user = {};
      $scope.user.login = false;
      $scope.user.displayName = 'Student';
      $scope.$watch(function(){
        return UserData.user.login;
      },function(){
          $scope.user = UserData.user;
      });
    }
  }
})


app.directive('alertStatus',function(GetResponse, $timeout,$compile,AppData){
  return{
    restrict: "E",
    templateUrl: AppData.protocol + AppData.host+ AppData.separator + AppData.path + '/index/alert_template',
    replace: true,
    link: function($scope){
      $scope.status = {};
      $scope.status.show = false;
      $scope.$watch(function(){
        return GetResponse.status;
      },function(){
        $scope.status = GetResponse.status;
        var AlEl = angular.element( document.querySelector( '#alert-ubuntu-right') );
        AlEl.html('<h1 >'+$scope.status.text+'</h1>');
        $compile(AlEl.contents())($scope);
        $scope.status.show = $scope.status.time ? true : false;
        $timeout(function(){
          $scope.status.show = false;
        },$scope.status.time);
      });
    }
  }
})
