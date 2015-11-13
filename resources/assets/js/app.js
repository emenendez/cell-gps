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
    'ngResource'
  ])
  .controller('MainCtrl', ['$scope', function ($scope) {
    $scope.phones = [];


  }]);
