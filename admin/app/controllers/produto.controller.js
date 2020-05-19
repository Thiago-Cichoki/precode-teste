goog.provide('precode.sistema.ProdutoCtrl');

precode.sistema.ProdutoCtrl = function ($scope, CategoriaService, ProdutoService, $state, UtilService) {
  var vm = this;

  vm.$state = $state;
  $scope.Util = UtilService;
  vm.UtilService = UtilService;
  vm.Produto = ProdutoService;
  vm.Categoria = CategoriaService;
  vm.Categoria.load();
  vm.Produto.load();
  $scope.imagemUpload = null;

  if(!vm.Produto.selected || !vm.Produto.selected.urlFotoProduto) {
    vm.imagemProduto = "img/produto-sem-imagem.jpg";
  } else {
    vm.imagemProduto = vm.Produto.selected.urlFotoProduto;
  }

  $scope.uploadFoto = function(scope){
    $scope.imagemUpload = $("#fotoProduto").prop('files')[0];
    $scope.Util.uploadFile($scope.imagemUpload).then(function(res){
        $("#thumb-produto").attr('src', res.data);
    });
  }
}

precode.sistema.ProdutoCtrl.prototype.create = function () {
  var vm = this;

  vm.Produto.selected.preco = $("#precoProduto").val();
  
  vm.Produto.selected.urlFotoProduto = $("#thumb-produto").attr('src');
  vm.Produto.create(vm.Produto.selected).then(function (res) {
    window.location.href = vm.UtilService.POINT + "/produtos";
    $(document).Toasts('create', {
      title: 'Sucesso',
      body: 'O produto foi cadastrado com sucesso!',
      class: 'bg-success'
    });
  });
}

precode.sistema.ProdutoCtrl.prototype.update = function () {
  var vm = this;

  vm.Produto.selected.preco = $("#precoProduto").val();

  vm.Produto.selected.urlFotoProduto = $("#thumb-produto").attr('src');
  vm.Produto.update(vm.Produto.selected).then(function (res) {
    $(document).Toasts('create', {
      title: 'Sucesso',
      body: 'O produto foi alterado com sucesso!',
      class: 'bg-success'
    });
  });
}

precode.sistema.ProdutoCtrl.prototype.delete = function (id) {
  var vm = this;

  if (!confirm("Deseja excluir esse produto?"))
    return false;

  vm.Produto.remove({ id: id }).then(function (res) {
    $(document).Toasts('create', {
      title: 'Sucesso',
      body: 'O produto foi removido com sucesso!',
      class: 'bg-success'
    });

    window.location.href = vm.UtilService.POINT + "/produtos";
  });
}




