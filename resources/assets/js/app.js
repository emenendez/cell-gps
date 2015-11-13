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
  .controller('MainCtrl', ['$scope', '$resource', 'poller', function ($scope, $resource, poller) {

    // Phones resource
    var Phones = $resource('/~admin/phones/:id');

    // Get poller. This also starts/restarts poller.
    var phonesPoller = poller.get(Phones, {action: 'query'});

    // Update view. Since a promise can only be resolved or rejected once but we want
    // to keep track of all requests, poller service uses the notifyCallback. By default
    // poller only gets notified of success responses.
    phonesPoller.promise.then(null, null, function(data) {
        $scope.phones = data;
    });

  }]);
