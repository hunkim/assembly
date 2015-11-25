'use strict';

var app = angular.module('myApp', ['chart.js', 'cgBusy']);

app.controller('customersCtrl',
  function($scope, $http, $location) {
    // API Host
    var $rhost = "http://a.kassembly.xyz/q.php";

    // show count option in the graph
    $scope.showCount = true;

    // http error flag
    $scope.errorFlag = false;

    // Chart Data
    $scope.series = ['발의 법안수'];
    $scope.labels = [];
    $scope.data = [
      [],
    ];

    $scope.id = 158;

    // stat and sale array
    $scope.statArr = [];
    $scope.listArr = [];
    $scope.coArr = [];

    // Set id
    $scope.setId = function($id) {
      $scope.id = $id;
      $scope.upAll();
    }


    // Set id
    $scope.toggleList = function($index) {
      if ($scope.listArr.length < $index) {
        return;
      }

      $scope.listArr[$index].open = !$scope.listArr[$index].open;

      if ($scope.listArr[$index].open) {
        if ($scope.listArr[$index].summary === undefined) {
          $scope.getSummary($index);
        }

        if ($scope.listArr[$index].ActArr === undefined) {
          $scope.getBillAct($index);
        }
      }
    }

    $scope.amIActive = function(name) {
      if (name == $scope.appType) {
        return 'active';
      }

      return '';
    }


    // recovering from network error
    $scope.reconnect = function() {
      $scope.errorFlag = false; //reset the flag and let's hope

      // no statdate? reload!
      if ($scope.statArr.length == 0) {
        $scope.getStat();
      }

      // no sale array? reload!
      if ($scope.saleArr.length == 0) {
        $scope.getList();
      }
    };

    // local function for KR URL encodning
    var koEncode = function($s) {
      if ($s == null || $s == "") {
        return $s;
      }
      return encodeURI(encodeURIComponent($s));
    };

    // update the graph (based on watch statArr)
    $scope.updateGraph = function() {
      // reset graph array
      $scope.labels = [];
      $scope.data = [];
      $scope.data[0] = [];

      var statLen = $scope.statArr.length;
      for (var i = 0; i < statLen; i++) {
        $scope.labels[i] = $scope.statArr[i].y + "/" +
          $scope.statArr[i].m;
        $scope.data[0][i] = $scope.statArr[i].c;
      }
    };


    // greaph on click. TODO: what should we do?
    $scope.onClick = function(points, evt) {
      //console.log(points, evt);
    };


    $scope.upAll = function() {
      $scope.getList();
      $scope.getStat();
      $scope.getCoAct();
    };


    $scope.getStat = function() {
      $scope.statArr = [];

      $scope.errorFlag = false;

      $scope.statPromise = $http.get($rhost +
          '/stat?id=' + $scope.id)
        .success(function(response) {
          $scope.statArr = response;
          $scope.updateGraph();
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getList = function() {
      $scope.listArr = [];
      $scope.errorFlag = false;
      $scope.salePromise = $http.get($rhost +
          "/list?id=" + $scope.id)
        .success(function(response) {
          $scope.listArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getCoAct = function() {
      $scope.coActArr = [];
      $scope.errorFlag = false;
      $scope.coActPromise = $http.get($rhost +
          "/coact?id=" + $scope.id)
        .success(function(response) {
          $scope.coArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getBillAct = function($index) {
      if ($scope.listArr.length < $index) {
        return;
      }

      console.log($index + ":" + $scope.listArr[$index]);
      var $bid = $scope.listArr[$index].id;
      if (!$bid) {
        return;
      }

      $scope.errorFlag = false;
      $scope.billActPromise = $http.get($rhost +
          "/billactors?bid=" + $bid)
        .success(function(response) {
          $scope.listArr[$index].ActArr = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    $scope.getSummary = function($index) {
      if ($scope.listArr.length < $index) {
        return;
      }

      var $bid = $scope.listArr[$index].id;
      if (!$bid) {
        return;
      }

      $scope.errorFlag = false;
      $scope.summaryPromise = $http.get($rhost +
          "/summary?bid=" + $bid)
        .success(function(response) {
          $scope.listArr[$index].summary = response;
        })
        .error(function(response) {
          $scope.errorFlag = true;
        });
    };

    // Show all for the initial screen
    $scope.upAll();
  }
);
