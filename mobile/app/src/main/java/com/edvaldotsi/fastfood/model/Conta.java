package com.edvaldotsi.fastfood.model;

import java.io.Serializable;
import java.util.List;

/**
 * Created by Edvaldo on 23/10/2015.
 */
public class Conta implements Serializable {

    private Cliente cliente;
    private List<Endereco> enderecos;
    private List<Contato> contatos;

    public Conta(Cliente cliente, List<Endereco> enderecos, List<Contato> contatos) {
        this.cliente = cliente;
        this.enderecos = enderecos;
        this.contatos = contatos;
    }

    public Cliente getCliente() {
        return cliente;
    }

    public void setCliente(Cliente cliente) {
        this.cliente = cliente;
    }

    public List<Endereco> getEnderecos() {
        return enderecos;
    }

    public void setEnderecos(List<Endereco> enderecos) {
        this.enderecos = enderecos;
    }

    public List<Contato> getContatos() {
        return contatos;
    }

    public void setContatos(List<Contato> contatos) {
        this.contatos = contatos;
    }
}
