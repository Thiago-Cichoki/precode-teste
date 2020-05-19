goog.provide('precode.AppCtrl');

precode.AppCtrl = function ($state, UtilService) {
  var vm = this;

  vm.Util = UtilService;
  vm.$state = $state;

}

