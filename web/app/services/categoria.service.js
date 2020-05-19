goog.provide("precode.sistema.CategoriaService");
goog.provide("precode.sistema.Categoria");

precode.sistema.Categoria = function (UtilService, $resource) {
    return $resource(UtilService.RESTENDPOINT + "/categoria/:id", { id: "@id" }, { update: { method: 'PUT' } });
}

precode.sistema.CategoriaService = function ($q, Categoria) {
    var self = {
        selected: null,
        list: [],
        load
    };

    return self;

    function load() {
        var d = $q.defer();

        Categoria.query().$promise.then(function (response) {
            self.list = response;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }
}

