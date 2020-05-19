goog.provide('precode.sistema.UtilService');

precode.sistema.UtilService = function ($http, $q) {
    var self = {
        dateToString,
        getTimeObject,
        setTimeObject,
        fixTimezone,
        cutString: function (str, length) {
            if (str.length > length) {
                return str.substring(0, 25) + '...';
            } else {
                return str;
            }
        },
        RESTENDPOINT: "/api",
        AUTHRESTENDPOINT: "/auth",
        POINT: "/admin",
        active: "resumo",
        uploadFile
    };

    return self;

    function dateToString(d) {
        return moment(d).format('YYYY-MM-DD');
    }

    function getTimeObject(str) {
        if (str) {//https://stackoverflow.com/questions/34050389/remove-timezone-from-a-moment-js-object
            let s = "2017-06-01" + ' ' + str;
            let dt = new moment(s).utc().add(0, 'm').toDate();
            //var dt = new Date();
            //var h = str.substring(0, 2);
            //var m = str.substring(3, 5);
            //dt.setHours(h, m);
            return dt;
        } else {
            return null;
        }
    }

    function setTimeObject(dt) {
        let utc = new moment(dt);
        return new moment(dt).utc().add(utc.utcOffset(), 'm').toDate();
    }

    function fixTimezone(dt, mode) {
        if (angular.isUndefined(dt)) {
            dt = new Date();
        }
        //javascript adds timezone to date (-3hours to brazil), 
        //but we`re using literal time, so we add/remove 3hours
        if (mode === 'in') {//-0300 to +0100
            dt.setHours(dt.getHours());
        } else if (mode === 'out') {
            let utc = new moment(dt);
            dt = new moment(dt).utc().add(utc.utcOffset(), 'm').toDate();
        }

        return dt;
    }

    function uploadFile(file) {

        var d = $q.defer();
        var fd = new FormData();

        fd.append('file', file);

        $http.post(self.RESTENDPOINT + "/arquivo", fd, {
            transformRequest: angular.identity,

            headers: { 'Content-Type': undefined }
        }).then(function(res){
            d.resolve(res);
        });

        return d.promise;

    }

}


