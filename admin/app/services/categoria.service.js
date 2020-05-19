goog.provide("precode.sistema.CategoriaService");
goog.provide("precode.sistema.Categoria");

precode.sistema.Categoria = function (UtilService, $resource) {
    return $resource(UtilService.RESTENDPOINT + "/categoria/:id", { id: "@id" }, { update: { method: 'PUT' } });
}

precode.sistema.CategoriaService = function ($q, Categoria) {
    var self = {
        selected: null,
        list: [],
        load,
        create,
        update,
        remove
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

    function create(params) {
        var d = $q.defer();

        Categoria.save(params).$promise.then(function (response) {
            self.selected = null;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function update(params) {
        var d = $q.defer();

        Categoria.update(params).$promise.then(function (response) {
            self.selected = null;
            $('#modal-default').modal('hide');
            $(document).Toasts('create', {
                title: 'Sucesso',
                body: 'A categoria foi editada com sucesso!',
                class: 'bg-success'
            });
            self.load();
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }

    function remove(id) {
        var d = $q.defer();

        Categoria.delete(id).$promise.then(function (response) {
            self.selected = null;
            d.resolve(response);
        }).catch(function (e) {
            console.log(e);

            d.reject(e);
        });

        return d.promise;
    }
}

