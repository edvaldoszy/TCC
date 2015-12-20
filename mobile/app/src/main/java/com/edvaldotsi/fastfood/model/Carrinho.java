package com.edvaldotsi.fastfood.model;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Edvaldo on 09/11/2015.
 */
public class Carrinho implements Serializable {

    private Pedido pedido;
    private List<Detalhes> detalhes;

    public Carrinho(Pedido pedido) {
        this.pedido = pedido;
        detalhes = new ArrayList<>();
    }

    public Carrinho(Pedido pedido, List<Detalhes> detalhes) {
        this.pedido = pedido;
        this.detalhes = detalhes;
    }

    public void addProduto(Detalhes detalhe) {
        detalhes.add(detalhe);
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
