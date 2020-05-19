goog.provide("precode.sistema.CarrinhoService");
goog.provide("precode.sistema.Carrinho");

precode.sistema.Carrinho = function (UtilService, $resource) {
    return $resource(UtilService.RESTENDPOINT + "/carrinho/:id", { id: "@id" }, { update: { method: 'PUT' } });
}

precode.sistema.CarrinhoService = function ($q, Carrinho) {
    var self = {
        selected: null,
        list: [],
        load,
        select,
        create,
        update,
        remove,
        adicionarProduto
    };

    return self;

    function load(id) {
        var d = $q.defer();

        Carrinho.query().$promise.then(function (response) {
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

        Carrinho.get({ id: id }).$promise.then(function (response) {
            self.selected = response;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function create(params) {
        var d = $q.defer();

        Carrinho.save(params).$promise.then(function (response) {
            self.selected = response;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function adicionarProduto(params) {
        var d = $q.defer();
        params.action = "adicionarProduto";
        Carrinho.save(params).$promise.then(function (response) {
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function update(params) {
        var d = $q.defer();
        Carrinho.update(params).$promise.then(function (response) {
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function remove(id) {
        var d = $q.defer();

        Carrinho.delete(id).$promise.then(function (response) {
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

}

