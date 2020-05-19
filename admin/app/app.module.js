goog.provide("precode.app");

// Controllers
goog.require("precode.AppCtrl");
goog.require('precode.sistema.CategoriaCtrl');
goog.require('precode.sistema.ProdutoCtrl');


// Services
goog.require("precode.sistema.UtilService");
goog.require("precode.sistema.CategoriaService");
goog.require("precode.sistema.Categoria");
goog.require("precode.sistema.ProdutoService");
goog.require("precode.sistema.Produto");



goog.require('precode.stringToNumberDirective');
goog.require('precode.stringToDateDirective');
goog.require('precode.tableToggleColDirective');
goog.require('precode.smartFloatDirective');
goog.require('precode.convertToNumberDirective');
goog.require('precode.modelSelectedDirective');
goog.require('precode.autocompleteDirective');
goog.require('precode.calendarDayDirective');
goog.require('precode.moDateInputDirective');

goog.require('precode.filter.cut');
goog.require('precode.filter.floor');
goog.require('precode.filter.ceil');
goog.require('precode.filter.abs');
goog.require('precode.filter.parseInt');
goog.require('precode.filter.range');

goog.require('precode.filter.propsFilter');

goog.require('precode.directive.precodeServiceRequired');
goog.require('precode.directive.precodeModuleRequired');

goog.require('precode.httpHandler.HttpRequestService');
goog.require('precode.httpHandler.HttpRequestInterceptor');
goog.require('precode.httpHandler.HttpResponseInterceptor');
goog.require('precode.popoverElem');
goog.require('precode.popoverClose');
goog.require('precode.onEnter');
goog.require('precode.myMention');
goog.require('precode.fileModelDirective');


precode.app = angular.module('precode.app', [
    "ngResource",
    "ngSanitize",
    'ngAnimate',
    'angular-loading-bar',
    'ui.bootstrap',
    'ui.router',
    // "angularUtils.directives.dirPagination"
]).run(function ($rootScope, $window, HttpRequestService, $interval, $location, $transitions) {

    $interval(function () { window.location.reload(); }, 10 * 60 * 60 * 1000);
    $rootScope.$on('$stateChangeSuccess', function (evt, toState) {
        $(document).scrollTop(0);
        if ($window.ga) { $window.ga('send', 'pageview', { page: $location.url() }); }//https://stackoverflow.com/questions/10713708/tracking-google-analytics-page-views-with-angularjs?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
        if ($window.mt) { $window.mt('send', 'pageview', { page_url: $location.url() }); }
    });

    $transitions.onSuccess({}, function () {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    })


})
    .service('HttpRequestService', precode.httpHandler.HttpRequestService)

    .service('UtilService', precode.sistema.UtilService)
    .service('CategoriaService', precode.sistema.CategoriaService)
    .service('Categoria', precode.sistema.Categoria)
    .service('ProdutoService', precode.sistema.ProdutoService)
    .service('Produto', precode.sistema.Produto)

    .factory('HttpRequestInterceptor', precode.httpHandler.HttpRequestInterceptor)
    .factory('HttpResponseInterceptor', precode.httpHandler.HttpResponseInterceptor)


    .directive('stringToNumber', precode.stringToNumberDirective)
    .directive('stringToDate', precode.stringToDateDirective)
    .directive('tableToggleCol', precode.tableToggleColDirective)
    .directive('smartFloat', precode.smartFloatDirective)
    .directive('convertToNumber', precode.convertToNumberDirective)
    .directive('modelSelected', precode.modelSelectedDirective)
    .directive('autocomplete', precode.autocompleteDirective)
    .directive('calendarDay', precode.calendarDayDirective)
    .directive('moDateInput', precode.moDateInputDirective)
    .directive('fileModel', precode.fileModelDirective)
    .directive('owlCarouselDirective', precode.owlCarouselDirective)
    .directive('owlCarouselItemDirective', precode.owlCarouselItemDirective)

    .directive('precodeServiceRequired', precode.directive.precodeServiceRequired)
    .directive('precodeModuleRequired', precode.directive.precodeModuleRequired)


    .controller("precode.AppCtrl", precode.AppCtrl)
    .controller('precode.sistema.CategoriaCtrl', precode.sistema.CategoriaCtrl)
    .controller('precode.sistema.ProdutoCtrl', precode.sistema.ProdutoCtrl)


    .config(function ($httpProvider, $provide, $stateProvider, $locationProvider, $urlRouterProvider, $uibModalProvider) {
        if (!$httpProvider.defaults.headers.get) {
            $httpProvider.defaults.headers.get = {};
        }

        $httpProvider.defaults.headers.get['If-Modified-Since'] = 'Mon, 26 Jul 1997 05:00:00 GMT';//disable-cache
        $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache, must-revalidate';//disable-cache
        $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';//disable-cache
        $httpProvider.defaults.headers.get['Expires'] = '0';//disable-cache

        //request timeout handler
        $httpProvider.interceptors.push('HttpRequestInterceptor');
        $httpProvider.interceptors.push('HttpResponseInterceptor');

        $provide.decorator("$exceptionHandler", function ($delegate, $injector) {
            return function (exception, cause) {
                var $rootScope = $injector.get("$rootScope");
                //$rootScope.addError({message: "Exception", reason: exception});
                console.log(exception);
                $("#showError").fadeIn();
                setTimeout(function () {
                    $("#showError").fadeOut();
                }, 2300);
                $delegate(exception, cause);
            };
        });

        if (window.history && window.history.pushState) {
            $locationProvider.html5Mode({
                enabled: true,
                requireBase: true,
                rewriteLinks: false
            });
        }
        else {
            $locationProvider.html5Mode(false);
        }
        $uibModalProvider.options = {
            animation: false,
            backdrop: true,
            size: 'sm',
            keyboard: false
        };

        $stateProvider
            .state({
                name: "resumo",
                url: "/",
                controller: 'precode.AppCtrl',
                controllerAs: "AppCtrl",
                resolve: {
                    q: function($state){
                        $state.go('produtos');
                    }
                }
            })
            .state({
                name: "categorias",
                url: "/categoria",
                templateUrl: "app/views/categorias.html",
                controller: 'precode.sistema.CategoriaCtrl',
                controllerAs: "CategoriaCtrl",
                resolve: {}
            })
            .state({
                name: "produtos",
                url: "/produtos",
                templateUrl: "app/views/produtos.html",
                controller: 'precode.sistema.ProdutoCtrl',
                controllerAs: "ProdutoCtrl",
                resolve: {}
            })
            .state({
                name: "novo-produto",
                url: "/produtos/novo",
                templateUrl: "app/views/novo-produto.html",
                controller: 'precode.sistema.ProdutoCtrl',
                controllerAs: "ProdutoCtrl",
                resolve: {}
            })
            .state({
                name: "editar-produto",
                url: "/produtos/{produto_id}",
                templateUrl: "app/views/editar-produto.html",
                controller: 'precode.sistema.ProdutoCtrl',
                controllerAs: "ProdutoCtrl",
                resolve: {
                    q: function(ProdutoService, $stateParams){
                            ProdutoService.select({id: $stateParams.produto_id});
                    }
                }
            })


        $urlRouterProvider.otherwise('/');
    });
goog.exportSymbol('precode.app', precode.app);