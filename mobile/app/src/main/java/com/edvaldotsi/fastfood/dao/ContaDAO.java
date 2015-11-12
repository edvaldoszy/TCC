package com.edvaldotsi.fastfood.dao;

import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.dao.AbstractDAO;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.model.Conta;
import com.edvaldotsi.fastfood.model.Contato;
import com.edvaldotsi.fastfood.model.Endereco;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.List;

/**
 * Created by Edvaldo on 28/10/2015.
 */
public class ContaDAO extends AbstractDAO<Conta> {

    private static Conta conta;

    public ContaDAO(Context context) {
        super(context);
    }

    public static Conta getConta() {
        return conta;
    }
    public static void setConta(Conta conta) {
        ContaDAO.conta = conta;
    }

    public static Cliente getCliente() {
        return conta.getCliente();
    }
    public static void setCliente(Cliente cliente) {
        conta.setCliente(cliente);
    }

    public static List<Endereco> getEnderecos() {
        return conta.getEnderecos();
    }

    public static List<Contato> getContatos() {
        return conta.getContatos();
    }

    @Override
    protected Conta createObject(Cursor c) {
        return null;
    }

    @Override
    public void insert(Conta model) {

    }

    public static String md5(String original) {
        if (original == null || original.isEmpty()) {
            return null;
        }
        // Cria a classe com o algorítmo de criptografia
        StringBuilder criptografado = new StringBuilder();
        try {
            MessageDigest md = MessageDigest.getInstance("MD5");
            // Criptografa a String recebida
            md.update(original.getBytes());
            // Recupera os bytes já criptografados
            byte[] digest = md.digest();
            // Converte os bytes para uma String em hexadecimal
            for (byte b : digest) {
                String hexaDecimal = String.format("%02x", b & 0xff);
                criptografado.append(hexaDecimal);
            }
            System.out.println("original: " + original);
            System.out.println("criptografado: " + criptografado.toString());
        } catch (NoSuchAlgorithmException ex) {
            ex.printStackTrace();
            throw new RuntimeException(ex);
        }
        // Converte o StringBuilder para String e retorna
        return criptografado.toString();
    }
}
