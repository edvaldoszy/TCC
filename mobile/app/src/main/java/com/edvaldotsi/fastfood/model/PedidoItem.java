package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 19/10/2015.
 */
public class PedidoItem implements Serializable {

    private int codigo;
    private Pedido pedido;
    private Produto produto;
    private Produto item;
    private int quantidade;
    private float valor;

    public int getCodigo() {
        return codigo;
    }

    public void setCodigo(int codigo) {
        this.codigo = codigo;
    }

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

    public Produto getItem() {
        return item;
    }

    public void setItem(Produto item) {
        this.item = item;
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
