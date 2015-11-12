package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 19/10/2015.
 */
public class Pedido implements Serializable {

    public static final int PAGAMENTO_DINHEIRO = 1;
    public static final int PAGAMENTO_CARTAO = 2;

    public static final String[] FORMAS_PAGAMENTO = {"Não selecionado", "Dinheiro", "Cartão"};

    private int codigo;
    private float valor;
    private int pagamento;
    private float troco;
    private long lat;
    private long lng;
    private char situacao = '1';
    private Cliente cliente;

    public Pedido(Cliente cliente) {
        this.cliente = cliente;
    }

    public int getCodigo() {
        return codigo;
    }

    public void setCodigo(int codigo) {
        this.codigo = codigo;
    }

    public float getValor() {
        return valor;
    }

    public void setValor(float valor) {
        this.valor = valor;
    }

    public int getPagamento() {
        return pagamento;
    }

    public void setPagamento(int pagamento) {
        this.pagamento = pagamento;
    }

    public float getTroco() {
        return troco;
    }

    public void setTroco(float troco) {
        this.troco = troco;
    }

    public long getLat() {
        return lat;
    }

    public void setLat(long lat) {
        this.lat = lat;
    }

    public long getLng() {
        return lng;
    }

    public void setLng(long lng) {
        this.lng = lng;
    }

    public char getSituacao() {
        return situacao;
    }

    public void setSituacao(char situacao) {
        this.situacao = situacao;
    }

    public Cliente getCliente() {
        return cliente;
    }

    public void setCliente(Cliente cliente) {
        this.cliente = cliente;
    }
}
