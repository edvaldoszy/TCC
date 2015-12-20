package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 19/10/2015.
 */
public class Pedido implements Serializable {

    public static final int PAGAMENTO_DINHEIRO = 1;
    public static final int PAGAMENTO_CARTAO = 2;

    public static final char ABERTO = '1';
    public static final char PRODUCAO = '3';
    public static final char FECHADO = '2';

    public static final String[] FORMAS_PAGAMENTO = {"Não selecionado", "Dinheiro", "Cartão"};

    private int codigo;
    private float valor;
    private int pagamento;
    private float troco;
    private char situacao = '1';
    private Cliente cliente;
    private Endereco endereco;
    private String dt_aberto;
    private String dt_producao;
    private String dt_fechado;
    private int produtos;

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

    public Endereco getEndereco() {
        return endereco;
    }

    public void setEndereco(Endereco endereco) {
        this.endereco = endereco;
    }

    public String getDataAberto() {
        return dt_aberto;
    }

    public void setDataAberto(String data) {
        this.dt_aberto = data;
    }

    public String getDataProducao() {
        return dt_producao;
    }

    public void setDataProducao(String data) {
        this.dt_producao = data;
    }

    public String getDataFechado() {
        return dt_fechado;
    }

    public void setDataFechado(String data) {
        this.dt_fechado = data;
    }

    public int getProdutos() {
        return produtos;
    }

    public void setProdutos(int produtos) {
        this.produtos = produtos;
    }
}
