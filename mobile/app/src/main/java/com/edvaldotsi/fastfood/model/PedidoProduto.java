package com.edvaldotsi.fastfood.model;

/**
 * Created by Edvaldo on 06/11/2015.
 */
public class PedidoProduto {

    private Pedido pedido;
    private Produto produto;
    private int quantidade;
    private float valor;

    public Pedido getPedido() {
        return pedido;
    }

    public void setPedido(Pedido pedido) {
        this.pedido = pedido;
    }

    public Produto getProduto() {
        return produto;
    }

    public void setProduto(Produto produto) {
        this.produto = produto;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public float getValor() {
        return valor;
    }

    public void setValor(float valor) {
        this.valor = valor;
    }
}
