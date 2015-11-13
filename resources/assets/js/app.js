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
  .controller('MainCtrl', ['$scope', '$resource', 'poller', 'Phones', function ($scope, $resource, poller, Phones) {

    // Initialize display variables
    $scope.showHelp = false;

    // Get poller. This also starts/restarts poller.
    var phonesPoller = poller.get(Phones, {action: 'query'});

    // Update view. Since a promise can only be resolved or rejected once but we want
    // to keep track of all requests, poller service uses the notifyCallback. By default
    // poller only gets notified of success responses.
    phonesPoller.promise.then(null, null, function(data) {
        $scope.phones = data;
    });

  }]);
