goog.provide("precode.sistema.ProdutoService");
goog.provide("precode.sistema.Produto");

precode.sistema.Produto = function (UtilService, $resource) {
    return $resource(UtilService.RESTENDPOINT + "/produtos/:id", { id: "@id" }, { update: { method: 'PUT' } });
}

precode.sistema.ProdutoService = function ($q, Produto) {
    var self = {
        selected: null,
        list: [],
        load,
        select,
    };

    return self;

    function load() {
        var d = $q.defer();

        Produto.query().$promise.then(function (response) {
            self.list = response;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });


        return d.promise;
    }

    function select(id) {
        var d = $q.defer();

        Produto.get(id).$promise.then(function (response) {
            self.selected = response;
            self.selected.quantidade = parseFloat(response.quantidade);
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

}

