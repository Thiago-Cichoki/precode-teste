goog.provide('precode.sistema.CategoriaCtrl');

precode.sistema.CategoriaCtrl = function (CategoriaService) {
  var vm = this;

  vm.Categoria = CategoriaService;
  vm.Categoria.load();
  vm.modoEdicao = false;

  vm.closeModal = function () {
    $('#modal-default').modal('hide');
    vm.Categoria.selected = null;
  }
}

precode.sistema.CategoriaCtrl.prototype.create = function () {
  var vm = this;

  if (!vm.Categoria.selected.nome)
    return false;

  vm.Categoria.create(vm.Categoria.selected).then(function (res) {
    $('#modal-default').modal('hide');
    $(document).Toasts('create', {
      title: 'Sucesso',
      body: 'A categoria foi criada com sucesso!',
      class: 'bg-success'
    });
    vm.Categoria.load();
  });
}

precode.sistema.CategoriaCtrl.prototype.update = function (categoria) {
  var vm = this;

  vm.modoEdicao = true;
  vm.Categoria.selected = categoria;
  $("#modal-default").modal('show');

}

precode.sistema.CategoriaCtrl.prototype.remove = function () {
  var vm = this;


  if (!confirm("Quer realmente excluir essa categoria?"))
    return;

  vm.Categoria.remove({ id: vm.Categoria.selected.id }).then(function (res) {
    $('#modal-default').modal('hide');
    $(document).Toasts('create', {
      title: 'Sucesso',
      body: 'A categoria foi removida com sucesso!',
      class: 'bg-success'
    });
    vm.Categoria.load();
  });


}

