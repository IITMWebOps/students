
var app = angular.module('spApp', ['ngProgress'] );

app.constant('AppData', {
  path : 'scratch/wd2',
  host : 'students.iitm.ac.in',
  protocol : 'http://',
  separator : '/',
  defaultPage : 'messages',
  alertTime: 40000
});

app.value('PageData', {
  title : 'home'
});
