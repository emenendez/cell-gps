'use strict';

/**
 * @ngdoc overview
 * @name cellGpsAngularApp
 * @description
 * # cellGpsAngularApp
 *
 * Main module of the application.
 */
angular
  .module('cellGpsAngularApp', [
    'ngResource',
    'emguo.poller',
  ])
  .factory('Phones', ['$resource', function($resource) {
    // Phones resource
    return $resource('/~admin/phones/:id');
  }])
  .factory('Messages', ['$resource', function($resource) {
    // Messages resource
    return $resource('/~admin/messages/:id');
  }])
  .controller('MainCtrl', ['$scope', 'poller', 'Phones', function ($scope, poller, Phones) {

    // Show/hide help text
    $scope.showHelp = false;
    $scope.clickHelp = function() {
        $scope.showHelp = !$scope.showHelp;
    }

    // Get poller. This also starts/restarts poller.
    var phonesPoller = poller.get(Phones, {action: 'query'});

    // Update view. Since a promise can only be resolved or rejected once but we want
    // to keep track of all requests, poller service uses the notifyCallback. By default
    // poller only gets notified of success responses.
    phonesPoller.promise.then(null, null, function(data) {
        $scope.phones = data;
    });

  }])
  .controller('SendCtrl', ['$scope', '$timeout', 'Messages', function($scope, $timeout, Messages) {

    $scope.submit = function() {
        Messages.save($scope.message, function(data) {
            if (data.success) {
                $scope.notification = 'Message sent';
                $timeout(function() {
                    $scope.notification = '';
                }, 3000);
            }
        });
    };

    $scope.showNotification = function() {
        return $scope.notification && $scope.notification !== '';
    }

  }]);
