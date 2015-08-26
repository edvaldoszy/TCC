package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 23/08/2015.
 */
public class Categoria implements Serializable {

    private Integer codigo;
    private String nome;

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
}
