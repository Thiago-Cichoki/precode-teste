goog.provide('precode.stringToNumberDirective');
goog.provide('precode.stringToDateDirective');
goog.provide('precode.tableToggleColDirective');
goog.provide('precode.smartFloatDirective');
goog.provide('precode.convertToNumberDirective');
goog.provide('precode.modelSelectedDirective');
goog.provide('precode.autocompleteDirective');
goog.provide('precode.calendarDayDirective');
goog.provide('precode.moDateInputDirective');
goog.provide('precode.datetimepickerNeutralTimezone');

goog.provide('precode.filter.cut');
goog.provide('precode.filter.floor');
goog.provide('precode.filter.ceil');
goog.provide('precode.filter.abs');
goog.provide('precode.filter.parseInt');
goog.provide('precode.filter.range');

goog.provide('precode.filter.propsFilter');

goog.provide('precode.directive.precodeServiceRequired');
goog.provide('precode.directive.precodeModuleRequired');

goog.provide('precode.httpHandler.HttpRequestService');
goog.provide('precode.httpHandler.HttpRequestInterceptor');
goog.provide('precode.httpHandler.HttpResponseInterceptor');
goog.provide('precode.popoverElem');
goog.provide('precode.popoverClose');
goog.provide('precode.onEnter');
goog.provide('precode.myMention');
goog.provide('precode.fileModelDirective');
goog.provide('precode.owlCarouselDirective');
goog.provide('precode.owlCarouselItemDirective');


precode.onEnter = function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.onEnter);
                });

                event.preventDefault();
            }
        });
    };
};

precode.stringToNumberDirective = function () {
    return {
        require: 'ngModel',
        scope: {
            model: '=ngModel'
        },
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return '' + value;
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value, 10);
            });

            scope.$watch('model', function (val, old) {
                if (typeof val == 'string') {
                    scope.model = parseInt(val);
                }
            });
        }
    };
};

precode.stringToDateDirective = function ($filter) {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return value;
            });
            ngModel.$formatters.push(function (value) {
                if (!value) {
                    return '';
                }
                return new Date(value);
            });
        }
    }
};

precode.convertToNumberDirective = function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (val) {
                return parseInt(val, 10);
            });
            ngModel.$formatters.push(function (val) {
                return '' + val;
            });
        }
    };
};

precode.tableToggleColDirective = function () {
    return {
        restrict: "A",
        scope: {},
        link: function (scope, element) {
            scope.$watch(function () {
                return {
                    'w': $(element).width()
                }
            }, function (newValue, oldValue) {
                // altera no proximo digest
                var width = $(element).width();
                if (width < 650) {
                    $(element).find('td.hidden-col, th.hidden-col').hide();
                    $(element).find('td.unhidden-col, th.unhidden-col').show();
                } else {
                    $(element).find('td.hidden-col, th.hidden-col').show();
                    $(element).find('td.unhidden-col, th.unhidden-col').hide();
                }
            }, true);
        }
    }
}

precode.smartFloatDirective = function ($filter) {
    var FLOAT_REGEXP_1 = /^\$?\d+.(\d{3})*(\,\d*)$/; //Numbers like: 1.123,56
    var FLOAT_REGEXP_2 = /^\$?\d+,(\d{3})*(\.\d*)$/; //Numbers like: 1,123.56
    var FLOAT_REGEXP_3 = /^\$?\d+(\.\d*)?$/; //Numbers like: 1123.56
    var FLOAT_REGEXP_4 = /^\$?\d+(\,\d*)?$/; //Numbers like: 1123,56

    return {
        require: 'ngModel',
        link: function (scope, elm, attrs, ctrl) {
            ctrl.$parsers.unshift(function (viewValue) {
                if (FLOAT_REGEXP_1.test(viewValue)) {
                    ctrl.$setValidity('float', true);
                    return parseFloat(viewValue.replace('.', '').replace(',', '.'));
                } else if (FLOAT_REGEXP_2.test(viewValue)) {
                    ctrl.$setValidity('float', true);
                    return parseFloat(viewValue.replace(',', ''));
                } else if (FLOAT_REGEXP_3.test(viewValue)) {
                    ctrl.$setValidity('float', true);
                    return parseFloat(viewValue);
                } else if (FLOAT_REGEXP_4.test(viewValue)) {
                    ctrl.$setValidity('float', true);
                    return parseFloat(viewValue.replace(',', '.'));
                } else {
                    ctrl.$setValidity('float', false);
                    return undefined;
                }
            });

            ctrl.$formatters.unshift(
                function (modelValue) {
                    return $filter('number')(parseFloat(modelValue), 2);
                }
            );
        }
    };
};

precode.calendarDayDirective = function () {
    return {
        templateUrl: '../home/templates/calendar-day.html',
        scope: {
            'datestring': '=',
            'datept': '=',
            'showcreatefn': '&',
            'selectfn': '&'
        },
        link: function (scope) {
            scope.angular = angular;

            /*
             scope.select = function (task) {
             scope.close();
             scope.selectfn({'task': task});
             };

             scope.close = function () {
             $('.hiddenEvents').css('display', 'none');
             };

             scope.showCreate = function () {
             scope.close();
             scope.showcreatefn({'dateString': scope.datestring});
             };
             */
        }
    }
}


precode.filter.cut = function () {
    return function (value, wordwise, max, tail) {
        if (!value)
            return '';

        max = parseInt(max, 10);
        if (!max)
            return value;
        if (value.length <= max)
            return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
                value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };
}
precode.filter.floor = function () {
    return Math.floor;
};
precode.filter.ceil = function () {
    return Math.ceil;
};
precode.filter.abs = function () {
    return Math.abs;
};

precode.directive.precodeServiceRequired = function (AccessService, ngToast) {//do action if service not allowed
    return {
        replace: true,
        restrict: 'A',
        priority: 100,
        link: {
            pre: function (scope, element, attr) {
                var s = { 'nome': attr.precodeServiceRequired };
                var isAllowed = AccessService.isAllowedService(s);
                var preventDefault = attr.precodeServiceDeniedPrevent;

                //console.log(s);
                //console.log(isAllowed);

                if (!isAllowed && !preventDefault) {//remove element like ng-if
                    element.remove();

                } else if (!isAllowed && preventDefault) {//prevent from click
                    element.bind('click touchstart', function (e) {
                        e.stopImmediatePropagation();
                        e.preventDefault();
                        ngToast.create({
                            className: 'danger',
                            content: 'Você não tem permissão para fazer isso. <br> <img src="icons/mascot/crying.png" class="icon-64"> <br> Na dúvida, entra em contato com o administrador do sistema!'
                        });
                        scope.$apply();
                    });
                }
            }
        }
    };
}

precode.directive.precodeModuleRequired = function (AccessService, ngToast) {//do action if module not allowed
    return {
        replace: true,
        restrict: 'A',
        priority: 100,
        link: {
            pre: function (scope, element, attr) {

                var check = function () {
                    var m = { 'nome': attr.precodeModuleRequired };
                    var isAllowed = AccessService.isAllowedModule(m);
                    var preventDefault = attr.precodeModuleDeniedPrevent;

                    //console.log(AccessService);
                    //console.log(m);
                    //console.log(isAllowed);
                    //console.log(AccessService.resourcesLoaded);

                    if (!isAllowed && !preventDefault) {//remove element like ng-if
                        element.remove();
                    } else if (!isAllowed && preventDefault) {//prevent from click
                        element.bind('click touchstart', function (e) {
                            e.stopImmediatePropagation();
                            e.preventDefault();
                            ngToast.create({
                                className: 'danger',
                                content: 'Você não tem permissão para fazer isso. <br> <img src="icons/mascot/crying.png" class="icon-64"> <br> Na dúvida, entra em contato com o administrador do sistema!'
                            });
                            scope.$apply();
                        });
                    }
                }

                check();
                AccessService.registerObserverCallback(check);

            }
        }
    };
}

precode.filter.dateRange = function () {
    return function (items, field, from, to) {
        var df = parseDate(from);
        var dt = parseDate(to);
        var result = [];
        for (var i = 0; i < items.length; i++) {
            if (items[i][field] > df && items[i][field] < dt) {
                console.log(items[i]);
                console.log('yes!');
                result.push(items[i]);
            } else {
                console.log(items[i][field]);
                console.log('no!');
            }
        }
        return result;
    };
};

precode.filter.range = function () {
    return function (input, total) {
        total = parseInt(total);

        for (var i = 0; i < total; i++) {
            input.push(i);
        }

        return input;
    };
};

precode.filter.propsFilter = function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            var keys = Object.keys(props);

            items.forEach(function (item) {
                var itemMatches = false;

                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    };
};

precode.filter.toTrusted = function ($sce) {
    return function (value) {
        return $sce.trustAsHtml(value);
    };
};

precode.httpHandler.HttpRequestService = function ($q, $filter, $timeout) {
    var cancelPromises = [];

    function newTimeout(config) {
        //var defaultTimeout = config.timeout ? config.timeout : 12000;
        var defaultTimeout = config.timeout ? config.timeout : 120000;
        var canceller = $q.defer();

        //canceller by time
        $timeout(function () {
            canceller.resolve("Tempo máximo de requisição atingido, por favor atualize a página.");
        }, defaultTimeout);

        var p = {
            'url': config.url,
            'canceller': canceller
        };
        cancelPromises.push(p);

        return canceller.promise;
    }


    function cancelAll() {
        angular.forEach(cancelPromises, function (p) {
            p.canceller.promise.isGloballyCancelled = true;
            p.canceller.resolve();
        });
        cancelPromises.length = 0;
    }

    function remove(response) {
        cancelPromises = $filter('filter')(cancelPromises, function (p) {
            return p.url !== response.config.url;
        });
    }

    return {
        newTimeout: newTimeout,
        cancelAll: cancelAll,
        remove: remove
    };
};

precode.httpHandler.HttpRequestInterceptor = function ($q, HttpRequestService) {
    return {
        request: function (config) {
            config = config || {};
            config.params = config.params || {};

            var now = new Date().getTime();
            config.requestTimestamp = now;

            if (!String.prototype.endsWith('.html', config.url)) {//if not html
                config.params.requestTimestamp = now;//unique requests (no-cache)
            }

            if (config.url.indexOf("classe=file") !== -1) {//if file/upload
                config.timeout = 120000;
            } else {
                config.timeout = HttpRequestService.newTimeout(config);
            }

            return config;
        },
        response: function (response) {
            HttpRequestService.remove(response);
            return response;
        },
        responseError: function (response) {
            if (response && response.config && response.config.timeout && response.config.timeout.isGloballyCancelled) {
                return $q.defer().promise;
            }
            return $q.reject(response);
        }
    };
};

precode.httpHandler.HttpResponseInterceptor = function ($q, cfpLoadingBar) {
    return {
        'response': function (response) {
            // do something on success
            if (response.data.status && response.data.status != 200) {
                cfpLoadingBar.complete();
                return $q.reject(response.data.message);
            }
            response.config.responseTimestamp = new Date().getTime();
            return response;
        }
    };
};

precode.popoverElem = function () {
    //http://stackoverflow.com/questions/30512748/hide-angular-ui-bootstrap-popover-when-clicking-outside-of-it
    return {
        link: function (scope, element, attrs) {
            element.on('click', function () {
                //element.addClass('trigger');
                (element.hasClass('trigger')) ? element.removeClass('trigger') : element.addClass('trigger');
            });
        }
    };
};

precode.popoverClose = function ($timeout) {
    return {
        scope: {
            excludeClass: '@'
        },
        link: function (scope, element, attrs) {
            var trigger = document.getElementsByClassName('trigger');

            function closeTrigger(i) {
                //console.log('aqui n entrei');
                $timeout(function () {
                    $(angular.element(trigger[0])).click();
                    $(angular.element(trigger[0])).removeClass('trigger');
                    //console.log('desativei geral');
                    //console.log(angular.element(trigger[0]));
                });
            }

            element.on('click', function (event) {
                var etarget = angular.element(event.target);
                var tlength = trigger.length;

                //if (!etarget.hasClass('trigger') && !etarget.hasClass(scope.excludeClass)) {
                if (!etarget.hasClass('trigger') && !etarget.parents('.' + scope.excludeClass).length && !etarget.hasClass(scope.excludeClass)) {
                    //console.log('aqui nem comecei');
                    for (var i = 0; i < tlength; i++) {
                        closeTrigger(i);
                    }
                }
            });
        }
    };
};

precode.fileModelDirective = function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                scope.$apply(function () {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}

precode.owlCarouselDirective = function() {
    return {
        restrict: "A",
        transclude: false,
        link: function ($scope, element, attributes) {
            $scope.initCarousel = function () {
                $(element).owlCarousel($scope.HomeVM.owlDefaultOpts);
            };
        }
    };
}

precode.owlCarouselItemDirective = function () {
    return {
      restrict  : "A",
      transclude: false,
      link      : function ($scope, element, attributes) {
        if ( $scope.$last )
          $scope.initCarousel();
      }
    };
  }