package com.edvaldotsi.fastfood.request;

import java.util.HashMap;

/**
 * Created by Edvaldo on 20/09/2015.
 */
public class PostData extends HashMap<String, String> {

    @Override
    public String toString() {
        StringBuilder out = new StringBuilder();
        for (String name : keySet()) {
            if (out.length() > 0)
                out.append("&");

            out.append(name);
            out.append("=");
            out.append(get(name));
        }

        return out.toString();
    }

    public void put(String key, int value) {
        String str = String.valueOf(value);
        put(key, str);
    }
}
