'use strict';

var app = angular.module('myApp', ['angucomplete-alt']);

app.controller('assemblyMainCtrl',
  function($window, $scope, $http, $location) {
    // API Host
    var $rhost = "http://api.kassembly.xyz/q.php";
    var $rhostStatic = "./api/";

    // http error flag
    $scope.errorFlag = false;

    $scope.listProposedArr = [];
    $scope.listDecisionArr = [];

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
      // reload only empty
      if ($scope.actors.length==0) {
         $scope.getAllActors();
      }
      $scope.setCircleURL();
      $scope.setOptString();
      $scope.setOptString();
      
     // $scope.getListDecision();
      $scope.getListProposed();

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


    var mkActorURL = function($app, $id) {
      return $rhostStatic + "/latest/" + $id + "/" + $app + $scope.optQueryStatic + "/index.json";
    }

    $scope.getListDecision = function() {
      $scope.listArr = [];
      $scope.errorFlag = false;
      $scope.listDecisionPromise = $http.get("http://ec2-52-193-7-169.ap-northeast-1.compute.amazonaws.com/q.php/latestdecision")
        .success(function(response) {
          $scope.listDecisionArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

      $scope.getListProposed = function() {
      $scope.listArr = [];
      $scope.errorFlag = false;
//      $scope.listProposedPromise = $http.get("http://ec2-52-193-7-169.ap-northeast-1.compute.amazonaws.com/q.php/latestproposed")
      $scope.listProposedPromise = $http.get("api/latestproposed/index.json")

        .success(function(response) {
          $scope.listProposedArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    // recovering from network error
    $scope.reconnect = function() {
      $scope.errorFlag = false; //reset the flag and let's hope
      $scope.upAll();
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

    $scope.upAll(); 
  }
);
