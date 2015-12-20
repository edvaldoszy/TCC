package com.edvaldotsi.fastfood.request;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.HashMap;

/**
 * Created by Edvaldo on 20/09/2015.
 */
public class PostData extends HashMap<String, String> {

    @Override
    public String toString() {
        StringBuilder out = new StringBuilder();

        try {
            for (String name : keySet()) {
                if (out.length() > 0)
                    out.append("&");

                out.append(name);
                out.append("=");
                //out.append(get(name));
                out.append(URLEncoder.encode(get(name), "UTF-8"));
            }
        } catch (UnsupportedEncodingException ex) {
            ex.printStackTrace();
        }

        return out.toString();
    }

    public void put(String key, int value) {
        String str = String.valueOf(value);
        put(key, str);
    }
}
