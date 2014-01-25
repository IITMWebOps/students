Students Portal:

Directory Structure of students portal
    -apps  //All Application files goes here
    -assets  // All CSS and JS files ::Directly linked eg: students.iitm.ac.in/[ Path To File]
    -coreapp // Declaration of common functions used by many apps 
    -logs // error logging
    -public // directly linked :: 404/500 etc

Writing a new application

1) Create a directory unders apps directory on the name of application
2) All the files related to application shld be in that directory ( .JS and .CSS files can be in assets dir )
3) You can write inline javascripts and css

Executing the file:
  students.iitm.ac.in/[app dir name]/[file name]
    example: students.iitm.ac.in/[sub_path]/user/login will execute login.php file in user directory
  students.iitm.ac.in/[app dir name]/[sub file name]/[file name]
    example: students.iitm.ac.in/[sub_path]/dir1/sub_dir/xyz will execute xyz.php file in dir1/sub_dir directory


============================================

Dealing with forms:


-- Front End:
    |
    |==> herf
    |       |-> Uses 'GET' Method
    |       |-> Caches the file data
    |       |-> Use only for static html pages like login form etc
    |       |-> Target 'view' directory ( Space below the horizontal line )
    |==> app.request
    |       |-> It takes Object as args
    |       |-> U can specify maximum details
    |==> app.reqLite
            |-> It takes location as Argument
            |-> Makes POST Request
            |-> Wont Caches filedata
            |-> Prefered over herf

  =>  herf method:
        GET Method : <a href="#/[Path to file]"> click me </a>
        example:
            <a href="#/student_search"> students search </a>
            <a href="#/student_search?q=prasanth"> students search </a>
 
  =>  app.reqLite():
        ng-click = 'app.reqLite('/user/logout')'
            -> Uses Post method
            -> Wont Cache file data
      example:
        <a ng-click="app.reqLite('/user/logout')"> Logout </a>
        <a ng-click = "app.reqLite('/user/me?username=na10b042')"> Edit me </a>
        <form ng-submit="app.reqLite('user/login?username='+user.username) ">
            <input type="text" ng-model="user.username">
            <input type="submit" value="submit">
        </form>

 

  =>  app.request:
        ng-click = "app.request({
            location: '/example/exp',   // Loads http://students.iitm.ac.in/[AppData.path]/#/example/exp
            method: 'POST',             // Default: GET method
            object: 'user',             // Passes user object via method
            cache: 'true',              // Default: False
            path: 'xyz',                // Default: AppData.path || Line 4 in application.js
            title: 'MyTitle',           // Default: 'example' in '#/example/exp'
            target: 'ElementId',        // Default: 'view'
            progress: true,             // Default: if(ElementId = view):true else: false endif;
            alert: true                 // Default: if( http response status == 401 xor 404 ) true;
            alertAdv: false             // Example: {0: { code: '404',text: 'Not Found',cls:'warning',time:'500'},
                                                 1: { code: '401',text: 'Invalid user',cls:'info',time:'500'}}
          });

        example: Posting A form to login:
          <form ng-submit = "app.request(
                                  {
                                    location: '/user/login',   //IMPORTANT:: No '#' in path like href
                                    method: 'POST',
                                    object: user,
                                    alert: true,
                                    alertAdv: {
                                                0:{
                                                    code: '403',
                                                    text: 'Invalid Username or Password',
                                                    cls: 'warning'
                                                  }
                                                1:{
                                                    code: '200',
                                                    text: 'Successfully Logged In',
                                                    cls: success
                                                  }
                                              }
                                  }
                                    )" >
             <input type="text" ng-model = "user.username" >
             <input type="password" ng-model="user.password" >
             <input type="submit"  class="button " value="Sign In" >
           </form >
        example explained:
         ng-submit -> is a angular module which calls the angular method on submission
                   -> http://docs.angularjs.org/api/ng.directive:ngSubmit
         ng-model  -> creates a variable which can be used in that scope
                   -> http://docs.angularjs.org/api/ng.directive:ngModel
         app.request()
                   -> Angular method defined in application.js which takes object as Arguments
                        Object example => var foo = { bar: 'barValue', mn: 'xyzvalue'  }
                                            -> foo.bar  ## prints barValue
                                            -> foo.mn   ## prints xyzvalue
                    -> Arguments it takes:
                        -> location  => file path
                        -> method    => Post or get
                        -> object    => object name // say ng-model='user.username' object is user
                        -> alert     => Display alert box on top right on server response
                        -> alertAdv  => Say server returned 500 error || if u specify the code verses text and class, the specified text is displayed, else it will take standard pre defined alert status (if alert is true).
                        -> progress  => if true loading bar is displayed
                        -> target    => target element id where the response shld be displayed


-- Backend || Accessing form data
      => Post Method
            -> As object is being passed in the post data, Its better to access the request stream 
            -> How to access the I/O stream : 
                      -> php://
            -> How to access the request stream:
                      -> php://input
            -> How to decode it:
                      ->$data = json_decode(file_get_contents("php://input"));
                              -> It saves request header to $data
                              -> $data->username will give user.username value from the above example
            -> Drawbacks:
                      ->It returns everything after HTTP-header where as $_POST returns only x-www-form-urlencoded
      => Get Method
            -> As the data is url encoded we can use it with $_GET

=================================

useful Functions:

  => page_title function
        => It specifies the page title above the horizontal line( progress bar )
        => It is defined in coreapp folder
        => call it on first line of php file
        => page_title('login'); will show 'login' as page title
        => Order of preference:
                |-> 1) page_title('')
                |-> 2) title given in app.request //front end
                |-> 3) first word from url that is 'xyz' from students.iitm.ac.in/[sub_path]/#/xyz/foo
  => redirect_to function
        => use it instead of location header
        => It is defined in coreapp folder
        => It takes two arguments
                1) location
                2) change location in the url?
        => redirect_to('/user/login', true);
                -> the above function will redirect the page to /user/login and changes the url to students.iitm.ac.in/[sub_path]/#/user/login
        => redirect_to('/user/login', false);
                -> it redirects to /user/login but wont changes the url
        => If target is 'view' give 'true' as second argument else give false
  => http_response_code function
        => http_response_code('500', 'some text');
              => will return 500 status with text 'some text'
        => http_response_code('500');
              => will return 500 status with default text specified in coreapp/httpresponse.php
  => $current_user object
        => defined in coreapp/main.php
        => $current_user->login()
              -> returns true if user logged in
              -> returns false if user not logged in
        => $current_user->id
              -> returns user id that is 'id' value in 'users' table
        => $current_user->[column name]
              -> $current_user->username  //returns roll number of logged in student
              -> $current_user->fullname  //returns full name of logged in student
              -> and so on





DOs and Don'ts On Backend:

    => Never use LOCATION HEADER ( header('location: ') )
        -> Use redirect_to function to redirect
    => use http_response_code function to send status code header
    => use page_title function to specify the page tile
    => Never start session // its already started
    => use $current_user to check and get the current user data
    => DB Connection is already made


You can specify the costum details in
  -> coreapp/appconfig.php
  -> coreapp/dbconfig.php









#####
1) if target  = 'view' location in url changes
2) ng-model names should not be used:
              -> user
              -> request
              -> reqLite
              -> title
 
