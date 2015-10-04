package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 22/09/2015.
 */
public class Contato implements Serializable {

    private int codigo;
    private String telefone;
    private Cliente cliente;

    public Contato(int codigo, String telefone, Cliente cliente) {
        this.codigo = codigo;
        this.telefone = telefone;
        this.cliente = cliente;
    }

    public int getCodigo() {
        return codigo;
    }

    public void setCodigo(int codigo) {
        this.codigo = codigo;
    }

    public String getTelefone() {
        return telefone;
    }

    public void setTelefone(String telefone) {
        this.telefone = telefone;
    }

    public Cliente getCliente() {
        return cliente;
    }

    public void setCliente(Cliente cliente) {
        this.cliente = cliente;
    }
}
