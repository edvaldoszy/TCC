package com.edvaldotsi.fastfood.model;

/**
 * Created by Edvaldo on 09/09/2015.
 */
public class ProdutoItem extends Produto {

    private static final int maxQuantidade = 3;

    private int quantidade;
    private boolean adicional;

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public boolean isAdicional() {
        return adicional;
    }

    public void setAdicional(boolean adicional) {
        this.adicional = adicional;
    }

    public void incrementar() {
        if (quantidade < maxQuantidade) { quantidade++; }
    }

    public void decrementar() {
        if (quantidade > 0) { quantidade--; }
    }

    public float getValorTotal() {
        return quantidade * valor;
    }
}
