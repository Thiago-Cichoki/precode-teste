goog.provide('precode.sistema.AppCtrl');

precode.sistema.AppCtrl = function (CategoriaService, ProdutoService, CarrinhoService, UtilService) {
  var vm = this;

  vm.Categoria = CategoriaService;
  vm.Produto = ProdutoService;
  vm.Carrinho = CarrinhoService;
  vm.Util = UtilService;
  vm.Categoria.load();
  vm.Produto.load();
  vm.ProdutoCarrinho = {};
  vm.carrinhoId = sessionStorage.getItem('carrinhoId');
  if(!vm.Carrinho.selected){
    vm.Carrinho.select(vm.carrinhoId);
  }

  vm.addProduto = function (produtoId) {
    document.getElementById('sst' + produtoId).value++;
    vm.Carrinho.selected.produtos.forEach(produto => {
      produto.quantidade = $("#sst" + produto.id).val();
    });
  }

  vm.removerProduto = function (produtoId) {
    document.getElementById('sst' + produtoId).value--;
    vm.Carrinho.selected.produtos.forEach(produto => {
      produto.quantidade = $("#sst" + produto.id).val();
    });
  }

}

precode.sistema.AppCtrl.prototype.adicionarCarrinho = function (produto = null, redirect = true) {
  var vm = this;

  if(produto) {
    vm.ProdutoCarrinho.idProduto = produto.id;
    vm.ProdutoCarrinho.quantidade = 1;
  } else {
    vm.ProdutoCarrinho.idProduto = vm.Produto.selected.id;
    vm.ProdutoCarrinho.quantidade = $("#qqt").val();
  }


  carrinhoId = sessionStorage.getItem('carrinhoId');
  if (!carrinhoId)
    return vm.criarCarrinho();

  vm.ProdutoCarrinho.idCarrinho = carrinhoId;
  vm.Carrinho.adicionarProduto(vm.ProdutoCarrinho).then(function () {
    if(redirect){
      window.location.href = vm.Util.POINT + "/carrinho/" + sessionStorage.getItem('carrinhoId');
      return;
    }
    
    vm.Carrinho.select(carrinhoId);
  });

}

precode.sistema.AppCtrl.prototype.criarCarrinho = function () {
  var vm = this;

  vm.Carrinho.create(null).then(function (res) {
    sessionStorage.setItem('carrinhoId', vm.Carrinho.selected.id);
    vm.ProdutoCarrinho.idCarrinho = vm.Carrinho.selected.id;

    vm.Carrinho.adicionarProduto(vm.ProdutoCarrinho).then(function () {
      window.location.href = vm.Util.POINT +  "/carrinho/" + sessionStorage.getItem('carrinhoId');
    });
  });
}

precode.sistema.AppCtrl.prototype.atualizarCarrinho = function () {
  var vm = this;


  vm.Carrinho.update(vm.Carrinho.selected).then(function (res) {
    vm.Carrinho.select(vm.carrinhoId);
  });
}

precode.sistema.AppCtrl.prototype.removerProdutoDoCarrinho = function (id) {
  var vm = this;


  vm.Carrinho.remove({id: id, idCarrinho: vm.carrinhoId}).then(function (res) {
    vm.Carrinho.select(vm.carrinhoId);
  });
}
