'use strict';

var app = angular.module('myApp', ['angucomplete-alt']);

app.controller('assemblyMainCtrl',
  function($window, $scope, $http, $location) {
    // API Host
    var $rhost = "http://api.kassembly.xyz/q.php";
    var $rhostStatic = "./api/";

    // http error flag
    $scope.errorFlag = false;


    // all actors for search auto complete
    $scope.actors = [];

    // check box options
    $scope.opt = {
      result: "done",
      by: "rep"
    };

    $scope.circleUrl="circle.html";
    
    $scope.optString = '';

    $scope.setCircleURL = function() {
      $scope.circleUrl = "circle.html#/" + $scope.opt.result + "/" + $scope.opt.by;
    };

    $scope.setOptString = function() {
      $scope.optString = '';

      switch($scope.opt.by) {
        case 'rep':
          $scope.optString += "대표발의 의안중 ";
          break;
        case 'co':
          $scope.optString += "공동발의 의안중 ";
          break;
      }

      switch($scope.opt.result) {
        case 'pass':
          $scope.optString += "가결된 ";
          break;
        case 'done':
          $scope.optString += "처리된 ";
          break;
        case 'ongoing':
          $scope.optString += "계류중인 ";
          break;
      }
    };



    $scope.upAll = function() {
      $scope.setCircleURL();
      $scope.setOptString();
    };
 

    $scope.getAllActors = function() {
      $scope.errorFlag = false;
      $scope.getAllActorsPromise = $http.get($rhostStatic +
          "/actor/index.json")
        .success(function(response) {
          $scope.actors = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

 
    $scope.setActor = function(selected) {
      if (selected == undefined || selected.originalObject == undefined) {
        return;
      }

      var $id = selected.originalObject.id;
      if ($id === "") {
        return;
      }

      // jump
      $window.location.href = "in.html#/" + $id;
    };

    // get all actors
    $scope.getAllActors();
    $scope.upAll(); 
  }
);
