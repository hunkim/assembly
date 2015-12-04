'use strict';

var app = angular.module('myApp', ['cgBusy','ui.bootstrap','angucomplete-alt']);

app.controller('assemblyMainCtrl',
  function($window, $scope, $http, $location) {
    // API Host
    var $rhost = "http://ec2-52-193-7-169.ap-northeast-1.compute.amazonaws.com";
    var $rhostStatic = "./api/";

    var mkBillURL = function($app, $id) {
      return $rhostStatic + "/bill/" + $id + "/" + $app + "/index.json";
    };
    // http error flag
    $scope.errorFlag = false;

    $scope.listProposedArr = [];
    $scope.listDecisionArr = [];
    $scope.listSearchArr = [];

    // all actors for search auto complete
    $scope.actors = [];

    // check box options
    $scope.opt = {
      result: "done",
      by: "rep"
    };


    $scope.key = '';
    $scope.keySearched = '';


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
      
      $scope.getListDecision();
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
      $scope.listDecisionArr = [];
      $scope.errorFlag = false;
     // $scope.listDecisionPromise = $http.get("http://ec2-52-193-7-169.ap-northeast-1.compute.amazonaws.com/q.php/latestdecision")
      $scope.listDecisionPromise = $http.get("api/latestdecision/index.json")
        .success(function(response) {
          $scope.listDecisionArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

      $scope.getListProposed = function() {
      $scope.listProposedArr = [];
      $scope.errorFlag = false;
     // $scope.listProposedPromise = $http.get("http://ec2-52-193-7-169.ap-northeast-1.compute.amazonaws.com/q.php/latestproposed")
      $scope.listProposedPromise = $http.get("api/latestproposed/index.json")

        .success(function(response) {
          $scope.listProposedArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getListSearch = function() {
      $scope.listSearchArr = [];
      $scope.keySearched = $scope.key;

      if($scope.key==='') {
        return;
      }

      $scope.errorFlag = false;
      $scope.searchPromise = $http.get($rhost + "/q.php/billsearch?key=" + $scope.key)
        .success(function(response) {
          $scope.listSearchArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getBillAct = function($listArr, $index) {
      if ($listArr.length < $index) {
        return;
      }

      var $bid = $listArr[$index].id;
      if (!$bid) {
        return;
      }

      $scope.errorFlag = false;
      $scope.billActPromise = $http.get(mkBillURL("billactors",$bid))
        .success(function(response) {
          $listArr[$index].ActArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    // Show summary
    $scope.printSummary = function($summary) {
      if ($summary === undefined || $summary[0] === undefined ||
        $summary[
          0]
        .summary === undefined ||
        $summary[0].summary === "") {
        return "요약정보 없슴.";
      }

      return "요약정보: " + $summary[0].summary;
    }

    $scope.getSummary = function($listArr, $index) {
      if ($listArr.length < $index) {
        return;
      }

      var $bid = $listArr[$index].id;
      if (!$bid) {
        return;
      }

      $scope.errorFlag = false;
      $scope.summaryPromise = $http.get(mkBillURL("summary", $bid))
        .success(function(response) {
          $listArr[$index].summary = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };


     // Toggle cell so show more info
    $scope.toggleList = function($listArr, $index) {
      if ($listArr.length < $index) {
        return;
      }

      // Toggle it
      $listArr[$index].open = !$listArr[$index].open;

      // If it is open, get data
      if ($listArr[$index].open) {
        // Load only if it is not loaded
        if ($listArr[$index].summary === undefined) {
          $scope.getSummary($listArr, $index);
        }

        // Load only it is not loaded
        if ($listArr[$index].ActArr === undefined) {
          $scope.getBillAct($listArr, $index);
        }
      }
    }

    $scope.getDays = function($list) {
      var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
      var firstDate = new Date($list.proposed_date);
      var secondDate = new Date($list.decision_date);

      return Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
    }
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
