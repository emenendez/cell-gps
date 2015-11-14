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

    // IE8 placeholder hack
    $('input').placeholder();

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

    $scope.showNotification = false;
    $scope.loading = false;

    var numberField = $('#phone').get(0);

    $scope.submit = function() {
      $scope.loading = true;
      Messages.save($scope.message, function(data) {
        if (data.success) {
          $scope.loading = false;
          $scope.notification = 'Message sent';
          $scope.showNotification = true;
          $timeout(function() {
            $scope.showNotification = false;
          }, 3000);
        }
      });
    };

    $scope.updatePhone = function() {
      var defaultRegion = 'US';
      var valid = false;

      try
      {
        valid = phoneUtils.isValidNumber($scope.message.phone, defaultRegion);
      }
      catch (e) {}

      if (numberField.setCustomValidity)
      {
        if (valid)
        {
          numberField.setCustomValidity('');
        }
        else
        {
          numberField.setCustomValidity('Please enter a valid phone number.');
        }
      }

      if (valid)
      {
        if (phoneUtils.getRegionCodeForNumber($scope.message.phone, defaultRegion) == defaultRegion)
        {
          $scope.message.phone = phoneUtils.formatNational($scope.message.phone, defaultRegion);
        }
        else
        {
          $scope.message.phone = phoneUtils.formatInternational($scope.message.phone, defaultRegion);
        }
      }
    }

  }]);
