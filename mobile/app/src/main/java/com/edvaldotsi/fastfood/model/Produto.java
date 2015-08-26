package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 23/08/2015.
 */
public class Produto implements Serializable {

    private Integer codigo;
    private String nome;
    private Double valor;
    private Categoria categoria;

    public Integer getCodigo() {
        return codigo;
    }

    public void setCodigo(Integer codigo) {
        this.codigo = codigo;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public Double getValor() {
        return valor;
    }

    public void setValor(Double valor) {
        this.valor = valor;
    }

    public Categoria getCategoria() {
        return categoria;
    }

    public void setCategoria(Categoria categoria) {
        this.categoria = categoria;
    }

    @Override
    public String toString() {
        return nome;
    }
}
