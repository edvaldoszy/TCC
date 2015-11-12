package com.edvaldotsi.fastfood.model;

import java.io.Serializable;
import java.util.List;

/**
 * Created by Edvaldo on 10/11/2015.
 */
public class Detalhes implements Serializable {

    private Produto produto;
    private List<ProdutoItem> itens;
    private int quantidade = 1;
    private float valor = 0;

    public Produto getProduto() {
        return produto;
    }

    public void setProduto(Produto produto) {
        this.produto = produto;
    }

    public List<ProdutoItem> getItens() {
        return itens;
    }

    public void setItens(List<ProdutoItem> itens) {
        this.itens = itens;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public void incrementar() {
        if (quantidade < 10) { quantidade++; }
    }

    public void decrementar() {
        if (quantidade > 1) { quantidade--; }
    }

    public float getValorTotal() {
        return (valor + produto.getValor()) * quantidade;
    }

    public float getValor() {
        return valor;
    }

    public void setValor(float valor) {
        this.valor = valor;
    }
}
