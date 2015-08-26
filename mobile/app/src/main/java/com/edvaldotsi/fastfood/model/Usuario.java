package com.edvaldotsi.fastfood.model;

import java.io.Serializable;

/**
 * Created by Edvaldo on 22/08/2015.
 */
public class Usuario implements Serializable {

    private Integer codigo;
    private String nome;
    private String email;
    private boolean admin;

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

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public boolean isAdmin() {
        return admin;
    }

    public void setAdmin(boolean admin) {
        this.admin = admin;
    }
}