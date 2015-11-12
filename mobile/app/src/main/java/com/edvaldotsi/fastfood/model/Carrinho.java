package com.edvaldotsi.fastfood.model;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Edvaldo on 09/11/2015.
 */
public class Carrinho {

    private Endereco endereco;

    private Pedido pedido;
    private List<Detalhes> detalhes;

    public Carrinho(Pedido pedido, Endereco endereco) {
        this.pedido = pedido;
        this.endereco = endereco;
        detalhes = new ArrayList<>();
    }

    public void addProduto(Detalhes detalhe) {
        detalhes.add(detalhe);
    }

    public Endereco getEndereco() {
        return endereco;
    }

    public void setEndereco(Endereco endereco) {
        this.endereco = endereco;
    }

    public Pedido getPedido() {
        return pedido;
    }

    public void setPedido(Pedido pedido) {
        this.pedido = pedido;
    }

    public List<Detalhes> getDetalhes() {
        return detalhes;
    }

    public void setDetalhes(List<Detalhes> detalhes) {
        this.detalhes = detalhes;
    }

    public float getValorTotal() {
        float total = 0f;
        for (Detalhes d : detalhes) {
            total += d.getValorTotal();
        }
        pedido.setValor(total);
        return total;
    }
}
